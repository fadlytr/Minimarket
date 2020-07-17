<?php
  //buat koneksi dengan database mysql
  $dbhost = "wisata-lembang.com";
  $dbuser = "u8128384";
  $dbpass = "ca6rHxbjt#";
  $dbname = "u8128384_minimarket";
  $link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
  
  //periksa koneksi, tampilkan pesan kesalahan jika gagal
  if(!$link){
   die ("Koneksi dengan database gagal: ".mysqli_connect_errno().
         " - ".mysqli_connect_error());
   }


  // buat koneksi dengan database mysql
  // $dbhost = "localhost";
  // $dbuser = "root";
  // $dbpass = "";
  // $dbname = "minimarket";
  // $link = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
  
  // //periksa koneksi, tampilkan pesan kesalahan jika gagal
  // if(!$link){
  //   die ("Koneksi dengan database gagal: ".mysqli_connect_errno().
  //        " - ".mysqli_connect_error());
  // } 
?>  
