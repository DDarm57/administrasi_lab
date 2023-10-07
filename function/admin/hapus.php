<?php
include('../db/koneksi.php');

function hapus_ruangan($data)
{
    global $conn;
    $id_ruangan = $data['id_ruangan'];

    mysqli_query($conn, "DELETE FROM ruangan WHERE id_ruangan='$id_ruangan'");
    return mysqli_affected_rows($conn);
}

function hapus_kelas($data)
{
    global $conn;
    $id_kelas = $data['id_kelas'];

    mysqli_query($conn, "DELETE FROM kelas WHERE id_kelas='$id_kelas'");
    return mysqli_affected_rows($conn);
}

function hapus_guru($data)
{
    global $conn;
    $id_guru = $data['id_guru'];

    mysqli_query($conn, "DELETE FROM guru WHERE id_guru='$id_guru'");
    return mysqli_affected_rows($conn);
}

function hapus_jam($data)
{
    global $conn;
    $id_jam = $data['id_jam'];

    mysqli_query($conn, "DELETE FROM jam WHERE id_jam='$id_jam'");
    return mysqli_affected_rows($conn);
}
function hapus_mapel($data)
{
    global $conn;
    $id_mapel = $data['id_mapel'];

    mysqli_query($conn, "DELETE FROM mapel WHERE id_mapel='$id_mapel'");
    return mysqli_affected_rows($conn);
}

function hapus_jadwal($data)
{
    global $conn;

    $id_guruM = $data['id_guruM'];


    mysqli_query($conn, "DELETE FROM guru_mengajar WHERE id_guruM='$id_guruM'");
    return mysqli_affected_rows($conn);
}

function hapus_aslab($data)
{
    global $conn;
    $id_aslab = $data['id_aslab'];

    $get_data = mysqli_query($conn, "SELECT * FROM inventaris WHERE id_aslab='$id_aslab'");

    if (mysqli_num_rows($get_data) > 0) {
        echo '
        <script>
        alert("Data gagal di hapus karena ada aktivitas di dalam inventaris");
        window.location.href = "m_aslab.php";
        </script>
    ';
    } else {
        mysqli_query($conn, "DELETE FROM aslab WHERE id_aslab='$id_aslab'");
        return mysqli_affected_rows($conn);
    }
}

function hapus_tahunAkd($data)
{
    global $conn;
    $id_tahun = $data['id_tahun'];

    $get_data = mysqli_query($conn, "SELECT * FROM guru_mengajar WHERE id_tahun='$id_tahun'");

    if (mysqli_num_rows($get_data) > 0) {
        echo '
        <script>
        alert("Data gagal di hapus karena ada aktivitas di dalam jadwal");
        window.location.href = "m_tahunAkd.php";
        </script>
    ';
    } else {
        mysqli_query($conn, "DELETE FROM tahun_akademik WHERE id_tahun='$id_tahun'");
        return mysqli_affected_rows($conn);
    }
}
