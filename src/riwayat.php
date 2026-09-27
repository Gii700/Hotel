<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login/login.php");
    exit;
}

// Set tanggal booking otomatis hari ini jika belum ada
if (!isset($_SESSION['selected_tanggal'])) {
    $_SESSION['selected_tanggal'] = date('Y-m-d');
}

// Ambil nama user yang sedang login (opsional, fallback ke 'Tamu Hotel')
$nama_pemesan = $_SESSION['username'] ?? $_SESSION['nama'] ?? 'Gio Maulana Wijaya';

// Proses Hapus / Batalkan Pesanan (Delete)
if (isset($_GET['hapus'])) {
    unset($_SESSION['selected_room_id']);
    unset($_SESSION['selected_booking_type']);
    unset($_SESSION['selected_tanggal']);
    unset($_SESSION['status_pesanan']);
    
    @mysqli_query($conn, "DELETE FROM reservasi");
    
    echo "<script>alert('Pesanan berhasil dibatalkan (gajadi booking)!'); window.location='riwayat.php';</script>";
    exit;
}

// Proses Update / Edit Pesanan jika ada kiriman form edit
if (isset($_POST['update_pesanan'])) {
    $_SESSION['selected_booking_type'] = mysqli_real_escape_string($conn, $_POST['booking_type']);
    $_SESSION['selected_tanggal'] = mysqli_real_escape_string($conn, $_POST['tanggal_booking']);
    echo "<script>alert('Pesanan berhasil diubah!'); window.location='riwayat.php';</script>";
    exit;
}

$edit_mode = isset($_GET['edit']);
$status_pesanan = $_SESSION['status_pesanan'] ?? 'Menunggu Konfirmasi Admin';

// Tentukan warna status
$warna_status = '#d97706'; // Oranye default
if (strpos($status_pesanan, 'Disetujui') !== false) {
    $warna_status = '#16a34a'; // Hijau
} elseif (strpos($status_pesanan, 'Ditolak') !== false) {
    $warna_status = '#dc2626'; // Merah
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Pesanan Saya - Grand Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #f1f5f9; color: #0f172a; padding: 40px 20px; }
        .container { max-width: 900px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        h2, h3 { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 12px 14px; text-align: left; font-size: 13px; border-bottom: 1px solid #e2e8f0; }
        th { background-color: #f8fafc; color: #475569; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
        td { color: #1e293b; }
        .btn { padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: 600; display: inline-block; cursor: pointer; border: none; }
        .btn-warning { background-color: #d97706; color: white; }
        .btn-warning:hover { background-color: #b45309; }
        .btn-danger { background-color: #dc2626; color: white; }
        .btn-danger:hover { background-color: #b91c1c; }
        .btn-back { display: inline-block; background-color: #0f172a; color: white; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 600; }
        .btn-back:hover { background-color: #334155; }
        .alert { background: #f8fafc; padding: 15px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 13px; color: #475569; text-align: center; }
        .form-edit { background: #f8fafc; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-size: 11px; font-weight: 700; color: #475569; margin-bottom: 5px; text-transform: uppercase; }
        select, input { padding: 10px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 6px; width: 100%; outline: none; background: #fff; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Kelola Pesanan Saya (Batal / Ubah)</h2>

        <?php if ($edit_mode && isset($_SESSION['selected_room_id'])): ?>
            <div class="form-edit">
                <h3>Ubah Detail Pesanan</h3>
                <form method="POST" style="margin-top: 10px;">
                    <div class="form-group">
                        <label>Tanggal Booking</label>
                        <input type="date" name="tanggal_booking" value="<?= $_SESSION['selected_tanggal'] ?? date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Menginap</label>
                        <select name="booking_type" required>
                            <option value="full" <?= (($_SESSION['selected_booking_type'] ?? '') == 'full') ? 'selected' : '' ?>>Full Day (1 Hari Penuh)</option>
                            <option value="half" <?= (($_SESSION['selected_booking_type'] ?? '') == 'half') ? 'selected' : '' ?>>Setengah Hari (Transit)</option>
                        </select>
                    </div>
                    <button type="submit" name="update_pesanan" class="btn btn-warning">Simpan Perubahan</button>
                    <a href="riwayat.php" class="btn" style="background: #64748b; color: white;">Batal</a>
                </form>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['selected_room_id'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemesan</th>
                        <th>ID Kamar</th>
                        <th>Tanggal Booking</th>
                        <th>Jenis Menginap</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><strong><?= htmlspecialchars($nama_pemesan) ?></strong></td>
                        <td><?= $_SESSION['selected_room_id'] ?></td>
                        <td><?= $_SESSION['selected_tanggal'] ?? date('Y-m-d') ?></td>
                        <td><?= ucfirst($_SESSION['selected_booking_type'] ?? 'Full Day') ?></td>
                        <td><span style="color: <?= $warna_status ?>; font-weight: 600;"><?= htmlspecialchars($status_pesanan) ?></span></td>
                        <td>
                            <a href="riwayat.php?edit=true" class="btn btn-warning">Ubah</a>
                            <a href="riwayat.php?hapus=1" class="btn btn-danger" onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">Batalkan</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert">Belum ada pesanan aktif. Silakan pilih kamar terlebih dahulu di beranda.</div>
        <?php endif; ?>

        <br>
        <a href="index.php" class="btn-back">Kembali ke Beranda</a>
    </div>
</body>
</html>