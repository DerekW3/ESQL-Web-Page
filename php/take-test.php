<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dando Esame</title>
</head>
<body>
    <div class="header">
        <?php
        if (isset($_COOKIE['page'])) {
            $testNum = $_COOKIE['page'];
        } else {
            $testNum = $_POST['page'];
            setcookie('page', $testNum, time() + 3.6e6);
        }
        echo
        "<form action=\"./professor-homepage.php\" method=post>
                <button type=\"submit\"><img id=\"messaggi\" src=\"https://cdn4.iconfinder.com/data/icons/navigation-40/24/back-1-1024.png\" alt=\"Andare indietro simbolo\"></button>
        </form>";
        ?>
        <h3><?php echo ("Ciao, " . $_COOKIE['name']); ?></h3>
        <a href="./messaggi.php"><img id="messaggi" src="https://cdn3.iconfinder.com/data/icons/email-51/48/53-512.png" alt="Simbolo per messaggi"></a>
    </div>
    <?php
    ?>
</body>
</html>