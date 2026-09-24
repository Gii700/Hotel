<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_hotel";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Data Array Hotel (untuk mendukung halaman detail & index)
$daftar_hotel = [
    'bandung' => [
        'nama' => 'Urbanview Hotel Sakura Bandung',
        'lokasi' => 'Jl. Cihampelas No.3, Tamansari, Kota Bandung, Jawa Barat',
        'harga' => 'Rp 144.435',
        'skor' => '8.5',
        'label_ulasan' => 'Mengesankan',
        'jumlah_ulasan' => '315 ulasan',
        'pengulas' => 'Budi Santoso',
        'deskripsi_ulasan' => 'Lokasinya sangat strategis di tengah kota, dekat dengan pusat perbelanjaan dan kuliner. Kamarnya bersih, nyaman, dan stafnya ramah.',
        'img_main' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=600&q=80',
        'img_thumb1' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&w=200&q=80',
        'img_thumb2' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=200&q=80'
    ],
    'jakarta' => [
        'nama' => 'Grand Luxury Hotel Menteng Jakarta',
        'lokasi' => 'Jl. MH Thamrin No.10, Menteng, Jakarta Pusat, DKI Jakarta',
        'harga' => 'Rp 650.000',
        'skor' => '9.2',
        'label_ulasan' => 'Luar Biasa',
        'jumlah_ulasan' => '540 ulasan',
        'pengulas' => 'Siti Aminah',
        'deskripsi_ulasan' => 'Fasilitas bintang lima yang sangat memuaskan. Kolam renang bersih dan menu sarapannya sangat bervariasi serta enak.',
        'img_main' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=600&q=80',
        'img_thumb1' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=200&q=80',
        'img_thumb2' => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=200&q=80'
    ]
];
?>