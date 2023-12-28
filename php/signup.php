<!DOCTYPE html>
<html lang="en">
    <head>
    </head>
</head>

<body>
    <?php
        $nome=$_POST["nomeUtente"];
        $cognome=$_POST["cognomeUtente"];
        $email=$_POST["emailUtente"];

        try {
            $pdo=new PDO("mysql:host=localhost; dbname=ESQL", "root", "secretpassword1");
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('SET NAMES "utf8"');
        } catch(PDOException) {
            echo("Connessione non riuscita");
            exit();
        }
    ?>
</body>