<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Grand Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <a href="index.php" class="logo">grand<span>hotel</span></a>
            </div>
            <div class="nav-right">
                <a href="index.php" class="btn-login">&laquo; Kembali ke Beranda</a>
            </div>
        </div>
    </nav>

    <div class="detail-container" style="max-width: 1100px;">
        <div class="detail-header">
            <h2>Riwayat Pesanan Kamar</h2>
            <p>Daftar reservasi hotel yang berhasil kamu buat melalui aplikasi.</p>
        </div>

        <?php if (!empty($_SESSION['riwayat'])): ?>
            <div style="overflow-x: auto;">
                <table class="table-history">
                    <thead>
                        <tr>
                            <th>Waktu Booking</th>
                            <th>Nama Hotel</th>
                            <th>Tamu</th>
                            <th>Kamar</th>
                            <th>Check-In / Out</th>
                            <th>Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['riwayat'] as $pesanan): ?>
                        <tr>
                            <td><?php echo $pesanan['tanggal_pesan'] ?? '-'; ?></td>
                            <td><strong><?php echo $pesanan['hotel'] ?? '-'; ?></strong></td>
                            <td><?php echo $pesanan['nama'] ?? '-'; ?><br><small><?php echo $pesanan['telepon'] ?? '-'; ?></small></td>
                            <td><?php echo $pesanan['kamar'] ?? '-'; ?></td>
                            <td><?php echo $pesanan['checkin'] ?? '-'; ?> s/d <?php echo $pesanan['checkout'] ?? '-'; ?></td>
                            <td><span style="background: #e6f0ff; color: #0064fa; padding: 4px 8px; border-radius: 4px; font-weight: 600;"><?php echo $pesanan['metode'] ?? '-'; ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 20px;">
                <a href="riwayat.php?hapus=1" style="font-size: 13px; color: #ef4444; text-decoration: none; font-weight: 600;">🗑️ Bersihkan Riwayat</a>
            </div>
            <?php 
                if (isset($_GET['hapus'])) {
                    unset($_SESSION['riwayat']);
                    header("Location: riwayat.php");
                    exit;
                }
            ?>
        <?php else: ?>
            <div class="section-box" style="text-align: center; padding: 40px;">
                <p style="color: #6b7280; margin-bottom: 15px;">Belum ada riwayat pesanan kamar yang tercatat.</p>
                <a href="index.php" class="btn-choose-room" style="display: inline-block; width: auto; padding: 10px 25px;">Mulai Cari Hotel</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>