<?php
session_start();
include '../koneksi.php';

// Filter kota sederhana
$filter_kota = isset($_GET['kota']) ? $_GET['kota'] : 'semua';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari dan Book hotel dan penginapan murah - GrandHotel</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">grand<span>hotel</span></a>
            
            <div class="nav-right" style="display: flex; align-items: center; gap: 10px;">
                <a href="riwayat.php" class="btn-login">📋 Riwayat Pesanan</a>
                <?php if (isset($_SESSION['user_logged'])): ?>
                    <span style="font-weight: 600; font-size: 14px; margin-left: 10px;">Halo, <?= $_SESSION['user_name']; ?></span>
                    <a href="../logout.php" class="btn-register" style="background: #ef4444;">Logout</a>
                <?php else: ?>
                    <a href="../login.php" class="btn-login">Log In</a>
                    <a href="../register.php" class="btn-register">Daftar</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <div class="hero-simple">
        <h1>Pilihan Hotel Terbaik di Jakarta & Bandung</h1>
        <p>Nikmati pengalaman menginap nyaman dengan harga spesial dan ulasan terpercaya.</p>
    </div>

    <!-- MAIN CONTAINER -->
    <div class="hotel-list-container">
        <!-- FILTER FORM -->
        <form action="" method="GET" class="filter-container">
            <select name="kota">
                <option value="semua">Semua Kota</option>
                <option value="bandung" <?= ($filter_kota == 'bandung') ? 'selected' : ''; ?>>Bandung</option>
                <option value="jakarta" <?= ($filter_kota == 'jakarta') ? 'selected' : ''; ?>>Jakarta</option>
            </select>
            <button type="submit">Cari</button>
        </form>

        <!-- LIST HOTEL -->
        <?php foreach ($daftar_hotel as $key => $hotel): ?>
            <?php if ($filter_kota == 'semua' || $filter_kota == $key): ?>
            <div class="hotel-card">
                <div class="hotel-images">
                    <div class="img-main">
                        <img src="<?= $hotel['img_main']; ?>" alt="<?= $hotel['nama']; ?>">
                    </div>
                    <div class="img-thumbs">
                        <img src="<?= $hotel['img_thumb1']; ?>" alt="Thumb 1">
                        <img src="<?= $hotel['img_thumb2']; ?>" alt="Thumb 2">
                    </div>
                </div>

                <div class="hotel-info">
                    <div class="hotel-badges">
                        <span class="badge-type">Hotel</span>
                        <span class="badge-star">⭐⭐⭐</span>
                        <span class="badge-partner">Preferred Partner</span>
                    </div>
                    <h3><?= $hotel['nama']; ?></h3>
                    <p class="hotel-address">📍 <?= $hotel['lokasi']; ?></p>
                    <div class="hotel-rating">
                        <span class="score"><?= $hotel['skor']; ?></span>
                        <span class="text"><strong><?= $hotel['label_ulasan']; ?></strong> (<?= $hotel['jumlah_ulasan']; ?>)</span>
                    </div>
                </div>

                <div class="hotel-action">
                    <div class="price-box">
                        <span class="label">Harga mulai dari</span>
                        <span class="old-price">Rp 182.310</span>
                        <span class="current-price"><?= $hotel['harga']; ?></span>
                        <span class="tax">termasuk pajak & biaya</span>
                    </div>
                    <a href="detail.php?id=<?= $key; ?>" class="btn-choose-room">Pilih Kamar</a>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

</body>
</html>