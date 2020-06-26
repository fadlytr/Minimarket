<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KASIR</title>
    <script>
        function buyProduct(idBarangBuy, jumlahBuy){
            if (idBarangBuy == "") {
                document.getElementById("buyNotif").innerHTML = "masukkan id barang!!";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("buyNotif").innerHTML = this.responseText;
                }
            };
                xmlhttp.open("GET","BuyTry.php?q="+idBarangBuy+jumlahBuy,true);
                xmlhttp.send();
            }
        }
    </script>
</head>
<body>
    <h2>Kasir</h2>
    <form>
        <label for="idBarangBuy">Id Barang:</label><br>
        <input type="text" id="idBarangBuy" name="idBarangBuy"><br>
        <label for="jumlahBuy">Jumlah:</label><br>
        <input type="number" id="jumlahBuy" name="jumlahBuy"><br><br>
        <input type="submit" name="Buy" value="Buy" onclick="buyProduct(document.getElementById('idBarangBuy').value,document.getElementById('jumlahBuy').value)">
    </form> 

    <br>
    <div id="buyNotif"><b></b></div> <br>
    <br>

    <form method="POST">
        <label for="idBarangReq">Id Barang request:</label><br>
        <input type="text" id="idBarangReq" name="idBarangReq"><br>
        <label for="jumlahReq">Jumlah Request:</label><br>
        <input type="number" id="jumlahReq" name="jumlahReq"><br><br>
        <input type="submit" name="Request" value="Request">
    </form> 
</body>
</html>