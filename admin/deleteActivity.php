<?php
    require_once('../business_rules/SWTurismo.php');
    require_once('../business_rules/Admin.php');

    $conn = new SWTurismo('../business_rules/configFile.ini');

    session_start();

    $idActivity = $conn->idActivity($_GET['id']);

    if ($idActivity == null){
        header("location:admin.php");
    }

    if ($conn->deleteActivity($idActivity['idActivity'])) {
        echo "<script> alert('Atividade apagada com sucesso!') </script>";
        header("location:administrator.php?deleted");
    } else {
        echo "<script> alert('Não foi possivel apagar a atividade!') </script>";
    }

