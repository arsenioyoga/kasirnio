<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "kasirnio";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Password tidak di-hash
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $nomor_telepon = mysqli_real_escape_string($conn, $_POST['nomor_telepon']);

    // Cek apakah username sudah ada di database
    $checkQuery = "SELECT COUNT(*) AS count FROM pelanggan WHERE username = '$username'";
    $result = mysqli_query($conn, $checkQuery);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        
        if ($row['count'] > 0) {
            echo "<script>
                    alert('Username \"$username\" sudah terdaftar. Silakan pilih username lain.');
                    window.history.back();
                  </script>";
        } else {
            // Query untuk menambahkan pelanggan
            $sql = "INSERT INTO pelanggan (username, password, NamaPelanggan, Alamat, NomorTelepon) 
                    VALUES ('$username', '$password', '$nama', '$alamat', '$nomor_telepon')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>
                        alert('Pendaftaran pelanggan berhasil!');
                        window.location.href = 'login_pelanggan.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Pendaftaran gagal: " . mysqli_error($conn) . "');
                        window.history.back();
                      </script>";
            }
        }
    } else {
        echo "<script>
                alert('Terjadi kesalahan saat memeriksa username.');
                window.history.back();
              </script>";
    }
}

mysqli_close($conn);
?>
