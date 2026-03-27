<!-- resources/views/danh_sach_cong_trinh.php -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Quan ly Cong trinh VLUTE</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f4f4f4;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #007bff;
            color: white;
        }

        form {
            margin-bottom: 20px;
            background: #eee;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>HE THONG QUAN LY CONG TRINH - VLUTE</h2>

        <form method="POST">
            <input type="text" name="ten" placeholder="Ten cong trinh..." required>
            <select name="trang_thai">
                <option value="Dang chuan bi">Dang chuan bi</option>
                <option value="Dang thi cong">Dang thi cong</option>
                <option value="Hoan thanh">Hoan thanh</option>
            </select>
            <button type="submit" name="btn_them">Them moi</button>
        </form>

        <table>
            <tr>
                <th>STT</th>
                <th>Ten Cong Trinh</th>
                <th>Trang Thai</th>
            </tr>
            <?php
            $i = 1;
            while ($row = $du_lieu->fetch_assoc()): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><strong><?= $row['name'] ?></strong></td>
                    <td><?= $row['status'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>

</html>