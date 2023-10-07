<?php
session_start();
include '../db/koneksi.php';


$email_aslab = $_POST['email_aslab'];
$password_aslab = md5($_POST['password_aslab']);

$get_data = mysqli_query($conn, "SELECT * FROM aslab WHERE email_aslab='$email_aslab'");
$num_rows = mysqli_num_rows($get_data);

if ($email_aslab == '' || $password_aslab == '') {
    echo '
    <script>
    alert("Username dan Password tida boleh kosong");
    window.location.href = "../index.php";
    </script>
';
}

if ($num_rows > 0) {
    $cek_data = mysqli_fetch_array($get_data);
    if ($cek_data["password_aslab"] === $password_aslab) {
        $_SESSION['log'] = true;
        $_SESSION['id_aslab'] = $cek_data['id_aslab'];
        $_SESSION['nama_aslab'] = $cek_data['nama_aslab'];
        $_SESSION['email_aslab'] = $cek_data['email_aslab'];
        $_SESSION['password_aslab'] = $cek_data['password_aslab'];
        $_SESSION['role'] = $cek_data['role'];
        echo '
                <script>
                alert("Login berhasil");
                window.location.href = "../aslab/dashboard.php";
                </script>
            ';
    } else {
        echo '
        <script>
        alert("Password Salah");
        window.location.href = "../index.php";
        </script>
    ';
    }
} else {
    echo '
            <script>
            alert("Username dan Password Tidak Sesuai");
            window.location.href = "../index.php";
            </script>
        ';
}
