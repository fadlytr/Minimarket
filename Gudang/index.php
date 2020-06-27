<html>
<head></head>
<body>
	<h1>Helo</h1>
	 <button onclick="addData()">Add Data</button> 
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
  
function addData() {
	console.log("Add Data Clicked!");
	var db = firebase.firestore();
	db.collection("users").add({
	first: "Ada",
	last: "Lovelace",
	born: 1815
	})
	.then(function(docRef) {
		console.log("Document written with ID: ", docRef.id);
	})
	.catch(function(error) {
		console.error("Error adding document: ", error);
	});
}
</script>
</html>