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
        $telefono=$_POST["telefonoUtente"];
        $codice=$_POST["codiceUtente"];
        $anno=$_POST["annoImmatricolazione"];

        try {
            $pdo=new PDO("mysql:host=localhost; dbname=ESQL", "ESQLadmin", "esqladminpassword1");
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('SET NAMES "utf8"');
        } catch(PDOException $e) {
            echo("Connessione non riuscita");
            echo($e);
            exit();
        }

        try {
            $sql ="SELECT USER FROM mysql.user WHERE USER = '$email'";
            $result=$pdo->query($sql);
            if ($result->rowCount() == 0) {
                header("Location: ../index.html");
                exit();
            } else {
                header("Location: ../index.html");
                exit();
            }
        } catch (PDOException) { }

        try {
            if (empty($telefono)) {
                $sql="INSERT INTO UTENTI(Nome, Cognome, Email) VALUES ('$nome', '$cognome', '$email')";
                $result=$pdo->exec($sql);
            } else {
                $sql="INSERT INTO UTENTI(Nome, Cognome, Email, NumeroTelefono) VALUES ('$nome', '$cognome', '$email', '$telefono')";
                $result=$pdo->exec($sql);
            }
        } catch (PDOException $e) {
            echo('Codice errore'.$e->getMessage());
            exit();
        }

        try {
            $sql="INSERT INTO STUDENTI(EmailUtente, NomeUtente, CognomeUtente, Codice, AnnoImmatricolazione) VALUE ('$email', '$nome', '$cognome', '$codice', '$anno')";
            $result=$pdo->exec($sql);
        } catch (PDOException $e) {
            echo('Codice errore'.$e->getMessage());
            exit();
        }
    ?>
</body>