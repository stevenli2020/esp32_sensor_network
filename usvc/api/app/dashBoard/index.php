<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="../CSS/style.css">
    <script src="../JS/config.js"></script>
    <script src="../../JS/echarts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/eb814e06cc.js" crossorigin="anonymous"></script>
    <title>DashBoard</title>
</head>
<body>
    
    <?php include "/var/www/html/offcanvas.php"?>
    
    <br>
    <!-- Prepare a DOM with a defined width and height for ECharts -->
    <!-- <div class="container">
        
    </div> -->
    
    <!-- <?php include "/var/www/html/dashBoard/dashBoardHeader.php"?> -->
    <?php include "/var/www/html/dashBoard/dashBoardHeaderChart.php"?>
    <?php include "/var/www/html/dashBoard/Map.php"?>
    <?php include "/var/www/html/dashBoard/Table.php"?>
    <?php include "/var/www/html/dashBoard/registerDeviceForm.php"?>
    <?php include "/var/www/html/dashBoard/registerUserForm.php"?>
    <?php include "/var/www/html/dashBoard/updateUserForm.php"?>
    
        
           
    <script src="../JS/Utils.js"></script>       
    <!-- <script src="../JS/chart/ringGuage.js"></script>        -->
    <!-- <script src="../JS/chart/pie.js"></script>        -->
    <!-- <script src="../JS/chart/dashBoardHeaderline.js"></script>        -->
    <script src="../JS/chart/CPU.js"></script>       
    <script src="../JS/chart/memory.js"></script>       
    <script src="../JS/chart/bytes.js"></script>       
    <script src="../JS/chart/events.js"></script>       
    <script src="../JS/dashBoard.js"></script>
</body>
</html>