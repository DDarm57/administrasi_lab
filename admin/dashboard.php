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
<?php include('../layout/header.php') ?>

<?php
if (isset($_POST['update_profile'])) {
    require '../function/admin/edit.php';
    edit_profile($_POST);
}
if (isset($_POST["reset_pw"])) {
    require '../function/admin/edit.php';
    update_password($_POST);
}
$id_kajur  = $_SESSION['id_kajur'];
include "../db/koneksi.php";
$data_kajur = mysqli_fetch_array(mysqli_query($conn, "SELECT nama_kajur,email_kajur FROM ketua_jurusan WHERE id_kajur=$id_kajur"));
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-sm-6">
            <div class="card bg-primary text-white mb-4">
                <?php
                include '../db/koneksi.php';
                $query = mysqli_query($conn, "SELECT * FROM aslab");
                $get_numRows = mysqli_num_rows($query);
                ?>
                <div class="card-body">Data Aslab <h3><?= $get_numRows; ?></h3>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="m_aslab.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card bg-success text-white mb-4">
                <?php
                include '../db/koneksi.php';
                $query = mysqli_query($conn, "SELECT * FROM inventaris");
                $get_numRows = mysqli_num_rows($query);
                ?>
                <div class="card-body">Data Inventaris <h3><?= $get_numRows; ?></h3>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="m_inventaris.php">View Details</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold"><?= $_SESSION['nama_kajur']; ?></span><span class="text-black-50"><?= $_SESSION['email_kajur']; ?></span><span> </span></div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <form action="" method="POST">
                        <div class="row">
                            <div class="form-group">
                                <label for="nama_kajur">Nama kajur</label>
                                <input type="text" name="nama_kajur" id="" class="form-control" value="<?= $data_kajur['nama_kajur']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="email_kajur">Email kajur</label>
                                <input type="text" name="email_kajur" id="" class="form-control" value="<?= $data_kajur['email_kajur']; ?>">
                            </div>
                        </div>
                        <div class="mt-2 text-center">
                            <button class="btn btn-primary profile-button" name="update_profile" type="submit">Update Profil</button>
                        </div>
                    </form>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="password_kajur">Password</label>
                            <input type="text" name="password_kajur" id="" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="password_kajur">Konfimasi Password</label>
                            <input type="text" name="password_konfirmasi" id="" class="form-control" value="">
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary" name="reset_pw">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/footer.php') ?>