
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
  exit();
}
if (isset($_POST['idBarangBuy']) && isset($_POST['jumlahBuy'])) {
  $idBarang = mysqli_real_escape_string($con, $_POST['idBarangBuy']);
  $jumlahBarang = mysqli_real_escape_string($con, $_POST['jumlahBuy']);

  echo $idBarang;

  $getStok="SELECT stok_barang FROM barang WHERE id_barang = '$idBarang'";
  $stokNow = mysqli_query($con,$getStok);
  $stokNow = $stokNow - $jumlahBarang;
  $updateStok = "UPDATE barang SET stok_barang = $stokNow WHERE id_barang = '$idBarang'";
  mysqli_query($con,$updateStok);

  echo $stokNow;
  mysqli_close($con);
}else{
  echo "<p>dunno</p>";
}
?>
</body>
</html> 