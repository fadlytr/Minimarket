<!-- nambahin field status di db detail_transaksi
bikin css if status cannot proceed liatin disable
 -->

<?php
	include 'connection.php';
	if(isset($_POST['bayar'])){
		$id = $_POST['id_trx'];

		if($id!=null){
		// get barang yang ada di transaksi ini (cart ini)
		$barang = $link->query("SELECT a.*, b.* , SUM(a.jml_barang) as total 
						from detail_transaksi a JOIN barang b 
						ON a.id_barang = b.id_barang AND a.id_trx = $id 
						GROUP BY a.id_barang");

		$trx = 0; //inisialisasi counter banyak item / trx
		while($data = mysqli_fetch_array($barang)){ 
			$id_barang = $data['id_barang'];
			$qty = $data['total'];

			//ngurangin stok barang	
			if($qty >= $data['stok_barang']){
				$stock_now = $data['stok_barang'] - $qty;
				$update_stock = $link->query("UPDATE barang SET stok_barang = $stock_now WHERE id_barang = '$id_barang'");
				$trx++; //counter buat tau bahwa transaksi ini jadi dilakuin 
			}
		}

		// update status pembayaran
		if($trx > 0){
			$query = $link->query("UPDATE transaksi SET status = 'bayar' WHERE id_trx = '$id'");
			if($query){
			echo '<script language="javascript">alert("Berhasil"); document.location="index.php";</script>';
			}else{
				echo '<script language="javascript">alert("Tidak Berhasil"); document.location="index.php";</script>';
			}
		}else{
			$query = $link->query("UPDATE transaksi SET status = 'cannot_proceed' WHERE id_trx = '$id'");
			if($query){
				echo '<script language="javascript">alert("Tidak dapat diproses"); document.location="index.php";</script>';
			}
		}
		}else{
			echo '<script language="javascript">alert("Your cart is empty"); </script>';
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tubes Sistem Terdistribusi</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<nav class="navbar sticky-top navbar-light bg-dark">
  		<a class="navbar-brand" href="index.php"><h4>Minimarket Sister</h4></a>
  		<a class="btn btn-warning" href="index.php"> back</a>
	</nav> 
	<div class="container">
		<div class="row  mt-5">
		<div class="col-md-8">
		<table class="table">
			<tr>
				<td><h4>Cart</h4><td>
			</tr>
			<?php  
				$id_trx = $link -> query("SELECT id_trx FROM transaksi WHERE status = 'new_trx' AND jenis_trx='2'")->fetch_object()->id_trx;

				$total_harga = 0;
				if($id_trx!=null){
				$sql = "SELECT a.*, b.* , SUM(a.jml_barang) as total 
						from detail_transaksi a JOIN barang b 
						ON a.id_barang = b.id_barang AND a.id_trx = $id_trx 
						GROUP BY a.id_barang";
				$result	= mysqli_query($link, $sql);
				
				while($data = mysqli_fetch_array($result)){  
			?>
			<tr>
				<td class="col-md-2">
					<img class="cart-img" src="<?= $data['img']; ?>">
				</td>
				<td class="col-md-6">
					<h5><?= $data['nama_barang']; ?> </h5>
					<p class="price">Rp <?= $data['harga_barang']; ?></p>
					<?php 
						if($data['stok_barang'] < $data['total']){ 
							echo '<p class = "warning_message">Jumlah : '.$data['total'].'&nbsp&nbsp&nbspStok Habis</p>';
						}
						else{
							echo '<p>Jumlah : '.$data['total'].'</p>';
							$total_per_item = $data['total'] * $data['harga_barang'];
							$total_harga += $total_per_item;
						}
					?>
				</td>
			</tr>
			<?php 
				} 
				}else{
					echo '<tr><td><p>Cart is empty</p></td></tr>';
				}


			?>
		</table>
		</div>
		<div class="col-md-4">
			<form action="cart.php" method="post">
			<div class="card">
				<div class="card-body m-2">
					<h5>Ringkasan Belanja</h5>	
					<div class="row">
						<div class="col-md-8">Total Harga</div>
						<div class="col-md-4 price">Rp <?= $total_harga; ?></div>
					</div>

				</div>
				<input type="hidden" name="id_trx" value="<?= $id_trx; ?>">
				<input type="submit" class="btn btn-warning m-3" name="bayar" value="Bayar Sekarang">
			</div>
			</form>
		</div>
	</div>
	</div>
</body>
</html>