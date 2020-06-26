<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KASIR</title>
</head>
<body>
    <h2>Kasir</h2>
    <form method="POST">
        <label for="idBarangBuy">Id Barang:</label><br>
        <input type="text" id="idBarangBuy" name="idBarangBuy"><br>
        <label for="jumlahBuy">Jumlah:</label><br>
        <input type="number" id="jumlahBuy" name="jumlahBuy"><br><br>
        <input type="submit" value="Buy">
    </form> 

    <br><br>

    <form method="POST">
        <label for="idBarangReq">Id Barang request:</label><br>
        <input type="text" id="idBarangReq" name="idBarangReq"><br>
        <label for="jumlahReq">Jumlah Request:</label><br>
        <input type="number" id="jumlahReq" name="jumlahReq"><br><br>
        <input type="submit" value="Request">
    </form> 
</body>
</html>