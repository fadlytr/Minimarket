<?php
include 'connection.php';
if (isset($_POST['idBarangBuy']) && isset($_POST['jumlahBuy'])) {
  $idBarang = $_POST['idBarangBuy'];
  $jumlahBarang = $_POST['jumlahBuy'];

  if ($idBarang != NULL && $jumlahBarang != NULL) {
    // echo $idBarang;
    // echo $jumlahBarang;

    $updateStok = "UPDATE barang SET stok_barang = stok_barang - $jumlahBarang WHERE id_barang = '$idBarang'";

    if (mysqli_query($conn, $updateStok)) {
      echo "Pembelian berhasil!";
    } else {
      echo "Pembelian gagal!";
    }
  } else {
    echo "Pembelian gagal2!";
  }
} else {
  echo "Pembelian gagal3!";
}
?>
<form method="post" action="index.php">
  <input type="submit" name="Home" value="Home">
</form>