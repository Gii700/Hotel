<?php
session_start();
include '../koneksi.php';

// Cek data dari database
$check_query = "SELECT * FROM kamar";
$rooms = mysqli_query($conn, $check_query);

$all_rooms = [];
if ($rooms && mysqli_num_rows($rooms) > 0) {
    while ($row = mysqli_fetch_assoc($rooms)) {
        $all_rooms[] = $row;
    }
} else {
    // Data dummy elegan jika database kosong
    $all_rooms = [
        ['id' => 1, 'nama_kamar' => 'Deluxe Suite Room', 'harga' => 'Rp 750.000', 'img' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80'],
        ['id' => 2, 'nama_kamar' => 'Executive King Room', 'harga' => 'Rp 1.200.000', 'img' => 'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=600&q=80'],
        ['id' => 3, 'nama_kamar' => 'Superior Twin Room', 'harga' => 'Rp 500.000', 'img' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=600&q=80']
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Grand Hotel — Reservasi Kamar</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #fafafa;
            color: #0f172a;
        }

        /* Navbar Minimalis Elegan */
        .hotel-nav {
            background-color: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 80px;
            border-bottom: 1px solid #f1f5f9;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .logo span {
            color: #2563eb;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .nav-link {
            text-decoration: none;
            color: #475569;
            font-weight: 500;
            font-size: 14px;
        }

        .btn-login {
            text-decoration: none;
            color: #0f172a;
            font-weight: 600;
            padding: 8px 16px;
            font-size: 14px;
        }

        .btn-register {
            text-decoration: none;
            background-color: #0f172a;
            color: white;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 6px;
            font-size: 14px;
            transition: background 0.2s;
        }

        .btn-register:hover {
            background-color: #334155;
        }

        /* Hero Section Simpel */
        .hero-section {
            background: #ffffff;
            padding: 50px 20px 40px 20px;
            text-align: center;
            border-bottom: 1px solid #f1f5f9;
        }

        .hero-content h1 {
            font-size: 32px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .hero-content p {
            font-size: 15px;
            color: #64748b;
            margin-bottom: 30px;
        }

        /* Search Bar Clean */
        .search-box-container {
            max-width: 850px;
            margin: 0 auto;
            background: #ffffff;
            padding: 12px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            border: 1px solid #e2e8f0;
        }

        .search-form {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-field {
            flex: 1;
            display: flex;
            flex-direction: column;
            text-align: left;
            padding: 0 12px;
            border-right: 1px solid #f1f5f9;
        }

        .search-field:last-of-type {
            border-right: none;
        }

        .search-field label {
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .search-field input, .search-field select {
            border: none;
            font-size: 13px;
            font-weight: 600;
            outline: none;
            background: transparent;
            color: #0f172a;
        }

        .btn-search-action {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-search-action:hover {
            background-color: #1d4ed8;
        }

        /* Container Main */
        .container-main {
            max-width: 1100px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-title span.subtitle {
            font-size: 13px;
            font-weight: 500;
            color: #64748b;
        }

        /* Grid Kartu Kamar */
        .room-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
            gap: 24px;
            margin-bottom: 50px;
        }

        .room-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .room-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .room-img-container {
            width: 100%;
            height: 180px;
            overflow: hidden;
            position: relative;
        }

        .room-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .room-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(4px);
            color: white;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 4px;
        }

        .room-info {
            padding: 20px;
        }

        .room-info h3 {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .room-price {
            font-size: 14px;
            font-weight: 600;
            color: #2563eb;
            margin-bottom: 16px;
        }

        .btn-book {
            display: block;
            text-align: center;
            background-color: #f8fafc;
            color: #0f172a;
            border: 1px solid #cbd5e1;
            text-decoration: none;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.2s;
        }

        .btn-book:hover {
            background-color: #0f172a;
            color: white;
            border-color: #0f172a;
        }
    </style>
</head>
<body>

    <header class="hotel-nav">
        <h2 class="logo">Grand<span>Hotel</span></h2>
        <div class="nav-right">
            <?php if(isset($_SESSION['username'])): ?>
                <a href="riwayat.php" class="nav-link">Riwayat Pesanan</a>
                <a href="../logout.php" class="btn-register">Logout</a>
            <?php else: ?>
                <a href="../Login/login.php" class="btn-login">Masuk</a>
                <a href="../Login/register.php" class="btn-register">Daftar</a>
            <?php endif; ?>
        </div>
    </header>

    <section class="hero-section">
        <div class="hero-content">
            <h1>Temukan Kamar Ideal Anda</h1>
            <p>Pengalaman menginap modern dengan kenyamanan maksimal.</p>
        </div>

        <div class="search-box-container">
            <form action="index.php" method="GET" class="search-form">
                <div class="search-field">
                    <label>Pencarian</label>
                    <input type="text" name="keyword" placeholder="Cari nama kamar...">
                </div>
                <div class="search-field">
                    <label>Tanggal Check-In</label>
                    <input type="date" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="search-field">
                    <label>Tipe Sewa</label>
                    <select name="tipe_sewa">
                        <option>Full Day (1 Hari)</option>
                        <option>Transit (Setengah Hari)</option>
                    </select>
                </div>
                <button type="submit" class="btn-search-action">Cari</button>
            </form>
        </div>
    </section>

    <main class="container-main">

        <!-- 🌟 REKOMENDASI UNGGULAN -->
        <div class="section-title">
            <span>🌟 Rekomendasi Pilihan</span>
            <span class="subtitle">Kamar favorit dengan fasilitas terbaik</span>
        </div>
        
        <div class="room-grid">
            <?php 
            $recommended = array_slice($all_rooms, 0, 2);
            foreach($recommended as $index => $room): 
                // Gambar estetik acak untuk rekomendasi
                $img_url = isset($room['img']) ? $room['img'] : ($index === 0 ? 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=600&q=80' : 'https://images.unsplash.com/photo-1591088398332-8a7791972843?auto=format&fit=crop&w=600&q=80');
            ?>
                <div class="room-card">
                    <div class="room-img-container">
                        <span class="room-badge">Best Choice</span>
                        <img src="<?= $img_url ?>" alt="Foto Kamar Hotel">
                    </div>
                    <div class="room-info">
                        <h3><?= isset($room['nama_kamar']) ? $room['nama_kamar'] : 'Kamar ID: ' . $room['id'] ?></h3>
                        <div class="room-price"><?= isset($room['harga']) ? $room['harga'] : 'Rp 650.000 / malam' ?></div>
                        
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <a href="detail.php?id=<?= $room['id'] ?? 1 ?>" class="btn-book">Pesan Sekarang</a>
                        <?php else: ?>
                            <a href="../Login/login.php" class="btn-book">Login untuk Pesan</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- SEMUA KAMAR -->
        <div class="section-title">
            <span>Semua Kamar Tersedia</span>
        </div>

        <div class="room-grid">
            <?php foreach($all_rooms as $index => $room): 
                $img_url = isset($room['img']) ? $room['img'] : 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=600&q=80';
            ?>
                <div class="room-card">
                    <div class="room-img-container">
                        <span class="room-badge">Tersedia</span>
                        <img src="<?= $img_url ?>" alt="Foto Kamar Hotel">
                    </div>
                    <div class="room-info">
                        <h3><?= isset($room['nama_kamar']) ? $room['nama_kamar'] : 'Kamar ID: ' . $room['id'] ?></h3>
                        <div class="room-price"><?= isset($room['harga']) ? $room['harga'] : 'Rp 500.000 / malam' ?></div>
                        
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <a href="detail.php?id=<?= $room['id'] ?? 1 ?>" class="btn-book">Pesan Sekarang</a>
                        <?php else: ?>
                            <a href="../Login/login.php" class="btn-book">Login untuk Pesan</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </main>

</body>
</html>