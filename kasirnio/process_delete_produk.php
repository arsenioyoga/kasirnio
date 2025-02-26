<?php
session_start();

// Periksa apakah pengguna sudah login dan memiliki role admin atau petugas
if (!isset($_SESSION['username']) || !in_array($_SESSION['role'], ['admin', 'petugas'])) {
    echo "<script>alert('Akses ditolak. Anda bukan admin atau petugas.');window.location.href='login.php';</script>";
    exit;
}

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'kasirnio');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah parameter NamaProduk ada
if (isset($_GET['NamaProduk'])) {
    $NamaProduk = $_GET['NamaProduk']; // Mengambil nama produk dari URL

    // Query untuk menghapus produk berdasarkan NamaProduk
    $sql = "DELETE FROM produk WHERE NamaProduk = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameter
        $stmt->bind_param("s", $NamaProduk); // 's' menunjukkan bahwa parameter ini adalah string

        // Eksekusi query
        if ($stmt->execute()) {
            echo "<script>alert('Produk berhasil dihapus!'); window.location.href = 'admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus produk.'); window.location.href = 'admin_dashboard.php';</script>";
        }

        // Menutup statement
        $stmt->close();
    } else {
        echo "<script>alert('Terjadi kesalahan dalam query.'); window.location.href = 'admin_dashboard.php';</script>";
    }
} else {
    echo "<script>alert('Parameter NamaProduk tidak ditemukan.'); window.location.href = 'admin_dashboard.php';</script>";
}

// Menutup koneksi
$conn->close();
?>
