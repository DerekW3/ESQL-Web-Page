<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
</head>
</head>

<body>
    <?php
    $email = $_POST["emailUtente"];
    $password = $_POST["password"];

    try {
        $pdo = new PDO("mysql:host=localhost; dbname=ESQL", "ESQLadmin", "esqladminpassword1");

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');
    } catch (PDOException) {
        echo ("Connessione non riuscita");
        exit();
    }

    try {
        $sql = "SELECT * FROM UTENTI WHERE Email = '$email'";
        $result = $pdo->query($sql);
        if ($result->rowCount() == 0) {
            header("Location: ../webpages/select-type.html");
            exit();
        } else {
            foreach ($result as $row) {
                $name = $row['Nome'];
                $cognome = $row['Cognome'];
            }
            setcookie("name", $name, time() + 3.6e6);
            setcookie("cognome", $cognome, time() + 3.6e6);

            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;

            $sql = "SELECT * FROM STUDENTI WHERE EmailUtente = '$email'";
            $result = $pdo->query($sql);
            if ($result->rowCount() > 0) {
                header("Location: ./student-homepage.php");
                exit();
            } else {
                header("Location: ./professor-homepage.php");
                exit();
            }
        }
    } catch (PDOException) {
        exit();
    }
    ?>
</body>