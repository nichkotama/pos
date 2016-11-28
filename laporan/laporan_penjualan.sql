SELECT 
    a.id_transaksi_header,
    a.tgl_transaksi,
    c.nama_barang,
    b.barcode_barang,
    b.jml_barang,
    b.harga_sub_total,
    (c.harga_beli * b.jml_barang) AS harga_beli_subtotal,
    (b.harga_sub_total - (c.harga_beli * b.jml_barang)) AS margin_penjualan
FROM
    transaksi_kasir a
        JOIN
    transaksi_kasir_detail b ON a.id_transaksi_header = b.id_transaksi_header
		JOIN
	barang c ON b.barcode_barang = c.barcode_barang
GROUP BY b.id_transaksi_detail