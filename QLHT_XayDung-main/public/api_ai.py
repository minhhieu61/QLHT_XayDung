from fastapi import FastAPI
from pydantic import BaseModel
from sentence_transformers import SentenceTransformer, util
import mysql.connector
import uvicorn
import re

app = FastAPI()

# Tải mô hình AI
print("--- Đang khởi động AI... ---")
model = SentenceTransformer('paraphrase-multilingual-MiniLM-L12-v2')
print("--- AI Sẵn sàng! ---")

class DocInput(BaseModel):
    new_content: str

def get_db_connection():
    return mysql.connector.connect(
        host="localhost", user="root", password="", database="qlht_xaydung_vlute"
    )

@app.post("/check-ai")
async def check_ai(doc: DocInput):
    try:
        # Làm sạch nội dung gửi lên
        current_text = re.sub(r'\s+', ' ', doc.new_content).strip()
        if len(current_text) < 10:
            return {"ai_score": 0, "ai_status": "Normal"}

        conn = get_db_connection()
        cursor = conn.cursor()
        cursor.execute("SELECT noi_dung_van_ban FROM tai_lieu")
        rows = cursor.fetchall()
        conn.close()

        # Làm sạch dữ liệu cũ trong DB để đối soát
        existing_docs = [re.sub(r'\s+', ' ', row[0]).strip() for row in rows if row[0]]
        # Loại bỏ trường hợp tự so sánh với chính nó
        existing_docs = [d for d in existing_docs if d != current_text and len(d) > 10]

        if not existing_docs:
            return {"ai_score": 0, "ai_status": "Normal"}

        # Tính toán
        new_emb = model.encode(current_text, convert_to_tensor=True)
        old_embs = model.encode(existing_docs, convert_to_tensor=True)
        cosine_scores = util.cos_sim(new_emb, old_embs)
        max_score = float(max(cosine_scores[0]))
        score_percentage = round(max_score * 100, 2)

        status = "Duplicate" if score_percentage > 85 else "Warning" if score_percentage > 50 else "Normal"
        return {"ai_score": score_percentage, "ai_status": status}
    except Exception as e:
        return {"ai_score": 0, "ai_status": "Error"}

if __name__ == "__main__":
    uvicorn.run(app, host="0.0.0.0", port=8000)