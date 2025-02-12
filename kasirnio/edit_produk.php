<?php
session_start();

// Periksa apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    echo "<script>alert('Akses ditolak. Anda bukan admin.');window.location.href='login_admin.php';</script>";
    exit;
}

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'kasirnio');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data produk berdasarkan NamaProduk
if (isset($_GET['nama'])) {
    $nama = $conn->real_escape_string($_GET['nama']);
    $query = "SELECT * FROM produk WHERE NamaProduk='$nama'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>alert('Produk tidak ditemukan!');window.location.href='admin_dashboard.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Akses tidak valid!');window.location.href='admin_dashboard.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f6fa;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        form {
            margin-top: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #388E3C;
        }
        .back-btn {
            text-align: center;
            margin-top: 10px;
        }
        .back-btn a {
            text-decoration: none;
            color: #4CAF50;
            font-size: 16px;
        }
        .back-btn a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Produk</h1>
        <form action="process_edit_produk.php" method="POST">
            <input type="hidden" name="nama_lama" value="<?php echo htmlspecialchars($row['NamaProduk']); ?>">
            <label for="nama">Nama Produk:</label>
            <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($row['NamaProduk'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>

            <label for="harga">Harga:</label>
            <input type="number" name="harga" id="harga" value="<?php echo htmlspecialchars($row['harga'] ?? '0', ENT_QUOTES, 'UTF-8'); ?>" required>

            <label for="stok">Stok:</label>
            <input type="number" name="stok" id="stok" value="<?php echo htmlspecialchars($row['stok'] ?? '0', ENT_QUOTES, 'UTF-8'); ?>" required>

            <button type="submit">Simpan Perubahan</button>
        </form>
        <div class="back-btn">
            <a href="admin_dashboard.php">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
