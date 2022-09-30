<nav class="navbar bg-info bg-gradient">
    <div>
        <!-- <a class="navbar-brand" href="">Factilites</a> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
        <span class="navbar-toggler-icon"></span>
        </button>
        <?php 
            if($name != null)
                echo "<a class='navbar-brand text-center' href='' id='offcanvas-header'>$name</a>";
            else
                echo "<a class='navbar-brand text-center' href='' id='offcanvas-header'>$name</a>";
        ?>
        
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <?php 
                    if($name_arr[0] != null){
                        echo "<h5 class='offcanvas-title' id='offcanvasNavbarLabel'>".$name_arr[0]."</h5>";
                    } else {
                        echo "<h5 class='offcanvas-title' id='offcanvasNavbarLabel'>Digiflow</h5>";
                    }
                ?>                
                <button type="button" class="btn-close" id="Close-button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-start flex-grow-1 pe-3" id="offcanvasEl">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/"><i class="fa-solid fa-house-chimney"></i> Home</a>
                    </li>
                    <!-- <li class="nav-item" id="air-quality-female-toilet-barChart">
                        <a class="nav-link" onclick="getEvents()"><i class="fa-solid fa-chart-column"></i> Air Quality Female Toilet</a>
                    </li>
                    <li class="nav-item" id="sensor-for-female-toilet-barChart">
                        <a class="nav-link"><i class="fa-solid fa-chart-column"></i> Sensor For Female Toilet</a>
                    </li> -->
                    <li class="nav-item dropdown" id="air-quality-female-toilet-barChart">
                        <a class="nav-link" onclick="updateLine()" id="AirQ" role="button" aria-expanded="false">
                            <i class="fa-solid fa-chart-column"></i> Air Quality Female Toilet
                        </a>
                        <!-- <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                            <li><a class="dropdown-item">1 Hour</a></li>
                            <li><a class="dropdown-item">1 Day</a></li>
                            <li><a class="dropdown-item">1 Week</a></li>
                            <li><a class="dropdown-item">1 Month</a></li>
                            <li><a class="dropdown-item">1 Year</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item">Custom</a></li>
                        </ul> -->
                    </li>
                    <li class="nav-item dropdown" id="motion-detection-sensor-for-female-toilet-barChart">
                        <a class="nav-link dropdown-toggle" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-chart-column"></i> Motion Detection Female Toilet
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                            <!-- <li><a class="dropdown-item">1 Hour</a></li> -->
                            <li><a class="dropdown-item">1 Day</a></li>
                            <li><a class="dropdown-item">1 Week</a></li>
                            <li><a class="dropdown-item">1 Month</a></li>
                            <li><a class="dropdown-item">1 Year</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item">Custom</a></li>
                        </ul>
                    </li>
                    <!-- <li class="nav-item dropdown" id="trash-bin-sensor-for-female-toilet-barChart">
                        <a class="nav-link dropdown-toggle" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-chart-column"></i> Trash Bin Female Toilet
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                            <li><a class="dropdown-item">1 Hour</a></li>
                            <li><a class="dropdown-item">1 Day</a></li>
                            <li><a class="dropdown-item">1 Week</a></li>
                            <li><a class="dropdown-item">1 Month</a></li>
                            <li><a class="dropdown-item">1 Year</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item">Custom</a></li>
                        </ul>
                    </li> -->
                </ul>
                <!-- <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
                </form> -->
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" id="Auth">
                    <li class="nav-item justify-content-end" id="offcanvas-login"><a class="nav-link" aria-current="page">
                        Log In <i class="fa-solid fa-user"></i></a>
                    </li>
                    <!-- <li class="nav-item"><a class="nav-link" aria-current="page" href="/">
                        <i class="bi bi-house"></i> Register</a>
                    </li> -->
                    <li class="nav-item" id="offcanvas-logout" onclick="logout()"><a class="nav-link" aria-current="page">
                        Log Out <i class="fa-solid fa-right-from-bracket"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
