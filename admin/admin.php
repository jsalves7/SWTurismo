<?php

    require_once('../business_rules/SWTurismo.php');
    require_once('../business_rules/Admin.php');

    $conn = new SWTurismo('../business_rules/configFile.ini');

    $conn->isAdminLoggedOff();

    $success = "";

    if (isset($_GET['deleted'])) {
        $success =  "<script> alert('A atividade foi eliminada com sucesso!') </script>";
    }

    // if logout button is pressed
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'logout') {
            $_SESSION['admin']->logout();
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <meta charset="UTF-8">
    <title>Admin | Home</title>
</head>
<body>
<div class="container">
    <div class="menu-container">
        <a href="index.php"><h1>SWTurismo</h1></a>

        <ul id="menu">
            <li><a href="Contactos">Contactos</a></li>
            <li><a href="?logout">Logout</a></li>
        </ul>

        <form method="get" class="searchForm">
            <input type="text" placeholder="Pesquisar..." name="search">
            <button class="buttonAdmin" type="submit">OK</button>
        </form>
    </div>

    <div class="activitiesTable-container">
        <div class="activityTitle-container">
            <h2>Atividades</h2>
        </div>

        <a href="createActivity.php"><button><b>Criar Atividade</b></button></a>

        <div class="table-container">
            <?php
                echo $success;
                if (isset($_GET['search'])){
                     echo "<table>
                            <tr>
                                <th>Atividade</th>
                                <th>Eliminar</th>
                                <th>Editar</th>
                             </tr>
                            </table>";
                    foreach ($conn->searchAdmin($_GET['search']) as $value ){
                        echo "<table>
                                <tr>
                                    <td><a href='activity.php?id=" . $value['idActivity'] . "'>" . $value['name'] . "</a></td>
                                    <td><a href='deleteActivity.php?id=" . $value['idActivity'] . "'>Eliminar</><br></td>
                                    <td><a href='updateActivity.php?id=" . $value['idActivity'] . "'>Editar</a><br></td>
                                </tr>
                            </table>";
                    }
                } else {
                    echo "<table>
                            <tr>
                                <th>Atividade</th>
                                <th>Eliminar</th>
                                <th>Editar</th>
                            </tr>
                          </table>";
                    foreach ($conn->listActivityAdmin() as $value) {
                        echo "<table>
                                <tr>
                                    <td><a href='activity.php?id=" . $value['idActivity'] . "'>" . $value['name'] . "</a></td>
                                    <td><a href='deleteActivity.php?id=" . $value['idActivity'] . "'>Eliminar</><br></td>
                                    <td><a href='updateActivity.php?id=" . $value['idActivity'] . "'>Editar</a><br></td>
                                </tr>
                              </table>";
                    }
                }
            ?>
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

