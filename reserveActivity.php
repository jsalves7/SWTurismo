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

?>

<script>
    function isCreditCard(number, type)
    {
        if(type.value == "Visa") {
            regexp = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
        } else if(type.value == "MasterCard") {
            regexp = /^(?:5[1-5][0-9]{14})$/;
        }
        if (regexp.test(number.value)) {
            document.getElementById('reserve-btn').style.display = "block";
        } else {
            document.getElementById('reserve-btn').style.display = "none";
        }
    }
</script>

<?php

    //know if data was sent by post
    if(isset($_POST['cardName'])){
            //filter special chars
            foreach ($_POST as $key => $value) {
                $_POST["$key"] = filter_var($value, FILTER_SANITIZE_STRING);
            }

            $conn->reserveActivity($_SESSION['username']->idUser(), $_GET['idActivity'], $_POST['reservationDate'], $_POST['cardName'], $_POST['cardType'], $_POST['cardNumber'], $_POST['cardExpiry'], $_POST['cardCVV']);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <meta charset="UTF-8">
    <title>SWTurismo | Reservar</title>
    <script src="js/jquery-3.4.1.js"></script>
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
            <input type="text" placeholder="Pesquisar..." name="search">
            <button class="buttonAdmin" type="submit">OK</button>
        </form>
    </div>

    <div class="reserve-activity-container">
        <h2>Reservar <?php echo $idActivity['name'];?></h2>

        <form class="reserve-form" method="post">
            <label for="reservationDate" class="labelDate"><b>Data</b></label>
            <input type="date" id="reservationDate" name="reservationDate" required>

            <br>

            <h3>Dados do Cartão de Crédito</h3>

            <br>

            <label for="cardName" class="labelName"><b>Nome</b></label>
            <input type="text" id="cardName" placeholder="Nome" name="cardName" required>

            <label for="cardType" class="labelCardType"><b>Cartão</b></label>
            <select type="text" id="cardType" name="cardType" onChange="isCreditCard(cardNumber, cardType)" required>
                <option value="Visa">Visa</option>
                <option value="MasterCard">MasterCard</option>
            </select>

            <label for="cardNumber" class="labelCardNumber"><b>Número</b></label>
            <input type="number" id="cardNumber" name="cardNumber" onkeyup="isCreditCard(cardNumber, cardType)" required>

            <label for="cardExpiry" class="labelCardExpiry"><b>Validade</b></label>
            <input type="date" id="cardExpiry" name="cardExpiry" required>

            <label for="cardCVV" class="labelCardCVV"><b>CVV</b></label>
            <input type="number" id="cardCVV" name="cardCVV" required>

            <button type="submit" id="reserve-btn" style="display: none"><b>Reservar</b></button>
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