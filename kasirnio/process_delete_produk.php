<?php
// Mulai sesi
session_start();

// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Periksa apakah pengguna sudah login dan memiliki hak akses (admin atau petugas)
if (!isset($_SESSION['username']) || !in_array($_SESSION['role'], ['admin', 'petugas'])) {
    echo "<script>alert('Akses ditolak. Anda tidak memiliki izin.');window.location.href='login.php';</script>";
    exit;
}

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'kasirnio');

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pastikan parameter 'id' dikirim dan merupakan bilangan bulat yang valid
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT) !== false) {
    $ProdukID = intval($_GET['id']);

    // Cek apakah produk dengan ID tersebut ada
    $check_stmt = $conn->prepare("SELECT ProdukID FROM produk WHERE ProdukID = ?");
    $check_stmt->bind_param("i", $ProdukID);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Produk ditemukan, lanjutkan penghapusan
        $stmt = $conn->prepare("DELETE * FROM produk WHERE ProdukID = ?");
        $stmt->bind_param("i", $ProdukID);

        if ($stmt->execute()) {
            echo "<script>alert('Produk berhasil dihapus!');window.location.href='admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus produk: " . $stmt->error . "');window.location.href='admin_dashboard.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Produk dengan ID ini tidak ditemukan!');window.location.href='admin_dashboard.php';</script>";
    }

    $check_stmt->close();
} else {
    echo "<script>alert('Parameter ID produk tidak valid!');window.location.href='admin_dashboard.php';</script>";
}

// Tutup koneksi database
$conn->close();
?>
