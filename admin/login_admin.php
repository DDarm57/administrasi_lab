<?php
session_status() === PHP_SESSION_ACTIVE ?: session_start();

include '../db/koneksi.php';

if (isset($_POST['cek_loginAdmin'])) {
    $email_kajur = $_POST['email_kajur'];
    $password_kajur = md5($_POST['password_kajur']);

    if ($email_kajur == '' || $password_kajur == '') {
        echo '
        <script>
        alert("Username dan Password tida boleh kosong");
        window.location.href = "login_admin.php";
        </script>
    ';
    }
    $get_data = mysqli_query($conn, "SELECT * FROM ketua_jurusan WHERE email_kajur='$email_kajur'");
    $num_rows = mysqli_num_rows($get_data);
    if ($num_rows > 0) {
        $cek_data = mysqli_fetch_array($get_data);
        if ($cek_data["password_kajur"] === $password_kajur) {
            $_SESSION['log'] = true;
            $_SESSION['id_kajur'] = $cek_data['id_kajur'];
            $_SESSION['nama_kajur'] = $cek_data['nama_kajur'];
            $_SESSION['email_kajur'] = $cek_data['email_kajur'];
            $_SESSION['password_kajur'] = $cek_data['password_kajur'];
            $_SESSION['role'] = $cek_data['role'];
            echo '
                <script>
                alert("Login berhasil");
                window.location.href = "dashboard.php";
                </script>
            ';
        } else {
            echo '
            <script>
            alert("Password Salah");
            window.location.href = "login_admin.php";
            </script>
        ';
        }
    } else {
        echo '
            <script>
            alert("Username dan Password Salah");
            window.location.href = "login_admin.php";
            </script>
        ';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login Admin</title>
    <link href="../template/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-info">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login Ketua Jurusan</h3>
                                </div>
                                <div class="card-body">
                                    <form action="" method="POST">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="email_kajur" id="inputEmail" type="email" placeholder="name@example.com" />
                                            <label for="inputEmail">Email address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="password_kajur" id="inputPassword" type="password" placeholder="Password" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                                            <button type="submit" name="cek_loginAdmin" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="../index.php">Login Aslab</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2022</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../template/js/scripts.js"></script>
</body>

</html>