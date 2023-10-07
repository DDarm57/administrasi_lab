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
    <h1 class="mt-4">Data Aslab</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Data Aslab</li>
    </ol>
    <?php

    //tambah
    if (isset($_POST['simpan'])) {
        require '../function/admin/tambah.php';
        if (tambah_aslab($_POST) > 0) {
            echo '
        <script>
        alert("Data berhasil di tambahkan");
        window.location.href = "m_aslab.php";
        </script>
        ';
        } else {
            echo '
            <script>
            alert("Data gagal di tambahkan");
            window.location.href = "m_aslab.php";
            </script>
        ';
        }
    }

    //hapus
    if (isset($_POST['hapus'])) {
        require '../function/admin/hapus.php';
        if (hapus_aslab($_POST) > 0) {
            echo '
            <script>
            alert("Data berhasil di hapus");
            window.location.href = "m_aslab.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data gagal di hapus");
            window.location.href = "m_aslab.php";
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
                        <th>Nama aslab</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../db/koneksi.php');
                    $query = mysqli_query($conn, "SELECT * FROM aslab");
                    ?>
                    <?php $n = 1; ?>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['nama_aslab']; ?></td>
                            <td><?= $row['email_aslab']; ?></td>
                            <td><?= $row['password_aslab']; ?></td>
                            <td>
                                <form action="" method="POST">
                                    <input type="hidden" name="id_aslab" id="" value="<?= $row['id_aslab']; ?>">
                                    <button type="submit" name="hapus" class="btn btn-danger btn-sm" onclick="return confirm('apakah anda yain ingin menghapus')">Hapus</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah aslab</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama_aslab">Nama aslab</label>
                        <input type="text" name="nama_aslab" id="nama_aslab" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email_aslab">Email</label>
                        <input type="email" name="email_aslab" id="email_aslab" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password_aslab">Password</label>
                        <input type="text" name="password_aslab" id="password_aslab" class="form-control">
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

<?php include('../layout/footer.php') ?>

<script>
    $(document).on('click', '#edit', function(e) {
        e.preventDefault();
        let id_aslab = $(this).data('id_aslab');
        let nama_aslab = $(this).data('nama_aslab');
        let nip = $(this).data('nip');

        $('.modal-edit #id_aslab').val(id_aslab);
        $('.modal-edit #nama_aslab').val(nama_aslab);
        $('.modal-edit #nip').val(nip);
    })
</script>