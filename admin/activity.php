<?php

    require_once('../business_rules/SWTurismo.php');
    require_once('../business_rules/Admin.php');

    $conn = new SWTurismo('../business_rules/configFile.ini');

    $conn->isAdminLoggedOff();

    $idActivity = $conn->idActivity($_GET['id']);

    $success = "";

    if (isset($_POST['state'])){
        $conn->changeReservationState($_POST['state'], $idActivity['idActivity'], $_POST['idUser']);

        $success =  "<script> alert('O estado da atividade foi alterado com sucesso!') </script>";
    }

    if ($idActivity == null){
        header("location:admin.php");
    }

    // if logout button is pressed
    if (isset($_GET['action'])){
        if ($_GET['action'] == 'logout'){
            $_SESSION['admin']->logout();
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <meta charset="UTF-8">
    <title>Admin | Atividades</title>
</head>
<body>
<div class="container">
    <div class="menu-container">
        <a href="index.php"><h1>SWTurismo</h1></a>

        <ul id="menu">
            <li><a href="admin.php">Atividades</a></li>
            <li><a href="contactos.php">Contactos</a></li>
            <li><a href="?logout">Logout</a></li>
        </ul>

        <form method="get" class="searchForm">
            <input type="text" placeholder="Pesquisar..." name="search">
            <button class="buttonAdmin" type="submit">OK</button>
        </form>
    </div>

    <div class="activitiesTable-container">
        <?php if($conn->listReservationsAdmin($idActivity['idActivity']) != null){;?>

        <div class="activityTitle-container">
            <h2>Atividade <strong><?php echo $idActivity['name']?></strong></h2>
        </div>

        <div class="table-container">
            <table>
                <tr style="width:100%; background-color: #3C4447; color: white;">
                    <th style="width:20%;" colspan="2">Cliente</th>
                    <th style="width:80%;" colspan="3">Cartão de crédito</th>
                </tr>
                <tr>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Número</th>
                    <th>Tipo</th>
                    <th>CVV</th>
                </tr>
            <?php foreach ($conn->listReservationsAdmin($idActivity['idActivity']) as $value){ ?>
                <tr>
                    <td> <?php
                        $password = '3sc3RLrpd17';
                        $method = 'aes-256-cbc';

                        // Must be exact 32 chars (256 bit)
                        $password = substr(hash('sha256', $password, true), 0, 32);

                        // IV must be exact 16 chars (128 bit)
                        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);

                        // decrypt data
                        echo openssl_decrypt(base64_decode($value['name']), $method, $password, OPENSSL_RAW_DATA, $iv); ?>
                    </td>
                    <td>
                        <form class='state-form' method='post' action='activity.php?id=<?php echo $value['idActivity']; ?>'>
                            <select name='state'>
                                <option value ='reservada' <?php if ($value['state'] == 'reservada'){echo "selected";}?>>Reservada</option>
                                <option value ='adiada' <?php if ($value['state'] == 'adiada'){echo "selected";}?>>Adiada</option>
                                <option value ='cancelada' <?php if ($value['state'] == 'cancelada'){echo "selected";}?>>Cancelada</option>
                            </select>
                            <input type='hidden' name='idUser' value='<?php echo $value['idUser'];?>'>
                            <input type='submit' value='Mudar'>
                        </form>
                    </td>

                    <td class="sectionValue">
                        <?php echo openssl_decrypt(base64_decode($value['cardNumber']), $method, $password, OPENSSL_RAW_DATA, $iv);?>
                    </td>
                    <td class="sectionValue">
                        <?php echo openssl_decrypt(base64_decode($value['cardType']), $method, $password, OPENSSL_RAW_DATA, $iv);?>
                    </td>
                    <td class="sectionValue">
                        <?php echo openssl_decrypt(base64_decode($value['securityCode']), $method, $password, OPENSSL_RAW_DATA, $iv);?>
                    </td>
                <?php } ?>
            </table>
            <?php } else {; ?>
               <h3>Sem atividades <?php echo $idActivity['name']?> reservadas </h3>
            <?php }; ?>
        </div>
    </div>

    <footer class="footer">
        <div class="footerText-container">
            <h1>SWTurismo</h1>
            <h3>TO TRAVEL IS TO LIVE</h3>
            <p>O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro.O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. </p>
        </div>

        <div class="footerSocial-container">
            <h2>Copyrigth 2019 - SWTurismo</h2>

            <ul class="social">
                <li><img src="../img/facebook.svg" alt=""></li>
                <li><img src="../img/instagram.svg" alt=""></li>
                <li><img src="../img/twitter.svg" alt=""></li>
            </ul>
        </div>
    </footer>
</div>
</body>
</html>