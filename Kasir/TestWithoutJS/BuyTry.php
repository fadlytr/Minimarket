<!DOCTYPE html>
<html>
<head>
<style>

</style>
</head>
<body>

<?php

$con = mysqli_connect('localhost','root','','minimarket');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

if (isset($_POST['idBarangBuy']) && isset($_POST['jumlahBuy'])) {
  $idBarang = mysqli_real_escape_string($con, $_POST['idBarangBuy']);
  $jumlahBarang = $_POST['jumlahBuy'];

  echo $jumlahBarang;

  $getStok="SELECT stok_barang FROM barang WHERE id_barang = '$idBarang'";
  $result = mysqli_query($con,$getStok);
  $stokNow = mysqli_fetch_assoc($result);
  echo $stokNow['stok_barang'];
  $jumlahBarang = $stokNow['stok_barang'] - $jumlahBarang;
  $updateStok = "UPDATE barang SET stok_barang = $jumlahBarang WHERE id_barang = '$idBarang'";
  mysqli_query($con,$updateStok);

  echo $jumlahBarang;
  mysqli_close($con);
}else{
  echo "<p>dunno</p>";
}
?>
</body>
</html> 