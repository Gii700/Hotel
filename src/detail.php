<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login/login.php");
    exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : 1;
$query = mysqli_query($conn, "SELECT * FROM kamar");
$room = null;

if ($query && mysqli_num_rows($query) > 0) {
    $index = 0;
    while ($row = mysqli_fetch_assoc($query)) {
        foreach ($row as $val) {
            if ($val == $id || $index == ($id - 1)) {
                $room = $row;
                break 2;
            }
        }
        $index++;
    }
    if (!$room) {
        mysqli_data_seek($query, 0);
        $room = mysqli_fetch_assoc($query);
    }
}

$variasi_kamar = [
    ['tipe' => 'Deluxe Suite', 'luas' => '32.0 m²', 'bed' => '1 King Bed', 'fasilitas' => 'AC, Free WiFi, TV LED 43 inch, Kulkas Mini'],
    ['tipe' => 'Executive Pool Villa', 'luas' => '124.0 m²', 'bed' => '1 King Bed & Sofa Bed', 'fasilitas' => 'Kolam Renang Privat, Balkon / Teras, AC, Free WiFi, Bathtub'],
    ['tipe' => 'Family Superior', 'luas' => '45.0 m²', 'bed' => '2 Queen Beds', 'fasilitas' => 'AC, Free WiFi, Ruang Keluarga, Pembuat Kopi/Teh']
];

$random_index = (intval($id) - 1) % count($variasi_kamar);
$info = $variasi_kamar[$random_index >= 0 ? $random_index : 0];

$room_id = $id;
$tipe = $room['tipe_kamar'] ?? $room['type'] ?? $info['tipe'];
$nomor = $room['nomor_kamar'] ?? $room['room_number'] ?? '0' . $id;
$harga_full = $room['harga_full'] ?? $room['price_full'] ?? (500000 + ($id * 150000));
$harga_half = $room['harga_half'] ?? $room['price_half'] ?? (300000 + ($id * 75000));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Kamar & Pembayaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #f1f5f9; color: #0f172a; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
        .container { background: #ffffff; width: 100%; max-width: 480px; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        h2 { font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 20px; text-align: center; }
        .room-card { background: #f8fafc; padding: 16px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 20px; }
        .room-card h3 { font-size: 16px; color: #1e293b; margin-bottom: 8px; }
        .room-card p { font-size: 13px; color: #475569; margin-bottom: 4px; }
        label { display: block; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; }
        select, input[type="date"] { width: 100%; padding: 11px 14px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; background-color: #ffffff; color: #0f172a; margin-bottom: 15px; }
        button { width: 100%; background-color: #2563eb; color: white; border: none; padding: 12px; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer; transition: background 0.2s; margin-top: 5px; }
        button:hover { background-color: #1d4ed8; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Konfirmasi & Pembayaran</h2>
        
        <div class="room-card">
            <h3><?= $tipe ?> (No. Kamar: <?= $nomor ?>)</h3>
            <p>📐 Luas: <strong><?= $info['luas'] ?></strong> | 🛏️ Bed: <strong><?= $info['bed'] ?></strong></p>
            <p>✨ Fasilitas: <strong><?= $info['fasilitas'] ?></strong></p>
        </div>

        <form action="proses.php" method="POST">
            <input type="hidden" name="room_id" value="<?= $room_id ?>">
            
            <label>Check-In (Dari Tanggal):</label>
            <input type="date" name="checkin" value="<?= date('Y-m-d') ?>" required>

            <label>Check-Out (Sampai Tanggal):</label>
            <input type="date" name="checkout" value="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>

            <label>Jenis Menginap:</label>
            <select name="booking_type" required>
                <option value="full">Full Day (1 Hari Penuh) - Rp <?= number_format($harga_full, 0, ',', '.') ?></option>
                <option value="half">Setengah Hari (Transit) - Rp <?= number_format($harga_half, 0, ',', '.') ?></option>
            </select>

            <label>Metode Pembayaran:</label>
            <select name="metode_pembayaran" required>
                <option value="Transfer BCA">Transfer Bank BCA (123-456-7890)</option>
                <option value="Transfer Mandiri">Transfer Bank Mandiri (098-765-4321)</option>
                <option value="QRIS">QRIS / E-Wallet (GoPay/OVO/Dana)</option>
                <option value="Bayar di Hotel">Bayar Langsung di Resepsionis Hotel</option>
            </select>

            <button type="submit" name="pesan">Bayar & Pesan Sekarang</button>
        </form>
    </div>
</body>
</html>