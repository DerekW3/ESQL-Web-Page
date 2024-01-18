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
    require '../vendor/autoload.php';

    $mongoClient = new MongoDB\Client('mongodb://127.0.0.1:27017');

    $database = $mongoClient->selectDatabase("ESQL");
    $collection = $database->selectCollection("Logs");

    $titoloTest = $_COOKIE['titoloTest'];
    $page = $_COOKIE['page'];
    $numeroQuesito = $_COOKIE['numeroQuesito'];
    $tipoQuesito = $_COOKIE['tipoQuesito'];

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
        $sql = "SELECT Codice FROM STUDENTI WHERE EmailUtente LIKE '$email'";
        $result = $pdo->query($sql);

        foreach ($result as $row) {
            $codice = $row['Codice'];
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }

    try {
        if ($tipoQuesito == 0) {
            $soluzione = $_POST['soluzione'];
            $sql = "SELECT * FROM CODICE WHERE NumeroQuesito = '$numeroQuesito' AND TitoloTest LIKE '$titoloTest'";
            $result = $pdo->query($sql);

            foreach ($result as $row) {
                $temp = $row['Soluzione'];
            }

            try {
                $correctResult = $pdo->query($temp);
                $correctResultArray = array();

                $inputResult = $pdo->query($soluzione);
                $inputResultArray = array();

                foreach ($inputResult as $row) {
                    array_push($inputResultArray, $row);
                }

                foreach ($correctResult as $row) {
                    array_push($correctResultArray, $row);
                }

                if (empty(array_diff($inputResultArray, $correctResultArray))) {
                    $esito = 1;
                } else {
                    $esito = 0;
                }
            } catch (PDOException) {
                $esito = 0;
            }
        } else {
            $index = $_POST['index'];
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

    try {
        if (empty($index)) {
            $risposta = $soluzione;
        } else {
            $risposta = $index;
        }
        $sql = "CALL CONSEGNA_RISPOSTA('$codice', '$titoloTest', '$tipoQuesito', '$numeroQuesito', '$risposta', '$esito')";
        $result = $pdo->query($sql);

        $event = [
            "timestamp" => time(),
            "tipo_event" => "risposta",
            "descrizione" => $codice . "_" . $titoloTest
        ];

        $result = $collection->insertOne($event);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }

    header("Location: ./take-test.php");
    exit();
    ?>
</body>

</html>