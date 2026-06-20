<!DOCTYPE html>
<html>
<head>
    <title>Payment Success - OnlyPets</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .receipt-body { background: #0086e6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; font-family: Arial; }
        .receipt-card { background: white; width: 350px; border-radius: 20px; overflow: hidden; text-align: center; box-shadow: 0 10px 30px rgba(250, 249, 249, 0.2); }
        .receipt-header { background: #0086e6; padding: 40px 20px; color: white; }
        .receipt-header h2 { color: #ffffff; /* Mengubah warna teks Payment Success! menjadi putih */margin: 0;}
        .success-icon { background: #ffcc00; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 40px; color: #fff; border: 4px solid #fff; }
        .receipt-content { padding: 20px; text-align: left; color: white; }
        .amount { font-size: 28px; font-weight: bold; color: #ff8c00; margin: 20px 0; text-align: center; }
        .detail-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #666; }
    </style>
</head>
<body class="receipt-body">
    <div class="receipt-card">
        <div class="receipt-header">
            <div class="success-icon">✓</div>
            <h2>Payment Success!</h2>
            <p>Transaksi berhasil dibayar melalui Saldo OnlyPets</p>
        </div>
        <div class="receipt-content">
            <div class="amount">Rp <span id="finalTotal"></span></div>
            <hr>
            <div class="detail-row"><span>Waktu Transaksi</span> <span><?php echo date('d M Y H:i'); ?> WIB</span></div>
            <div class="detail-row"><span>Metode</span> <span>E-Wallet</span></div>
            <div class="detail-row"><span>Status</span> <span style="color: green; font-weight: bold;">SUKSES</span></div>
            <button onclick="window.location.href='index.php'" class="checkout-btn" style="margin-top: 20px;">Kembali ke Home</button>
        </div>
    </div>
    <script>
        // Mengambil total dari localStorage yang disimpan saat checkout
        document.getElementById('finalTotal').innerText = localStorage.getItem('lastTotal') || '0';
    </script>
</body>
</html>