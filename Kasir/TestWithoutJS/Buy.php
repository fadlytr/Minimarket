<?php
include 'connection.php';
if (isset($_POST['idBarangBuy']) && isset($_POST['jumlahBuy'])) {
  $idBarang = mysqli_real_escape_string($con, $_POST['idBarangBuy']);
  $jumlahBarang = $_POST['jumlahBuy'];
  
  if($idBarang != NULL && $jumlahBarang != NULL){
    // echo $idBarang;
    // echo $jumlahBarang;

    $getStok="SELECT stok_barang FROM barang WHERE id_barang = '$idBarang'";
    $result = mysqli_query($con,$getStok);
    $stokNow = mysqli_fetch_assoc($result);
    // echo $stokNow['stok_barang'];
    $jumlahBarang = $stokNow['stok_barang'] - $jumlahBarang;
    $updateStok = "UPDATE barang SET stok_barang = $jumlahBarang WHERE id_barang = '$idBarang'";
    mysqli_query($con,$updateStok);

    // echo $jumlahBarang;
    echo "Pembelian berhasil!";
    mysqli_close($con);
  }else{
    echo "Pemebelian gagal!";  
  }
}else{
  echo "Pembelian berhasil!";
}
?>
<form method="post" action="index.php">
  <input type="submit" name="Home" value="Home">
</form>