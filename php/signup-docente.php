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
        $dipartimento=$_POST["nomeDipartimento"];
        $corso=$_POST["nomeCorso"];
        $password=md5($_POST["password"]);

        try {
            $pdo=new PDO("mysql:host=localhost; dbname=ESQL", "ESQLadmin", "esqladminpassword1");
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT, FALSE);
            $pdo->exec('SET NAMES "utf8"');
        } catch(PDOException $e) {
            echo("Connessione non riuscita").$e->getMessage();
            exit();
        }

        try {
            $sql ="SELECT USER FROM mysql.user WHERE USER = '$email'";
            $result=$pdo->query($sql);
            if ($result->rowCount() > 0) {
                header("Location: ../index.html");
                exit();
            }
        } catch (PDOException) { }

        try {
            $sql="CREATE USER '$email'@'localhost' IDENTIFIED BY '$password'";
            $result=$pdo->query($sql);

            $sql="GRANT SELECT, INSERT, UPDATE on ESQL.* TO '$email'@'localhost'";
            $result=$pdo->query($sql);

            if (!empty($telefono)) {
                $numeroTelefono = $telefono;
            } else {
                $numeroTelefono = 0;
            }

            $sql="CALL iscrivi_docente('$email', '$nome', '$cognome', '$numeroTelefono', '$dipartimento', '$corso')";
            $result=$pdo->exec($sql);

            $pdo->commit();
        } catch (PDOException $e) {
            echo('Codice errore'.$e->getMessage());
            echo('Signup Failed');
            $pdo->rollBack();
        }

        header("Location: ../index.html");
        exit();
    ?>
</body>