let cart = [];

// 1. Fungsi Tambah ke Keranjang
function addCart(nama, harga, gambar) {
    let statusLogin = localStorage.getItem("isLoggedIn");
    
    // Jika tidak ada data login atau statusnya bukan "true"
    if (statusLogin !== "true") {
        alert("Silakan login terlebih dahulu untuk menambahkan barang ke keranjang!");
        window.location.href = "login.html"; // Arahkan pengguna ke halaman login
        return; // Hentikan fungsi di sini agar barang tidak dimasukkan ke keranjang
    }
    let itemDitemukan = cart.find(item => item.nama === nama);

    if (itemDitemukan) {
        itemDitemukan.jumlah += 1;
    } else {
        cart.push({
            nama: nama,
            harga: harga,
            jumlah: 1,
            gambar: gambar // <--- 2. Tambahkan baris ini agar letak foto disimpan
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
    window.location.href = "checkout.html";
}
// Mengecek status login saat halaman dimuat
document.addEventListener("DOMContentLoaded", function() {
    const isLoggedIn = localStorage.getItem("isLoggedIn");
    const namaUser = localStorage.getItem("namaUser");

    if (isLoggedIn === "true") {
        // Jika sudah login: Sembunyikan 'Login', tampilkan 'Halo [User]' dan 'Logout'
        document.getElementById("nav-login").style.display = "none";
        
        document.getElementById("nav-user").style.display = "inline";
        document.getElementById("nama-user").innerText = namaUser;
        document.getElementById("nav-logout").style.display = "inline";
    }
});

// Fungsi untuk proses Logout
function logout() {
    // Menghapus data login dari browser
    localStorage.removeItem("isLoggedIn");
    localStorage.removeItem("namaUser");
    
    window.location.reload(); 
}

function prosesLogin() {
    // 1. Ambil email yang sedang diketik user saat login
    let emailYangDiketik = document.getElementById("emailInput").value;

    // Pengecekan jika email kosong
    if(emailYangDiketik.trim() === "") {
        alert("Masukkan email Anda!");
        return;
    }

    // 2. Cari nama di memori browser BERDASARKAN email tersebut
    let namaAkun = localStorage.getItem(emailYangDiketik);

    // 3. Jika email tidak ditemukan di memori (belum daftar)
    if (!namaAkun) {
        alert("Email tidak ditemukan. Silakan daftar terlebih dahulu!");
        return;
    }

    // 4. Jika email ditemukan, lanjutkan proses login
    localStorage.setItem("isLoggedIn", "true");
    
    // Set nama user yang sedang aktif agar dibaca oleh index.html dan checkout.html
    localStorage.setItem("namaUser", namaAkun); 

    alert("Login berhasil! Selamat datang, " + namaAkun);
    window.location.href = "index.html"; 
}
