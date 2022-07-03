<center>
<?php

$url = $_SERVER['REQUEST_URI'];  
header("Refresh: 300; URL=$url");  
//echo "Halaman ini akan direfresh setiap 15 detik</br>";
echo '<font size=15 color=Blue>Penambangan Sinyal Harian INDODAX</font></br></br></br>';

// Create database connection using config file
include_once("koneksi.php");
 
// Fetch all users data from database
// $result = mysqli_query($mysqli, "SELECT * FROM btc order by id desc");

?>
</center>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pengumpulan data BTC</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">  
    <!--DataTables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/scroller/2.0.6/css/scroller.dataTables.min.css" />
    <!--Daterangepicker -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css" /> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css" /> -->
    <!-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" /> -->
    
</head>
<body>
<div class="container">
    <!--Panel Form pencarian -->
    <div class="row">
    <div class="col-md">
        <div class="panel panel-default">
        <div class="panel-heading"><b>Search</b></div>
        <div class="panel-body">
            <form class="form-inline" >
            <div class="form-group">
                <select class="form-control form-select" id="select" name="select" required="">
                <?php
                    $kolom=(isset($_GET['Kolom']))? $_GET['Kolom'] : "";
                ?>
                <option selected>Open this select menu</option>
                <option value="sinyal" <?php if ($kolom=="sinyal") echo "selected"; ?>>Sinyal</option>
                <option value="level" <?php if ($kolom=="level") echo "selected";?>>Level</option>
                <option value="hargaidr" <?php if ($kolom=="hargaidr") echo "selected";?>>Harga IDR</option>
                <option value="hargausdt" <?php if ($kolom=="hargausdt") echo "selected";?>>Harga USDT</option>
                <option value="volidr" <?php if ($kolom=="volidr") echo "selected";?>>Volume IDR</option>
                <option value="volusdt" <?php if ($kolom=="volusdt") echo "selected";?>>Volume USDT</option>
                <option value="lastbuy" <?php if ($kolom=="lastbuy") echo "selected";?>>Last Buy</option>
                <option value="lastsell" <?php if ($kolom=="lastsell") echo "selected";?>>Last Sell</option>
                <option value="jenis" <?php if ($kolom=="jenis") echo "selected";?>>Jenis</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Kata kunci.." required="" value="<?php if (isset($_GET['KataKunci']))  echo $_GET['KataKunci']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="index.php" class="btn btn-danger">Reset</a>
            </form>
        </div>
        </div>
    </div>
    </div>
    <!-- TABLE -->
    <div class="row">
    <div class="col-md-12">
        <table id="example" class="table table-striped table-bordered display nowrap">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sinyal</th> 
                <th>Level</th> 
                <th>Tanggal dan Waktu</th>
                <th>Harga Rp.</th>
                <th>Harga USDT</th> 
                <th>Vol BTC</th> 
                <th>Vol Rp.</th>
                <th>Last Buy</th>
                <th>Last Sell</th>
                <th>Jenis</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $page = (isset($_GET['page']))? (int) $_GET['page'] : 1;
      
            $kolomCari=(isset($_GET['select']))? $_GET['select'] : "";

            $kolomKataKunci=(isset($_GET['keyword']))? $_GET['keyword'] : "";
      
            // Jumlah data per halaman
            $limit = 100;
      
            $limitStart = ($page - 1) * $limit;
            
            //kondisi jika parameter pencarian kosong
            if($kolomCari=="" && $kolomKataKunci==""){
              $result = mysqli_query($conn, "SELECT * FROM btc order by id desc LIMIT 6000");
            }else{
              //kondisi jika parameter kolom pencarian diisi
              $result = mysqli_query($conn, "SELECT * FROM btc WHERE $kolomCari LIKE '%$kolomKataKunci%' order by id desc LIMIT 6000");
            }
            
            $no = $limitStart + 1;

            while($user_data = mysqli_fetch_array($result)) {  

            $konter=$user_data['sinyal'];      

            echo "<tr>";

            $hrgidr=number_format($user_data['hargaidr']);
            $hrgusdt=number_format($user_data['hargausdt']);
            $vidr=number_format($user_data['volidr'],8,",",".");
            $vusdt=number_format($user_data['volusdt']);
            $lbuy=number_format($user_data['lastbuy']);
            $lsell=number_format($user_data['lastsell']);

            if($konter>=120)
            {
            echo "<td align=center bgcolor=#FF0000>".$user_data['id']."</td>";
            echo "<td align=center bgcolor=#FF0000>".$user_data['sinyal']."</td>";
            echo "<td align=center bgcolor=#FF0000>".$user_data['level']."</td>";
            echo "<td align=center bgcolor=#FF0000>".$user_data['tanggal']."</td>";
            echo "<td align=center bgcolor=#FF0000>".$hrgidr."</td>";
            echo "<td align=center bgcolor=#FF0000>".$hrgusdt."</td>";
            echo "<td align=center bgcolor=#FF0000>".$vidr."</td>";
            echo "<td align=center bgcolor=#FF0000>".$vusdt."</td>";
            echo "<td align=center bgcolor=#FF0000>".$lbuy."</td>";
            echo "<td align=center bgcolor=#FF0000>".$lsell."</td>";
            if ($user_data['jenis']=='crash'){
            echo "<td align=center bgcolor=red>".$user_data['jenis']."</td>";}
            elseif ($user_data['jenis']=='moon'){
            echo "<td align=center bgcolor=green>".$user_data['jenis']."</td>";}
            }  

            elseif($konter>=111)
            {
            echo "<td align=center bgcolor=#FF4500>".$user_data['id']."</td>";
            echo "<td align=center bgcolor=#FF4500>".$user_data['sinyal']."</td>";
            echo "<td align=center bgcolor=#FF4500>".$user_data['level']."</td>";
            echo "<td align=center bgcolor=#FF4500>".$user_data['tanggal']."</td>";
            echo "<td align=center bgcolor=#FF4500>".$hrgidr."</td>";
            echo "<td align=center bgcolor=#FF4500>".$hrgusdt."</td>";
            echo "<td align=center bgcolor=#FF4500>".$vidr."</td>";
            echo "<td align=center bgcolor=#FF4500>".$vusdt."</td>";
            echo "<td align=center bgcolor=#FF4500>".$lbuy."</td>";
            echo "<td align=center bgcolor=#FF4500>".$lsell."</td>";    
            if ($user_data['jenis']=='crash'){
            echo "<td align=center bgcolor=red>".$user_data['jenis']."</td>";}
            elseif ($user_data['jenis']=='moon'){
            echo "<td align=center bgcolor=green>".$user_data['jenis']."</td>";}
            }  

            elseif($konter>=101)
            {
            echo "<td align=center bgcolor=#FFA500>".$user_data['id']."</td>";
            echo "<td align=center bgcolor=#FFA500>".$user_data['sinyal']."</td>";
            echo "<td align=center bgcolor=#FFA500>".$user_data['level']."</td>";
            echo "<td align=center bgcolor=#FFA500>".$user_data['tanggal']."</td>";
            echo "<td align=center bgcolor=#FFA500>".$hrgidr."</td>";
            echo "<td align=center bgcolor=#FFA500>".$hrgusdt."</td>";
            echo "<td align=center bgcolor=#FFA500>".$vidr."</td>";
            echo "<td align=center bgcolor=#FFA500>".$vusdt."</td>";
            echo "<td align=center bgcolor=#FFA500>".$lbuy."</td>";
            echo "<td align=center bgcolor=#FFA500>".$lsell."</td>";    
            if ($user_data['jenis']=='crash'){
            echo "<td align=center bgcolor=red>".$user_data['jenis']."</td>";}
            elseif ($user_data['jenis']=='moon'){
            echo "<td align=center bgcolor=green>".$user_data['jenis']."</td>";}
            }

            elseif($konter>=91) 
            {
            echo "<td align=center bgcolor=#E52A2A>".$user_data['id']."</td>";
            echo "<td align=center bgcolor=#E52A2A>".$user_data['sinyal']."</td>";
            echo "<td align=center bgcolor=#E52A2A>".$user_data['level']."</td>";
            echo "<td align=center bgcolor=#E52A2A>".$user_data['tanggal']."</td>";
            echo "<td align=center bgcolor=#E52A2A>".$hrgidr."</td>";
            echo "<td align=center bgcolor=#E52A2A>".$hrgusdt."</td>";
            echo "<td align=center bgcolor=#E52A2A>".$vidr."</td>";
            echo "<td align=center bgcolor=#E52A2A>".$vusdt."</td>";
            echo "<td align=center bgcolor=#E52A2A>".$lbuy."</td>";
            echo "<td align=center bgcolor=#E52A2A>".$lsell."</td>";    
            if ($user_data['jenis']=='crash'){
            echo "<td align=center bgcolor=red>".$user_data['jenis']."</td>";}
            elseif ($user_data['jenis']=='moon'){
            echo "<td align=center bgcolor=green>".$user_data['jenis']."</td>";}
            }  

            elseif($konter>=81)
            {
            echo "<td align=center bgcolor=#F20082>".$user_data['id']."</td>";
            echo "<td align=center bgcolor=#F20082>".$user_data['sinyal']."</td>";
            echo "<td align=center bgcolor=#F20082>".$user_data['level']."</td>";
            echo "<td align=center bgcolor=#F20082>".$user_data['tanggal']."</td>";
            echo "<td align=center bgcolor=#F20082>".$hrgidr."</td>";
            echo "<td align=center bgcolor=#F20082>".$hrgusdt."</td>";
            echo "<td align=center bgcolor=#F20082>".$vidr."</td>";
            echo "<td align=center bgcolor=#F20082>".$vusdt."</td>";
            echo "<td align=center bgcolor=#F20082>".$lbuy."</td>";
            echo "<td align=center bgcolor=#F20082>".$lsell."</td>";    
            if ($user_data['jenis']=='crash'){
            echo "<td align=center bgcolor=red>".$user_data['jenis']."</td>";}
            elseif ($user_data['jenis']=='moon'){
            echo "<td align=center bgcolor=green>".$user_data['jenis']."</td>";}
            }  

            elseif($konter>=71)
            {
            echo "<td align=center bgcolor=#DC5C5C>".$user_data['id']."</td>";
            echo "<td align=center bgcolor=#DC5C5C>".$user_data['sinyal']."</td>";
            echo "<td align=center bgcolor=#DC5C5C>".$user_data['level']."</td>";
            echo "<td align=center bgcolor=#DC5C5C>".$user_data['tanggal']."</td>";
            echo "<td align=center bgcolor=#DC5C5C>".$hrgidr."</td>";
            echo "<td align=center bgcolor=#DC5C5C>".$hrgusdt."</td>";
            echo "<td align=center bgcolor=#DC5C5C>".$vidr."</td>";
            echo "<td align=center bgcolor=#DC5C5C>".$vusdt."</td>";
            echo "<td align=center bgcolor=#DC5C5C>".$lbuy."</td>";
            echo "<td align=center bgcolor=#DC5C5C>".$lsell."</td>";    
            if ($user_data['jenis']=='crash'){
            echo "<td align=center bgcolor=red>".$user_data['jenis']."</td>";}
            elseif ($user_data['jenis']=='moon'){
            echo "<td align=center bgcolor=green>".$user_data['jenis']."</td>";}
            }  

            elseif($konter>=61)
            {
            echo "<td align=center bgcolor=#FF69B4>".$user_data['id']."</td>";
            echo "<td align=center bgcolor=#FF69B4>".$user_data['sinyal']."</td>";
            echo "<td align=center bgcolor=#FF69B4>".$user_data['level']."</td>";
            echo "<td align=center bgcolor=#FF69B4>".$user_data['tanggal']."</td>";
            echo "<td align=center bgcolor=#FF69B4>".$hrgidr."</td>";
            echo "<td align=center bgcolor=#FF69B4>".$hrgusdt."</td>";
            echo "<td align=center bgcolor=#FF69B4>".$vidr."</td>";
            echo "<td align=center bgcolor=#FF69B4>".$vusdt."</td>";
            echo "<td align=center bgcolor=#FF69B4>".$lbuy."</td>";
            echo "<td align=center bgcolor=#FF69B4>".$lsell."</td>";    
            if ($user_data['jenis']=='crash'){
            echo "<td align=center bgcolor=red>".$user_data['jenis']."</td>";}
            elseif ($user_data['jenis']=='moon'){
            echo "<td align=center bgcolor=green>".$user_data['jenis']."</td>";}
            }

            elseif($konter>=51) 
            {
            echo "<td align=center bgcolor=#F08080>".$user_data['id']."</td>";
            echo "<td align=center bgcolor=#F08080>".$user_data['sinyal']."</td>";
            echo "<td align=center bgcolor=#F08080>".$user_data['level']."</td>";
            echo "<td align=center bgcolor=#F08080>".$user_data['tanggal']."</td>";
            echo "<td align=center bgcolor=#F08080>".$hrgidr."</td>";
            echo "<td align=center bgcolor=#F08080>".$hrgusdt."</td>";
            echo "<td align=center bgcolor=#F08080>".$vidr."</td>";
            echo "<td align=center bgcolor=#F08080>".$vusdt."</td>";
            echo "<td align=center bgcolor=#F08080>".$lbuy."</td>";
            echo "<td align=center bgcolor=#F08080>".$lsell."</td>";    
            if ($user_data['jenis']=='crash'){
            echo "<td align=center bgcolor=red>".$user_data['jenis']."</td>";}
            elseif ($user_data['jenis']=='moon'){
            echo "<td align=center bgcolor=green>".$user_data['jenis']."</td>";}
            }  

            elseif($konter>=41)
            {
            echo "<td align=center bgcolor=#FFA07A>".$user_data['id']."</td>";
            echo "<td align=center bgcolor=#FFA07A>".$user_data['sinyal']."</td>";
            echo "<td align=center bgcolor=#FFA07A>".$user_data['level']."</td>";
            echo "<td align=center bgcolor=#FFA07A>".$user_data['tanggal']."</td>";
            echo "<td align=center bgcolor=#FFA07A>".$hrgidr."</td>";
            echo "<td align=center bgcolor=#FFA07A>".$hrgusdt."</td>";
            echo "<td align=center bgcolor=#FFA07A>".$vidr."</td>";
            echo "<td align=center bgcolor=#FFA07A>".$vusdt."</td>";
            echo "<td align=center bgcolor=#FFA07A>".$lbuy."</td>";
            echo "<td align=center bgcolor=#FFA07A>".$lsell."</td>";    
            if ($user_data['jenis']=='crash'){
            echo "<td align=center bgcolor=red>".$user_data['jenis']."</td>";}
            elseif ($user_data['jenis']=='moon'){
            echo "<td align=center bgcolor=green>".$user_data['jenis']."</td>";}
            }  

            elseif($konter>=31)
            {
            echo "<td align=center bgcolor=#9370D8>".$user_data['id']."</td>";
            echo "<td align=center bgcolor=#9370D8>".$user_data['sinyal']."</td>";
            echo "<td align=center bgcolor=#9370D8>".$user_data['level']."</td>";
            echo "<td align=center bgcolor=#9370D8>".$user_data['tanggal']."</td>";
            echo "<td align=center bgcolor=#9370D8>".$hrgidr."</td>";
            echo "<td align=center bgcolor=#9370D8>".$hrgusdt."</td>";
            echo "<td align=center bgcolor=#9370D8>".$vidr."</td>";
            echo "<td align=center bgcolor=#9370D8>".$vusdt."</td>";
            echo "<td align=center bgcolor=#9370D8>".$lbuy."</td>";
            echo "<td align=center bgcolor=#9370D8>".$lsell."</td>";    
            if ($user_data['jenis']=='crash'){
            echo "<td align=center bgcolor=red>".$user_data['jenis']."</td>";}
            elseif ($user_data['jenis']=='moon'){
            echo "<td align=center bgcolor=green>".$user_data['jenis']."</td>";}
            }  

            elseif($konter>=21) 
            {
            echo "<td align=center bgcolor=#BA55D3>".$user_data['id']."</td>";
            echo "<td align=center bgcolor=#BA55D3>".$user_data['sinyal']."</td>";
            echo "<td align=center bgcolor=#BA55D3>".$user_data['level']."</td>";
            echo "<td align=center bgcolor=#BA55D3>".$user_data['tanggal']."</td>";
            echo "<td align=center bgcolor=#BA55D3>".$hrgidr."</td>";
            echo "<td align=center bgcolor=#BA55D3>".$hrgusdt."</td>";
            echo "<td align=center bgcolor=#BA55D3>".$vidr."</td>";
            echo "<td align=center bgcolor=#BA55D3>".$vusdt."</td>";
            echo "<td align=center bgcolor=#BA55D3>".$lbuy."</td>";
            echo "<td align=center bgcolor=#BA55D3>".$lsell."</td>";    
            if ($user_data['jenis']=='crash'){
            echo "<td align=center bgcolor=red>".$user_data['jenis']."</td>";}
            elseif ($user_data['jenis']=='moon'){
            echo "<td align=center bgcolor=green>".$user_data['jenis']."</td>";}
            }

            elseif($konter>=11) 
            {
            echo "<td align=center bgcolor=#66CDAA>".$user_data['id']."</td>";
            echo "<td align=center bgcolor=#66CDAA>".$user_data['sinyal']."</td>";
            echo "<td align=center bgcolor=#66CDAA>".$user_data['level']."</td>";
            echo "<td align=center bgcolor=#66CDAA>".$user_data['tanggal']."</td>";
            echo "<td align=center bgcolor=#66CDAA>".$hrgidr."</td>";
            echo "<td align=center bgcolor=#66CDAA>".$hrgusdt."</td>";
            echo "<td align=center bgcolor=#66CDAA>".$vidr."</td>";
            echo "<td align=center bgcolor=#66CDAA>".$vusdt."</td>";
            echo "<td align=center bgcolor=#66CDAA>".$lbuy."</td>";
            echo "<td align=center bgcolor=#66CDAA>".$lsell."</td>";    
            if ($user_data['jenis']=='crash'){
            echo "<td align=center bgcolor=red>".$user_data['jenis']."</td>";}
            elseif ($user_data['jenis']=='moon'){
            echo "<td align=center bgcolor=green>".$user_data['jenis']."</td>";}
            }  

            elseif($konter>=1)
            {
            echo "<td align=center bgcolor=#32CD32>".$user_data['id']."</td>";
            echo "<td align=center bgcolor=#32CD32>".$user_data['sinyal']."</td>";
            echo "<td align=center bgcolor=#32CD32>".$user_data['level']."</td>";
            echo "<td align=center bgcolor=#32CD32>".$user_data['tanggal']."</td>";
            echo "<td align=center bgcolor=#32CD32>".$hrgidr."</td>";
            echo "<td align=center bgcolor=#32CD32>".$hrgusdt."</td>";
            echo "<td align=center bgcolor=#32CD32>".$vidr."</td>";
            echo "<td align=center bgcolor=#32CD32>".$vusdt."</td>";
            echo "<td align=center bgcolor=#32CD32>".$lbuy."</td>";
            echo "<td align=center bgcolor=#32CD32>".$lsell."</td>";    
            if ($user_data['jenis']=='crash'){
            echo "<td align=center bgcolor=red>".$user_data['jenis']."</td>";}
            elseif ($user_data['jenis']=='moon'){
            echo "<td align=center bgcolor=green>".$user_data['jenis']."</td>";}
            }  

            else
            {
            echo "<td align=center bgcolor=#00FF00>".$user_data['id']."</td>";
            echo "<td align=center bgcolor=#00FF00>".$user_data['sinyal']."</td>";
            echo "<td align=center bgcolor=#00FF00>".$user_data['level']."</td>";
            echo "<td align=center bgcolor=#00FF00>".$user_data['tanggal']."</td>";
            echo "<td align=center bgcolor=#00FF00>".$hrgidr."</td>";
            echo "<td align=center bgcolor=#00FF00>".$hrgusdt."</td>";
            echo "<td align=center bgcolor=#00FF00>".$vidr."</td>";
            echo "<td align=center bgcolor=#00FF00>".$vusdt."</td>";
            echo "<td align=center bgcolor=#00FF00>".$lbuy."</td>";
            echo "<td align=center bgcolor=#00FF00>".$lsell."</td>";
            if ($user_data['jenis']=='crash'){
            echo "<td align=center bgcolor=red>".$user_data['jenis']."</td>";}
            elseif ($user_data['jenis']=='moon'){
            echo "<td align=center bgcolor=green>".$user_data['jenis']."</td>";}
            }  

                echo "</tr>";
            }
            ?>
        </tbody>
        </table>
    </div>
    </div>
</div>
<!--Jquery -->
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!--Boostrap -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<!--DataTables -->
<script src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/scroller/2.0.6/js/dataTables.scroller.min.js"></script>
<!--DateRangePicker -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script> -->
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> -->
<!-- <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
<!-- <script type="text/javascript" src="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->

<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> -->

<script type="text/javascript"> 
$(document).ready(function() {
    $('#example').DataTable({
        "lengthMenu": [10, 25, 50, 100, 1000],
        "pageLength": 25,
        "searching": true,
        "search": "Search data: ",
        scrollX: 100,
        processing: true,
    });
} );
</script>
<!-- d-M-yy h:mm tt -->
</body>
</html>