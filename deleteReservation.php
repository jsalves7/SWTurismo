<?php

    require_once('business_rules/SWTurismo.php');
    require_once('business_rules/User.php');
    require_once('business_rules/Activity.php');

    $conn = new SWTurismo('business_rules/configFile.ini');

    session_start();

    $conn->deleteReservation($_GET['idActivity']);

    header("location:listActivity.php?deleted");
