<?php
session_start();
include '../koneksi.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Ganti 'users' jika nama tabel database Anda berbeda (misal: 'user' atau 'pelanggan')
    $table_name = 'users'; 

    $cek_email = mysqli_query($conn, "SELECT * FROM $table_name WHERE email = '$email'");
    if ($cek_email && mysqli_num_rows($cek_email) > 0) {
        $error = "Email sudah terdaftar. Silakan gunakan email lain.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO $table_name (username, email, password) VALUES ('$nama', '$email', '$hashed_password')";
        if (mysqli_query($conn, $query)) {
            $success = "Registrasi berhasil! Silakan <a href='login.php'>login</a>.";
        } else {
            $error = "Terjadi kesalahan sistem: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - Grand Hotel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-card {
            background: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 35px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .brand-logo {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 25px;
            text-decoration: none;
            display: block;
            text-align: center;
            letter-spacing: -0.5px;
        }

        .brand-logo span {
            color: #2563eb;
        }

        .login-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .login-header p {
            font-size: 13px;
            color: #64748b;
        }

        .alert-error {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 20px;
            text-align: center;
        }

        .alert-success {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
            padding: 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 14px;
            font-size: 13px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            outline: none;
            background-color: #ffffff;
            color: #0f172a;
        }

        .form-group input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-submit {
            width: 100%;
            background-color: #0f172a;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background-color: #334155;
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #64748b;
        }

        .login-footer a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <a href="../src/index.php" class="brand-logo">Grand<span>Hotel</span></a>
        
        <div class="login-header">
            <h1>Daftar Akun Baru</h1>
            <p>Buat akun untuk mulai memesan hotel</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert-error"><?= $error ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Nama Lengkap / Username</label>
                <input type="text" name="nama" placeholder="Masukkan nama..." required autocomplete="off">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="nama@email.com" required autocomplete="off">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-submit">Daftar Sekarang</button>
        </form>

        <div class="login-footer">
            Sudah punya akun? <a href="login.php">Masuk</a>
        </div>
    </div>

</body>
</html>