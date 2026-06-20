<?php
include "config.php";

if(isset($_POST['register'])){
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat']; // Mengambil input alamat baru
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Query ini tidak memasukkan kolom 'id' secara manual untuk menghindari 
    // error "Incorrect integer value" seperti yang terlihat di sumber [1] dan [2].
    $query = mysqli_query($conn, 
        "INSERT INTO users (nama, email, alamat, password) 
         VALUES ('$nama', '$email', '$alamat', '$password')"
    );

    if($query){
        echo "
        <script>
            alert('Register berhasil! Silakan login untuk berbelanja.');
            window.location='login.php';
        </script>
        ";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - OnlyPets</title>
    <!-- Menghubungkan ke style.css agar tampilan elegan dan ke tengah -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-page">
    <div class="login-container">
        <h2>Daftar Akun OnlyPets</h2>
        
        <form method="POST">
            <!-- Field Nama Lengkap -->
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            
            <!-- Field Email -->
            <input type="email" name="email" placeholder="Email (contoh: kurnia@gmail.com)" required>
            
            <!-- Field Alamat Baru (Agar transaksi lebih praktis nantinya) -->
            <input type="text" name="alamat" placeholder="Alamat Lengkap Rumah" required>
            
            <!-- Field Password -->
            <input type="password" name="password" placeholder="Password Baru" required>
            
            <button type="submit" name="register">Daftar Sekarang</button>
        </form>

        <div class="login-footer">
            Sudah punya akun? <a href="login.php">Masuk di sini</a>
        </div>
    </div>
</div>

</body>
</html>