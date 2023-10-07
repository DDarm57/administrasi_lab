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

<div class="container-fluid">
    <h1 class="mt-4">Edit Guru Mengajar</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active"><a href="m_jadwal.php">Manajemen Jadwal</a>/Edit Guru Mengajar</li>
    </ol>
    <div class="card">
        <div class="card-header">
            Form Edit Guru Mengajar
        </div>
        <?php
        //Tambah
        if (isset($_POST['update_guruM'])) {
            require '../function/admin/edit.php';
            if (edit_jadwal($_POST) > 0) {
                echo '
                <script>
                alert("Data berhasil di tambahkan");
                window.location.href = "m_jadwal.php";
                </script>
                ';
            } else {
                echo '
                <script>
                alert("Data gagal di tambahkan");
                window.location.href = "tambah_guruM.php";
                </script>
                ';
            }
        }
        ?>
        <?php
        include('../db/koneksi.php');
        $id_jadwal = $_GET['id_jadwal'];
        $query = mysqli_query($conn, "SELECT * FROM jadwal LEFT JOIN guru_mengajar ON guru_mengajar.id_guruM = jadwal.id_guruM WHERE id_jadwal='$id_jadwal'");
        $get_data = mysqli_fetch_array($query);
        ?>
        <div class="card-body">
            <form action="" method="POST">
                <input type="hidden" name="id_jadwal" id="" value="<?= $get_data['id_jadwal']; ?>">
                <input type="hidden" name="id_guruM" id="" value="<?= $get_data['id_guruM']; ?>">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama_guru">Pilih Guru</label>
                            <?php
                            include('../db/koneksi.php');
                            $query = mysqli_query($conn, "SELECT * FROM guru");
                            ?>
                            <select class="selectpicker form-control" name="id_guru" data-container="body" data-live-search="true" title="Guru">
                                <?php while ($row = mysqli_fetch_array($query)) : ?>
                                    <option <?= ($get_data['id_guru'] == $row['id_guru'] ? 'selected' : ''); ?> value="<?= $row['id_guru']; ?>">Nama : <?= $row['nama_guru']; ?> | NIP : <?= $row['nip']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Pilih Mapel</label>
                            <?php
                            include('../db/koneksi.php');
                            $query = mysqli_query($conn, "SELECT * FROM mapel");
                            ?>
                            <select class="selectpicker form-control" name="id_mapel" data-container="body" data-live-search="true" title="Mapel">
                                <?php while ($row = mysqli_fetch_array($query)) : ?>
                                    <option <?= ($get_data['id_mapel'] == $row['id_mapel'] ? 'selected' : ''); ?> value="<?= $row['id_mapel']; ?>"><?= $row['nama_mapel']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Pilih Kelas</label>
                            <?php
                            include('../db/koneksi.php');
                            $query = mysqli_query($conn, "SELECT * FROM kelas");
                            ?>
                            <select class="selectpicker form-control" name="id_kelas" data-container="body" data-live-search="true" title="Kelas">
                                <?php while ($row = mysqli_fetch_array($query)) : ?>
                                    <option <?= ($get_data['id_kelas'] == $row['id_kelas'] ? 'selected' : ''); ?> value="<?= $row['id_kelas']; ?>"><?= $row['nama_kelas']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama_guru">Pilih Jam</label>
                            <?php
                            include('../db/koneksi.php');
                            $query = mysqli_query($conn, "SELECT * FROM jam");
                            ?>
                            <select class="selectpicker form-control" name="id_jam" data-container="body" data-live-search="true" title="Jam">
                                <?php while ($row = mysqli_fetch_array($query)) : ?>
                                    <option <?= ($get_data['id_jam'] == $row['id_jam'] ? 'selected' : ''); ?> value="<?= $row['id_jam']; ?>">Jam Mulai : <?= $row['jam_mulai']; ?> - Selesai : <?= $row['jam_selesai']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nama_guru">Pilih Ruangan</label>
                            <?php
                            include('../db/koneksi.php');
                            $query = mysqli_query($conn, "SELECT * FROM ruangan");
                            ?>
                            <select class="selectpicker form-control" name="id_ruangan" data-container="body" data-live-search="true" title="Ruangan">
                                <?php while ($row = mysqli_fetch_array($query)) : ?>
                                    <option <?= ($get_data['id_ruangan'] == $row['id_ruangan'] ? 'selected' : ''); ?> value="<?= $row['id_ruangan']; ?>"><?= $row['nama_ruangan']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="hari">Hari</label>
                            <select class="selectpicker form-control" name="hari" data-container="body" data-live-search="true" title="Hari">
                                <option <?= ($get_data['hari'] == 'Senin' ? 'selected' : ''); ?> value="Senin">Senin</option>
                                <option <?= ($get_data['hari'] == 'Selasa' ? 'selected' : ''); ?> value="Selasa">Selasa</option>
                                <option <?= ($get_data['hari'] == 'Rabu' ? 'selected' : ''); ?> value="Rabu">Rabu</option>
                                <option <?= ($get_data['hari'] == 'Kamis' ? 'selected' : ''); ?> value="Kamis">Kamis</option>
                                <option <?= ($get_data['hari'] == "Jum'at" ? 'selected' : ''); ?> value="Jum'at">Jum'at</option>
                                <option <?= ($get_data['hari'] == 'Sabtu' ? 'selected' : ''); ?> value="Sabtu">Sabtu</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" name="update_guruM" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>

<?php include('../layout/footer.php') ?>