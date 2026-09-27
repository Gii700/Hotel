<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login/login.php");
    exit;
}

// Proses Tambah (Create)
if (isset($_POST['tambah'])) {
    $tipe = mysqli_real_escape_string($conn, $_POST['tipe_kamar']);
    $nomor = mysqli_real_escape_string($conn, $_POST['nomor_kamar']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga_full']);
    
    @mysqli_query($conn, "INSERT INTO kamar (tipe_kamar, nomor_kamar, harga_full) VALUES ('$tipe', '$nomor', '$harga')");
    header("Location: crud_kamar.php");
    exit;
}

// Proses Hapus (Delete)
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    @mysqli_query($conn, "DELETE FROM kamar WHERE id = '$id' OR id_kamar = '$id'");
    header("Location: crud_kamar.php");
    exit;
}

// Ambil data untuk dibaca (Read)
$result = @mysqli_query($conn, "SELECT * FROM kamar");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CRUD Data Kamar - Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #f1f5f9; color: #0f172a; padding: 30px; }
        .container { max-width: 900px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        h2, h3 { color: #0f172a; margin-bottom: 20px; }
        form { background: #f8fafc; padding: 20px; border-radius: 8px; border: 1px solid #e2e8f0; margin-bottom: 25px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-size: 12px; font-weight: 700; color: #475569; margin-bottom: 5px; text-transform: uppercase; }
        input { width: 100%; padding: 10px; font-size: 13px; border: 1px solid #cbd5e1; border-radius: 6px; outline: none; background: #fff; }
        button { background-color: #2563eb; color: white; border: none; padding: 10px 16px; border-radius: 6px; font-weight: 600; font-size: 13px; cursor: pointer; }
        button:hover { background-color: #1d4ed8; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px 14px; text-align: left; font-size: 13px; border-bottom: 1px solid #e2e8f0; }
        th { background-color: #f8fafc; color: #475569; font-weight: 600; text-transform: uppercase; font-size: 11px; }
        .btn-danger { background-color: #dc2626; color: white; padding: 6px 10px; border-radius: 4px; text-decoration: none; font-size: 12px; }
        .btn-danger:hover { background-color: #b91c1c; }
        .btn-back { display: inline-block; margin-top: 20px; background-color: #0f172a; color: white; padding: 10px 16px; border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manajemen CRUD Data Kamar</h2>
        
        <!-- Form Tambah Data (Create) -->
        <form method="POST">
            <h3>Tambah Kamar Baru</h3>
            <div class="form-group">
                <label>Tipe Kamar</label>
                <input type="text" name="tipe_kamar" placeholder="Contoh: Deluxe Suite" required>
            </div>
            <div class="form-group">
                <label>Nomor Kamar</label>
                <input type="text" name="nomor_kamar" placeholder="Contoh: 101" required>
            </div>
            <div class="form-group">
                <label>Harga Full Day</label>
                <input type="number" name="harga_full" placeholder="Contoh: 500000" required>
            </div>
            <button type="submit" name="tambah">Simpan Data (Create)</button>
        </form>

        <!-- Tabel Baca Data (Read) -->
        <h3>Daftar Kamar (Read & Delete)</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tipe Kamar</th>
                    <th>Nomor</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id_kamar = $row['id'] ?? $row['id_kamar'] ?? 1;
                        $tipe = $row['tipe_kamar'] ?? $row['type'] ?? 'Deluxe';
                        $nomor = $row['nomor_kamar'] ?? $row['room_number'] ?? '01';
                        $harga = $row['harga_full'] ?? $row['price_full'] ?? 500000;
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $tipe ?></td>
                    <td><?= $nomor ?></td>
                    <td>Rp <?= number_format($harga, 0, ',', '.') ?></td>
                    <td>
                        <a href="crud_kamar.php?hapus=<?= $id_kamar ?>" class="btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align: center;'>Belum ada data kamar.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="index.php" class="btn-back">Kembali ke Beranda</a>
    </div>
</body>
</html>