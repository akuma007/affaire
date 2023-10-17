<?php
// Get id_affaire
$id_affaire = $_GET['id'];

// Validate id
if (!is_numeric($id_affaire)) {
  echo "Invalid ID";
  exit;
}

// Database connection
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'aff';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  echo "Error: Failed to connect to database";
  exit;
}

// Affaire query
$sql = "SELECT * FROM affaire WHERE id_affaire=?";
$stmt1 = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt1, "i", $id_affaire);
mysqli_stmt_execute($stmt1);
$result1 = mysqli_stmt_get_result($stmt1);

// Session query
$sql2 = "SELECT * FROM session WHERE id_affaire=?";
$stmt2 = mysqli_prepare($conn, $sql2);
mysqli_stmt_bind_param($stmt2, "i", $id_affaire);
mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);

// Display results
?>

<!DOCTYPE html>
<html>
<head>
  <title>Affaire & Session Details</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    h1 {
      font-size: 24px;
      margin-bottom: 20px;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }

    table, th, td {
      border: 1px solid #ccc;
    }

    th, td {
      padding: 8px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    tr:hover {
      background-color: #f5f5f5;
    }

    a {
      text-decoration: none;
      font-weight: bold;
      color: #007BFF;
      display: block;
      margin-top: 20px;
    }

    a:hover {
      color: #0056b3;
    }
  </style>
</head>
<body>

<h1>Affaire Details</h1>

<table>
  <tr>
    <th>ID</th>
    <th>Numéro</th>
    <th>Date</th>
    <th>Nom</th>
    <th>Tribunal</th>
    <th>Avocat</th>
    <th>Demandeur</th>
    <th>Défendeur</th>
  </tr>

  <?php while ($row1 = mysqli_fetch_assoc($result1)): ?>
    <tr>
      <td><?php echo isset($row1['id_affaire']) ? $row1['id_affaire'] : ''; ?></td>
      <td><?php echo isset($row1['numéro_affaire']) ? $row1['numéro_affaire'] : ''; ?></td>
      <td><?php echo isset($row1['date_affaire']) ? $row1['date_affaire'] : ''; ?></td>
      <td><?php echo isset($row1['nom_affaire']) ? $row1['nom_affaire'] : ''; ?></td>
      <td><?php echo isset($row1['tribunal']) ? $row1['tribunal'] : ''; ?></td>
      <td><?php echo isset($row1['avocat_affaire']) ? $row1['avocat_affaire'] : ''; ?></td>
      <td><?php echo isset($row1['demandeur']) ? $row1['demandeur'] : ''; ?></td>
      <td><?php echo isset($row1['défendeur']) ? $row1['défendeur'] : ''; ?></td>
    </tr>
  <?php endwhile; ?>

</table>

<h1>Session Details</h1>

<table>
  <tr>
    <th>Numéro</th>
    <th>Date</th>
    <th>Jugement</th>
    <th>Décision</th>
    <th>Phases</th>
  </tr>

  <?php while ($row2 = mysqli_fetch_assoc($result2)): ?>
    <tr>
      <td><?php echo isset($row2['numéro']) ? $row2['numéro'] : ''; ?></td>
      <td><?php echo isset($row2['date_session']) ? $row2['date_session'] : ''; ?></td>
      <td><?php echo isset($row2['jugement_rendu']) ? $row2['jugement_rendu'] : ''; ?></td>
      <td><?php echo isset($row2['décision']) ? $row2['décision'] : ''; ?></td>
      <td><?php echo isset($row2['les_phases']) ? $row2['les_phases'] : ''; ?></td>
    </tr>
  <?php endwhile; ?>

</table>

<a href="affaire.php">Back to Affaires</a>

</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>
