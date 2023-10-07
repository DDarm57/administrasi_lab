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
<?php include('../layout/header.php') ?>

<?php
if (isset($_POST['update_profile'])) {
    require '../function/aslab/edit.php';
    if (edit_profile($_POST) > 0) {
        echo '
            <script>
            alert("Profil berhasil di update");
            window.location.href = "dashboard.php";
            </script>
            ';
    } else {
        echo '
            <script>
            alert("Gagal update profil");
            window.location.href = "dashboard.php";
            </script>
            ';
    }
}

if (isset($_POST["update_pw"])) {
    require '../function/aslab/edit.php';
    update_password($_POST);
}
include "../db/koneksi.php";
$id_aslab = $_SESSION["id_aslab"];
$data_aslab = mysqli_fetch_array(mysqli_query($conn, "SELECT nama_aslab, email_aslab FROM aslab WHERE id_aslab=$id_aslab"));
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold"><?= $_SESSION['nama_aslab']; ?></span><span class="text-black-50"><?= $_SESSION['email_aslab']; ?></span><span> </span></div>
                <div class="card bg-primary text-white">
                    <?php
                    include '../db/koneksi.php';
                    $id_aslab = $_SESSION['id_aslab'];
                    $query = mysqli_query($conn, "SELECT * FROM inventaris WHERE id_aslab='$id_aslab'");
                    $num_rows = mysqli_num_rows($query);
                    ?>
                    <div class="card-body">Data Inventaris <h2><?= $num_rows; ?></h2>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="m_inventaris.php">View Details</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <form action="" method="POST">
                        <div class="row">
                            <div class="form-group">
                                <label for="nama_aslab">Nama Aslab</label>
                                <input type="text" name="nama_aslab" id="" class="form-control" value="<?= $data_aslab['nama_aslab']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="email_aslab">Email Aslab</label>
                                <input type="text" name="email_aslab" id="" class="form-control" value="<?= $data_aslab['email_aslab']; ?>">
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-primary profile-button" name="update_profile" type="submit">Update Profil</button>
                        </div>
                    </form>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="password_aslab">Password Aslab</label>
                            <input type="text" name="password_aslab" id="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password_aslab">Password Aslab</label>
                            <input type="text" name="password_konfirmasi" id="" class="form-control" required>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary" name="update_pw">Updat Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/footer.php') ?>