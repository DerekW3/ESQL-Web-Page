<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quesito Viewer</title>
    <link rel="stylesheet" href="../styles/professor-homepage.css">
</head>

<body>
    <div class="header">
        <?php
        $testNum = $_POST['page'];
        echo
        "<form action=\"./view-test.php\" method=post>
                <input type=\"hidden\" name=page value=\"$testNum\">
                <button type=\"submit\"><img id=\"messaggi\" src=\"https://cdn4.iconfinder.com/data/icons/navigation-40/24/back-1-1024.png\" alt=\"Andare indietro simbolo\"></button>
        </form>";
        ?>
        <h3><?php echo ("Ciao, " . $_COOKIE['name']); ?></h3>
        <a href="./messaggi.php"><img id="messaggi" src="https://cdn3.iconfinder.com/data/icons/email-51/48/53-512.png" alt="Simbolo per messaggi"></a>
    </div>
    <div class="content">
        <div class="quesiti">
            <?php
            $titoloTest = $_POST['titoloTest'];
            $numeroQuesito = $_POST['numeroQuesito'];

            try {
                $pdo = new PDO("mysql:host=localhost; dbname=ESQL", $_SESSION['email'], $_SESSION['password']);

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->exec('SET NAMES "utf8"');
            } catch (PDOException $e) {
                echo ("Connessione non riuscita") . $e->getMessage();
                exit();
            }

            try {
                $sql = "SELECT * FROM CODICE WHERE NumeroQuesito = '$numeroQuesito' AND TitoloTest LIKE '$titoloTest'";
                $result = $pdo->query($sql);

                if ($result->rowCount() == 0) {
                    $tipoQuesito = "ripostaChiusa";
                } else {
                    $tipoQuesito = "codice";
                }
            } catch (PDOException $e) {
                echo ("Azione fallito") . $e->getMessage();
                exit();
            }

            try {
                if ($tipoQuesito == "codice") {
                    $sql = "SELECT * FROM CODICE WHERE NumeroQuesito = '$numeroQuesito' AND TitoloTest LIKE '$titoloTest' ORDER BY NumeroSoluzione ASC";
                    $result = $pdo->query($sql);

                    foreach ($result as $row) {
                        $numeroSoluzione = $row['NumeroSoluzione'];
                        $soluzione = $row['Soluzione'];

                        echo
                        "<div class=\"quesito\">
                            <div id=\"info\" style=\"margin-right: auto;\">
                                <h3 style=\"color: var(--text);\">Soluzione #$numeroSoluzione</h3>
                                <p style=\"color: var(--text);\">$soluzione</p>
                            </div>
                        </div>";
                    }
                }
            } catch (PDOException $e) {
                echo ("Azione fallita") . $e->getMessage();
                exit();
            }
            ?>
        </div>
    </div>
</body>

</html>