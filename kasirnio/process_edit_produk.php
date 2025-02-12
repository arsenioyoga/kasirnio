<?php
session_start();

// Periksa apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    echo "<script>alert('Akses ditolak. Anda bukan admin.');window.location.href='login_admin.php';</script>";
    exit;
}

// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "kasirnio";

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produkid = $conn->real_escape_string($_POST["produkid"]);
    $nama = $conn->real_escape_string($_POST["nama"]);
    $harga = $conn->real_escape_string($_POST["harga"]);
    $stok = $conn->real_escape_string($_POST["stok"]);

    // Query untuk memperbarui produk berdasarkan ProdukID
    $query = "UPDATE produk SET NamaProduk='$nama', harga='$harga', stok='$stok' WHERE produkid='$produkid'";

    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Produk berhasil diperbarui!');window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui produk: " . $conn->error . "');window.location.href='edit_produk.php?produkid=$produkid';</script>";
    }
} else {
    echo "<script>alert('Akses tidak valid!');window.location.href='admin_dashboard.php';</script>";
}

$conn->close();
?>
