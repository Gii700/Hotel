<?php
session_start();
include '../koneksi.php';

// Proses Aksi Admin via POST (Tombol)
if (isset($_POST['aksi'])) {
    if ($_POST['aksi'] == 'acc') {
        $_SESSION['status_pesanan'] = 'Disetujui (ACC Admin) ✅';
        $msg = 'Pesanan berhasil disetujui (ACC)!';
    } elseif ($_POST['aksi'] == 'tolak') {
        $_SESSION['status_pesanan'] = 'Ditolak Admin ❌';
        $msg = 'Pesanan berhasil ditolak.';
    }
    echo "<script>alert('$msg'); window.location='admin.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin - Grand Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #f1f5f9; color: #0f172a; padding: 40px 20px; }
        .container { max-width: 950px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); }
        h2 { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 12px 14px; text-align: left; font-size: 13px; border-bottom: 1px solid #e2e8f0; }
        th { background-color: #f8fafc; color: #475569; font-weight: 600; text-transform: uppercase; font-size: 11px; }
        td { color: #1e293b; }
        .btn { padding: 8px 14px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; display: inline-block; transition: background 0.2s; }
        .btn-success { background-color: #16a34a; color: white; }
        .btn-success:hover { background-color: #15803d; }
        .btn-danger { background-color: #dc2626; color: white; }
        .btn-danger:hover { background-color: #b91c1c; }
        .btn-back { display: inline-block; background-color: #0f172a; color: white; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 600; }
        .alert { background: #f8fafc; padding: 15px; border-radius: 6px; border: 1px solid #e2e8f0; font-size: 13px; color: #475569; text-align: center; }
        .action-form { display: inline-block; margin-right: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Panel Admin: Verifikasi & Persetujuan (ACC) Pesanan Hotel</h2>

        <?php if (isset($_SESSION['selected_room_id'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Pemesan</th>
                        <th>Kamar</th>
                        <th>Check-In / Tanggal</th>
                        <th>Pembayaran</th>
                        <th>Status Saat Ini</th>
                        <th>Aksi Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong><?= $_SESSION['username'] ?? 'Gio Maulana Wijaya' ?></strong></td>
                        <td>Kamar No. <?= $_SESSION['selected_room_id'] ?></td>
                        <td><?= $_SESSION['selected_tanggal'] ?? date('Y-m-d') ?></td>
                        <td><?= $_SESSION['metode_pembayaran'] ?? 'Transfer BCA' ?></td>
                        <td>
                            <?php 
                                $status = $_SESSION['status_pesanan'] ?? 'Menunggu Konfirmasi Admin';
                                $color = '#d97706';
                                if (strpos($status, 'Disetujui') !== false) $color = '#16a34a';
                                elseif (strpos($status, 'Ditolak') !== false) $color = '#dc2626';
                            ?>
                            <span style="font-weight: 600; color: <?= $color ?>;"><?= $status ?></span>
                        </td>
                        <td>
                            <!-- Menggunakan Form dan Tombol agar tidak berupa link teks biasa -->
                            <form method="POST" class="action-form" onsubmit="return confirm('Setujui (ACC) pesanan ini?')">
                                <input type="hidden" name="aksi" value="acc">
                                <button type="submit" class="btn btn-success">ACC</button>
                            </form>

                            <form method="POST" class="action-form" onsubmit="return confirm('Tolak pesanan ini?')">
                                <input type="hidden" name="aksi" value="tolak">
                                <button type="submit" class="btn btn-danger">Tolak</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert">Belum ada pesanan masuk dari user untuk diverifikasi.</div>
        <?php endif; ?>

        <br>
        <a href="index.php" class="btn-back">Kembali ke Beranda User</a>
        <a href="crud_kamar.php" class="btn-back" style="background-color: #2563eb; margin-left: 10px;">Buka CRUD Kamar</a>
    </div>
</body>
</html>