<?php

/*session_start();

if(!isset($_SESSION['user'])) {
  header("Location: index.html");
  exit;
}
*/

$host = "localhost";
$username = "root";
$password = "";
$dbname = "aff";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM  session";
$stmt = $conn->prepare($sql);
if (!$stmt) {
  die("Prepare failed: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();
?>


<!DOCTYPE html>
<html>
<head>
  <style>
    
    /* Style pour la table */
    table {
      border-collapse: collapse;
      width: 100%;
    }
    
    th, td {
      text-align: left;
      padding: 8px;
      border-bottom: 1px solid #ddd;
    }
    
    th {
      background-color: #f2f2f2;
    }

    /* Responsive sur petits écrans */
    @media (max-width: 600px) {
      table {
        border: 0;
      }

      table caption {
        font-size: 1.3em;
      }
      
      table thead {
        border: none;
        clip: rect(0 0 0 0);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width: 1px;
      }
      
      table tr {
        border-bottom: 3px solid #ddd;
        display: block;
        margin-bottom: .625em;
      }
      
      table td {
        border-bottom: 1px solid #ddd;
        display: block;
        font-size: .8em;
        text-align: right;
      }
      
      table td::before {
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
      }
      
      table td:last-child {
        border-bottom: 0;
      }
    }
    footer {
      position: fixed;
      bottom: 0;
      left: 100;
      right: 0;
      height: 50px;  
      background: white;
    }
  </style>
</head>

<body>

<table>
<table> <caption><h1></h1></caption> 

<table>
  <tr>
    <th>Numéro</th>
    <th>date_session</th>
    <th>Jugement_rendu</th>
    <th>décision</th>
    <th>les_Phases</th>  
  </tr>

<?php while ($row = $result->fetch_assoc()): ?>

  <tr>
    <td><?php echo $row['Numéro']; ?></td>
    <td><?php echo $row['date_session']; ?></td>
    <td><?php echo $row['Jugement_rendu']; ?></td>
    <td><?php echo $row['décision']; ?></td>
    <td><?php echo $row['les_Phases']; ?></td>
    
  </tr>

<?php endwhile; ?>

</table>

  </tbody>


</table>
<?php 
$conn->close();
?>
<form action="" method="post">

</form>

</body>
</html>