<?php

    require_once('business_rules/SWTurismo.php');
    require_once('business_rules/User.php');
    require_once('business_rules/Reservation.php');
    require_once('business_rules/Activity.php');

    $conn = new SWTurismo('business_rules/configFile.ini');

    //know if user can be here
    $conn->isUserLoggedOff();

    if (!isset($_GET['idActivity'])){
        header("location:homepage.php");
    }

    $idActivity = $conn->idActivity($_GET['idActivity']);

    if ($idActivity == null){
        header("location:homepage.php");
    }

    // know if data was sent by post
    if(isset($_POST['comment'])){
        //filter special chars
        foreach ($_POST as $key => $value) {
            $_POST["$key"] = filter_var($value, FILTER_SANITIZE_STRING);
        }

        $conn->commentActivity($_POST['comment'], $_SESSION['username']->idUser(), $_GET['idActivity']);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="UTF-8">
    <title>SWTurismo | Comentar Atividade</title>
</head>
<body>
<div class="container">
    <div class="menu-container">
        <a href="homepage.php"><h1>SWTurismo</h1></a>

        <ul id="menu">
            <li><a href="listActivity.php">Reservas</a></li>
            <li><a href="contactos.php">Contactos</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>

        <form method="get" class="searchForm" action="search.php">
            <input type="text" placeholder="Pesquisar..." name="search">
            <button class="buttonAdmin" type="submit">OK</button>
        </form>
    </div>

    <div class="comment-container">
        <h2>Comentar Atividade <strong><?php echo $idActivity['name'];?></strong></h2>

        <form class="comment-form" method="post">
            <label for="comment" class="label-comment"><b>Comentário</b></label>
            <textarea name="comment" id="comment" placeholder="Comentário..." required></textarea>

            <button type="submit"><b>Gravar</b></button>
        </form>
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
