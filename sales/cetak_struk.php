<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');
require('../php/modular/html_table.php');

if(isset($_GET['bon']) AND isset($_GET['nomor_struk'])) {
    $num_struk = $_GET['nomor_struk'];
    $bayar_tunai = $_GET['bayar'];

    $qStruk = "SELECT transaksi_kasir.id_transaksi_header, karyawan.id_karyawan, karyawan.nama_karyawan, barang.nama_barang, barang.harga_jual, transaksi_kasir_detail.barcode_barang, transaksi_kasir_detail.jml_barang, transaksi_kasir_detail.harga_sub_total FROM transaksi_kasir JOIN transaksi_kasir_detail ON transaksi_kasir.id_transaksi_header = transaksi_kasir_detail.id_transaksi_header JOIN barang ON transaksi_kasir_detail.barcode_barang = barang.barcode_barang JOIN karyawan ON transaksi_kasir.id_petugas = karyawan.id_karyawan WHERE transaksi_kasir.id_transaksi_header = '" . $num_struk . "'";

    $result_struk = $db->prepare($qStruk);
    $result_struk->execute();

    $result_struk_detail = $db->prepare($qStruk);
    $result_struk_detail->execute();

    $hasil_header_struk=$result_struk->fetch();
    $pdf=new PDF('P','mm',array(75,100));
    $pdf->AddPage();
    // HEADER
    $pdf->Image($url_web.'/images/logo-black.png',50,5,15);
    $pdf->SetFont('Arial','',8); 
    $kop = "BM MART";
    $kop_2 = "Jl. LODAN RAYA NO. 2,";
    $kop_3 = "ANCOL - JAKARTA UTARA";
    // $kop_3 = "Purchase Order " . $num_po;
    $pdf->Text(5 - ($pdf->GetStringWidth($text) / 2), 8, $kop);
    $pdf->SetFont('Arial','',5); 
    $pdf->Text(5 - ($pdf->GetStringWidth($text) / 2), 11, $kop_2);
    $pdf->Text(5 - ($pdf->GetStringWidth($text) / 2), 13, $kop_3);
    $pdf->Text(5 - ($pdf->GetStringWidth($text) / 2), 18, '--------------------------------------------------------------------------------------------------------------');
    $pdf->Text(6 - ($pdf->GetStringWidth($text) / 2), 20, $hasil_header_struk['id_transaksi_header']);
    $pdf->Text(45 - ($pdf->GetStringWidth($text) / 2), 20, $hasil_header_struk['id_karyawan'] . '  /');
    $pdf->Text(55 - ($pdf->GetStringWidth($text) / 2), 20, $hasil_header_struk['nama_karyawan']);
    $pdf->Text(5 - ($pdf->GetStringWidth($text) / 2), 22, '--------------------------------------------------------------------------------------------------------------');
    // $pdf->Text(80 - ($pdf->GetStringWidth($text) / 2), 25, $kop_3);

    // BODY
    $pdf->SetFont('Arial','',5); 
    $htmlTable="<TABLE BORDER='none' cellspacing='0' cellpadding='0' style='padding-left:-10px'>";
    for($i=0;$row = $result_struk_detail->fetch();$i++){
        $htmlTable.="<TR>";
        $htmlTable.="<TD width='155' height='15'>".$row['nama_barang']."</TD>";
        $htmlTable.="<TD width='20' height='15'>".$row['jml_barang']."</TD>";
        $htmlTable.="<TD width='45' height='15'>".str_replace(',', '.', number_format($row['harga_jual']))."</TD>";
        $htmlTable.="<TD width='45' height='15'>".str_replace(',', '.', number_format($row['harga_sub_total']))."</TD>";
        $htmlTable.="</TR>";
        $grandtotal += (int) $row['harga_sub_total'];
    }
    $htmlTable.="<TR>";
    $htmlTable.="<TD width='265' height='15'>-------------------------------------------------------------------------------------------------------------</TD>";
    $htmlTable.="</TR>";
    $htmlTable.="<TR>";
    $htmlTable.="<TD ALIGN='RIGHT' width='220' height='15'>TOTAL    : </TD>";
    $htmlTable.="<TD width='45' height='15'>".str_replace(',', '.', number_format($grandtotal))."</TD>";
    $htmlTable.="</TR>";
    $htmlTable.="<TR>";
    $htmlTable.="<TD ALIGN='RIGHT' width='220' height='15'>BAYAR    : </TD>";
    $htmlTable.="<TD width='45' height='15'>".str_replace(',', '.', number_format($bayar_tunai))."</TD>";
    $htmlTable.="</TR>";
    $htmlTable.="<TR>";
    $htmlTable.="<TD ALIGN='RIGHT' width='220' height='15'>Kembali    : </TD>";
    $htmlTable.="<TD width='45' height='15'>".str_replace(',', '.', number_format($bayar_tunai-$grandtotal))."</TD>";
    $htmlTable.="</TR>";
    $htmlTable.="</TABLE>";
    $pdf->SetLeftMargin(5);
    $pdf->WriteHTML("<br><br><br>$htmlTable");

    $pdf->Text(18, 95, 'Terima kasih telah berbelanja, kembali lain waktu.');
    // $pdf->Text(144 - ($pdf->GetStringWidth($text) / 2), 125, str_replace(',', '.', number_format($grandtotal)));

    // $pdf->SetFont('Arial','',10); 
    // $pdf->Text(20 - ($pdf->GetStringWidth($text) / 2), 160, 'Supplier,');
    // $pdf->Text(20 - ($pdf->GetStringWidth($text) / 2), 190, '(____________________)');
    // $pdf->Text(125 - ($pdf->GetStringWidth($text) / 2), 160, 'Disetujui Oleh,');
    // $pdf->Text(125 - ($pdf->GetStringWidth($text) / 2), 190, '(____________________)');

    $pdf->Output(); 
}else{
    header('Location:index.php');
}
?>