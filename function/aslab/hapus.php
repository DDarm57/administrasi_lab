<?php
include('../db/koneksi.php');

function hapus_inventaris($data)
{
    global $conn;
    $id_inventaris = $data['id_inventaris'];

    mysqli_query($conn, "DELETE FROM inventaris WHERE id_inventaris='$id_inventaris'");
    return mysqli_affected_rows($conn);
}
