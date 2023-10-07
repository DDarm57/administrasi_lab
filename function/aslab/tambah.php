<?php
include('../db/koneksi.php');
function tambah_inventaris($data)
{
    global $conn;
    $id_aslab = $_SESSION['id_aslab'];
    $kode = $data['kode'];
    $nama_inventaris = $data['nama_inventaris'];
    $jumlah = $data['jumlah'];
    $kondisi = $data['kondisi'];
    $tahun_pengadaan = substr($data['tahun_pengadaan'], 0, 4);
    $creted_at = $data['tahun_pengadaan'];

    mysqli_query($conn, "INSERT INTO inventaris (id_aslab,kode,nama_inventaris,jumlah,kondisi,tahun_pengadaan,created_at) 
    VALUES ('$id_aslab','$kode', '$nama_inventaris', '$jumlah', '$kondisi', $tahun_pengadaan, '$creted_at')");
    return mysqli_affected_rows($conn);
}
