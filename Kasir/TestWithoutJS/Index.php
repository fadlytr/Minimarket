<?php
include 'connection.php';
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KASIR MM1</title>
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

  <!-- FORM Request Barang -->
  <!-- Gapake tag <form> supaya work haha -->
  <!-- ID MINIMARKET<input type="text" name="id_minimarket" id="id_minimarket" /></br> -->
  ID BARANG
  <!--<input type="text" name="id_barang" id="id_barang"/></br>-->
  <select id="id_barang">
    <?php
    $result = mysqli_query($conn, "SELECT id_barang FROM barang");
    $total = mysqli_num_rows($result);

    while ($data = mysqli_fetch_array($result)) {
    ?>
      <option name="<?= $data['id_barang']; ?>"><?= $data['id_barang']; ?></option>
    <?php } ?>
  </select></br>
  JUMLAH BARANG<input type="number" name="jml_barang" id="jml_barang" /></br>
  <button onclick="request()">Request Barang</button>

  <!-- Script Tambah Request -->
  <script>
    function request() {
      console.log("Request Barang Clicked!");
      // GET VALUE DARI FORM
      var val_id_barang = "MM1";
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
      // getRequests() < !--ini ilangin di minimarket-- >
    }
  </script>


  <!-- Table Request -->
  <table id="requestData" border="1">
  </table>
  <script>
    function getRequests() {
      var db = firebase.firestore();
      var output = "<tr><td>ID REQUEST</td><td>ID BARANG</td><td>ID MINIMARKET</td><td>JUMLAH BARANG</td><td>JADWAL PENGIRIMAN</td><tr>";
      db.collection("requests").orderBy("timestamp", "desc").get().then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
          console.log(doc.id, " => ", doc.data());
          var req_data = doc.data();
          var id_request = doc.id;
          console.log(id_request);
          output = output + "<tr><td>" + id_request + "</td><td>" + req_data["id_barang"] + "</td><td>" + req_data["id_minimarket"] + "</td><td>" + req_data["jml_barang"] + "</td><td><input id='" + id_request + "'type='date' value='" + req_data["jadwal_kirim"] + "'/><button onclick='updateJadwal(\"" + id_request + "\",\"" + doc.id + "\")'>Update Jadwal</button></td></tr>";
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
</script>

</html>