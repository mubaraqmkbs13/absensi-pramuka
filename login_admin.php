<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db_config.php';

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            header('Location: pengaturan.php');
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - scout attendance</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="background-animation">
    <div class="floating-icon">⛺</div>
    <div class="floating-icon">🌲</div>
    <div class="floating-icon">🔥</div>
    <div class="floating-icon">🧭</div>
    <div class="floating-icon">🪵</div>
    <div class="floating-icon">🛡️</div>
</div>

<div class="main-container">
    <header class="scout-header">
        <div class="header-content">
            <div class="logo-container">
                <div class="scout-logo">
                    <div class="logo-rays">
                        <div class="ray ray-1"></div>
                        <div class="ray ray-2"></div>
                        <div class="ray ray-3"></div>
                        <div class="ray ray-4"></div>
                    </div>
                    <div class="logo-icon"> scout </div>
                </div>
                <div class="logo-text">
                    <h1> scout <span class="highlight">attendance</span></h1>
                    <p class="tagline">Login Admin</p>
                </div>
            </div>
        </div>
    </header>

    <main class="content-area">
        <div class="container">
            <section class="form-card">
                <div class="card-header">
                    <h3><i class="fas fa-lock"></i> Login Admin</h3>
                </div>

                <form method="POST" style="max-width: 400px; margin: 0 auto;">
                    <div style="margin-bottom: 15px;">
                        <label><i class="fas fa-user"></i> Username</label>
                        <input type="text" name="username" placeholder="Masukkan username" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label><i class="fas fa-key"></i> Password</label>
                        <input type="password" name="password" placeholder="Masukkan password" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ccc;">
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-error"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
            </section>

            <div class="nav-links" style="text-align: center; margin-top: 20px;">
                <a href="index.php" class="submit-btn" style="color: white; display: inline-block; padding: 12px 25px; text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Kembali ke Form Absensi
                </a>
            </div>
        </div>
    </main>

    <footer>
        <p> scout attendance &copy; 2026 | Dibuat untuk Pramuka Indonesia </p>
    </footer>
</div>

<style>
.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-weight: 500;
}

.alert-error {
    background: rgba(244, 67, 54, 0.1);
    color: #D32F2F;
    border: 1px solid rgba(244, 67, 54, 0.3);
}
</style>

</body>
</html>