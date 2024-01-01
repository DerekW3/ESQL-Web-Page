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
        $password=$_POST["password"];

        try {
            $pdo=new PDO("mysql:host=localhost; dbname=ESQL", "ESQLadmin", "esqladminpassword1");
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('SET NAMES "utf8"');
        } catch(PDOException $e) {
            echo("Connessione non riuscita").$e->getMessage();
            echo($e);
            exit();
        }

        try {
            $sql ="SELECT USER FROM mysql.user WHERE USER = '$email'";
            $result=$pdo->query($sql);
            if ($result->rowCount() != 0) {
                header("Location: ../index.html");
                exit();
            }
        } catch (PDOException) { }

        $pdo->beginTransaction(void);
        try {
            $sql="CREATE USER '$email'@'localhost' IDENTIFIED BY '$password'";
            $result=$pdo->query($sql);

            $sql="GRANT SELECT, INSERT, UPDATE on ESQL.* TO '$email'@'localhost'";
            $result=$pdo->query($sql);

            $sql="INSERT INTO UTENTI(Nome, Cognome, Email) VALUES ('$nome', '$cognome', '$email')";
            $result=$pdo->exec($sql);
            
            if (!is_empty($telefono)) {
                $sql="INSERT INTO TELEFONI(EmailUtente, NumeroTelefono) VALUES ('$email', '$telefono')";
                $result=$pdo->exec($sql);
            }

            $sql="INSERT INTO STUDENTI(EmailUtente, NomeUtente, CognomeUtente, Codice, AnnoImmatricolazione) VALUE ('$email', '$nome', '$cognome', '$codice', '$anno')";
            $result=$pdo->exec($sql);

            $pdo->commit();
        } catch (PDOException $e) {
            echo('Codice errore'.$e->getMessage());
            echo('Signup Failed');
            $pdo->rollback();
        }

        header("Location: ../index.html");
        exit();
    ?>
</body>