<?php

    require_once('business_rules/SWTurismo.php');
    require_once('business_rules/User.php');

    $conn = new SWTurismo('business_rules/configFile.ini');

    //know if user can be here
    $conn->isUserLoggedOff();
    $conn->listActivityAdmin();
    $conn->listActivityUser($_SESSION['username']->idUser());
    $conn->listComments();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="UTF-8">
    <title>SWTurismo | Reservas</title>
</head>
<body>
<div class="container">
    <div class="menu-container">
        <a href="homepage.php"><h1>SWTurismo</h1></a>

        <ul id="menu">
            <li><a href="Contactos">Contactos</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>

        <form method="get" class="searchForm" action="search.php">
            <input type="text" placeholder="Pesquisar..." name="search">
            <button class="buttonAdmin" type="submit">OK</button>
        </form>
    </div>

    <div class="title-container">
        <h1>Lista de Atividades Reservadas</h1>
    </div>

    <div class="activities-container">
        <div class="activities">
            <?php foreach ($conn->listActivityUser($_SESSION['username']->idUser()) as $value) { ?>
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
                        <div class="columnActivity"><h3>Data: &nbsp;</h3><p><?php echo $value['reservationDate']?></p></div>
                        <div class="columnActivity"><h3>Estado: &nbsp;</h3><p>Estado: <?php echo $value['state']?></p></div>
                    </div>
                    <?php if($value['reservationDate'] < date('Y-m-d')) { ?>
                    <a class="comment-btn" href="commentActivity.php?idActivity=<?php echo $value['idActivity'] ?>">Comentar</a>
                    <a class="delete-btn" href="deleteReservation.php?idActivity=<?php echo $value['idActivity'] ?>" onclick="return confirmation()">Eliminar</a>
                    <?php
                    } ?>
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
<script type="text/javascript">
    function confirmation() {
        return confirm('Eliminar Reserva?');
    }
</script>
</body>
</html>
