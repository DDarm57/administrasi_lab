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
    <h1 class="mt-4">Manajemen Kelas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Manajemen Kelas</li>
    </ol>
    <?php

    //tambah
    if (isset($_POST['simpan'])) {
        require '../function/admin/tambah.php';
        if (tambah_kelas($_POST) > 0) {
            echo '
        <script>
        alert("Data berhasil di tambahkan");
        window.location.href = "m_kelas.php";
        </script>
        ';
        } else {
            echo '
            <script>
            alert("Data gagal di tambahkan");
            window.location.href = "m_kelas.php";
            </script>
        ';
        }
    }

    //hapus
    if (isset($_POST['hapus'])) {
        require '../function/admin/hapus.php';
        if (hapus_kelas($_POST) > 0) {
            echo '
            <script>
            alert("Data berhasil di hapus");
            window.location.href = "m_kelas.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data gagal di hapus");
            window.location.href = "m_kelas.php";
            </script>
            ';
        }
    }

    //edit
    if (isset($_POST['update'])) {
        require '../function/admin/edit.php';
        if (edit_kelas($_POST) > 0) {
            echo '
            <script>
            alert("Data berhasil di update");
            window.location.href = "m_kelas.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data gagal di update");
            window.location.href = "m_kelas.php";
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
                        <th>Nama kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../db/koneksi.php');
                    $query = mysqli_query($conn, "SELECT * FROM kelas");
                    ?>
                    <?php $n = 1; ?>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['nama_kelas']; ?></td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm" id="edit" data-id_kelas="<?= $row['id_kelas']; ?>" data-nama_kelas="<?= $row['nama_kelas']; ?>" data-toggle="modal" data-target="#exampleModaledit">Edit</a>
                                <form action="" method="POST" class="d-inline">
                                    <input type="hidden" name="id_kelas" value="<?= $row['id_kelas']; ?>">
                                    <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('apakah anda yakin ingin menghapus data?')">Hapus</button>
                                </form>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_kelas">Nama kelas</label>
                        <input type="text" name="nama_kelas" id="nama_kelas" class="form-control">
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
                <h5 class="modal-title" id="exampleModalLabel">Edit kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body modal-edit">
                    <div class="form-group">
                        <input type="hidden" name="id_kelas" id="id_kelas">
                        <label for="nama_kelas">Nama kelas</label>
                        <input type="text" name="nama_kelas" id="nama_kelas" class="form-control">
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
        let id_kelas = $(this).data('id_kelas');
        let nama_kelas = $(this).data('nama_kelas');

        $('.modal-edit #id_kelas').val(id_kelas);
        $('.modal-edit #nama_kelas').val(nama_kelas);
    })
</script>