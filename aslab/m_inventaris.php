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
    if ($_SESSION['role'] != 'aslab') {
        header('location: ../admin/dashboard.php');
    }
}
?>

<?php include('../layout/header.php'); ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Inventaris</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Manajemen Inventaris</li>
    </ol>
    <?php

    function random_str(
        int $length = 64,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ): string {
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces[] = $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    //tambah
    if (isset($_POST['simpan'])) {
        require '../function/aslab/tambah.php';
        if (tambah_inventaris($_POST) > 0) {
            echo '
        <script>
        alert("Data inventaris berhasil di tambahkan");
        window.location.href = "m_inventaris.php";
        </script>
        ';
        } else {
            echo '
            <script>
            alert("Data inventaris gagal di tambahkan");
            window.location.href = "m_inventaris.php";
            </script>
        ';
        }
    }

    //hapus
    if (isset($_POST['hapus'])) {
        require '../function/aslab/hapus.php';
        if (hapus_inventaris($_POST) > 0) {
            echo '
            <script>
            alert("Data inventaris berhasil di hapus");
            window.location.href = "m_inventaris.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data inventaris gagal di hapus");
            window.location.href = "m_inventaris.php";
            </script>
            ';
        }
    }

    //edit
    if (isset($_POST['update'])) {
        require '../function/aslab/edit.php';
        if (edit_inventaris($_POST) > 0) {
            echo '
            <script>
            alert("Data inventaris berhasil di update");
            window.location.href = "m_inventaris.php";
            </script>
            ';
        } else {
            echo '
            <script>
            alert("Data inventaris gagal di update");
            window.location.href = "m_inventaris.php";
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
    <?php
    $a = random_str(10);
    $b = random_str(8, 'abcdefghijklmnopqrstuvwxyz');
    $c = random_str();
    ?>
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
                        <th>Kode</th>
                        <th>Nama Inventaris</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Tahun Pengadaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../db/koneksi.php');
                    $id_aslab = $_SESSION['id_aslab'];
                    $query = mysqli_query($conn, "SELECT * FROM inventaris WHERE id_aslab='$id_aslab'");
                    ?>
                    <?php $n = 1; ?>
                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                        <tr>
                            <td><?= $n++; ?></td>
                            <td><?= $row['kode']; ?></td>
                            <td><?= $row['nama_inventaris']; ?></td>
                            <td><?= $row['jumlah']; ?></td>
                            <td><?= $row['kondisi']; ?></td>
                            <td><?= $row['tahun_pengadaan']; ?></td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm" id="edit" data-id_inventaris="<?= $row['id_inventaris']; ?>" data-kode="<?= $row['kode']; ?>" data-nama_inventaris="<?= $row['nama_inventaris']; ?>" data-jumlah="<?= $row['jumlah']; ?>" data-kondisi="<?= $row['kondisi']; ?>" data-tahun_pengadaan="<?= $row['tahun_pengadaan']; ?>" data-toggle="modal" data-target="#exampleModaledit">Edit</a>
                                <form action="" method="POST" class="d-inline">
                                    <input type="hidden" name="id_inventaris" value="<?= $row['id_inventaris']; ?>">
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah inventaris</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode">Kode</label>
                        <input type="text" name="kode" id="kode" class="form-control" value="<?php echo 'Inv' . $a . date('Y'); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_inventaris">Nama inventaris</label>
                        <input type="text" name="nama_inventaris" id="nama_inventaris" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kondisi">Kondisi</label>
                        <input type="text" name="kondisi" id="kondisi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tahun_pengadaan">Tahun Pengadaan</label>
                        <input type="date" name="tahun_pengadaan" id="tahun_pengadaan" class="form-control">
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
                <h5 class="modal-title" id="exampleModalLabel">Edit inventaris</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <div class="modal-body modal-edit">
                    <input type="hidden" name="id_inventaris" id="id_inventaris">
                    <div class="form-group">
                        <label for="kode">Kode</label>
                        <input type="text" name="kode" id="kode" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nama_inventaris">Nama inventaris</label>
                        <input type="text" name="nama_inventaris" id="nama_inventaris" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kondisi">Kondisi</label>
                        <input type="text" name="kondisi" id="kondisi" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tahun_pengadaan">Tahun Pengadaan</label>
                        <input type="text" name="tahun_pengadaan" id="tahun_pengadaan" class="form-control" readonly>
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
        let id_inventaris = $(this).data('id_inventaris');
        let kode = $(this).data('kode');
        let nama_inventaris = $(this).data('nama_inventaris');
        let jumlah = $(this).data('jumlah');
        let kondisi = $(this).data('kondisi');
        let tahun_pengadaan = $(this).data('tahun_pengadaan');

        $('.modal-edit #id_inventaris').val(id_inventaris);
        $('.modal-edit #kode').val(kode);
        $('.modal-edit #nama_inventaris').val(nama_inventaris);
        $('.modal-edit #jumlah').val(jumlah);
        $('.modal-edit #kondisi').val(kondisi);
        $('.modal-edit #tahun_pengadaan').val(tahun_pengadaan);
    })
</script>