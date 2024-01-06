<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messaggi</title>
    <link rel="stylesheet" href="../styles/professor-homepage.css">
</head>

<body>
    <div class="header">
        <?php
        if ($_SESSION['tipoUtente'] == 'studente') {
            echo
            "<form action=\"./student-homepage.php\" method=post>
                <button type=\"submit\"><img id=\"messaggi\" src=\"https://cdn4.iconfinder.com/data/icons/navigation-40/24/back-1-1024.png\" alt=\"Andare indietro simbolo\"></button>
            </form>";
        } else {
            echo
            "<form action=\"./professor-homepage.php\" method=post>
                <button type=\"submit\"><img id=\"messaggi\" src=\"https://cdn4.iconfinder.com/data/icons/navigation-40/24/back-1-1024.png\" alt=\"Andare indietro simbolo\"></button>
            </form>";
        }
        ?>
        <h3><?php echo ("Ciao, " . $_COOKIE['name']); ?></h3>
        <a href="./messaggi.php"><img id="messaggi" src="https://cdn3.iconfinder.com/data/icons/email-51/48/53-512.png" alt="Simbolo per messaggi"></a>
    </div>
    <div class="content">
        <div class="quesiti">
            <?php
            $tipoUtente = $_SESSION['tipoUtente'];

            $email = $_SESSION['email'];

            try {
                $pdo = new PDO("mysql:host=localhost; dbname=ESQL", $_SESSION['email'], $_SESSION['password']);

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->exec('SET NAMES "utf8"');
            } catch (PDOException $e) {
                echo ("Connessione non riuscita") . $e->getMessage();
                exit();
            }

            ?>
        </div>
    </div>
</body>