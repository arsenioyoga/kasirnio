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
    $username = $_POST['username'];
    $password = $_POST['password']; // Password tidak di-hash
    $role = $_POST['role'];

    // Cek apakah username sudah ada di database
    $checkQuery = "SELECT COUNT(*) AS count FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $checkQuery);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        
        // Jika username sudah ada
        if ($row['count'] > 0) {
            echo "<script>
                    alert('Username \"$username\" sudah terdaftar. Silakan pilih username lain.');
                    window.history.back();
                  </script>";
        } else {
            // Query untuk menambahkan user
            $sql = "INSERT INTO user (username, password, role) VALUES ('$username', '$password', '$role')";

            if (mysqli_query($conn, $sql)) {
                echo "<script>
                        alert('Register berhasil!');
                        window.location.href = 'login.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Register gagal: " . mysqli_error($conn) . "');
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
