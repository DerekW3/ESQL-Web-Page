<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    require_once __DIR__ . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $db_host = getenv('DB_HOST');
    $db_name = getenv('DB_NAME');
    $db_username = getenv('DB_USERNAME');
    $db_password = getenv('DB_PASSWORD');
    ?>
</body>

</html>