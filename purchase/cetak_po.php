<?php 
require_once('../php/modular/koneksi.php');
require_once('../php/modular/otentifikasi.php');
require('../php/modular/html_table.php');

if(isset($_GET['key']) AND $_GET['method'] == 'nomor_po'){
    $num_po = urldecode($_GET['key']);

    $qPO = "SELECT transaksi_pembelian.id_pembelian, transaksi_pembelian_detail.id_pembelian, transaksi_pembelian_detail.barcode_barang, transaksi_pembelian_detail.jml_beli, transaksi_pembelian_detail.harga_sub_total, barang.nama_barang, barang.harga_beli, supplier.nama_supplier, supplier.no_telp, supplier.alamat FROM transaksi_pembelian JOIN transaksi_pembelian_detail ON transaksi_pembelian.id_pembelian = transaksi_pembelian_detail.id_pembelian JOIN barang ON transaksi_pembelian_detail.barcode_barang = barang.barcode_barang JOIN supplier ON barang.id_supplier = supplier.id_supplier WHERE transaksi_pembelian.id_pembelian = '" . $num_po . "'";
    // echo $qPO; die();
    $result_po = $db->prepare($qPO);
    $result_po->execute();

    $result_po_detail = $db->prepare($qPO);
    $result_po_detail->execute();

    $hasil_satuan=$result_po->fetch();
    $pdf=new PDF();
    $pdf->AddPage('P','A4');
    // HEADER
    $pdf->Image($url_web.'/images/logo-dark-mini.png',18,13,20);
    $pdf->SetFont('Arial','B',10); 
    $kop = "BM Mart";
    $kop_2 = "Jl. Lodan Raya No. 2, Ancol - Jakarta Utara";
    $kop_3 = "Purchase Order " . $num_po;
    $pdf->Text(100 - ($pdf->GetStringWidth($text) / 2), 15, $kop);
    $pdf->Text(70 - ($pdf->GetStringWidth($text) / 2), 20, $kop_2);
    $pdf->Text(80 - ($pdf->GetStringWidth($text) / 2), 25, $kop_3);
    
    $pdf->SetFont('Arial','',10); 
    $pdf->Text(20 - ($pdf->GetStringWidth($text) / 2), 50, 'Yth.');
    $pdf->Text(20 - ($pdf->GetStringWidth($text) / 2), 55, $hasil_satuan['nama_supplier']);
    $pdf->Text(20 - ($pdf->GetStringWidth($text) / 2), 60, $hasil_satuan['alamat']);
    $pdf->Text(20 - ($pdf->GetStringWidth($text) / 2), 65, $hasil_satuan['no_telp']);
    $pdf->Text(20 - ($pdf->GetStringWidth($text) / 2), 75, 'Berdasarkan penawaran yang Anda buat, maka dengan ini kami hendak memesan barang kepada saudara');
    $pdf->Text(20 - ($pdf->GetStringWidth($text) / 2), 80, 'dengan rincian sebagai berikut :');

    // BODY
    $pdf->SetFont('Arial','B',6); 
    $htmlTable="<TABLE BORDER='1px' cellspacing='0' cellpadding='0'>";
    $htmlTable.="<TR>";
    $htmlTable.="<TD width='75' bgcolor='#D0D0FF'>No.</TD>";
    $htmlTable.="<TD width='250' bgcolor='#D0D0FF'>Nama Barang</TD>";
    $htmlTable.="<TD width='80' bgcolor='#D0D0FF'>Barcode</TD>";
    $htmlTable.="<TD width='50' bgcolor='#D0D0FF'>Jumlah</TD>";
    $htmlTable.="<TD width='75' bgcolor='#D0D0FF'>Harga Satuan</TD>";
    $htmlTable.="<TD width='75' bgcolor='#D0D0FF'>Harga Sub Total</TD>";
    $htmlTable.="</TR>";
    for($i=0;$row = $result_po_detail->fetch();$i++){
        $htmlTable.="<TR>";
        $htmlTable.="<TD width='75'>".($i+1)."</TD>";
        $htmlTable.="<TD width='250'>".$row['nama_barang']."</TD>";
        $htmlTable.="<TD width='80'>".$row['barcode_barang']."</TD>";
        $htmlTable.="<TD width='50'>".$row['jml_beli']."</TD>";
        $htmlTable.="<TD width='75'>".str_replace(',', '.', number_format($row['harga_beli']))."</TD>";
        $htmlTable.="<TD width='75'>".str_replace(',', '.', number_format($row['harga_sub_total']))."</TD>";
        $htmlTable.="</TR>";
        $grandtotal += (int) $row['harga_sub_total'];
    }
    $htmlTable.="</TABLE>";
    $pdf->WriteHTML("<br><br><br><br><hr><br><br><br><br><br><br><br><br><br><br><br>$htmlTable");

    $pdf->Text(125 - ($pdf->GetStringWidth($text) / 2), 125, 'Grand Total : ');
    $pdf->Text(144 - ($pdf->GetStringWidth($text) / 2), 125, str_replace(',', '.', number_format($grandtotal)));

    $pdf->SetFont('Arial','',10); 
    $pdf->Text(20 - ($pdf->GetStringWidth($text) / 2), 160, 'Supplier,');
    $pdf->Text(20 - ($pdf->GetStringWidth($text) / 2), 190, '(____________________)');
    $pdf->Text(125 - ($pdf->GetStringWidth($text) / 2), 160, 'Disetujui Oleh,');
    $pdf->Text(125 - ($pdf->GetStringWidth($text) / 2), 190, '(____________________)');

    $pdf->Output(); 
}else{
    header('Location:list_po.php');
}
?>