<?php

    require_once('business_rules/SWTurismo.php');
    require_once('business_rules/Admin.php');
    require_once('business_rules/User.php');

    $conn = new SWTurismo('business_rules/configFile.ini');

    //know if user can be here
    $conn->isUserLoggedOff();
    $conn->listActivityAdmin();
    $conn->listActivityUser($_SESSION['username']->idUser());

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="UTF-8">
    <title>SWTurismo | Pesquisar</title>
</head>
<body>
<div class="container">
    <div class="menu-container">
        <a href="homepage.php"><h1>SWTurismo</h1></a>

        <ul id="menu">
            <li><a href="listActivity.php">Reservas</a></li>
            <li><a href="Contactos">Contactos</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>

        <form method="get" class="searchForm" action="search.php">
            <input type="text" placeholder="Pesquisar..." name="search" value="<?php echo $_GET['search']; ?>">
            <button class="buttonAdmin" type="submit">OK</button>
        </form>
    </div>

    <div class="title-container">
        <h1>Actividades</h1>
    </div>

    <div class="activities-container">
        <div class="activities">
            <?php foreach ($conn->search() as $value) { ?>
                <div class="item">
                    <div class="activity-item">
                        <img src="<?php echo $conn->activityImage($value['idImage']) ;?>">
                        <h2><?php echo $value['name'] ?></h2>
                        <?php
                        if(strlen($value['desc'])> 100 ) { ?>
                            <p><?php echo substr($value['desc'], 0, 100) . "..." ?></p>
                            <?php
                        }else{ ?>
                            <p><?php echo $value['desc']?></p>
                            <?php
                        } ?>
                    </div>
                    <button><a href="reserveActivity.php?idActivity=<?php echo $value['idActivity']?>">Reservar atividade</a></button>
                </div>
                <?php
            } ?>
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
                <li><img src="img/facebook.svg" alt=""></li>
                <li><img src="img/instagram.svg" alt=""></li>
                <li><img src="img/twitter.svg" alt=""></li>
            </ul>
        </div>
    </footer>
</div>
</body>
</html>
