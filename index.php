<?php
session_start(); // <-- Hanya satu kali di awal file
// ... kode logika ...
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi Pramuka Modern</title>
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
                    <p class="tagline">Sistem Absensi Digital untuk Kegiatan Pramuka</p>
                </div>
            </div>
            <div class="header-badges">
                <div class="badge"><i class="fas fa-check-circle"></i> Absensi</div>
                <div class="badge"><i class="fas fa-user-clock"></i> Penegak</div>
            </div>
        </div>
    </header>

    <main class="content-area">
        <div class="container">
            <section class="welcome-section">
                <div class="welcome-text">
                    <h2><i class="fas fa-user-check"></i> Selamat Datang di Sistem Absensi Pramuka</h2>
                    <p class="description">
                        Catat kehadiranmu dalam kegiatan dengan cepat dan aman. Sistem ini juga mendukung upload foto untuk dokumentasi absensi.
                    </p>
                    <div class="scout-motto">
                        <i class="fas fa-quote-left"></i> Satya Ku Ku Darmakan – Bakti Ku Ku Iklaskan <i class="fas fa-quote-right"></i>
                    </div>
                </div>
            </section>

            <!-- ... sisa kode header dan welcome ... -->
            <section class="form-card">
                <div class="card-header">
                    <h3><i class="fas fa-id-badge"></i> Form Absensi Kegiatan</h3>
                </div>

                <?php
                include 'db_config.php';
                $result = mysqli_query($conn, "SELECT status, waktu_mulai, waktu_selesai FROM absensi_status WHERE id = 1");
                $row = mysqli_fetch_assoc($result);

                $status = $row['status'];
                $waktu_mulai = strtotime($row['waktu_mulai']);
                $waktu_selesai = strtotime($row['waktu_selesai']);
                $now = time();

                $is_active = false;

                // Jika status 'buka' dan waktu saat ini berada di antara rentang
                if ($status === 'buka' && $waktu_mulai <= $now && $now <= $waktu_selesai) {
                    $is_active = true;
                }
                ?>

                <?php if (!$is_active): ?>
                    <div style="text-align: center; padding: 30px;">
                        <?php if ($now < $waktu_mulai): ?>
                            <h3 style="color: #2196F3;"><i class="fas fa-clock"></i> Absensi Belum Dibuka</h3>
                            <p style="color: #757575; margin-top: 10px;">
                                Absensi akan dibuka pada:<br>
                                <strong><?php echo date('d M Y H:i', $waktu_mulai); ?></strong>
                            </p>
                        <?php elseif ($now > $waktu_selesai): ?>
                            <h3 style="color: #f44336;"><i class="fas fa-lock"></i> Absensi Sudah Ditutup</h3>
                            <p style="color: #757575; margin-top: 10px;">
                                Absensi ditutup pada:<br>
                                <strong><?php echo date('d M Y H:i', $waktu_selesai); ?></strong>
                            </p>
                        <?php else: ?>
                            <h3 style="color: #f44336;"><i class="fas fa-exclamation-triangle"></i> Absensi Ditutup</h3>
                            <p style="color: #757575; margin-top: 10px;">Form absensi saat ini tidak aktif.</p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <form class="attendance-form" action="proses_absen.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Nama Lengkap</label>
                            <div class="input-with-icon">
                                <input type="text" name="nama" placeholder="Contoh: Andi Saputra" required>
                                <div class="input-focus-line"></div>
                            </div>
                            <div class="form-hint">
                                <i class="fas fa-info-circle"></i> Gunakan nama asli yang terdaftar.
                            </div>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-school"></i> Kelas / Gugus Depan</label>
                            <div class="input-with-icon">
                                <input type="text" name="kelas" placeholder="Penegak Bantara" required>
                                <div class="input-focus-line"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-calendar-check"></i> Status Kehadiran</label>
                            <div class="status-indicators">
                                <div class="status-indicator active" data-status="Hadir">
                                    <div class="indicator-icon present"><i class="fas fa-check"></i></div>
                                    <span>Hadir</span>
                                </div>
                                <div class="status-indicator" data-status="Izin">
                                    <div class="indicator-icon permission"><i class="fas fa-hand-paper"></i></div>
                                    <span>Izin</span>
                                </div>
                                <div class="status-indicator" data-status="Sakit">
                                    <div class="indicator-icon sick"><i class="fas fa-bed"></i></div>
                                    <span>Sakit</span>
                                </div>
                            </div>
                            <input type="hidden" name="status" id="statusValue" value="Hadir">
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-camera"></i> Foto Bukti Kehadiran</label>
                            <div class="file-upload-area">
                                <input type="file" name="foto" id="fotoInput" accept="image/*" capture="environment">
                                <div class="upload-content">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <h4>Geser atau Klik untuk Unggah</h4>
                                    <p>Pilih foto dari galeri atau ambil langsung dari kamera</p>
                                    <p class="upload-hint">Format: JPG, PNG, maksimal 5MB</p>
                                </div>
                            </div>

                            <div class="image-preview-container" id="previewContainer">
                                <div class="preview-header">
                                    <h4><i class="fas fa-image"></i> Pratinjau Foto</h4>
                                    <button type="button" class="clear-preview" id="clearPreview">
                                        <i class="fas fa-times"></i> Hapus
                                    </button>
                                </div>
                                <div class="image-preview">
                                    <div class="preview-placeholder">
                                        <i class="fas fa-image"></i>
                                        <p>Foto akan muncul di sini</p>
                                    </div>
                                    <img id="previewFoto" alt="Pratinjau Foto">
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="submit-btn">
                                <i class="fas fa-paper-plane"></i> Kirim Data Absensi
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </section>

              <            <div class="nav-links" style="text-align: center; margin-top: 20px;">
                <a href="lihat_absensi.php" class="submit-btn" style="color: white; display: inline-block; padding: 12px 25px; text-decoration: none;">
                    <i class="fas fa-table"></i> Lihat Data Absensi
                </a>
                <a href="login_admin.php" class="submit-btn" style="color: white; display: inline-block; padding: 12px 25px; text-decoration: none; background: linear-gradient(135deg, #607d8b, #455a64); margin-top: 10px;">
                    <i class="fas fa-user-lock"></i> Login Admin
                </a>
            </div>
            </div>
    <footer>
        <p> GUDEP 02.001_02.0002</p>
    </footer>
</div>

<script>
    // Toggle status kehadiran
    document.querySelectorAll('.status-indicator').forEach(indicator => {
        indicator.addEventListener('click', () => {
            document.querySelectorAll('.status-indicator').forEach(i => i.classList.remove('active'));
            indicator.classList.add('active');
            const status = indicator.getAttribute('data-status');
            document.getElementById('statusValue').value = status;
        });
    });

    // Preview foto
    const fotoInput = document.getElementById('fotoInput');
    const previewFoto = document.getElementById('previewFoto');
    const previewContainer = document.getElementById('previewContainer');
    const clearPreview = document.getElementById('clearPreview');

    fotoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewFoto.src = e.target.result;
                previewFoto.style.display = 'block';
                document.querySelector('.preview-placeholder').style.display = 'none';
                previewContainer.classList.add('show');
            };
            reader.readAsDataURL(file);
        }
    });

    clearPreview.addEventListener('click', function() {
        previewFoto.src = '';
        previewFoto.style.display = 'none';
        document.querySelector('.preview-placeholder').style.display = 'block';
        previewContainer.classList.remove('show');
        fotoInput.value = '';
    });
</script>

</body>
</html>