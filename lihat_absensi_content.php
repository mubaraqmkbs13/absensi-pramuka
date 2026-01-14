<?php
include 'db_connect.php';

$result = mysqli_query($conn, "
    SELECT id, nama, kelas, tanggal, status, foto
    FROM tb_absensi
    ORDER BY tanggal DESC
");

echo '<div class="attendance-table-wrapper">';
echo '<table class="attendance-table">';
echo '<thead>';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Nama</th>';
echo '<th>Kelas</th>';
echo '<th>Tanggal</th>';
echo '<th>Status</th>';
echo '<th>Foto</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if (mysqli_num_rows($result) == 0) {
    echo '<tr><td colspan="6" style="text-align: center; padding: 30px; color: #757575; font-style: italic;">Belum ada data absensi.</td></tr>';
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $statusClass = strtolower($row['status']);
        $fotoPath = $row['foto'] ? 'uploads/' . $row['foto'] : '';
        
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . htmlspecialchars($row['nama']) . '</td>';
        echo '<td>' . htmlspecialchars($row['kelas']) . '</td>';
        echo '<td>' . $row['tanggal'] . '</td>';
        echo '<td><span class="status-badge ' . $statusClass . '">' . ucfirst($row['status']) . '</span></td>';
        echo '<td>';
        if ($fotoPath) {
            echo '<img src="' . $fotoPath . '" alt="Foto Kehadiran" class="photo-preview">';
        } else {
            echo '<span class="no-photo">Tidak ada</span>';
        }
        echo '</td>';
        echo '</tr>';
    }
}
echo '</tbody>';
echo '</table>';
echo '</div>';

mysqli_close($conn);
?>