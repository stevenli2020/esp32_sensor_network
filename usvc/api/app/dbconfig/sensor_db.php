<?php
    $servername='database';
    $dbname='sensor_db';
	$username ='client';
	$password='QP8[dq!n38r.Nw.(';
	// echo 'Connecting to uam Database..\n';
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
	// echo 'OK';


