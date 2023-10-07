<?php
include('../db/koneksi.php');

function edit_ruangan($data)
{
    global $conn;
    $id_ruangan = $data['id_ruangan'];
    $nama_ruangan = $data['nama_ruangan'];

    mysqli_query($conn, "UPDATE ruangan SET nama_ruangan='$nama_ruangan' WHERE id_ruangan='$id_ruangan' ");
    return mysqli_affected_rows($conn);
}

function edit_kelas($data)
{
    global $conn;
    $id_kelas = $data['id_kelas'];
    $nama_kelas = $data['nama_kelas'];

    mysqli_query($conn, "UPDATE kelas SET nama_kelas='$nama_kelas' WHERE id_kelas='$id_kelas' ");
    return mysqli_affected_rows($conn);
}

function edit_guru($data)
{
    global $conn;
    $id_guru = $data['id_guru'];
    $nama_guru = $data['nama_guru'];
    $nip = $data['nip'];

    mysqli_query($conn, "UPDATE guru SET nama_guru='$nama_guru', nip='$nip' WHERE id_guru='$id_guru' ");
    return mysqli_affected_rows($conn);
}

function edit_jam($data)
{
    global $conn;
    $id_jam = $data['id_jam'];
    $jam_mulai = $data['jam_mulai'];
    $jam_selesai = $data['jam_selesai'];

    mysqli_query($conn, "UPDATE guru SET jam_mulai='$jam_mulai', jam_selesai='$jam_selesai' WHERE id_jam='$id_jam' ");
    return mysqli_affected_rows($conn);
}

function edit_mapel($data)
{
    global $conn;
    $id_mapel = $data['id_mapel'];
    $nama_mapel = $data['nama_mapel'];

    mysqli_query($conn, "UPDATE mapel SET nama_mapel='$nama_mapel' WHERE id_mapel='$id_mapel' ");
    return mysqli_affected_rows($conn);
}

function edit_jadwal($data)
{
    global $conn;
    $id_jadwal = $data['id_jadwal'];
    $id_guruM = $data['id_guruM'];
    $id_jam = $data['id_jam'];
    $id_guru = $data['id_guru'];
    $id_kelas = $data['id_kelas'];
    $id_mapel = $data['id_mapel'];
    $id_ruangan = $data['id_ruangan'];
    $hari = $data['hari'];

    $get_data = mysqli_query($conn, "SELECT * FROM jadwal LEFT JOIN guru_mengajar ON guru_mengajar.id_guruM WHERE jadwal.id_ruangan='$id_ruangan' AND jadwal.hari='$hari' AND guru_mengajar.id_jam='$id_jam'");

    $cek_data = mysqli_fetch_array($get_data);

    if ($cek_data) {
        echo "<script>
        alert('Gagal! tidak dapat menambahkan jadwal pada hari dan jam pada ruangan yang sama');
        window.location.href = 'm_jadwal.php';
        </script>";
    } else {
        mysqli_query($conn, "UPDATE guru_mengajar SET id_jam='$id_jam', id_guru='$id_guru', id_kelas='$id_kelas', id_mapel='$id_mapel' WHERE guru_mengajar.id_guruM='$id_guruM'");
        mysqli_query($conn, "UPDATE jadwal SET id_ruangan='$id_ruangan',hari='$hari' WHERE jadwal.id_jadwal='$id_jadwal'");
        return mysqli_affected_rows($conn);
    }
}

function edit_profile($data)
{
    global $conn;
    $id_kajur = $_SESSION['id_kajur'];
    $nama_kajur = $data['nama_kajur'];
    $email_kajur = $data['email_kajur'];

    mysqli_query($conn, "UPDATE ketua_jurusan SET nama_kajur='$nama_kajur', email_kajur='$email_kajur' WHERE id_kajur=$id_kajur");
    // var_dump(mysqli_error($conn));
    // exit;
    echo "<script>
    alert('Profil berhasil di update');
    window.location.href = 'dashboard.php';
    </script>";
}

function edit_tahunAkd($data)
{
    global $conn;
    $id_tahun = $data['id_tahun'];
    $tahun = $data['tahun'];
    $semester = $data['semester'];

    $get_data = mysqli_query($conn, "SELECT * FROM tahun_akademik WHERE tahun='$tahun' AND semester='$semester'");
    $cek_data = mysqli_num_rows($get_data);
    if ($cek_data > 0) {
        echo "<script>
        alert('Gagal! tahun dan semester tidak boleh sama');
        window.location.href = 'm_tahunAkd.php';
        </script>";
    } else {
        mysqli_query($conn, "UPDATE tahun_akademik SET tahun='$tahun', semester='$semester' WHERE id_tahun='$id_tahun'");
        return mysqli_affected_rows($conn);
    }
}

function update_password($data)
{
    global $conn;
    $id_kajur = $_SESSION['id_kajur'];
    $password_kajur = $data["password_kajur"];
    $password_konfirmasi = $data["password_konfirmasi"];

    if ($password_kajur != $password_konfirmasi) {
        echo "<script>
        alert('Password konfirmasi tidak sama');
        window.location.href = 'dashboard.php';
        </script>";
    } else {
        $new_pw = md5($password_kajur);
        mysqli_query($conn, "UPDATE ketua_jurusan SET password_kajur='$new_pw' WHERE id_kajur=$id_kajur");
        echo "<script>
        alert('Password berhasil di reset. Silahkan login kembali');
        window.location.href = 'logout.php';
        </script>";
    }
}
