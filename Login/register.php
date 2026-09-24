<?php
session_start();
include 'koneksi.php';

$error = '';
$success = '';

if (isset($_POST['register'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek email apakah sudah terdaftar
    $cek_email = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($cek_email) > 0) {
        $error = "Email sudah terdaftar, silakan gunakan email lain.";
    } else {
        $query = "INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$password')";
        if (mysqli_query($koneksi, $query)) {
            $success = "Registrasi berhasil! Silakan <a href='login.php'>Login di sini</a>.";
        } else {
            $error = "Terjadi kesalahan, coba lagi.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - GrandHotel</title>
    <link rel="stylesheet" href="src/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="auth-body">

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="src/index.php" class="logo">grand<span>hotel</span></a>
                <h2>Buat Akun Baru</h2>
                <p>Daftar untuk mulai memesan hotel impianmu.</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error; ?></div>
            <?php endif; ?>

            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?= $success; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="contoh@domain.com" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter" required>
                </div>
                <button type="submit" name="register" class="btn-submit-booking">Daftar Sekarang</button>
            </form>

            <div class="auth-footer">
                <p>Sudah punya akun? <a href="login.php">Masuk</a></p>
            </div>
        </div>
    </div>

</body>
</html>