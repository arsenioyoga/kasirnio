<?php
// Mulai sesi
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

// Proses penghapusan produk
if (isset($_GET['nama'])) {
    // Ambil nama produk dari URL
    $nama = $conn->real_escape_string($_GET['nama']);

    // Query untuk menghapus produk berdasarkan nama
    $query = "DELETE FROM produk WHERE NamaProduk='$nama'";

    // Eksekusi query
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Produk berhasil dihapus!');window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus produk!');window.location.href='admin_dashboard.php';</script>";
    }
} else {
    echo "<script>alert('Produk tidak ditemukan!');window.location.href='admin_dashboard.php';</script>";
}

// Tutup koneksi
$conn->close();
?>
