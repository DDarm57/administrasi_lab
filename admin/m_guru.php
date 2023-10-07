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
    <h1 class="mt-4">Manajemen Guru</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Manajemen Guru</li>
    </ol>
    <?php

    //tambah
    if (isset($_POST['simpan'])) {
        require '../function/admin/tambah.php';
        if (tambah_guru($_POST) > 0) {
            echo '
        <script>
        alert("Data berhasil di tambahkan");
        window.location.href = "m_guru.php";
        </script>
        ';
        } else {
            echo '
            <script>
            alert("Data gagal di tambahkan");
            window.location.href = "m_guru.php";
            </script>
        ';
        }
    }

    //hapus
    if (isset($_POST['hapus'])) {
        require '../function/admin/hapus.php';
        if (hapus_guru($_POST) > 0) {
            echo '
            <script>
            alert("Data berhasil di hapus");
            window.location.href = "m_guru.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data gagal di hapus");
            window.location.href = "m_guru.php";
            </script>
            ';
        }
    }

    //edit
    if (isset($_POST['update'])) {
        require '../function/admin/edit.php';
        if (edit_guru($_POST) > 0) {
            echo '
            <script>
            alert("Data berhasil di update");
            window.location.href = "m_guru.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data gagal di update");
            window.location.href = "m_guru.php";
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
                        <th>Nama guru</th>
                        <th>NIP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../db/koneksi.php');
                    $query = mysqli_query($conn, "SELECT * FROM guru");
                    ?>
                    <?php $n = 1; ?>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['nama_guru']; ?></td>
                            <td>
                                <p class="<?= ($row['nip'] == 0 ? 'text-danger' : ''); ?>"><?= ($row['nip'] == 0 ? '<strong>NIP Kosong</strong>' : $row['nip']); ?></p>
                            </td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm" id="edit" data-id_guru="<?= $row['id_guru']; ?>" data-nama_guru="<?= $row['nama_guru']; ?>" data-nip="<?= $row['nip']; ?>" data-toggle="modal" data-target="#exampleModaledit">Edit</a>
                                <form action="" method="POST" class="d-inline">
                                    <input type="hidden" name="id_guru" value="<?= $row['id_guru']; ?>">
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_guru">Nama guru</label>
                        <input type="text" name="nama_guru" id="nama_guru" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="number" name="nip" id="nip" class="form-control">
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
                <h5 class="modal-title" id="exampleModalLabel">Edit guru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body modal-edit">
                    <div class="form-group">
                        <input type="hidden" name="id_guru" id="id_guru">
                        <label for="nama_guru">Nama guru</label>
                        <input type="text" name="nama_guru" id="nama_guru" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="number" name="nip" id="nip" class="form-control">
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
        let id_guru = $(this).data('id_guru');
        let nama_guru = $(this).data('nama_guru');
        let nip = $(this).data('nip');

        $('.modal-edit #id_guru').val(id_guru);
        $('.modal-edit #nama_guru').val(nama_guru);
        $('.modal-edit #nip').val(nip);
    })
</script>