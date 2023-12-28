<!DOCTYPE html>
<html lang="en">
    <head>
    </head>
</head>

<body>
    <?php
        $type=$_POST['tipoUtente'];
        if ($type == "studente") {
            header("Location: ../webpages/signup-studente.html");
            exit();
        } elseif ($type == "docente") {
            header("Location: ../webpages/signup-docente.html");
            exit();
        }
    ?>
</body>