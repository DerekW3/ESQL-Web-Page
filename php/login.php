<!DOCTYPE html>
<html lang="en">
    <head>
    </head>
</head>

<body>
    <?php
        $email=$_POST["emailUtente"];
        $email=$_POST["password"];

        try {
            $pdo=new PDO("mysql:host=localhost; dbname=ESQL", "root", "secretpassword1");
            
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec('SET NAMES "utf8"');
        } catch(PDOException) {
            echo("Connessione non riuscita");
            exit();
        }

        try {
            $sql ="SELECT USER FROM mysql.user WHERE USER = '$email'";
            $result=$pdo->query($sql);
        } catch (PDOException) {
            exit();
        }
        
        if ($result->rowCount() == 0) {
            header("Location: ../webpages/select-type.html");
            exit();
        } else {
            // TODO: Redirect to the main page based on type
        }
    ?>
</body>