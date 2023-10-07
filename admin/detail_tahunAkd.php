<?php
session_start();
if (!$_SESSION['log']) {
    echo '
    <script>
    alert("Silahkan login terlebih dahulu");
    window.location.href = "../index.php";
    </script>
    ';
} else {
    if ($_SESSION['role'] != 'kajur') {
        header('location: ../aslab/dashboard.php');
    }
}
?>
<?php include('../layout/header.php'); ?>

<div class="container-fluid px-4">
    <?php
    include('../db/koneksi.php');
    $id_tahun = $_GET['id_tahun'];
    $get_tahun = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_akademik WHERE id_tahun='$id_tahun'"));
    ?>
    <h3 class="mt-4">Detail Tahun Akademik <?= $get_tahun['tahun']; ?> | Semester <?= $get_tahun['semester']; ?></h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"><a href="m_tahunAkd.php">Manajemen Tahun Akademik</a>/Detail Tahun Akademik <?= $get_tahun['tahun']; ?> | Semester <?= $get_tahun['semester']; ?></li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DataTable Example
        </div>
        <div class="card-body">
            <table class="table table-stripped" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>nama_guru</th>
                        <th>Nip</th>
                        <th>Ruangan</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../db/koneksi.php');
                    $id_tahun = $_GET['id_tahun'];
                    $query_guruM = mysqli_query(
                        $conn,
                        "SELECT * FROM jadwal LEFT JOIN ruangan ON ruangan.id_ruangan = jadwal.id_ruangan 
                        LEFT JOIN guru_mengajar ON guru_mengajar.id_guruM = jadwal.id_guruM 
                        LEFT JOIN guru ON guru.id_guru = guru_mengajar.id_guru 
                        LEFT JOIN kelas ON kelas.id_kelas = guru_mengajar.id_kelas 
                        LEFT JOIN jam ON jam.id_jam = guru_mengajar.id_jam 
                        LEFT JOIN mapel ON mapel.id_mapel = guru_mengajar.id_mapel 
                        WHERE guru_mengajar.id_tahun='$id_tahun'"
                    );
                    // var_dump(mysqli_fetch_array($query_guruM));
                    ?>
                    <?php $n = 1; ?>
                    <?php while ($row = mysqli_fetch_array($query_guruM)) { ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['nama_guru']; ?></td>
                            <td>
                                <p class="<?= ($row['nip'] == 0 ? 'text-danger' : ''); ?>"><?= ($row['nip'] == 0 ? '<strong>NIP Kosong</strong>' : $row['nip']); ?></p>
                            </td>
                            <td><?= $row['nama_ruangan']; ?></td>
                            <td><?= $row['nama_kelas']; ?></td>
                            <td><?= $row['nama_mapel']; ?></td>
                            <td><?= $row['hari']; ?></td>
                            <td><?= $row['jam_mulai']; ?></td>
                            <td><?= $row['jam_selesai']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('../layout/footer.php') ?>