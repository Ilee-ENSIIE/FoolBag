<?php

try {
    $user = 'tp_web';
    $pass = 'tp_web';
    $dbh = new PDO('pgsql:host=localhost;dbname=tp_web', $user, $pass);

    $tableRows = [];
    foreach ($dbh->query("select '✓ postgres connection' as test;") as $row) {
        $tableRows[] = $row[0];
    }
    foreach ($dbh->query("select whatever from test;") as $row) {
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
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
</head>    
<body>
    
<div class="container">
    <h3><?php echo 'Hello world from Cloud9! php' . PHP_VERSION; ?></h3>

    <table class="table table-bordered table-hover table-striped">
        <thead>
            <tr>
                <th>Something</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tableRows as $row) : ?>
                <tr>
                    <td><?php echo $row ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
</div>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>