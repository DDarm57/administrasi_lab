<?php
require '../vendor/autoload.php';
include '../db/koneksi.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$tahun_pengadaan = $_POST['tahun_pengadaan'];

if ($tahun_pengadaan == '') {
    echo "<script>
    alert('Gagal! inputan tidak boleh kosong');
    window.location.href = 'm_inventaris.php';
    </script>";
} else {

    $get_tahun = mysqli_query($conn, "SELECT * FROM inventaris LEFT JOIN aslab ON aslab.id_aslab = inventaris.id_aslab WHERE tahun_pengadaan='$tahun_pengadaan'");
    $cek_rows = mysqli_num_rows($get_tahun);
    if ($cek_rows > 0) {

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Times New Roman')
            ->setSize(11);

        $spreadsheet->getActiveSheet()
            ->setCellValue('A1', "DAFTAR INVENTARIS LAB");
        $spreadsheet->getActiveSheet()
            ->mergeCells("A1:G1");
        $spreadsheet->getActiveSheet()
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->setCellValue('A2', "SMK NURUL ULUM MANGAR");
        $spreadsheet->getActiveSheet()
            ->mergeCells("A2:G2");
        $spreadsheet->getActiveSheet()
            ->getStyle('A2')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $spreadsheet->getActiveSheet()
            ->setCellValue('A3', "TAHUN PENGADAAN " . $tahun_pengadaan);
        $spreadsheet->getActiveSheet()
            ->mergeCells("A3:G3");

        $spreadsheet->getActiveSheet()
            ->getStyle('A3')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        //Buat kolom dan isi
        $spreadsheet->getActiveSheet()
            ->setCellValue('A5', 'No')
            ->mergeCells("A5:A6")
            ->setCellValue('B5', 'Kode')
            ->mergeCells("B5:B6")
            ->setCellValue('C5', 'Inventaris')
            ->mergeCells("C5:C6")
            ->setCellValue('D5', 'Jml')
            ->mergeCells("D5:D6")
            ->setCellValue('E5', 'Kondisi')
            ->mergeCells("E5:E6")
            ->setCellValue('F5', 'Thn Pengadaan')
            ->mergeCells("F5:F6")
            ->setCellValue('G5', 'Aslab')
            ->mergeCells("G5:G6");

        // style lebar kolom
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('A')
            ->setWidth(4);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('B')
            ->setWidth(23);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('C')
            ->setWidth(17);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('D')
            ->setWidth(5);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('F')
            ->setWidth(14);
        $spreadsheet->getActiveSheet()
            ->getColumnDimension('G')
            ->setWidth(15);

        $spreadsheet->getActiveSheet()
            ->getStyle('A5:G6')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        //Atur Border Atas
        $spreadsheet->getActiveSheet()
            ->getStyle('A5:G6')
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);
        $ambil_tahun = mysqli_query($conn, "SELECT * FROM inventaris LEFT JOIN aslab ON aslab.id_aslab = inventaris.id_aslab WHERE tahun_pengadaan='$tahun_pengadaan'");
        $nomer = 1;
        $column = 7;
        while ($row = mysqli_fetch_array($ambil_tahun)) {
            $spreadsheet->getActiveSheet()
                ->setCellValue('A' . $column, $nomer++)
                ->setCellValue('B' . $column, "'" . $row['kode'])
                ->setCellValue('C' . $column, $row['nama_inventaris'])
                ->setCellValue('D' . $column, $row['jumlah'])
                ->setCellValue('E' . $column, $row['kondisi'])
                ->setCellValue('F' . $column, $row['tahun_pengadaan'])
                ->setCellValue('G' . $column, $row['nama_aslab']);
            $spreadsheet->getActiveSheet()
                ->getRowDimension($column)
                ->setRowHeight(19);
            $last_numb = $column;
            $column++;
        }

        if ($last_numb == NULL) {
            echo "<script>
            alert('Jadwal tidak boleh satu baris');
            window.location.href = 'm_inventaris.php';
            </script>";
        } else {
            $get_lastNumb = $last_numb;
            $spreadsheet->getActiveSheet()
                ->getStyle('A7:A' . $get_lastNumb)
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER)
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $spreadsheet->getActiveSheet()
                ->getStyle('B7:B' . $get_lastNumb)
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_TOP)
                ->setHorizontal(Alignment::HORIZONTAL_LEFT);

            $spreadsheet->getActiveSheet()
                ->getStyle('C7:G' . $get_lastNumb)
                ->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER)
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);


            //Atur Border Atas
            $spreadsheet->getActiveSheet()
                ->getStyle('A7:G' . $get_lastNumb)
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $writer = new Xlsx($spreadsheet);
            $get_thn = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM tahun_akademik WHERE status='aktif'"));
            $filename = date('ymd') . 'Inventaris ' . $tahun_pengadaan;

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
        }
    } else {
        echo "<script>
        alert('data inventaris kosong');
        window.location.href = 'm_inventaris.php';
        </script>";
    }
}
