<?php
session_start();
include '../koneksi.php';

$id = isset($_GET['id']) ? $_GET['id'] : 'bandung';
if (!array_key_exists($id, $daftar_hotel)) {
    $id = 'bandung';
}
$hotel = $daftar_hotel[$id];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail <?= $hotel['nama']; ?> - GrandHotel</title>
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

    <!-- DETAIL CONTAINER -->
    <div class="detail-page-container">
        <div style="margin-bottom: 20px;">
            <a href="index.php" class="btn-login" style="background: #e2e8f0; padding: 8px 14px; border-radius: 8px;">« Kembali ke Daftar Hotel</a>
        </div>

        <div class="hotel-detail-grid">
            <!-- Kolom Kiri: Galeri & Info -->
            <div>
                <div class="gallery-box">
                    <div class="gallery-main">
                        <img src="<?= $hotel['img_main']; ?>" alt="Main Image">
                    </div>
                    <div class="gallery-thumbs">
                        <img src="<?= $hotel['img_thumb1']; ?>" alt="Thumb 1">
                        <img src="<?= $hotel['img_thumb2']; ?>" alt="Thumb 2">
                    </div>
                </div>

                <div class="content-card">
                    <h3 class="section-title">Penilaian & Ulasan Tamu</h3>
                    <div style="margin-bottom: 10px;">
                        <strong style="color: #2563eb; font-size: 18px;"><?= $hotel['skor']; ?>/10</strong> 
                        <span style="font-weight: 700; color: #1e293b;">(<?= $hotel['label_ulasan']; ?>)</span>
                    </div>
                    <p style="font-size: 13px; color: #64748b; margin-bottom: 4px;"><strong><?= $hotel['pengulas']; ?></strong></p>
                    <p style="font-size: 13px; font-style: italic; color: #334151;">"<?= $hotel['deskripsi_ulasan']; ?>"</p>
                </div>

                <div class="content-card">
                    <h3 class="section-title">Fasilitas Utama</h3>
                    <div class="facilities-grid">
                        <div>📶 Wi-Fi Gratis</div>
                        <div>❄️ AC di Setiap Ruangan</div>
                        <div>🅿️ Area Parkir Luas</div>
                        <div>🏊 Kolam Renang</div>
                        <div>🛎️ Resepsionis 24 Jam</div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Form Pesan Kamar -->
            <div>
                <div class="booking-card">
                    <h3 class="section-title">Pilih Tanggal & Pesan Kamar</h3>
                    <form action="proses.php" method="POST">
                        <input type="hidden" name="hotel_dipilih" value="<?= $hotel['nama']; ?>">
                        
                        <div class="form-group">
                            <label>Nama Pemesan / Tamu</label>
                            <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>
                        </div>
                        <div class="form-group">
                            <label>No. Telepon / WhatsApp</label>
                            <input type="text" name="telepon" placeholder="Contoh: 08123456789" required>
                        </div>
                        <div class="form-group">
                            <label>Pilih Tipe Kamar</label>
                            <select name="kamarPilihan" id="pilihan_kamar" onchange="updateHarga()">
                                <option value="Superior Room" data-harga="Rp 350.000">Superior Room - Rp 350.000 / malam</option>
                                <option value="Deluxe Room" data-harga="Rp 500.000">Deluxe Room - Rp 500.000 / malam</option>
                                <option value="Suite Room" data-harga="Rp 750.000">Suite Room - Rp 750.000 / malam</option>
                            </select>
                        </div>
                        <!-- Input hidden untuk mengirim harga ke proses.php -->
                        <input type="hidden" name="harga" id="input_harga" value="Rp 350.000">

                        <div class="form-group">
                            <label>Tanggal Check-In</label>
                            <input type="date" name="checkin" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Check-Out</label>
                            <input type="date" name="checkout" required>
                        </div>
                        <div class="form-group">
                            <label>Metode Pembayaran</label>
                            <select name="metode">
                                <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                                <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                                <option value="QRIS / E-Wallet">QRIS / E-Wallet</option>
                                <option value="Bayar di Hotel (Cash)">Bayar di Hotel (Cash)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-submit-booking">Konfirmasi & Pesan Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateHarga() {
            var select = document.getElementById('pilihan_kamar');
            var harga = select.options[select.selectedIndex].getAttribute('data-harga');
            document.getElementById('input_harga').value = harga;
        }
    </script>
</body>
</html>