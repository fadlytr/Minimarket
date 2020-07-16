<?php
	include 'connection.php';
	$id_barang = $_POST["id_barang"];
	$new_stok = $_POST["new_stok"];
	
	
	$sql = "UPDATE barang SET stok_barang=".$new_stok." WHERE id_barang='".$id_barang."'";

	if (mysqli_query($conn, $sql)) {
		echo "Stok Berhasil Diperbarui";
	} else {
		echo "Stok Gagal Diperbarui";
	}
?>