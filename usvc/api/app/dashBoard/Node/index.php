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
    <title>Location</title>
</head>
<body>
    <?php 
        $name = $_GET['name'];
    ?>
    <?php include "/var/www/html/offcanvas.php"?>
    <?php include "/var/www/html/dashBoard/Node/addSensorForm.php"?>
    
    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Air Quality</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Motion Detection</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Bin Fill Level</button>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Time</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" onclick="chartTimeSelect('HOUR')">1 Hour</a></li>
                <li><a class="dropdown-item" onclick="chartTimeSelect('DAY')">1 Day</a></li>
                <li><a class="dropdown-item" onclick="chartTimeSelect('WEEK')">1 Week</a></li>
                <li><a class="dropdown-item" onclick="chartTimeSelect('MONTH')">1 Month</a></li>
            </ul>
        </li>
    </ul>
    <div id="node-chart"></div>
    <?php include "/var/www/html/dashBoard/Facility/locationAlert.php"?>
    <div class="container mt-5 mb-5">
        <h2>Sensors</h2>
        <div class="list-group" id="locations-list">
            <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                <div class="row">
                    <img src="https://picsum.photos/200" alt="" class="col-4" id="feedbacks-img">
                    <div class="col-8">
                    <div class="justify-content-between">
                        <h4 class="mb-1">List group item heading</h4>
                        <small>3 days ago</small>
                    </div>
                    <p class="mb-1">Some placeholder content in a paragraph.</p>
                    <small>And some small print.</small>
                    </div>              
                </div>            
            </a>
            <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                <div class="row">
                    <img src="https://picsum.photos/200" alt="" class="col-4" id="feedbacks-img">
                    <div class="col-8">
                    <div class="justify-content-between">
                        <h6 class="mb-1">List group item heading</h6>
                        <small>3 days ago</small>
                    </div>
                    <p class="mb-1">Some placeholder content in a paragraph.</p>
                    <small>And some small print.</small>
                    </div>              
                </div>            
            </a>
            <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                <div class="row">
                    <img src="https://picsum.photos/200" alt="" class="col-4" id="feedbacks-img">
                    <div class="col-8">
                    <div class="justify-content-between">
                        <h6 class="mb-1">List group item heading</h6>
                        <small>3 days ago</small>
                    </div>
                    <p class="mb-1">Some placeholder content in a paragraph.</p>
                    <small>And some small print.</small>
                    </div>              
                </div>            
            </a>
        </div>
        <br>
    </div>
    <?php include "/var/www/html/dashBoard/updateUserForm.php"?>
    <script src="../../JS/Utils.js"></script>
    <script src="../../JS/config.js"></script>
    <script src="../../JS/chart/nodeDottedBar.js"></script>
    <script src="../../JS/node.js"></script>
           
</body>
</html>