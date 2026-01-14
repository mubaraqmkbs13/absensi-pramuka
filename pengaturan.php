<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login_admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengaturan Absensi - scout attendance</title>
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
                    <p class="tagline">Pengaturan Jadwal Absensi Kegiatan</p>
                </div>
            </div>
            <div class="header-badges">
                <div class="badge"><i class="fas fa-cog"></i> Admin</div>
            </div>
        </div>
    </header>

    <main class="content-area">
        <div class="container">
            <section class="welcome-section">
                <div class="welcome-text">
                    <h2><i class="fas fa-clock"></i> Pengaturan Jadwal Absensi</h2>
                    <p class="description">
                        Atur rentang waktu absensi aktif. Form akan otomatis terbuka/tutup sesuai waktu yang ditentukan.
                    </p>
                </div>
            </section>

            <section class="form-card">
                <div class="card-header">
                    <h3><i class="fas fa-calendar-alt"></i> Jadwal Absensi</h3>
                </div>

                <div style="padding: 20px; text-align: center;">
                    <?php
                    include 'db_config.php';

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $waktu_mulai = $_POST['waktu_mulai'];
                        $waktu_selesai = $_POST['waktu_selesai'];
                        $status = $_POST['status'];

                        $stmt = $conn->prepare("UPDATE absensi_status SET status = ?, waktu_mulai = ?, waktu_selesai = ? WHERE id = 1");
                        $stmt->bind_param("sss", $status, $waktu_mulai, $waktu_selesai);
                        $stmt->execute();

                        if ($stmt->affected_rows > 0) {
                            echo '<div class="alert alert-success">Jadwal absensi berhasil diperbarui.</div>';
                        } else {
                            echo '<div class="alert alert-error">Gagal memperbarui jadwal.</div>';
                        }
                        $stmt->close();
                    }

                    $result = mysqli_query($conn, "SELECT status, waktu_mulai, waktu_selesai FROM absensi_status WHERE id = 1");
                    $row = mysqli_fetch_assoc($result);
                    $current_status = $row['status'];
                    $current_waktu_mulai = $row['waktu_mulai'];
                    $current_waktu_selesai = $row['waktu_selesai'];
                    ?>

                    <form method="POST" style="max-width: 600px; margin: 0 auto;">
                        <div style="margin-bottom: 15px; text-align: left;">
                            <label><i class="fas fa-toggle-on"></i> Status Absensi</label>
                            <select name="status" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
                                <option value="buka" <?php echo $current_status === 'buka' ? 'selected' : ''; ?>>Buka</option>
                                <option value="tutup" <?php echo $current_status === 'tutup' ? 'selected' : ''; ?>>Tutup</option>
                            </select>
                        </div>

                        <div style="margin-bottom: 15px; text-align: left;">
                            <label><i class="fas fa-play-circle"></i> Waktu Mulai</label>
                            <input type="datetime-local" name="waktu_mulai" value="<?php echo $current_waktu_mulai; ?>" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
                        </div>

                        <div style="margin-bottom: 20px; text-align: left;">
                            <label><i class="fas fa-stop-circle"></i> Waktu Selesai</label>
                            <input type="datetime-local" name="waktu_selesai" value="<?php echo $current_waktu_selesai; ?>" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;">
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="fas fa-save"></i> Simpan Jadwal
                        </button>
                    </form>

                    <div style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 10px; display: inline-block;">
                        <h4>Jadwal Aktif:</h4>
                        <p>
                            <strong>Mulai:</strong> <?php echo $current_waktu_mulai ? $current_waktu_mulai : '-'; ?><br>
                            <strong>Selesai:</strong> <?php echo $current_waktu_selesai ? $current_waktu_selesai : '-'; ?>
                        </p>
                    </div>
                </div>
            </section>

            <div class="nav-links" style="text-align: center; margin-top: 25px;">
                <a href="index.php" class="back-button">
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

.alert-success {
    background: rgba(46, 125, 50, 0.1);
    color: #2E7D32;
    border: 1px solid rgba(46, 125, 50, 0.3);
}

.alert-error {
    background: rgba(244, 67, 54, 0.1);
    color: #D32F2F;
    border: 1px solid rgba(244, 67, 54, 0.3);
}
</style>

</body>
</html>