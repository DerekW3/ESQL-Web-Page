<?php
    session_start()
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="../styles/student-homepage.css">
</head>
<body>
    <div class="greeting"><?php echo("Ciao, " . $_COOKIE['name']); ?></div>
    <div class="content">
        <div class="selection">Messaggi</div>
        <div class="selection">Esami</div>
    </div>
</body>
</html>