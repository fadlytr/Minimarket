<?php
	include 'connection.php';
	if(isset($_POST['submit'])){
		$id_barang = $_POST['id'];
		$qty = $_POST['qty'];
		$status = 'new_trx';
		$datenow = date("Y-m-d H:i:s");
		
				// Liat apakah transaksi lama udah dibayar atau belum kalau udah bikin transaksi baru 
		$trx = $link -> query("SELECT COUNT(*) FROM transaksi WHERE status = 'new_trx' AND jenis_trx = 2 ")->fetch_row();
		if($trx[0] == 0){
			$new_trx = mysqli_query($link,"INSERT INTO transaksi (jenis_trx,tgl_trx,status) VALUES('2', '$datenow', '$status')");
		}

		// Ambil id_trx terakhir yang statusnya belum dibayar
		$id_trx = $link -> query("SELECT id_trx FROM transaksi WHERE status = '$status' AND jenis_trx = 2 ")->fetch_object()->id_trx;

		// Masukin ke cart
		$query = mysqli_query($link,"INSERT INTO detail_transaksi VALUES('$id_trx','$id_barang', '$qty')");
		
		if($query) {
			echo '<script language="javascript">alert("Berhasil disimpan ke keranjang"); document.location="index.php";</script>';
		}else{
			echo '<script language="javascript">alert("Tidak berhasil disimpan ke keranjang"); document.location="index.php";</script>';
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Minimarket Sister</title>
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<nav class="navbar sticky-top navbar-light bg-dark">
  		<a class="navbar-brand" href="#"><h4>Minimarket Sister</h4></a>
  		<a class="btn btn-warning" href="cart.php"> cart</a>
	</nav> 
	<div class="container">
		<div class="row">
		<?php
			
			$result = mysqli_query($link, "SELECT * FROM barang");
			$total = mysqli_num_rows($result);
			  
			while($data = mysqli_fetch_array($result)){ 
		?>
		<div class="col-md-3 mt-4">
			<div class="card" style="width: 15rem;">
				<img class="card-img-top p-3" src="<?= $data['img']; ?>"/>
				<div class="card-body">
					<h5 class="card-title"><?= $data['nama_barang'];?></h5>
					<p class="card-subtitle price">Rp <?= $data['harga_barang'];?></p>
					<div class="mt-4">
						<form action="index.php" method="POST">
							<button class="btn btn-outline-success btn-sm">-</button>
							<input  type="number" name="qty" min="1">
							<button class="btn btn-outline-success btn-sm ">+</button>
							<input type="hidden" name="id" value="<?= $data['id_barang'];?>">
							<input type="submit" name="submit" value="Add to cart" class="btn btn-warning btn-sm ml-2">
						</form>	
					</div>	
				</div>
			</div>
		</div>
		<?php } ?>
		</div>
	</div>
</body>
</html>