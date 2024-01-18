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
            $soluzione = $_POST['soluzione'];
            $sql = "SELECT * FROM CODICE WHERE NumeroQuesito = '$numeroQuesito' AND TitoloTest LIKE '$titoloTest'";
            $result = $pdo->query($sql);

            foreach ($result as $row) {
                $temp = $row['Soluzione'];
            }

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
    ?>
</body>

</html>