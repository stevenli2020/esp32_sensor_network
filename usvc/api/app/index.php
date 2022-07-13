<?php
//phpinfo()
// include "/var/www/html/dbconfig/sensor_db.php";

?>

<html lang="en">
<?php include "/var/www/html/base.php"?>
<body>
    
    <?php include "/var/www/html/offcanvas.php"?>
    
    <br>
    <!-- Prepare a DOM with a defined width and height for ECharts -->
    <!-- <div class="container">
        
    </div> -->
    
        
    <div class="container mb-5" id="chartParent">
        <h3 id="lineChartTitle" class="mb-1"></h3>
        <div id="lineChart"></div><br>
        <!-- <div id="Bar"></div><br> -->
        <!-- <button type="button" class="btn btn-primary" id="getEvent" onclick="getEvents()">Get Events</button>
        <br>
        <div class="card" id="card">
        </div> -->
        <!--=============== BATTERY ===============-->
        
        <!-- <div class="battery__card">
            <div class="battery__data">               -->

                <!-- <p class="battery__status">
                    Low battery <i class="ri-plug-line"></i>
                </p> -->
                <!-- <div class="trash">
                    <p class="Trash__text">Trash Can</p>
                    <h1 class="Trash__percentage">
                        20%
                    </h1>
                    <span class="bi bi-trash-fill" style="font-size:145px; color: white;"></span>
                </div>
            </div>
            <div class="battery__data">
                <p class="battery__text">Battery</p>
                <h1 class="battery__percentage">
                    20%
                </h1>
                <div class="battery__pill">
                
                <div class="battery__level">
                    <div class="battery__liquid"></div>
                </div>
            </div>
            </div>

            
        </div> -->
        
        
        
    </div>
    <script src="./JS/Utils.js"></script>
    <!-- <script src="./JS/batt.js"></script>         -->
    <script src="./JS/Bar.js"></script> 
    <script src="./JS/lineChart.js"></script>        
           
    <?php include "/var/www/html/navbar.php" ?>
    <script src="./JS/index.js"></script>
</body>
</html>