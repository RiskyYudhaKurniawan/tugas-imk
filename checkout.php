<?php 
session_start(); 
// Pastikan user sudah login [2]
if(!isset($_SESSION['login'])){
    header("location:login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout OnlyPets - Konfirmasi Pesanan</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Style Tambahan untuk gaya Tokopedia */
        body { background-color: #f3f4f5; font-family: Arial, sans-serif; }
        .checkout-wrapper { display: flex; gap: 20px; max-width: 1100px; margin: 30px auto; padding: 0 20px; align-items: flex-start; }
        .main-content { flex: 2; }
        .sidebar-content { flex: 1; position: sticky; top: 20px; }
        
        .card-tkpd { background: white; border-radius: 12px; padding: 20px; margin-bottom: 15px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); text-align: left; }
        .card-tkpd h3 { font-size: 16px; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px; color: #333; text-transform: uppercase; letter-spacing: 0.5px; }
        
        .address-box { display: flex; gap: 12px; font-size: 14px; color: #555; }
        .address-box b { color: #333; display: block; margin-bottom: 4px; }
        
        .product-list-item { display: flex; gap: 15px; padding: 15px 0; border-bottom: 1px solid #f0f0f0; align-items: center; }
        .product-list-item img { width: 70px; height: 70px; border-radius: 8px; object-fit: cover; background: #eee; }
        .product-details { flex: 1; }
        .product-details p { font-size: 14px; color: #666; margin: 4px 0; }
        
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #555; }
        .total-row { border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px; font-weight: bold; font-size: 18px; color: #333; }
        
        .btn-tokopedia { width: 100%; background: #03ac0e; color: white; border: none; padding: 15px; border-radius: 10px; font-weight: bold; font-size: 16px; cursor: pointer; margin-top: 10px; }
        .btn-tokopedia:hover { background: #028a0b; }
    </style>
</head>
<body>

<div class="checkout-wrapper">
    <!-- Bagian Utama (Kiri) -->
    <div class="main-content">
        <h2 style="margin-bottom: 20px;">Checkout</h2>
        
        <!-- Alamat Pengiriman -->
        <div class="card-tkpd">
            <h3>📍 Alamat Pengiriman</h3>
            <div class="address-box">
                <div>
                    <b><?php echo $_SESSION['nama']; ?></b>
                    <p><?php echo $_SESSION['alamat'] ?? 'Alamat belum diatur'; ?></p>
                </div>
            </div>
        </div>
        
        <!-- Daftar Produk -->
        <div class="card-tkpd">
            <h3>Pesanan Anda</h3>
            <div id="checkoutProducts">
                <!-- Produk dari keranjang akan muncul di sini via JavaScript -->
            </div>
        </div>
    </div>

    <!-- Sidebar Transaksi (Kanan) -->
    <div class="sidebar-content">
        <div class="card-tkpd">
            <h3>Metode Pembayaran</h3>
            <select style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd; margin-bottom: 15px;">
                <option>Pilih Pembayaran</option>
                <option>BCA Virtual Account</option>
                <option>GoPay</option>
                <option>OVO</option>
                <option>COD (Bayar di Tempat)</option>
            </select>
        </div>

        <div class="card-tkpd">
            <h3>Ringkasan Belanja</h3>
            <div class="summary-row">
                <span>Total Harga (Produk)</span>
                <span id="subtotalCheckout">Rp 0</span>
            </div>
            <div class="summary-row">
                <span>Biaya Pengiriman</span>
                <span style="color: #03ac0e;">Gratis Ongkir</span>
            </div>
            <div class="summary-row">
                <span>Biaya Jasa Aplikasi</span>
                <span>Rp 1.000</span>
            </div>

            <div class="summary-row total-row">
                <span>Total Tagihan</span>
                <span id="grandTotal">Rp 0</span>
            </div>

            <button class="btn-tokopedia" onclick="bayarSekarang()">Bayar Sekarang</button>
        </div>
    </div>
</div>

<script>
    // Mengambil data keranjang yang disimpan di localStorage [3]
    const cart = JSON.parse(localStorage.getItem('checkout')) || [];
    const container = document.getElementById('checkoutProducts');
    let totalHarga = 0;

    // Tampilkan Produk secara detail
    if(cart.length > 0) {
        cart.forEach(item => {
            const sub = item.harga * item.jumlah;
            totalHarga += sub;
            container.innerHTML += `
                <div class="product-list-item">
                    <img src="images/makanan/contoh.jpg" alt="Product">
                    <div class="product-details">
                        <b style="font-size: 15px;">${item.nama}</b>
                        <p>${item.jumlah} barang x Rp ${item.harga.toLocaleString('id-ID')}</p>
                        <small style="color: #03ac0e;">Proteksi Produk Tersedia</small>
                    </div>
                    <div style="font-weight: bold; color: #333;">Rp ${sub.toLocaleString('id-ID')}</div>
                </div>
            `;
        });
    } else {
        container.innerHTML = "<p>Data pesanan tidak ditemukan.</p>";
    }

    // Tampilkan Ringkasan Tagihan
    const grandTotal = totalHarga + 1000; // Total + biaya aplikasi
    document.getElementById('subtotalCheckout').innerText = "Rp " + totalHarga.toLocaleString('id-ID');
    document.getElementById('grandTotal').innerText = "Rp " + grandTotal.toLocaleString('id-ID');

    // Simpan total final untuk ditampilkan di halaman bukti transaksi (success.php) [3]
    localStorage.setItem('lastTotal', grandTotal.toLocaleString('id-ID'));

    function bayarSekarang() {
        alert("Mengalihkan ke halaman pembayaran...");
        window.location.href = 'success.php';
    }
</script>

</body>
</html>