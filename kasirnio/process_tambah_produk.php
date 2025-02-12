<?php

$host = "localhost:3306"; // Sesuaikan dengan konfigurasi server Anda
$username = "root";
$password = "";
$database = "kasirnio";

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $conn->real_escape_string($_POST["nama"]);
    $harga = $conn->real_escape_string($_POST["harga"]);
    $stok = $conn->real_escape_string($_POST["stok"]);

    // Generate random ProdukID dalam batas INT
    $produkID = rand(1, 2147483647);

    // Query untuk menambahkan produk
    $query = "INSERT INTO produk (produkid, NamaProduk, harga, stok) VALUES ('$produkID', '$nama', '$harga', '$stok')";

    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Produk berhasil ditambahkan!');window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan produk: " . $conn->error . "');window.location.href='tambah_produk.php';</script>";
    }
} else {
    echo "<script>alert('Akses tidak valid!');window.location.href='admin_dashboard.php';</script>";
}

$conn->close();
?>
