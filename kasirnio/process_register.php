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
    $password = $_POST['password']; // Hash password
    $role = $_POST['role'];

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

mysqli_close($conn);
?>
