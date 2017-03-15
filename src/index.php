<?php
require_once(__DIR__ . '/../vendor/autoload.php');
use Something\Example;

// test the autoloader
$example = new Example();

// test the database connection
try {
    $user = 'tp_web';
    $pass = 'tp_web';
    $dbh = new PDO('pgsql:host=localhost;dbname=tp_web', $user, $pass);

    $tableRows = [];
    foreach ($dbh->query("select whatever from test limit 10;") as $row) {
        $tableRows[] = $row[0];
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
<html>
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>    
<body>
    
    <div class="container">
        <h3><?php echo 'Hello world from Cloud9! php' . PHP_VERSION; ?></h3>
    
        <table class="table table-bordered table-hover table-striped">
            <?php foreach ($tableRows as $row) : ?>
                <tr>
                    <td><?php echo $row ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>