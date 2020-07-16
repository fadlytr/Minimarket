<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KASIR</title>
</head>
<body>
    <h2>Kasir</h2>
    <form method="POST" action="Buy.php">
        <label>Id Barang:</label><br>
        <input type="text" id="idBarangBuy" name="idBarangBuy"><br>
        <label>Jumlah:</label><br>
        <input type="number" id="jumlahBuy" name="jumlahBuy"><br><br>
        <input type="submit" name="Buy" value="Beli">
    </form> 

    <br><br>

    <!-- Request Barang -->
    <form method="POST">
        <label for="idBarangReq">Id Barang request:</label><br>
        <input type="text" id="idBarangReq" name="idBarangReq"><br>
        <label for="jumlahReq">Jumlah Request:</label><br>
        <input type="number" id="jumlahReq" name="jumlahReq"><br><br>
        <input type="submit" value="Request">
    </form>


    <!-- Table Request -->
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
   <!-- End Table Request  -->

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
}
</script>
</html>