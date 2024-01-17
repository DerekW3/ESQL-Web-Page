<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controllando...</title>
</head>

<body>
    <?php
    $titoloTest = $_COOKIE['titoloTest'];
    $page = $_COOKIE['page'];
    $numeroQuesito = $_COOKIE['numeroQuesito'];
    $tipoQuesito = $_COOKIE['tipoQuesito'];
    $index = $_POST['index'];

    echo ($numeroQuesito . " " . $tipoQuesito);

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
        if ($tipoQuesito == 0) {
            $sql = "SELECT Soluzione FROM CODICE WHERE NumeroQuesito = '$numeroQuesito' AND TitoloTest LIKE '$titoloTest'";
            $result = $pdo->query($sql);
        } else {
            $sql = "SELECT * FROM RISPOSTA_CHIUSA WHERE NumeroQuesito = '$numeroQuesito' AND TitoloTest LIKE '$titoloTest' AND NumeroOpzione = '$index'";
            $result = $pdo->query($sql);

            foreach ($result as $row) {
                $soluzione = $row['Soluzione'];
                if ($soluzione == 1) {
                    $esito = 1;
                } else {
                    $esito = 0;
                }
            }
        }
    } catch (PDOException $e) {
        echo ("Fallito") . $e->getMessage();
        exit();
    }
    ?>
</body>

</html>