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
    <h1 class="mt-4">Manajemen Tahun Akademik</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Manajemen Tahun Akademik</li>
    </ol>
    <?php

    //tambah
    if (isset($_POST['simpan'])) {
        require '../function/admin/tambah.php';
        if (tambah_tahunAkd($_POST) > 0) {
            echo '
        <script>
        alert("Data berhasil di tambahkan");
        window.location.href = "m_tahunAkd.php";
        </script>
        ';
        } else {
            echo '
            <script>
            alert("Data gagal di tambahkan");
            window.location.href = "m_tahunAkd.php";
            </script>
        ';
        }
    }

    //hapus
    if (isset($_POST['hapus'])) {
        require '../function/admin/hapus.php';
        if (hapus_tahunAkd($_POST) > 0) {
            echo '
            <script>
            alert("Data berhasil di hapus");
            window.location.href = "m_tahunAkd.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data gagal di hapus");
            window.location.href = "m_tahunAkd.php";
            </script>
            ';
        }
    }

    //edit
    if (isset($_POST['update'])) {
        require '../function/admin/edit.php';
        if (edit_tahunAkd($_POST) > 0) {
            echo '
            <script>
            alert("Data berhasil di update");
            window.location.href = "m_tahunAkd.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data gagal di update");
            window.location.href = "m_tahunAkd.php";
            </script>
            ';
        }
    }

    if (isset($_POST['update_status'])) {
        include '../db/koneksi.php';
        $id_tahun = $_POST['id_tahun'];
        $cek_status = mysqli_query($conn, "SELECT * FROM tahun_akademik WHERE status='aktif'");
        $get_status = mysqli_fetch_array($cek_status);
        $get_idTahun = $get_status['id_tahun'];
        mysqli_query($conn, "UPDATE tahun_akademik SET status='tidak aktif' WHERE id_tahun='$get_idTahun'");
        mysqli_query($conn, "UPDATE tahun_akademik SET status='aktif' WHERE id_tahun='$id_tahun'");
        if (mysqli_affected_rows($conn) > 0) {
            echo '
            <script>
            alert("Data status tahun akademik berhasil di update");
            window.location.href = "m_tahunAkd.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data status tahun akademik gagal di update");
            window.location.href = "m_tahunAkd.php";
            </script>
            ';
        }
    }

    ?>
    <div class="mb-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Tambah
        </button>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DataTable Example
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../db/koneksi.php');
                    $query = mysqli_query($conn, "SELECT * FROM tahun_akademik");
                    ?>
                    <?php $n = 1; ?>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['tahun']; ?></td>
                            <td><?= $row['semester']; ?></td>
                            <td>
                                <strong>
                                    <p class="<?= ($row['status'] == 'aktif' ? 'text-success' : 'text-danger'); ?>"><?= $row['status']; ?></p>
                                </strong>
                            </td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm" id="edit" data-id_tahun="<?= $row['id_tahun']; ?>" data-tahun="<?= $row['tahun']; ?>" data-semester="<?= $row['semester']; ?>" data-toggle="modal" data-target="#exampleModaledit">Edit</a>
                                <form action="" method="POST" class="d-inline">
                                    <input type="hidden" name="id_tahun" value="<?= $row['id_tahun']; ?>">
                                    <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('apakah anda yakin ingin menghapus data?')">Hapus</button>
                                </form>
                                <form action="" method="POST" class="d-inline">
                                    <input type="hidden" name="id_tahun" id="" value="<?= $row['id_tahun']; ?>">
                                    <button type="submit" name="update_status" class="btn btn-success btn-sm" onclick="return confirm('apakah anda yakin ingin mengupdate status?')">Aktifkan</button>
                                </form>
                                <a href="detail_tahunAkd.php?id_tahun=<?= $row['id_tahun']; ?>" class="btn btn-info btn-sm">Detail Tahun Akademik</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Ruangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <select class="selectpicker form-control" name="tahun" data-container="body" data-live-search="true" title="Tahun">
                            <?php for ($i = 22; $i <= 30; $i++) { ?>
                                <option value="20<?= $i; ?>">20<?= $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <label for="semester">Semester</label>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="semester" id="semester" value="Gasal">
                            <label class="form-check-label" for="semester">Gasal</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="semester" id="inlineRadio2" value="Genap">
                            <label class="form-check-label" for="inlineRadio2">Genap</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal edit -->
<div class="modal fade" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Ruangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body modal-edit">
                    <input type="hidden" name="id_tahun" id="id_tahun">
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <select class="selectpicker form-control" name="tahun" id="tahun" data-container="body" data-live-search="true" title="Tahun">
                            <?php for ($i = 22; $i <= 30; $i++) { ?>
                                <option value="20<?= $i; ?>">20<?= $i; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <label for="semester">Semester</label>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="semester" id="inlineRadio1" value="Gasal">
                            <label class="form-check-label" for="inlineRadio1">Gasal</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="semester" id="inlineRadio2" value="Genap">
                            <label class="form-check-label" for="inlineRadio2">Genap</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="update" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../layout/footer.php') ?>

<script>
    $(document).on('click', '#edit', function(e) {
        e.preventDefault();
        let id_tahun = $(this).data('id_tahun');
        let tahun = $(this).data('tahun');
        let semester = $(this).data('semester');

        $('.modal-edit #id_tahun').val(id_tahun);
        $('.modal-edit #tahun').val(tahun).change();
        $('input:radio[name="semester"]').filter('[value=' + semester + ']').attr('checked', true);
    })
</script>