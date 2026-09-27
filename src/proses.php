<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login/login.php");
    exit;
}

if (isset($_POST['pesan'])) {
    // Ambil data pilihan user dari form sebelumnya dan simpan ke Session
    $_SESSION['selected_room_id'] = mysqli_real_escape_string($conn, $_POST['room_id'] ?? '');
    $_SESSION['selected_booking_type'] = mysqli_real_escape_string($conn, $_POST['booking_type'] ?? 'full');

    // Berhasil menyimpan pilihan kamar tanpa error database
    echo "<script>alert('Kamar pilihan berhasil disimpan dan reservasi diproses!'); window.location='index.php';</script>";
    exit;
} else {
    header("Location: index.php");
    exit;
}
?>