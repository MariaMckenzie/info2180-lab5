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

if (!isset($_GET["context"])) {
  $stmt = $conn->prepare("SELECT * FROM countries WHERE name LIKE '%$req%'");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else {
  $stmt = $conn->prepare("SELECT cities.name, cities.district, cities.population FROM cities JOIN countries ON cities.country_code=countries.code WHERE countries.name LIKE '%$req%';");
  $stmt->execute();
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!-- displaying the table for countries -->
<?php if (!isset($_GET["context"]))  { ?>
  <table id="country_table">
    <thead>
      <th>Name</th>
      <th>Continent</th>
      <th>Independence Year</th>
      <th> Head of State</th>
    </thead>
    <tbody>
      <?php foreach ($results as $row): ?>
      <tr>
        <td><?= $row['name'] ; ?></td>
        <td><?= $row['continent'] ; ?></td>
        <td><?= $row['independence_year'] ; ?></td>
        <td><?= $row['head_of_state'] ; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php } ?>

  <!-- displaying the table for cities -->
  <?php if (isset($_GET["context"]))  { ?>
  <table id="city_table">
    <thead>
      <th>Name</th>
      <th>District</th>
      <th>Population</th>
    </thead>
    <tbody>
      <?php foreach ($results as $row): ?>
      <tr>
        <td><?= $row['name'] ; ?></td>
        <td><?= $row['district'] ; ?></td>
        <td><?= $row['population'] ; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php } ?>