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
    require_once '../config.php';

    $titoloTest = $_COOKIE['titoloTest'];
    $page = $_COOKIE['page'];
    $numeroQuesito = $_COOKIE['numeroQuesito'];
    $tipoQuesito = $_COOKIE['tipoQuesito'];
    $index = $_POST['index'];
    $soluzione = $_POST['soluzione'];

    $email = $_SESSION['email'];

    try {
        $pdo = new PDO("mysql:host=$db_host; dbname=$db_name", $db_username, $db_password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');
    } catch (PDOException $e) {
        echo ("Connessione non riuscita") . $e->getMessage();
        exit();
    }

    try {
        if ($tipoQuesito == 0) {
            $sql = "SELECT * FROM CODICE WHERE NumeroQuesito = '$numeroQuesito' AND TitoloTest LIKE '$titoloTest'";
            $result = $pdo->query($sql);

            $soluzione = $result['Soluzione'];
            $correctResult = $pdo->query($soluzione);

            $inputResult = $pdo->query($soluzione);

            if ($correctResult == $inputResult) {
                $esito = 1;
            } else {
                $esito = 0;
            }

            echo ($esito);
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