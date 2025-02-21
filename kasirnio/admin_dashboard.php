<?php
session_start();

// Periksa apakah pengguna sudah login dan memiliki role admin atau petugas
if (!isset($_SESSION['username']) || !in_array($_SESSION['role'], ['admin', 'petugas'])) {
    echo "<script>alert('Akses ditolak. Anda bukan admin atau petugas.');window.location.href='login.php';</script>";
    exit;
}

$username = $_SESSION['username']; // Mendapatkan username pengguna yang login

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'kasirnio');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data produk dari database
$query = "SELECT NamaProduk, Harga, Stok FROM produk";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f6fa;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #4CAF50;
            position: fixed;
            left: 0;
            top: 0;
            color: white;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            padding-top: 20px;
        }
        .sidebar h2 {
            text-align: center;
            margin: 0;
            font-size: 24px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }
        .sidebar ul li {
            margin: 15px 0;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            padding: 12px 20px;
            display: block;
            transition: background 0.3s, transform 0.2s;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        .sidebar ul li a:hover {
            background-color: #388E3C;
            transform: scale(1.05);
        }
        .logout {
            margin-top: auto;
            padding: 15px;
            text-align: center;
            background-color: #f44336;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
        }
        .logout a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 0;
        }
        .logout:hover {
            background-color: #d32f2f;
            transform: scale(1.05);
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        table thead {
            background-color: #4CAF50;
            color: white;
        }
        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            padding: 10px 16px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            font-weight: bold;
        }
        .btn-edit {
            background-color: #FFC107;
            color: white;
        }
        .btn-edit:hover {
            background-color: #FFA000;
            transform: scale(1.05);
        }
        .btn-delete {
            background-color: #f44336;
            color: white;
        }
        .btn-delete:hover {
            background-color: #d32f2f;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Panel</h2>
        <ul>
            <li><a href="admin_dashboard.php">🏠 Dashboard</a></li>
            <li><a href="tambahproduk.php">➕ Tambah Produk</a></li>
        </ul>
        <div class="logout">
            <a href="logout.php">🚪 Logout</a>
        </div>
    </div>

    <div class="content">
        <h1>Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h1>
        <p>Gunakan tabel berikut untuk melihat, mengedit, atau menghapus produk:</p>

        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()){
                        echo "<tr>
                            <td>" . htmlspecialchars($row['NamaProduk']) . "</td>
                            <td>Rp " . number_format($row['Harga'], 0, ',', '.') . "</td>
                            <td>" . htmlspecialchars($row['Stok']) . "</td>
                            <td>
                                <a href='edit_produk.php?NamaProduk=".urlencode($row['NamaProduk']) . "' class='btn btn-edit'>✏️ Edit</a>
                                <a href='process_delete_produk.php?NamaProduk=" . urlencode($row['NamaProduk']) . "' class='btn btn-delete' onclick=\"return confirm('Apakah Anda yakin ingin menghapus produk ini?');\">🗑️ Hapus</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada produk.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
