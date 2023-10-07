<?php
include('../db/koneksi.php');
function edit_inventaris($data)
{
    global $conn;

    $id_inventaris = $data['id_inventaris'];
    $kode = $data['kode'];
    $nama_inventaris = $data['nama_inventaris'];
    $jumlah = $data['jumlah'];
    $kondisi = $data['kondisi'];

    mysqli_query($conn, "UPDATE inventaris SET kode='$kode', nama_inventaris='$nama_inventaris', jumlah='$jumlah', kondisi='$kondisi' WHERE id_inventaris='$id_inventaris' ");
    return mysqli_affected_rows($conn);
}

function edit_profile($data)
{
    global $conn;
    $id_aslab = $_SESSION['id_aslab'];
    $nama_aslab = $data['nama_aslab'];
    $email_aslab = $data['email_aslab'];

    mysqli_query($conn, "UPDATE aslab SET nama_aslab='$nama_aslab', email_aslab='$email_aslab'  WHERE id_aslab='$id_aslab'");
    return mysqli_affected_rows($conn);
}

function update_password($data)
{
    global $conn;
    $id_aslab = $_SESSION['id_aslab'];
    $password_aslab = $data["password_aslab"];
    $password_konfirmasi = $data["password_konfirmasi"];

    if ($password_aslab != $password_konfirmasi) {
        echo "<script>
        alert('Password konfirmasi tidak sama');
        window.location.href = 'dashboard.php';
        </script>";
    } else {
        $new_pw = md5($password_aslab);
        mysqli_query($conn, "UPDATE aslab SET password_aslab='$new_pw' WHERE id_aslab=$id_aslab");
        echo "<script>
        alert('Password berhasil di reset. Silahkan login kembali');
        window.location.href = 'logout_aslab.php';
        </script>";
    }
}
