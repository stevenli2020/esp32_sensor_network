<?php
//phpinfo()
// include "/var/www/html/dbconfig/sensor_db.php";

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Cache-control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../JS/echarts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <!--=============== REMIXICONS ===============-->
    <link rel="stylesheet" href="../../CSS/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/eb814e06cc.js" crossorigin="anonymous"></script>
    <title>DashBoard</title>
</head>
<body>
    <?php 
        $name = $_GET['name']; 
        $name_arr = explode("&", $name);
    ?>
    <?php include "/var/www/html/offcanvas.php"?>
    
    <br>
    <!-- Prepare a DOM with a defined width and height for ECharts -->
    <!-- <div class="container">
        
    </div> -->
    
    <ul class="nav nav-tabs justify-content-center mb-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="hour-tab" data-bs-toggle="tab" data-bs-target="#hour-tab-pane" type="button" role="tab" aria-controls="hour-tab-pane" aria-selected="true">1 Hour</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="day-tab" data-bs-toggle="tab" data-bs-target="#day-tab-pane" type="button" role="tab" aria-controls="day-tab-pane" aria-selected="false">1 Day</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="week-tab" data-bs-toggle="tab" data-bs-target="#week-tab-pane" type="button" role="tab" aria-controls="week-tab-pane" aria-selected="false">1 Week</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="month-tab" data-bs-toggle="tab" data-bs-target="#month-tab-pane" type="button" role="tab" aria-controls="month-tab-pane" aria-selected="false">1 Month</button>
        </li>
    </ul>
    <div class="container" id="chartParent">
        <h3 id="lineChartTitle" class="mb-1"></h3>
        <!-- <i class="fa-solid fa-battery-full" style="color: green;float: right;"> 100 %</i> -->
        <div class="row">
            <div class="col align-self-end">
                <!-- <p class="BatteryText">100 %</p> -->
                <i class="fa-solid fa-battery-full fa-xl" id="BatteryIcon" style="float: right;"> 100 %</i>
            </div>                                    
        </div>
    </div>
    <div id="chart-id"></div>
    
    <div class="container">
        <div class="row mt-2 mb-2">
            <div class="col-sm-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title" id="detail-alert-day">0</h5>
                        <p class="card-text">Alerts over the past day</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title" id="detail-alert-week">0</h5>
                        <p class="card-text">Alerts over the past 7 days</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title" id="detail-alert-month">0</h5>
                        <p class="card-text">Alerts over the past 30 days</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-3"></div>
            <div class="col-sm-3">
                <div class="card" style="width: auto;" id="">
                    <!-- <img class="card-img-top" src="icons8-alarm-clock-80.png" alt="Card image cap"> -->
                    <i class="fa-solid fa-stopwatch text-center pt-2" style="font-size: 30px;"></i>
                    <div class="card-body text-center">
                    <h5 class="card-title">Employee time saved</h5>
                        <p class="card-text"><strong>0 Hours</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card" style="width: auto;" id="">
                    <!-- <img class="card-img-top" src="icons8-alarm-clock-80.png" alt="Card image cap"> -->
                    <i class="fa-regular fa-bell text-center pt-2" style="font-size: 30px;"></i>
                    <div class="card-body text-center">
                    <h5 class="card-title">Alert Free</h5>
                        <p class="card-text"><strong>0%</strong></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
    
    <?php include "/var/www/html/dashBoard/Detail/detailAlert.php"?>
    <?php include "/var/www/html/dashBoard/updateUserForm.php"?>
    <script src="../../JS/Utils.js"></script>
    <script src="../../JS/config.js"></script>
    <!-- <script src="../../JS/index.js"></script> -->
    <script src="../../JS/chart/batt.js"></script>        
    <!-- <script src="../../JS/chart/battGuage.js"></script>  -->
    <script src="../../JS/chart/Bar.js"></script> 
    <script src="../../JS/chart/lineChart.js"></script>        
    <script src="../../JS/detail.js"></script>        
           
</body>
</html>