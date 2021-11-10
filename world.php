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

<style>
table {
  font-family: Verdana;
  color: #0E103D;
  border-collapse: collapse;
  border: 2px solid #0E103D;
  margin-left: auto;
  margin-right: auto;
}

th {
  border: 2px solid #0E103D;
  padding: 10px;
  text-align: left;
}

#th1 { 
  background-color: #A5668B;
  color: #F2D7EE;
}

#th2 { 
  background-color: #69306D;
  color: #F2D7EE;
}

td {
  color: #0E103D;
  border-bottom: 1px solid #0E103D;
  padding-left: 10px;
  padding-right: 10px;
}
</style>

<!-- displaying the table for countries -->
<?php if (!isset($_GET["context"]))  { ?>
  <table id="country_table">
    <thead id="th1">
      <th style="width: 250px;">Name</th>
      <th>Continent</th>
      <th  style="text-align: center;">Independence Year</th>
      <th> Head of State</th>
    </thead>
    <tbody>
      <?php foreach ($results as $row): ?>
      <tr>
        <td><?= $row['name'] ; ?></td>
        <td><?= $row['continent'] ; ?></td>
        <td style="text-align: center;"><?= $row['independence_year'] ; ?></td>
        <td><?= $row['head_of_state'] ; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php } ?>

  <!-- displaying the table for cities -->
  <?php if (isset($_GET["context"]))  { ?>
  <table id="city_table">
    <thead id="th2">
      <th style="width: 200px;">Name</th>
      <th>District</th>
      <th style="text-align: center">Population</th>
    </thead>
    <tbody>
      <?php foreach ($results as $row): ?>
      <tr>
        <td><?= $row['name'] ; ?></td>
        <td><?= $row['district'] ; ?></td>
        <td style="text-align: center;"><?= $row['population'] ; ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php } ?>