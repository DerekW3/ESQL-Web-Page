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

        try {
            $pdo=new PDO("mysql:host=localhost; dbname=ESQL", "root", "secretpassword1");
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('SET NAMES "utf8"');
        } catch(PDOException) {
            echo("Connessione non riuscita");
            exit();
        }

        try {
            $sql ='SELECT * FROM UTENTI WHERE $nome=Nome, $cognome=Cognome, $email=Email';
            $result=$pdo->query($sql);

            header("Location: ../index.html");
            exit();
        } catch (PDOException) { }

        try {
            if (empty($telefono)) {
                $sql="INSERT INTO UTENTI(Nome, Cognome, Email) VALUES ('$nome', '$cognome', '$email')";
                $result=$pdo->exec($sql);
            } else {
                $sql="INSERT into UTENTI(Nome, Cognome, Email, NumeroTelefono) VALUES ('$nome', '$cognome', '$email', '$telefono')";
                $result=$pdo->exec($sql);
            }
        } catch (PDOException $e) {
            echo('Codice errore'.$e->getMessage());
            exit();
        }

        try {
            $sql="INSERT INTO DOCENTI(NomeUtente, EmailUtente, CognomeUtente, NomeDipartimento, NomeCorso) VALUES ('$nome', '$email', '$cognome', '$dipartimento', '$corso')";
            $result=$pdo->exec($sql);
        } catch (PDOException $e) {
            echo('Codice errore'.$e->getMessage());
            exit();
        }
    ?>
</body>