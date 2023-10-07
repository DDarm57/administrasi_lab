<?php
include('../db/koneksi.php');
function tambah_ruangan($data)
{
    global $conn;
    $nama_ruangan = $data['nama_ruangan'];

    $get_data = mysqli_query($conn, "SELECT * FROM ruangan WHERE nama_ruangan = '$nama_ruangan'");

    $cek_data = mysqli_fetch_array($get_data);
    if ($cek_data) {
        echo "<script>
        alert('Data ruangan dengan nama " . $cek_data['nama_ruangan'] . " sudah ada');
        window.location.href = 'm_ruangan.php';
        </script>";
    } else {
        mysqli_query($conn, "INSERT INTO ruangan (nama_ruangan) VALUES ('$nama_ruangan')");
        return mysqli_affected_rows($conn);
    }
}

function tambah_kelas($data)
{
    global $conn;
    $nama_kelas = $data['nama_kelas'];

    $get_data = mysqli_query($conn, "SELECT * FROM kelas WHERE nama_kelas = '$nama_kelas'");

    $cek_data = mysqli_fetch_array($get_data);
    if ($cek_data) {
        echo "<script>
        alert('Data kelas dengan nama " . $cek_data['nama_kelas'] . " sudah ada');
        window.location.href = 'm_kelas.php';
        </script>";
    } else {
        mysqli_query($conn, "INSERT INTO kelas (nama_kelas) VALUES ('$nama_kelas')");
        return mysqli_affected_rows($conn);
    }
}

function tambah_guru($data)
{
    global $conn;
    $nama_guru = $data['nama_guru'];
    $nip = $data['nip'];

    $get_data = mysqli_query($conn, "SELECT * FROM guru WHERE nip = '$nip'");

    $cek_data = mysqli_fetch_array($get_data);
    if ($cek_data) {
        if ($cek_data['nip'] == 0) {
            mysqli_query($conn, "INSERT INTO guru (nama_guru,nip) VALUES ('$nama_guru', '$nip')");
            return mysqli_affected_rows($conn);
        }
        echo "<script>
        alert('Data guru dengan nip " . $cek_data['nip'] . " sudah ada');
        window.location.href = 'm_guru.php';
        </script>";
    } else {
        mysqli_query($conn, "INSERT INTO guru (nama_guru,nip) VALUES ('$nama_guru', '$nip')");
        return mysqli_affected_rows($conn);
    }
}


function tambah_jam($data)
{
    global $conn;

    $jam_mulai = $data['jam_mulai'];
    $jam_selesai = $data['jam_selesai'];

    if ($jam_mulai == '' || $jam_selesai == '') {
        echo "<script>
        alert('Data jam tidak boleh kosong');
        window.location.href = 'm_jadwal.php';
        </script>";
    } else {
        mysqli_query($conn, "INSERT INTO jam (jam_mulai,jam_selesai) VALUES ('$jam_mulai','$jam_selesai')");
        return mysqli_affected_rows($conn);
    }
}

function tambah_mapel($data)
{
    global $conn;
    $nama_mapel = $data['nama_mapel'];

    $get_data = mysqli_query($conn, "SELECT * FROM mapel WHERE nama_mapel='$nama_mapel'");

    $cek_data = mysqli_fetch_array($get_data);

    if ($cek_data) {
        echo "<script>
        alert('Data jadwal sudah ada');
        window.location.href = 'm_jadwal.php';
        </script>";
    } else {
        if ($nama_mapel == '') {
            echo "<script>
        alert('Data tidak boleh kosong');
        window.location.href = 'm_jadwal.php';
        </script>";
        } else {
            mysqli_query($conn, "INSERT INTO mapel (nama_mapel) VALUES ('$nama_mapel')");
            return mysqli_affected_rows($conn);
        }
    }
}

