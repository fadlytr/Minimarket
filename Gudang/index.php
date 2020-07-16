<?php
include 'connection.php';
?>
<html>
<head>
	<title>Gudang</title>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body onload="getRequests()">
	<h1>Helo</h1>
	
	<!-- TODO
	- nambah field tanggal sama id minimarket di table request
	- update stock di gudang
	-->
	
	<!-- FORM Request Barang -->
	<!-- Gapake tag <form> supaya work haha -->
	ID MINIMARKET<input type="text" name="id_minimarket" id="id_minimarket"/></br>
	ID BARANG<!--<input type="text" name="id_barang" id="id_barang"/></br>-->
	<select id="id_barang">
		<?php	
		$result = mysqli_query($conn, "SELECT id_barang FROM barang");
		$total = mysqli_num_rows($result);
			  
		while($data = mysqli_fetch_array($result)){ 
		?>
		<option name="<?= $data['id_barang'];?>"><?= $data['id_barang'];?></option>
		<?php } ?>
	</select></br>
	JUMLAH BARANG<input type="number" name="jml_barang" id="jml_barang"/></br>
	<button onclick="request()">Request Barang</button>
	<script>
	function request(){
		console.log("Request Barang Clicked!");
		// GET VALUE DARI FORM
		var val_id_barang = document.getElementById('id_barang').value;
		var val_jml_barang = document.getElementById('jml_barang').value;
		var val_id_minimarket = document.getElementById('id_minimarket').value;
		
		// TAMBAH DATA KE FIREBASE
		var db = firebase.firestore();
		var val_timestamp = firebase.firestore.Timestamp.now();
		db.collection("requests").add({
		id_barang: val_id_barang,
		id_minimarket: val_id_minimarket,
		jml_barang: Number(val_jml_barang),
		timestamp: val_timestamp
		})
		.then(function(docRef) {
			console.log("Document written with ID: ", docRef.id);
		})
		.catch(function(error) {
			console.error("Error adding document: ", error);
		});
		
		//TAMPILKAN DATA
		getRequests()
	}
	</script>
	
	<!-- Show data request -->
	<table id="requestData" border="1">
	</table>
	<script>
	function getRequests(){	
		var db = firebase.firestore();
		var output = "<tr><td>ID REQUEST</td><td>ID BARANG</td><td>ID MINIMARKET</td><td>JUMLAH BARANG</td><td>JADWAL PENGIRIMAN</td><tr>";
		db.collection("requests").orderBy("timestamp","desc").get().then(function(querySnapshot) {
			querySnapshot.forEach(function(doc) {
				console.log(doc.id, " => ", doc.data());
				var req_data = doc.data();
				var id_request = doc.id;
				console.log(id_request);
				output = output + "<tr><td>"+id_request+"</td><td>"+req_data["id_barang"]+"</td><td>"+req_data["id_minimarket"]+"</td><td>"+req_data["jml_barang"]+"</td><td><input id='"+id_request+"'type='date' value='"+req_data["jadwal_kirim"]+"'/><button onclick='updateJadwal(\""+id_request+"\",\""+doc.id+"\")'>Update Jadwal</button></td></tr>";
			});
			document.getElementById("requestData").innerHTML = output;
		});
	}
	</script>
	<script>
	function updateJadwal(id_request,doc_id){
		var db = firebase.firestore();
		var tanggal = document.getElementById(id_request).value;
		
		var washingtonRef = db.collection("requests").doc(doc_id);

		// Set the "capital" field of the city 'DC'
		return washingtonRef.update({
			jadwal_kirim: tanggal
		})
		.then(function() {
			console.log("Document successfully updated!");
			alert("Jadwal Kirim Berhasil Diperbarui")
		})
		.catch(function(error) {
			// The document probably doesn't exist.
			console.error("Error updating document: ", error);
			alert("Jadwal Kirim Gagal Diperbarui")
			getRequests();
		});
	}
	</script>
	
	<table border="1">
	<tr><td>ID BARANG</td><td>NAMA BARANG</td><td>IMAGE</td><td>STOK</td></tr>
	<?php	
		$result = mysqli_query($conn, "SELECT * FROM barang");
		$total = mysqli_num_rows($result);
			  
		while($data = mysqli_fetch_array($result)){ 
		?>
		
		<tr>
			<td><?= $data['id_barang'];?></td>
			<td><?= $data['nama_barang'];?></td>
			<td><img width="100" src="<?= $data['img'];?>"/></td>
			<td><input id="<?= $data['id_barang'];?>" type="number" value="<?= $data['stok_barang'];?>"/><button onclick="updateStok('<?= $data['id_barang'];?>')">Update Stok</button></td>
		</tr>
		
	<?php } ?>
	</table>
	<script type="text/javascript">
	function updateStok(val_id_barang){
		var val_new_stok = document.getElementById(val_id_barang).value;
	
		$.ajax({
            type : "POST",  //type of method
            url  : "update_stok.php",  //your page
            data : { id_barang: val_id_barang, new_stok: val_new_stok},// passing the values
            success: function(res){
				alert(res);          //do what you want here...
            }
        });
	}
	
	</script>
</body>

<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-app.js"></script>

<!-- Firestore -->
<script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-firestore.js"></script>

<script src="https://www.gstatic.com/firebasejs/7.15.5/firebase-analytics.js"></script>

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyDGI9VjRtkXmEHXSFIMyVvyJlhmtGCLGqI",
    authDomain: "minimarket-c18b4.firebaseapp.com",
    databaseURL: "https://minimarket-c18b4.firebaseio.com",
    projectId: "minimarket-c18b4",
    storageBucket: "minimarket-c18b4.appspot.com",
    messagingSenderId: "1009663674856",
    appId: "1:1009663674856:web:ebd523eaf2fa040d61bc5d",
    measurementId: "G-CDB0TYJRJQ"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
</script>
</html>