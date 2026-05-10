from fastapi import FastAPI
from pydantic import BaseModel
from sentence_transformers import SentenceTransformer, util
import mysql.connector
import uvicorn

app = FastAPI()

# Tải mô hình AI đa ngôn ngữ (Hỗ trợ tiếng Việt cực tốt)
model = SentenceTransformer('paraphrase-multilingual-MiniLM-L12-v2')

class DocInput(BaseModel):
    new_content: str

def get_db_connection():
    return mysql.connector.connect(
        host="localhost", 
        user="root", 
        password="", 
        database="qlht_xaydung_vlute" # Thay đúng tên DB của bạn
    )

@app.post("/check-ai")
async def check_ai(doc: DocInput):
    try:
        conn = get_db_connection()
        cursor = conn.cursor()
        # Lấy nội dung cũ để so sánh ngữ nghĩa
        cursor.execute("SELECT noi_dung_van_ban FROM tai_lieu")
        rows = cursor.fetchall()
        conn.close()

        existing_docs = [row[0] for row in rows if row[0]]
        
        if not existing_docs:
            return {"ai_score": 0, "ai_status": "Normal"}

        # Chuyển văn bản thành Vector
        new_emb = model.encode(doc.new_content, convert_to_tensor=True)
        old_embs = model.encode(existing_docs, convert_to_tensor=True)

        # Tính độ tương đồng
        cosine_scores = util.cos_sim(new_emb, old_embs)
        max_score = float(max(cosine_scores[0]))
        score_percentage = round(max_score * 100, 2)

        # Phân loại trạng thái dựa trên ngưỡng điểm
        status = "Duplicate" if score_percentage > 85 else "Warning" if score_percentage > 50 else "Normal"
        
        return {"ai_score": score_percentage, "ai_status": status}
    except Exception as e:
        print(f"Lỗi AI: {e}")
        return {"ai_score": 0, "ai_status": "Error"}

if __name__ == "__main__":
    uvicorn.run(app, host="0.0.0.0", port=8000)