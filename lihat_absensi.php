<?php
session_start(); // <-- Dipanggil sekali di awal file
// ... kode logika ...
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lihat Data Absensi - scout attendance</title>
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
                    <h1> Gudep <span class="highlight">SMA N 1 LABUHANHAJI</span></h1>
                    <p class="tagline">Lihat Data Kehadiran Anggota Pramuka</p>
                </div>
            </div>
            <div class="header-badges">
                <div class="badge"><i class="fas fa-users"></i> Anggota</div>
                <div class="badge"><i class="fas fa-calendar-day"></i> Hari Ini</div>
            </div>
        </div>
    </header>

    <main class="content-area">
        <div class="container">
            <section class="welcome-section">
                <div class="welcome-text">
                    <h2><i class="fas fa-list-check"></i> Daftar Kehadiran Anggota</h2>
                    <p class="description">
                        Berikut adalah data kehadiran anggota Pramuka yang telah tercatat dalam sistem. Anda dapat melihat nama, kelas, status kehadiran, dan foto bukti kehadiran.
                    </p>
                    <div class="scout-motto">
                        <i class="fas fa-quote-left"></i> Disiplin dan Tanggung Jawab – Jiwa Kepemimpinan Pramuka <i class="fas fa-quote-right"></i>
                    </div>
                </div>
            </section>

            <section class="form-card">
                <div class="card-header">
                    <h3><i class="fas fa-table-columns"></i> Tabel Kehadiran</h3>
                </div>
                <div class="attendance-table-container">
                    <?php include 'lihat_absensi_content.php'; ?>
                </div>
            </section>

                       <div class="nav-links" style="text-align: center; margin-top: 25px;">
                <a href="index.php" class="back-button">
                    <i class="fas fa-arrow-left"></i> Kembali ke Form Absensi
                </a>
            </div>
            </div>
        </div>
    </main>

    <footer>
        <p> GUDEP 02.001_02.0002</p>
    </footer>
</div>

</body>
</html>