<?php
session_start();

// Tangkap data dari form dengan aman
$hotel_dipilih = $_POST['hotel_dipilih'] ?? $_POST['nama_hotel'] ?? 'Tidak diketahui';
$nama          = $_POST['nama'] ?? 'Tamu';
$telepon       = $_POST['telepon'] ?? '-';
$kamarPilihan  = $_POST['kamarPilihan'] ?? 'Standar';
$checkin       = $_POST['checkin'] ?? date('Y-m-d');
$checkout      = $_POST['checkout'] ?? date('Y-m-d', strtotime('+1 day'));
$metode        = $_POST['metode'] ?? 'Tunai';
$harga         = $_POST['harga'] ?? 'Rp 0';

// Simpan data pemesanan ke dalam array riwayat di Session agar bisa dilihat di riwayat.php
if (!isset($_SESSION['riwayat'])) {
    $_SESSION['riwayat'] = [];
}

// Tambahkan pesanan baru ke awal array riwayat
array_unshift($_SESSION['riwayat'], [
    'hotel'   => $hotel_dipilih,
    'nama'    => $nama,
    'telepon' => $telepon,
    'kamar'   => $kamarPilihan,
    'checkin' => $checkin,
    'checkout'=> $checkout,
    'metode'  => $metode,
    'harga'   => $harga,
    'tanggal_pesan' => date('Y-m-d H:i:s')
]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket Pemesanan - Grand Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f3f4f6;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
        }
        .ticket-wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        .ticket-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #ffffff;
            padding: 25px;
            text-align: center;
        }
        .ticket-header h2 {
            margin: 0 0 5px 0;
            font-size: 22px;
        }
        .ticket-header p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .ticket-body {
            padding: 30px;
        }
        .ticket-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px dashed #e5e7eb;
            font-size: 14px;
        }
        .ticket-row:last-child {
            border-bottom: none;
        }
        .ticket-row span.label {
            color: #6b7280;
            font-weight: 500;
        }
        .ticket-row span.value {
            color: #111827;
            font-weight: 600;
            text-align: right;
        }
        .ticket-footer {
            background: #f9fafb;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e5e7eb;
        }
        .btn-home {
            background: #2563eb;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: background 0.2s;
        }
        .btn-home:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-left">
                <a href="index.php" class="logo">grand<span>hotel</span></a>
            </div>
            <div class="nav-right">
                <a href="riwayat.php" style="color: #2563eb; font-weight: 600; text-decoration: none; font-size: 14px;">Lihat Riwayat Pesanan</a>
            </div>
        </div>
    </nav>

    <!-- TIKET / BUKTI PEMESANAN -->
    <main>
        <div class="ticket-wrapper">
            <div class="ticket-header">
                <h2>🎉 Pemesanan Berhasil!</h2>
                <p>Terima kasih telah melakukan reservasi di Grand Hotel.</p>
            </div>
            
            <div class="ticket-body">
                <div class="ticket-row">
                    <span class="label">Hotel</span>
                    <span class="value"><?php echo htmlspecialchars($hotel_dipilih); ?></span>
                </div>
                <div class="ticket-row">
                    <span class="label">Nama Pemesan</span>
                    <span class="value"><?php echo htmlspecialchars($nama); ?></span>
                </div>
                <div class="ticket-row">
                    <span class="label">No. Telepon</span>
                    <span class="value"><?php echo htmlspecialchars($telepon); ?></span>
                </div>
                <div class="ticket-row">
                    <span class="label">Tipe Kamar</span>
                    <span class="value"><?php echo htmlspecialchars($kamarPilihan); ?></span>
                </div>
                <div class="ticket-row">
                    <span class="label">Tanggal Check-in</span>
                    <span class="value"><?php echo htmlspecialchars($checkin); ?></span>
                </div>
                <div class="ticket-row">
                    <span class="label">Tanggal Check-out</span>
                    <span class="value"><?php echo htmlspecialchars($checkout); ?></span>
                </div>
                <div class="ticket-row">
                    <span class="label">Metode Pembayaran</span>
                    <span class="value"><?php echo htmlspecialchars($metode); ?></span>
                </div>
                <div class="ticket-row" style="margin-top: 10px; padding-top: 15px; border-top: 2px solid #e5e7eb;">
                    <span class="label" style="font-size: 16px; color: #111827;">Total Harga</span>
                    <span class="value" style="font-size: 18px; color: #ef4444;"><?php echo htmlspecialchars($harga); ?></span>
                </div>
            </div> <!-- ✨ Penutup div ticket-body yang sebelumnya kurang -->
        
            <div class="ticket-footer">
                <span style="font-size: 13px; color: #6b7280;">Simpan bukti pesanan ini.</span>
                <a href="index.php" class="btn-home">Kembali ke Beranda</a>
            </div>
        </div>
    </main>

</body>
</html>