<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f6fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-size: 16px;
            margin-bottom: 5px;
            color: #333;
        }
        input {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #388E3C;
        }
        .back-link {
            text-align: center;
            margin-top: 15px;
        }
        .back-link a {
            text-decoration: none;
            color: #4CAF50;
            transition: color 0.3s;
        }
        .back-link a:hover {
            color: #388E3C;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Tambah Produk</h2>
        <form action="process_tambah_produk.php" method="POST">
            <label for="nama">Nama Produk</label>
            <input type="text" id="nama" name="nama" required>

            <label for="harga">Harga</label>
            <input type="number" id="harga" name="harga" required>

            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" required>

            <button type="submit">Tambah Produk</button>
        </form>
        <div class="back-link">
            <a href="admin_dashboard.php">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
