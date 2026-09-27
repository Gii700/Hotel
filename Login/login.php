<?php
session_start();
include '../koneksi.php'; 

$error = '';
$table_name = 'users'; // Sesuaikan jika nama tabel Anda 'user'

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Hanya mencari berdasarkan kolom email sesuai struktur tabel database Anda
    $result = mysqli_query($conn, "SELECT * FROM $table_name WHERE email = '$email'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password']) || $password === $row['password']) {
            $_SESSION['user_id'] = $row['id'] ?? 1;
            $_SESSION['username'] = $row['email'];
            header("Location: ../src/index.php");
            exit;
        } else {
            $error = "Password yang Anda masukkan salah.";
        }
    } else {
        $error = "Akun dengan email tersebut tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk - Grand Hotel</title>
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
            <h1>Login Akun</h1>
            <p>Silakan masuk untuk melanjutkan reservasi</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan email..." required autocomplete="off">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-submit">Masuk</button>
        </form>

        <div class="login-footer">
            Belum punya akun? <a href="register.php">Daftar</a>
        </div>
    </div>

</body>
</html>