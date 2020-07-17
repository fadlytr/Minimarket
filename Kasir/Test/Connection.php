<?php
  // buat koneksi dengan database mysql
  $dbhost = "www.wisata-lembang.com";
  $dbuser = "u8128384";
  $dbpass = "ca6rHxbjt#";
  $dbname = "u8128384_minimarket";
  $conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
  
  //periksa koneksi, tampilkan pesan kesalahan jika gagal
  if(!$conn){
    die ("Koneksi dengan database gagal: ".mysqli_connect_errno().
         " - ".mysqli_connect_error());
  }
?>