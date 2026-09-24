<?php
session_start();
include 'koneksi.php';

$error = '';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            // Set session login
            $_SESSION['user_logged'] = true;
            $_SESSION['user_name'] = $row['nama'];
            $_SESSION['user_email'] = $row['email'];
            
            header("Location: src/index.php");
            exit;
        } else {
            $error = "Password yang kamu masukkan salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GrandHotel</title>
    <link rel="stylesheet" href="src/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="auth-body">

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <a href="src/index.php" class="logo">grand<span>hotel</span></a>
                <h2>Selamat Datang Kembali</h2>
                <p>Masuk untuk mengelola pesanan hotelmu.</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="contoh@domain.com" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan password" required>
                </div>
                <button type="submit" name="login" class="btn-submit-booking">Masuk</button>
            </form>

            <div class="auth-footer">
                <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
            </div>
        </div>
    </div>

</body>
</html>