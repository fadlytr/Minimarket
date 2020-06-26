
<!DOCTYPE html>
<html>
<head>
<style>

</style>
</head>
<body>

<?php
$q = intval($_GET['q']);
$qlen = strlen($q);
$idBarang = substr($q, 0, 6);
$jumlahBarang = substr($q, 7, $qlen);

echo $idBarang;

$con = mysqli_connect('localhost','root','','minimarket');
if (!$con) {
  die('Could not connect: ' . mysqli_error($con));
}

// mysqli_select_db($con,"minimarket");
$getStok="SELECT stok_barang FROM barang WHERE id_barang = '".$idBarang."'";
$stokNow = mysqli_query($con,$getStok);
$stokNow = $stokNow - $jumlahBarang;
$updateStok = "UPDATE barang SET stok_barang = $stokNow WHERE id_barang = '".$idBarang."'";
mysqli_query($con,$updateStok);

echo $stokNow;
// echo "<table>
// <tr>
// <th>Firstname</th>
// <th>Lastname</th>
// <th>Age</th>
// <th>Hometown</th>
// <th>Job</th>
// </tr>";
// while($row = mysqli_fetch_array($result)) {
//   echo "<tr>";
//   echo "<td>" . $row['FirstName'] . "</td>";
//   echo "<td>" . $row['LastName'] . "</td>";
//   echo "<td>" . $row['Age'] . "</td>";
//   echo "<td>" . $row['Hometown'] . "</td>";
//   echo "<td>" . $row['Job'] . "</td>";
//   echo "</tr>";
// }
// echo "</table>";
mysqli_close($con);
?>
</body>
</html> 