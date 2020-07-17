<?php
include 'connection.php';
if (isset($_POST['bayar'])) {
    $id = $_POST['id_trx'];
    echo $id;

    if ($id != null) {
        // get barang yang ada di transaksi ini (cart ini)
        $barang = $link->query("SELECT a.*, b.* , SUM(a.jml_barang) as total 
						from detail_transaksi a JOIN barang b 
						ON a.id_barang = b.id_barang AND a.id_trx = $id 
						GROUP BY a.id_barang");

        $trx = 0; //inisialisasi counter banyak item / trx
        while ($data = mysqli_fetch_array($barang)) {
            $id_barang = $data['id_barang'];
            $qty = $data['total'];

            //ngurangin stok barang	
            if ($qty >= $data['stok_barang']) {
                $stock_now = $data['stok_barang'] - $qty;
                $update_stock = $link->query("UPDATE barang SET stok_barang = $stock_now WHERE id_barang = '$id_barang'");
                $trx++; //counter buat tau bahwa transaksi ini jadi dilakuin 
            }
        }

        // update status pembayaran
        if ($trx > 0) {
            $query = $link->query("UPDATE transaksi SET status = 'bayar' WHERE id_trx = '$id'");
            if ($query) {
                echo '<script language="javascript">alert("Berhasil"); document.location="index.php";</script>';
            } else {
                echo '<script language="javascript">alert("Tidak Berhasil"); document.location="index.php";</script>';
            }
        } else {
            $query = $link->query("UPDATE transaksi SET status = 'cannot_proceed' WHERE id_trx = '$id'");
            if ($query) {
                echo '<script language="javascript">alert("Tidak dapat diproses"); document.location="index.php";</script>';
            }
        }
    } else {
        echo '<script language="javascript">alert("Your cart is empty"); </script>';
    }
}
?>
<form method="post" action="index.php">
  <input type="submit" name="Home" value="Home">
</form>