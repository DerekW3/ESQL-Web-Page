<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rispondi</title>
    <link rel="stylesheet" href="../styles/signup.css">
</head>

<body>
    <div class="container">
        <?php
        $numeroQuesito = $_POST['numeroQuesito'];
        $titoloTest = $_POST['titoloTest'];
        $testNum = $_POST['page'];

        if (!isset($_COOKIE['numeroQuesito'])) {
            setcookie('numeroQuesito', $numeroQuesito, time() + 3.6e6);
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

        try {
            $sql = "SELECT * FROM QUESITI WHERE TitoloTest LIKE '$titoloTest' AND Numero = '$numeroQuesito'";
            $result = $pdo->query($sql);

            $tipoQuesito = 0;

            $sql2 = "SELECT * FROM CODICE WHERE TitoloTest LIKE '$titoloTest' AND NumeroQuesito = '$numeroQuesito'";
            $result2 = $pdo->query($sql2);

            if ($result2->rowCount() == 0) {
                $tipoQuesito = 1;
                $sql2 = "SELECT * FROM RISPOSTA_CHIUSA WHERE TitoloTest LIKE '$titoloTest' AND NumeroQuesito = '$numeroQuesito'";
                $result2 = $pdo->query($sql2);
            }

            if (!isset($_COOKIE['tipoQuesito'])) {
                setcookie('tipoQuesito', $tipoQuesito, time() + 3.6e6);
            }
        } catch (PDOException $e) {
            echo ("Fallito") . $e->getMessage();
            exit();
        }
        ?>
        <form action="./check-answer.php" method="post" id="answerQuestion">
            <div class="container-three">
                <?php
                try {
                    if ($tipoQuesito == 0) {
                        foreach ($result as $row) {
                            $descrizione = $row['Descrizione'];
                        }
                        echo
                        "<label for=\"soluzione\">$descrizione</label>
                        <textarea id=\"soluzione\" name=\"soluzione\" rows=\"5\" cols=\"80\" placeholder=\"Inserisci Codice\"></textarea>";
                    } else {
                        $index = 1;
                        foreach ($result2 as $row) {
                            $descrizione = $row['Testo'];
                            echo
                            "<input type=\"radio\" id=\"$index\" name=\"index\" value=\"$index\" required>
                            <label for=\"$index\">$descrizione</label>";
                            $index += 1;
                        }
                    }
                } catch (PDOException $e) {
                    echo ("Fallito") . $e->getMessage();
                    exit();
                }
                ?>
            </div>
        </form>

        <button style="margin-top: 10px;" type="submit" form="answerQuestion" value="Submit">Rispondi</button>
    </div>
</body>

</html>