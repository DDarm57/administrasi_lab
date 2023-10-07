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
    <h1 class="mt-4">Data Inventaris</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Data Inventaris</li>
    </ol>
    <div class="d-flex justify-content-end">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-success mb-2 text-right" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-file-excel"></i> Excel
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
                        <th>Kode</th>
                        <th>Nama Inventaris</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Tahun Pengadaan</th>
                        <th>Aslab</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../db/koneksi.php');
                    $query = mysqli_query($conn, "SELECT * FROM inventaris");
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
                            <?php
                            $id_aslab = $row['id_aslab'];
                            $get_data = mysqli_query($conn, "SELECT * FROM aslab WHERE id_aslab='$id_aslab'");
                            $aslab = mysqli_fetch_array($get_data);
                            ?>
                            <td><?= $aslab['nama_aslab']; ?></td>
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
                <h5 class="modal-title" id="exampleModalLabel">Print Berdasarkan Tahun Pengadaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="../admin/excel_inventaris.php" method="POST">
                <div class="modal-body">
                    <label for="">Tahun Pengadaan</label>
                    <select class="selectpicker form-control" name="tahun_pengadaan" data-container="body" data-live-search="true" title="Tahun">
                        <?php for ($i = 22; $i <= 30; $i++) { ?>
                            <option value="20<?= $i; ?>">20<?= $i; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Unduh</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('../layout/footer.php') ?>