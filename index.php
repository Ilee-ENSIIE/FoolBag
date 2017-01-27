<html><body>
<?php
// A simple web site in Cloud9 that runs through Apache
// Press the 'Run' button on the top to start the web server,
// then click the URL that is emitted to the Output tab of the console

echo 'Hello world from Cloud9!<br/>';
echo 'Your PHP version is ' . PHP_VERSION . '<br/>';

try {
    $user = 'tp_web';
    $pass = 'tp_web';
    $dbh = new PDO('pgsql:host=localhost;dbname=tp_web', $user, $pass);
    foreach($dbh->query("select '✓ postgres connection' as test;") as $row) {
        echo $row[0] . '<br/>';
    }
    foreach($dbh->query("select count(*) from test;") as $row) {
        echo $row[0] . ' items in the test table<br/>';
    }
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
</body>
</html>