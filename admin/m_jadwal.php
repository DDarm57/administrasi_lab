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
    <h1 class="mt-4">Manajemen Jadwal</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Manajemen Jadwal</li>
    </ol>
    <?php
    //tambah Jam
    if (isset($_POST['simpan_jam'])) {
        require '../function/admin/tambah.php';
        if (tambah_jam($_POST) > 0) {
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
            window.location.href = "m_jadwal.php";
            </script>
        ';
        }
    }
    //=========================================================
    //tambah mapel
    if (isset($_POST['simpan_mapel'])) {
        require '../function/admin/tambah.php';
        if (tambah_mapel($_POST) > 0) {
            echo '
        <script>
        alert("Data mapel berhasil di tambahkan");
        window.location.href = "m_jadwal.php";
        </script>
        ';
        } else {
            echo '
            <script>
            alert("Data mapel gagal di tambahkan");
            window.location.href = "m_jadwal.php";
            </script>
        ';
        }
    }
    //=========================================================
    if (isset($_POST['hapus_jam'])) {
        require '../function/admin/hapus.php';
        if (hapus_jam($_POST) > 0) {
            echo '
            <script>
            alert("Data jam berhasil di hapus");
            window.location.href = "m_jadwal.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data jam gagal di hapus");
            window.location.href = "m_jadwal.php";
            </script>
            ';
        }
    }

    if (isset($_POST['hapus_mapel'])) {
        require '../function/admin/hapus.php';
        if (hapus_mapel($_POST) > 0) {
            echo '
            <script>
            alert("Data mapel berhasil di hapus");
            window.location.href = "m_jadwal.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data mapel gagal di hapus");
            window.location.href = "m_jadwal.php";
            </script>
            ';
        }
    }

    if (isset($_POST['hapus_jadwal'])) {
        require '../function/admin/hapus.php';
        if (hapus_jadwal($_POST) > 0) {
            echo '
            <script>
            alert("Data jadwal berhasil di hapus");
            window.location.href = "m_jadwal.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data jadwal gagal di hapus");
            window.location.href = "m_jadwal.php";
            </script>
            ';
        }
    }

    if (isset($_POST['update_jam'])) {
        require '../function/admin/edit.php';
        if (edit_jam($_POST) > 0) {
            echo '
            <script>
            alert("Data jam berhasil di update");
            window.location.href = "m_jadwal.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data jam gagal di update");
            window.location.href = "m_jadwal.php";
            </script>
            ';
        }
    }

    if (isset($_POST['update_mapel'])) {
        require '../function/admin/edit.php';
        if (edit_mapel($_POST) > 0) {
            echo '
            <script>
            alert("Data mapel berhasil di update");
            window.location.href = "m_jadwal.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data mapel gagal di update");
            window.location.href = "m_jadwal.php";
            </script>
            ';
        }
    }

    ?>
    <div class="row">
        <div class="col-sm-6">
            <a href="tambah_guruM.php" class="btn btn-primary btn-sm mb-2">Tambah Guru Mengajar</a>
        </div>
        <div class="col-sm-6">
            <form action="../admin/excel_jadwal.php" method="POST" class="mb-2">
                <div class="d-flex justify-content-end">
                    <select class="selectpicker form-control mx-2" name="hari" data-container="body" data-live-search="true" title="Cetak Berdasarkan Hari">
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jum'at">Jum'at</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Excel</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <i class="fas fa-table me-1"></i>
                    Data Guru Mengajar
                </div>
                <div class="col-6 text-right">
                    <!-- Button trigger modal -->
                </div>
            </div>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../db/koneksi.php');
                    $cek_data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_akademik WHERE status='aktif'"));
                    $id_tahun = $cek_data['id_tahun'];
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
                            <td>
                                <a href="edit_guruM.php?id_jadwal=<?= $row['id_jadwal']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <form action="" method="POST" class="d-inline">
                                    <input type="hidden" name="id_guruM" id="" value="<?= $row['id_guruM']; ?>">
                                    <button type="submit" name="hapus_jadwal" class="btn btn-danger btn-sm" onclick="return confirm('Ada sebagian data yang terhubung dengan data jadwal apakah anda yakin ingin menghapus jadwal?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mb-2">
        <form action="" method="POST">
            <label for="">Jam Mulai & Selesai</label>
            <div class="input-group mb-3">
                <input type="time" class="form-control" name="jam_mulai">
                <input type="time" class="form-control" name="jam_selesai">
                <div class="input-group-prepend">
                    <button type="submit" name="simpan_jam" class="btn btn-primary">Tambah</button>
                </div>
                <!-- /btn-group -->
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Jam
                </div>
                <div class="card-body" style="overflow-x: auto;">
                    <table class="table table-stripped" id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('../db/koneksi.php');
                            $query = mysqli_query($conn, "SELECT * FROM  jam");
                            ?>
                            <?php $n = 1; ?>
                            <?php while ($row = mysqli_fetch_array($query)) { ?>
                                <tr>
                                    <td><?= $n++; ?></td>
                                    <td><?= $row['jam_mulai']; ?></td>
                                    <td><?= $row['jam_selesai']; ?></td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm" id="edit_jam" data-id_jam="<?= $row['id_jam']; ?>" data-jam_mulai="<?= $row['jam_mulai']; ?>" data-jam_selesai="<?= $row['jam_selesai']; ?>" data-toggle="modal" data-target="#exampleModaleditjam">Edit</a>
                                        <form action="" method="POST" class="d-inline">
                                            <input type="hidden" name="id_jam" value="<?= $row['id_jam']; ?>">
                                            <button type="submit" name="hapus_jam" class="btn btn-danger btn-sm" onclick="return confirm('apakah anda yakin ingin menghapus data?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <i class="fas fa-table me-1"></i>
                            Data Mapel
                        </div>
                        <div class="col-6 text-right">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModalmapel">
                                Tambah Mapel
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="overflow-x: auto;">
                    <table class="table table-stripped" id="example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Mapel</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('../db/koneksi.php');
                            $query_mapel = mysqli_query($conn, "SELECT * FROM  mapel");
                            ?>
                            <?php $n = 1; ?>
                            <?php while ($row = mysqli_fetch_array($query_mapel)) { ?>
                                <tr>
                                    <td><?= $n++; ?></td>
                                    <td><?= $row['nama_mapel']; ?></td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm" id="edit_mapel" data-id_mapel="<?= $row['id_mapel']; ?>" data-nama_mapel="<?= $row['nama_mapel']; ?>" data-toggle="modal" data-target="#exampleModaleditmapel">Edit</a>
                                        <form action="" method="POST" class="d-inline">
                                            <input type="hidden" name="id_mapel" value="<?= $row['id_mapel']; ?>">
                                            <button type="submit" name="hapus_mapel" class="btn btn-danger btn-sm" onclick="return confirm('apakah anda yakin ingin menghapus data?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal mapel -->
<div class="modal fade" id="exampleModalmapel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Mapel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_mapel">Nama Mapel</label>
                        <input type="text" name="nama_mapel" id="nama_mapel" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="simpan_mapel" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal edit jam -->
<div class="modal fade" id="exampleModaleditjam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Jam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body modal-edit-jam">
                    <input type="hidden" name="id_jam" id="id_jam">
                    <div class="form-group">
                        <label for="jam_mulai">Jam Mulai</label>
                        <input type="time" name="jam_mulai" id="jam_mulai" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="jam_selesai">Jam Selesai</label>
                        <input type="time" name="jam_selesai" id="jam_selesai" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="update_jam" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal edit mapel -->
<div class="modal fade" id="exampleModaleditmapel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Mapel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body modal-edit-mapel">
                    <input type="hidden" name="id_mapel" id="id_mapel">
                    <div class="form-group">
                        <label for="nama_mapel">Nama Mapel</label>
                        <input type="text" name="nama_mapel" id="nama_mapel" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="update_mapel" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../layout/footer.php') ?>

<script>
    $(document).on('click', '#edit_jam', function(e) {
        e.preventDefault();
        let id_jam = $(this).data('id_jam');
        let jam_mulai = $(this).data('jam_mulai');
        let jam_selesai = $(this).data('jam_selesai');

        $('.modal-edit-jam #id_jam').val(id_jam);
        $('.modal-edit-jam #jam_mulai').val(jam_mulai);
        $('.modal-edit-jam #jam_selesai').val(jam_selesai);
    })

    $(document).on('click', '#edit_mapel', function(e) {
        e.preventDefault();
        let id_mapel = $(this).data('id_mapel');
        let nama_mapel = $(this).data('nama_mapel');

        $('.modal-edit-mapel #id_mapel').val(id_mapel);
        $('.modal-edit-mapel #nama_mapel').val(nama_mapel);
    })
</script>