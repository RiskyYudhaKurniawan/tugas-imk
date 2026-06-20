<?php
session_start();
include "config.php";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $data = mysqli_query(
        $conn,
        "SELECT * FROM users WHERE email='$email'"
    );

    $user = mysqli_fetch_assoc($data);

    if($user && password_verify($password, $user['password'])){
        $_SESSION['login'] = true;
        $_SESSION['nama'] = $user['nama'];
        header("location:index.php");
        exit; // Tambahkan exit setelah header location
    } else {
        echo "<script>alert('Email atau password salah')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - OnlyPets</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="cart" class="cart">
    <!-- Tombol Close (X) -->
    <span class="close-cart" onclick="closeCart()">&times;</span>
    
    <h2>Keranjang Anda</h2>
    
    <div id="cartItems">
        <!-- Item akan muncul di sini secara dinamis -->
    </div>

    <h3>Total : Rp <span id="total">0</span></h3>
    <button class="checkout-btn" onclick="checkout()">Checkout Sekarang</button>
    
    <!-- Tombol Kembali opsional di bagian bawah -->
    <p style="text-align:center; margin-top:15px; cursor:pointer; color:#666;" onclick="closeCart()">
        &larr; Kembali Belanja
    </p>
</div>
<!-- Kita gunakan class baru untuk membungkus agar posisi ke tengah -->
<div class="login-page">
    <div class="login-container">
        <h2>Login</h2>
        
        <form method="POST">
            <input type="email" name="email" placeholder="Email (contoh: kurnia@gmail.com)" required>
            <input type="password" name="password" placeholder="Password" required>
            
            <button type="submit" name="login">Masuk</button>
        </form>

        <div class="login-footer">
            Belum punya akun? <a href="register.php">Daftar</a>
        </div>
    </div>
</div>

</body>
</html>