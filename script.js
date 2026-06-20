let cart = [];

// 1. Fungsi Tambah ke Keranjang
function addCart(nama, harga) {
    let itemDitemukan = cart.find(item => item.nama === nama);

    if (itemDitemukan) {
        itemDitemukan.jumlah += 1;
    } else {
        cart.push({
            nama: nama,
            harga: harga,
            jumlah: 1
        });
    }
    
    updateCart();
    openCart();
}

// 2. Fungsi Perbarui Tampilan Keranjang (Ditambahkan Kontrol Jumlah)
function updateCart() {
    let area = document.getElementById("cartItems");
    area.innerHTML = "";
    let total = 0;

    cart.forEach((item, index) => {
        let subtotalItem = item.harga * item.jumlah;

        area.innerHTML += `
            <div class="cart-item" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; border-bottom:1px solid #eee; padding-bottom:10px;">
                <div style="flex: 1;">
                    <strong style="display:block; font-size:14px;">${item.nama}</strong>
                    <div style="display:flex; align-items:center; gap:10px; margin-top:5px;">
                        <!-- Tombol Kurangi (-) -->
                        <button onclick="kurangiQty(${index})" style="background:#eee; color:#333; padding:2px 8px; width:auto; border-radius:5px;">-</button>
                        
                        <span style="font-weight:bold;">${item.jumlah}</span>
                        
                        <!-- Tombol Tambah (+) -->
                        <button onclick="tambahQty(${index})" style="background:#eee; color:#333; padding:2px 8px; width:auto; border-radius:5px;">+</button>
                    </div>
                    <small style="display:block; margin-top:5px; color:#666;">Rp ${subtotalItem.toLocaleString('id-ID')}</small>
                </div>
                
                <!-- Tombol Hapus Seluruhnya (Tong Sampah / Teks Hapus) -->
                <button onclick="removeItem(${index})" style="background:none; color:#ff4d4d; padding:0; width:auto; font-size:12px; margin-left:10px;">Hapus</button>
            </div>
        `;
        total += subtotalItem;
    });

    document.getElementById("total").innerHTML = total.toLocaleString('id-ID');
}

// 3. Fungsi Tambah Jumlah (Internal Keranjang)
function tambahQty(index) {
    cart[index].jumlah += 1;
    updateCart();
}

// 4. Fungsi Kurangi Jumlah (Logika yang Anda minta)
function kurangiQty(index) {
    if (cart[index].jumlah > 1) {
        // Jika lebih dari 1, kurangi jumlahnya saja
        cart[index].jumlah -= 1;
    } else {
        // Jika jumlahnya 1 dan dikurangi, maka hapus dari keranjang
        cart.splice(index, 1);
    }
    updateCart();
}

// 5. Fungsi Hapus Seluruhnya
function removeItem(index) {
    // Menghapus baris barang tersebut tanpa peduli berapa jumlahnya
    cart.splice(index, 1);
    updateCart();
}

// Fungsi Navigasi (Tetap sama)
function openCart() { document.getElementById("cart").classList.add("active"); }
function closeCart() { document.getElementById("cart").classList.remove("active"); }

function checkout() {
    if (cart.length === 0) {
        alert("Keranjang Anda masih kosong!");
        return;
    }

    // HITUNG TOTAL BELANJA SEBELUM PINDAH HALAMAN
    let totalBelanja = 0;
    cart.forEach(item => {
        totalBelanja += (item.harga * item.jumlah);
    });

    // Simpan data keranjang dan TOTAL harga ke localStorage
    localStorage.setItem("checkout", JSON.stringify(cart));
    localStorage.setItem("lastTotal", totalBelanja.toLocaleString('id-ID')); 

    // Pindah ke halaman checkout
    window.location.href = "checkout.php";
}