function tambah_guruM($data)
{
    global $conn;
    $id_jam = $data['id_jam'];
    $id_guru = $data['id_guru'];
    $id_kelas = $data['id_kelas'];
    $id_mapel = $data['id_mapel'];
    $id_ruangan = $data['id_ruangan'];
    $hari = $data['hari'];

    $cek_tahun = mysqli_query($conn, "SELECT * FROM tahun_akademik WHERE status='aktif'");
    $get_tahun = mysqli_fetch_array($cek_tahun);
    $id_tahun = $get_tahun['id_tahun'];

    $get_data = mysqli_query($conn, "SELECT * FROM jadwal JOIN guru_mengajar ON guru_mengajar.id_guruM WHERE jadwal.id_ruangan='$id_ruangan' AND jadwal.hari='$hari' AND guru_mengajar.id_guru='$id_guru' AND guru_mengajar.id_kelas='$id_kelas' AND guru_mengajar.id_jam='$id_jam' AND guru_mengajar.id_tahun='$id_tahun'");
    $get_data2 = mysqli_query($conn, "SELECT * FROM jadwal JOIN guru_mengajar ON guru_mengajar.id_guruM WHERE jadwal.id_ruangan='$id_ruangan' AND jadwal.hari='$hari' AND guru_mengajar.id_jam='$id_jam' AND guru_mengajar.id_guru='$id_guru' AND guru_mengajar.id_tahun='$id_tahun'");
    // $get_data = mysqli_query($conn, "SELECT * FROM jadwal LEFT JOIN guru_mengajar ON guru_mengajar.id_guruM WHERE guru_mengajar.id_tahun='$id_tahun'");

    $cek_data = mysqli_fetch_array($get_data);
    $cek_data2 = mysqli_fetch_array($get_data2);
    var_dump($cek_data);
    if ($cek_data) {
        echo "<script>
        alert('Gagal! jadwal tidak boleh sama');
        window.location.href = 'm_jadwal.php';
        </script>";
        if ($cek_data == NULL) {
            mysqli_query($conn, "INSERT INTO guru_mengajar (id_jam,id_guru,id_kelas,id_mapel,id_tahun) VALUES ('$id_jam','$id_guru','$id_kelas','$id_mapel','$id_tahun')");
            $id_guruM = mysqli_insert_id($conn);
            mysqli_query($conn, "INSERT INTO jadwal (id_ruangan,id_guruM,hari) VALUES ('$id_ruangan','$id_guruM','$hari')");
            return mysqli_affected_rows($conn);
        }
    } elseif ($cek_data2) {
        echo "<script>
            alert('Gagal! ruangan tidak boleh sama pada jam dan hari yang sama');
            window.location.href = 'm_jadwal.php';
            </script>";
    } else {
        mysqli_query($conn, "INSERT INTO guru_mengajar (id_jam,id_guru,id_kelas,id_mapel,id_tahun) VALUES ('$id_jam','$id_guru','$id_kelas','$id_mapel','$id_tahun')");
        $id_guruM = mysqli_insert_id($conn);
        mysqli_query($conn, "INSERT INTO jadwal (id_ruangan,id_guruM,hari) VALUES ('$id_ruangan','$id_guruM','$hari')");
        return mysqli_affected_rows($conn);
    }
}

function tambah_aslab($data)
{
    global $conn;
    $nama_aslab = $data['nama_aslab'];
    $email_aslab = $data['email_aslab'];
    $password_aslab = $data['password_aslab'];
    $role = 'aslab';

    $get_data = mysqli_query($conn, "SELECT * FROM aslab where password_aslab='$password_aslab'");
    $cek_data = mysqli_num_rows($get_data);
    if ($cek_data > 0) {
        echo "<script>
        alert('Gagal! password tidak boleh sama dengan aslab lainnya. Gunakan password lain');
        window.location.href = 'm_aslab.php';
        </script>";
    } else {
        mysqli_query($conn, "INSERT INTO aslab (nama_aslab,email_aslab,password_aslab,role) VALUES ('$nama_aslab','$email_aslab','$password_aslab', '$role')");
        return mysqli_affected_rows($conn);
    }
}

function tambah_tahunAkd($data)
{
    global $conn;
    $tahun = $data['tahun'];
    $semester = $data['semester'];
    $status = 'tidak aktif';

    $get_data = mysqli_query($conn, "SELECT * FROM tahun_akademik WHERE tahun='$tahun' AND semester='$semester'");
    $cek_data = mysqli_num_rows($get_data);
    if ($cek_data > 0) {
        echo "<script>
        alert('Gagal! tahun dan semester tidak boleh sama');
        window.location.href = 'm_tahunAkd.php';
        </script>";
    } else {
        mysqli_query($conn, "INSERT INTO tahun_akademik (tahun,semester,status) VALUES ('$tahun', '$semester', '$status')");
        return mysqli_affected_rows($conn);
    }
}
