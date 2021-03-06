<?php
include 'connection.php';
if (isset($_POST['addItem'])) {
  $id_barang = $_POST['idBarangBuy'];
  $qty = $_POST['jumlahBuy'];
  $status = 'new_trx';
  $datenow = date("Y-m-d H:i:s");

  // Liat apakah transaksi lama udah dibayar atau belum kalau udah bikin transaksi baru 
  $trx = $conn->query("SELECT COUNT(*) FROM transaksi WHERE status = 'new_trx' AND jenis_trx = 1 ")->fetch_row();
  if ($trx[0] == 0) {
    $new_trx = mysqli_query($conn, "INSERT INTO transaksi (jenis_trx,tgl_trx,status) VALUES('1', '$datenow', '$status')");
  }

  // Ambil id_trx terakhir yang statusnya belum dibayar
  $id_trx = $conn->query("SELECT id_trx FROM transaksi WHERE status = '$status' AND jenis_trx = 1 ")->fetch_object()->id_trx;

  // Masukin ke cart
  $query = mysqli_query($conn, "INSERT INTO detail_transaksi VALUES('$id_trx','$id_barang', '$qty')");

  if ($query) {
    echo '<script language="javascript">alert("Berhasil disimpan ke keranjang"); document.location="index.php";</script>';
  } else {
    echo '<script language="javascript">alert("Tidak berhasil disimpan ke keranjang"); document.location="index.php";</script>';
  }
}
?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KASIR MM1</title>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>

<body onload="getRequests()">
  <b style="font-size: x-large;">Kasir MM1</b><br>
  <!-- Form addItem -->
  <div id="addItem" style="margin-top: 5px;">
    <form method="POST" action="index.php">
      <label style="padding-right: 38px;">Id Barang</label>
      <select id="idBarangBuy" name="idBarangBuy">
        <?php
        $result = mysqli_query($conn, "SELECT id_barang FROM barang");
        $total = mysqli_num_rows($result);

        while ($data = mysqli_fetch_array($result)) {
        ?>
          <option name="<?= $data['id_barang']; ?>"><?= $data['id_barang']; ?></option>
        <?php } ?>
      </select></br>

      <label style="padding-right: 10px;">Jumlah Barang</label><input type="number" name="jumlahBuy" id="jumlahBuy" /></br>
      <input type="submit" name="addItem" value="add Item">
    </form>
  </div>
  <!-- End Form addItem -->

  <!-- Cart and buy -->
  <table class="tableCart" border="1">
    <tr>
      <td>
        Nama item
      </td>
      <td>
        Harga satuan
      </td>
      <td>
        qty
      </td>
      <td>
        Harga
      </td>
    </tr>
    <?php
    $id_trx = $conn->query("SELECT id_trx FROM transaksi WHERE status = 'new_trx' AND jenis_trx='1'")->fetch_object()->id_trx;

    $total_harga = 0;
    if ($id_trx != null) {
      $sql = "SELECT a.*, b.* , SUM(a.jml_barang) as total 
						from detail_transaksi a JOIN barang b 
						ON a.id_barang = b.id_barang AND a.id_trx = $id_trx 
						GROUP BY a.id_barang";
      $result  = mysqli_query($conn, $sql);

      while ($data = mysqli_fetch_array($result)) {
    ?>
        <tr>
          <td class="col-md-6">
            <?= $data['nama_barang']; ?>
          </td>
          <td>
            <p class="price">Rp <?= $data['harga_barang']; ?></p>
          </td>
          <td>
            <?php
            echo  $data['total'];
            $total_per_item = $data['total'] * $data['harga_barang'];
            $total_harga += $total_per_item;
            ?>
          </td>
          <td>
            <?php
            echo "<p>Rp " . $total_per_item . "</p>";
            ?>
          </td>
        </tr>
    <?php
      }
    } else {
      echo '<p>Cart is empty</p>';
    }
    ?>
  </table>
  <form action="bayar.php" method="post">
    <label style="padding-right: 38px;">Ringkasan Belanja</label><br>
    <b style="margin-right: 20px;">Total Harga</b> Rp <?= $total_harga; ?>
    <input type="hidden" name="id_trx" value="<?= $id_trx; ?>">
    <input type="submit" name="bayar" value="Bayar Sekarang">
  </form>
  <!-- End Cart and Buy -->

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
    <label style="padding-right: 10px;">Jumlah Barang</label><input type="number" min="1" name="jml_barang" id="jml_barang" /></br>
    <button onclick="request()" style="margin-bottom: 10px;margin-left: 105px;">Request Barang</button>

    <!-- Script Tambah Request -->
    <script>
      function request() {
        console.log("Request Barang Clicked!");
        // GET VALUE DARI FORM
        var val_id_barang = document.getElementById('id_barang').value;
        var val_jml_barang = document.getElementById('jml_barang').value;
        var val_id_minimarket = "MM1";

        // TAMBAH DATA KE FIREBASE
        var db = firebase.firestore();
        var val_timestamp = firebase.firestore.Timestamp.now();
        db.collection("requests").add({
            id_barang: val_id_barang,
            id_minimarket: val_id_minimarket,
            jml_barang: Number(val_jml_barang),
            timestamp: val_timestamp,
            isReceived: false
          })
          .then(function(docRef) {
            console.log("Document written with ID: ", docRef.id);
          })
          .catch(function(error) {
            console.error("Error adding document: ", error);
          });
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
              output = output + "<tr><td>" + id_request + "</td><td>" + req_data["id_barang"] + "</td><td>" + req_data["jml_barang"] + "</td><td>" + req_data["jadwal_kirim"] + "<button id ='" + id_request + "' onclick='received(\"" + id_request + "\",\"" + doc.id + "\",\"" + req_data["id_barang"] + "\",\"" + req_data["jml_barang"] + "\")'>Receive</button></td></tr>";
            }
          });
          document.getElementById("requestData").innerHTML = output;
        });
      }
    </script>
    <!-- End Table Request  -->

    <!-- Update receive -->
    <script>
      function received(id_request, doc_id, val_id_barang, val_new_stok) {
        var db = firebase.firestore();
        var val_timestamp = firebase.firestore.Timestamp.now();
        var washingtonRef = db.collection("requests").doc(doc_id);

        // Set the "capital" field of the city 'DC'
        washingtonRef.get().then(function(doc) {
          req_data = doc.data();
          if (req_data["isReceived"] == false && req_data["jadwal_kirim"] != undefined) {
            return washingtonRef.update({
                isReceived: true,
                timestamp: val_timestamp
              })
              .then(function() {
                console.log("Document successfully updated!");
                alert("Barang Diterima!")
                /* Update Stok di mysql */
                $.ajax({
                  type: "POST", //type of method
                  url: "update_stok.php", //your page
                  data: {
                    id_barang: val_id_barang,
                    new_stok: val_new_stok
                  }, // passing the values
                  success: function(res) {
                    alert(res); //do what you want here...
                  }
                });
              })
              .catch(function(error) {
                // The document probably doesn't exist.
                console.error("Error updating document: ", error);
                alert("Barang gagal diterima")
                getRequests();
              });
            getRequests();
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
            getRequests();
          }
        });
      }
    </script>
    <!-- End Update Receive -->
  </div>
<!-- End Form Request -->

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