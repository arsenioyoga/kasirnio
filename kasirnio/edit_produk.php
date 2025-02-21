<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f9;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #2c3e50;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        label {
            display: block;
            font-size: 14px;
            color: #34495e;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #3498db;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #27ae60;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2ecc71;
        }

        button:focus {
            outline: none;
        }
    </style>
</head>
<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "kasirnio");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data berdasarkan ID
if (isset($_GET['NamaProduk'])) {
    $namaProduk = $conn->real_escape_string($_GET['NamaProduk']); // Hindari SQL Injection
    
    // Gunakan prepared statement
    $stmt = $conn->prepare("SELECT * FROM produk WHERE NamaProduk = ?");
    $stmt->bind_param("s", $namaProduk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<p>Menu tidak ditemukan.</p>";
        exit();
    }
    $stmt->close();
}

// Update data setelah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ProdukID = intval($_POST['ProdukID']);
    $NamaProduk = $conn->real_escape_string($_POST['NamaProduk']);
    $Harga = floatval($_POST['Harga']);
    $Stok = intval($_POST['Stok']);

    // Gunakan prepared statement untuk update
    $stmt = $conn->prepare("UPDATE produk SET NamaProduk = ?, Harga = ?, Stok = ? WHERE ProdukID = ?");
    $stmt->bind_param("sdii", $NamaProduk, $Harga, $Stok, $ProdukID);

    if ($stmt->execute()) {
        echo "<script>alert('Menu berhasil diperbarui!'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
</head>
<body>
    <form method="POST" action="">
        <h1>Edit Menu</h1>
        <input type="hidden" name="ProdukID" value="<?php echo htmlspecialchars($row['ProdukID']); ?>">
        
        <label for="NamaProduk">Nama Produk:</label>
        <input type="text" name="NamaProduk" id="NamaProduk" value="<?php echo htmlspecialchars($row['NamaProduk']); ?>" required />
        
        <label for="Harga">Harga:</label>
        <input type="number" step="0.01" name="Harga" id="Harga" value="<?php echo htmlspecialchars($row['Harga']); ?>" required>
        
        <label for="Stok">Stok:</label>
        <input type="number" name="Stok" id="Stok" value="<?php echo htmlspecialchars($row['Stok']); ?>" required>
        
        <button type="submit">Simpan</button>
    </form>
</body>
</html>
