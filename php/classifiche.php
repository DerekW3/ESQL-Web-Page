<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classifiche</title>
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
    <div class="content">
        <h3 id="title">Classifica Uno</h3>
        <div class="tests">
            <?php
            try {
                $sql = "SELECT * FROM CLASSIFICA";
                $result = $pdo->query($sql);

                foreach ($result as $row) {
                    $codice = $row['CodiceStudente'];
                    $count = $row['COUNT(*)'];
                    echo
                    "<div class=\"test\">
                            <div id=\"info\">
                                <h3 style=\"color: var(--text);\">Codice: $codice</h3>
                                <h3 style=\"color: var(--text);\">Numero Test Finiti: $count</h3>
                            </div>
                        </div>";
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
                exit();
            }
            ?>
            <h3 id="title">Classifica Due</h3>
            <div class="tests">
                <?php
                try {
                    $sql = "SELECT * FROM CLASSIFICA_DUE";
                    $result = $pdo->query($sql);

                    foreach ($result as $row) {
                        $codice = $row['CodiceStudente'];
                        $count = $row['CORRECTS / WRONGS'];
                        echo
                        "<div class=\"test\">
                            <div id=\"info\">
                                <h3 style=\"color: var(--text);\">Codice: $codice</h3>
                                <h3 style=\"color: var(--text);\">Tasso di Correttezza: $count</h3>
                            </div>
                        </div>";
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    exit();
                }
                ?>
            </div>
            <h3 id="title">Classifica Tre</h3>
            <div class="tests">
                <?php
                try {
                    $sql = "SELECT * FROM CLASSIFICA_TRE";
                    $result = $pdo->query($sql);

                    foreach ($result as $row) {
                        $titoloTest = $row['TitoloTest'];
                        $numero = $row['Numero'];
                        $count = $row['COUNT(*)'];
                        echo
                        "<div class=\"test\">
                            <div id=\"info\">
                                <h3 style=\"color: var(--text);\">Test: $titoloTest</h3>
                                <h3 style=\"color: var(--text);\">Quesito : $numero</h3>
                                <h3 style=\"color: var(--text);\">Numero Risposte: $count</h3>
                            </div>
                        </div>";
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                    exit();
                }
                ?>
            </div>
        </div>
</body>

</html>