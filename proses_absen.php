<?php
include 'db_config.php';

$nama = $_POST['nama'];
$kelas = $_POST['kelas'];
$status = $_POST['status'];

$foto = $_FILES['foto']['name'];
$foto_tmp = $_FILES['foto']['tmp_name'];

// Buat folder uploads jika belum ada
$target_dir = "uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$foto_path = $target_dir . basename($foto);

// Jika ada foto yang diupload
if ($foto) {
    // Cek apakah file adalah gambar
    $check = getimagesize($foto_tmp);
    if ($check !== false) {
        move_uploaded_file($foto_tmp, $foto_path);
    } else {
        die("File bukan gambar.");
    }
} else {
    $foto = null;
}

$sql = "INSERT INTO tb_absensi (nama, kelas, status, foto) VALUES ('$nama', '$kelas', '$status', '$foto')";

if (mysqli_query($conn, $sql)) {
    $success = true;
} else {
    $error = "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Success - scout attendance</title>
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
                    <h1> GUDEP <span class="highlight">SMA N 1 LABUHANHAJI</span></h1>
                    <p class="tagline">Pengumpulan Data Kehadiran Pramuka</p>
                </div>
            </div>
        </div>
    </header>

    <main class="content-area">
        <div class="container">
            <section class="welcome-section">
                <div class="welcome-text">
                    <h2><i class="fas fa-check-circle"></i> Absensi Berhasil Disimpan!</h2>
                    <p class="description">
                        Terima kasih telah mencatat kehadiranmu. Data kamu telah tersimpan dengan aman di sistem.
                    </p>
                    <div class="scout-motto">
                        <i class="fas fa-quote-left"></i> Satya Ku Ku Darmakan – Bakti Ku Ku Iklaskan <i class="fas fa-quote-right"></i>
                    </div>
                </div>
            </section>

            <section class="form-card">
    <div class="card-header">
        <h3><i class="fas fa-info-circle"></i> Detail Kehadiran</h3>
    </div>
    <div style="padding: 20px; text-align: center;">
        <div style="background: #f9f9f9; padding: 25px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); max-width: 350px; margin: 0 auto; text-align: center;">
            <h3 style="color: var(--primary-dark); margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-user-check" style="color: var(--secondary);"></i> Detail Kehadiran
            </h3>
            <hr style="border: none; border-top: 1px solid #ddd; margin: 15px 0;">

            <div style="text-align: left; line-height: 1.8; font-size: 0.95rem; color: var(--dark);">
                <p><strong><i class="fas fa-user" style="color: var(--secondary); margin-right: 8px;"></i>Nama:</strong> <?php echo htmlspecialchars($nama); ?></p>
                <p><strong><i class="fas fa-school" style="color: var(--secondary); margin-right: 8px;"></i>Kelas:</strong> <?php echo htmlspecialchars($kelas); ?></p>
                <p>
                    <strong><i class="fas fa-calendar-check" style="color: var(--secondary); margin-right: 8px;"></i>Status:</strong>
                    <span style="display: inline-block; padding: 5px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; text-transform: capitalize; min-width: 60px; text-align: center; background: <?php
                        echo $status === 'Hadir' ? 'rgba(46, 125, 50, 0.1)' : ($status === 'Izin' ? 'rgba(33, 150, 243, 0.1)' : 'rgba(255, 152, 0, 0.1)');
                    ?>; color: <?php
                        echo $status === 'Hadir' ? 'var(--primary)' : ($status === 'Izin' ? '#2196F3' : '#FF9800');
                    ?>; border: 1px solid <?php
                        echo $status === 'Hadir' ? 'rgba(46, 125, 50, 0.3)' : ($status === 'Izin' ? 'rgba(33, 150, 243, 0.3)' : 'rgba(255, 152, 0, 0.3)');
                    ?>;">
                        <?php echo ucfirst($status); ?>
                    </span>
                </p>
                <p>
                    <strong><i class="fas fa-camera" style="color: var(--secondary); margin-right: 8px;"></i>Foto:</strong><br>
                    <?php if ($foto): ?>
                        <img src="<?php echo $foto_path; ?>" alt="Foto Kehadiran" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; margin-top: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                    <?php else: ?>
                        <span style="color: var(--gray); font-style: italic;">Tidak ada foto</span>
                    <?php endif; ?>
                </p>
            </div>
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
        <p> GUDEP  02.001_02.002 </p>
    </footer>
</div>

<style>
.status-badge {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: capitalize;
    min-width: 60px;
    text-align: center;
}

.status-badge.hadir {
    background: rgba(46, 125, 50, 0.1);
    color: var(--primary);
    border: 1px solid rgba(46, 125, 50, 0.3);
}

.status-badge.izin {
    background: rgba(33, 150, 243, 0.1);
    color: #2196F3;
    border: 1px solid rgba(33, 150, 243, 0.3);
}

.status-badge.sakit {
    background: rgba(255, 152, 0, 0.1);
    color: #FF9800;
    border: 1px solid rgba(255, 152, 0, 0.3);
}
</style>

</body>
</html>