<html>
<head></head>
<body onload="getRequests()">
	<h1>Helo</h1>
	<!-- FORM Request Barang -->
	<!-- Gapake tag <form> supaya work haha -->
	ID BARANG<input type="text" name="id_barang" id="id_barang"/></br>
	JUMLAH BARANG<input type="number" name="jml_barang" id="jml_barang"/></br>
	<button onclick="request()">Request Barang</button>
	<script>
	function request(){
		console.log("Request Barang Clicked!");
		// GET VALUE DARI FORM
		var val_id_barang = document.getElementById('id_barang').value;
		var val_jml_barang = document.getElementById('jml_barang').value;
		var val_id_request = "R1" + val_id_barang
		
		// TAMBAH DATA KE FIREBASE
		var db = firebase.firestore();
		db.collection("requests").add({
		id_request: val_id_barang,
		id_barang: "R"+val_id_barang,
		jml_barang: Number(val_jml_barang)
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
		var output = "<tr><td>ID REQUEST</td><td>ID BARANG</td><td>JUMLAH BARANG</td><tr>";
		db.collection("requests").get().then(function(querySnapshot) {
			querySnapshot.forEach(function(doc) {
				console.log(doc.id, " => ", doc.data());
				var req_data = doc.data();
				output = output + "<tr><td>"+req_data["id_request"]+"</td><td>"+req_data["id_barang"]+"</td><td>"+req_data["jml_barang"]+"</td></tr>"
			});
			document.getElementById("requestData").innerHTML = output;
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