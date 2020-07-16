<?php
include 'connection.php';
?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KASIR MM1</title>
</head>

<body onload="getRequests()">
  <h2>Kasir MM1</h2>
  <form method="POST" action="Buy.php">
    <label>Id Barang:</label><br>
    <input type="text" id="idBarangBuy" name="idBarangBuy"><br>
    <label>Jumlah:</label><br>
    <input type="number" id="jumlahBuy" name="jumlahBuy"><br><br>
    <input type="submit" name="Buy" value="Beli">
  </form>

  <table id="table_barang" border="1">
    <tr>
      <td>ID BARANG</td>
      <td>ID MINIMARKET</td>
      <td>JUMLAH BARANG</td>
      <td>JADWAL PENERIMAAN</td>
    <tr>
  </table>

  <!-- FORM Request Barang -->
  <div id="form_request" style="margin-top:20px">
    <b style="font-size: x-large;">Form Request</b><br>
    <!-- ID MINIMARKET<input type="text" name="id_minimarket" id="id_minimarket" /></br> -->
    <label style="padding-right: 38px;">Id Barang</label>
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
    <label style="padding-right: 10px;">Jumlah Barang</label><input type="number" name="jml_barang" id="jml_barang" /></br>
    <button onclick="request()" style="margin-bottom: 10px;margin-left: 105px;">Request Barang</button>

    <!-- Script Tambah Request -->
    <script>
      function request() {
        console.log("Request Barang Clicked!");
        // GET VALUE DARI FORM
        var val_id_barang = document.getElementById('id_barang').value;;
        var val_jml_barang = document.getElementById('jml_barang').value;
        var val_id_minimarket = "MM1";

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
        var output = "<tr><td>ID REQUEST</td><td>ID BARANG</td><td>JUMLAH BARANG</td><td>JADWAL PENERIMAAN</td><tr>";
        db.collection("requests").where("id_minimarket", "==", "MM1").orderBy("timestamp", "desc").get().then(function(querySnapshot) {
          querySnapshot.forEach(function(doc) {
            console.log(doc.id, " => ", doc.data());
            var req_data = doc.data();
            var id_request = doc.id;
            console.log(id_request);
            if (req_data["isReceived"] == false || req_data["isReceived"] == undefined) {
              output = output + "<tr><td>" + id_request + "</td><td>" + req_data["id_barang"] + "</td><td>" + req_data["jml_barang"] + "</td><td>" + req_data["jadwal_kirim"] + "<button id ='" + id_request + "' onclick='received(\"" + id_request + "\",\"" + doc.id + "\")'>Received</button></td></tr>";
            }
          });
          document.getElementById("requestData").innerHTML = output;
        });
      }
    </script>
    <!-- End Table Request  -->

    <!-- Update Jadwal -->
    <script>
      function received(id_request, doc_id) {
        var db = firebase.firestore();
        var tanggal = document.getElementById(id_request).value;
        var val_timestamp = firebase.firestore.Timestamp.now();
        var washingtonRef = db.collection("requests").doc(doc_id);

        // Set the "capital" field of the city 'DC'
        washingtonRef.get().then(function(doc) {
          req_data = doc.data();
          if (req_data["isReceived"] != undefined && req_data["isReceived"] == false && req_data["jadwal_kirim"] != undefined) {
            return washingtonRef.update({
                isReceived: true,
                timestamp: val_timestamp
              })
              .then(function() {
                console.log("Document successfully updated!");
                alert("Barang Diterima!")
              })
              .catch(function(error) {
                // The document probably doesn't exist.
                console.error("Error updating document: ", error);
                alert("Barang gagal diterima")
                getRequests();
              });
          } else {
            return washingtonRef.update({
                isReceived: false,
                timestamp: val_timestamp
              })
              .then(function() {
                console.log("Document successfully updated!");
                alert("Barang Belum Dikirim!")
              })
              .catch(function(error) {
                // The document probably doesn't exist.
                console.error("Error updating document: ", error);
                alert("Barang gagal diterima")
                getRequests();
              });
          }
        });
      }
    </script>
  </div>

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