<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
  $conn = new pdo("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  ));
  } catch(PDOException $pe){
      echo $pe->getMessage();
  }

//$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

$req = $_GET["country"];

$stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$req%'");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//echo $req;
//echo $results;

/*
if ($c == ""){
  $stmt = $conn->query("SELECT * FROM countries");
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  echo $results
}*/


?>
<ul>
<?php foreach ($results as $row): ?>
  <li><?= $row['name'] ; ?></li>
<?php endforeach; ?>
</ul>
