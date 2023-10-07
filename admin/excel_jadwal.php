<?php
require '../vendor/autoload.php';
include '../db/koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$hari = $_POST['hari'];

if ($hari == '') {
    echo "<script>
    alert('Gagal! inputan hari tidak boleh kosong');
    window.location.href = 'm_jadwal.php';
    </script>";
} else {
    $cek_data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_akademik WHERE status='aktif'"));
    $id_tahun = $cek_data['id_tahun'];
    $query_guruM = mysqli_query(
        $conn,
        "SELECT * FROM jadwal LEFT JOIN ruangan ON ruangan.id_ruangan = jadwal.id_ruangan 
        LEFT JOIN guru_mengajar ON guru_mengajar.id_guruM = jadwal.id_guruM 
        LEFT JOIN guru ON guru.id_guru = guru_mengajar.id_guru 
        LEFT JOIN kelas ON kelas.id_kelas = guru_mengajar.id_kelas 
        LEFT JOIN jam ON jam.id_jam = guru_mengajar.id_jam 
        LEFT JOIN mapel ON mapel.id_mapel = guru_mengajar.id_mapel 
        WHERE guru_mengajar.id_tahun='$id_tahun' AND jadwal.hari='$hari'"
    );

    $cek_jadwal = mysqli_fetch_array($query_guruM);

    if ($cek_jadwal) {

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Times New Roman')
            ->setSize(11);

        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', "DAFTAR JADWAL LAB");
        $spreadsheet->getActiveSheet()
            ->mergeCells("A1:H1");
        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->setCellValue('A2', "SMK NURUL ULUM MANGAR");
        $spreadsheet->getActiveSheet()
            ->mergeCells("A2:H2");
        $spreadsheet->getActiveSheet()
            ->getStyle('A2')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $get_tahun = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_akademik WHERE status='aktif'"));

        $spreadsheet->getActiveSheet()
            ->setCellValue('A3', "SEMESTER " . $get_tahun['semester'] . " TAHUN " . $get_tahun['tahun']);
        $spreadsheet->getActiveSheet()
            ->mergeCells("A3:H3");

        $spreadsheet->getActiveSheet()
            ->getStyle('A3')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        //Buat kolom dan isi
        $spreadsheet->getActiveSheet()
            ->setCellValue('A5', 'NO')
            ->mergeCells("A5:A6")
            ->setCellValue('B5', 'NAMA GURU')
            ->mergeCells("B5:B6")
            ->setCellValue('C5', 'NIP')
            ->mergeCells("C5:C6")
            ->setCellValue('D5', 'RUANGAN')
            ->mergeCells("D5:D6")
            ->setCellValue('E5', 'KELAS')
            ->mergeCells("E5:E6")
            ->setCellValue('F5', 'MAPEL')
            ->mergeCells("F5:F6")
            ->setCellValue('G5', 'HARI')
            ->mergeCells("G5:G6")
            ->setCellValue('H5', 'JAM')
            ->mergeCells("H5:H6");

        // style lebar kolom
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('A')
            ->setWidth(4);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('B')
            ->setWidth(18);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('C')
            ->setWidth(16);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('D')
            ->setWidth(13);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('F')
            ->setWidth(14);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('G')
            ->setWidth(6);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('H')
            ->setWidth(12);

        $spreadsheet->getActiveSheet()
            ->getStyle('A5:H6')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        //Atur Border Atas
        $spreadsheet->getActiveSheet()
            ->getStyle('A5:H6')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $nomer = 1;
        $column = 7;
        while ($row = mysqli_fetch_array($query_guruM)) {
            $spreadsheet->getActiveSheet()
                ->setCellValue('A' . $column, $nomer++)
                ->setCellValue('B' . $column, $row['nama_guru'])
                ->setCellValue('C' . $column, "'" . $row['nip'])
                ->setCellValue('D' . $column, $row['nama_ruangan'])
                ->setCellValue('E' . $column, $row['nama_kelas'])
                ->setCellValue('F' . $column, $row['nama_mapel'])
                ->setCellValue('G' . $column, $row['hari'])
                ->setCellValue('H' . $column, $row['jam_mulai'] . ' - ' . $row['jam_selesai']);
            $spreadsheet->getActiveSheet()
                ->getRowDimension($column)
                ->setRowHeight(50);
            $last_numb = $column;
            $column++;
        }

        if ($last_numb == NULL) {
            echo "<script>
            alert('Jadwal tidak boleh satu baris');
            window.location.href = 'm_jadwal.php';
            </script>";
        } else {
            $get_lastNumb = $last_numb;
            $spreadsheet->getActiveSheet()
                ->getStyle('A7:A' . $get_lastNumb)
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER)
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $spreadsheet->getActiveSheet()
                ->getStyle('B7:C' . $get_lastNumb)
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_TOP)
                ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                ->setWrapText('B7:C' . $get_lastNumb);

            $spreadsheet->getActiveSheet()
                ->getStyle('F7:F' . $get_lastNumb)
                ->getAlignment()
                ->setWrapText('F7:F' . $get_lastNumb);

            $spreadsheet->getActiveSheet()
                ->getStyle('D7:H' . $get_lastNumb)
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER)
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);


            //Atur Border Atas
            $spreadsheet->getActiveSheet()
                ->getStyle('A7:H' . $get_lastNumb)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $writer = new Xlsx($spreadsheet);
            $get_thn = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_akademik WHERE status='aktif'"));
            $filename = date('ymd') . ' JadwalTahun_' . $get_thn['tahun'] . '_Semester_' . $get_thn['semester'];

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        }
    } else {
        echo "<script>
        alert('Jadwal di hari kosong');
        window.location.href = 'm_jadwal.php';
        </script>";
    }
}
