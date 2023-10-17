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

$sql = "SELECT * FROM avocat";
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
<script>
        function openForm() {
            window.open('insert_avocat.php');
        }

        
    // JavaScript
function supprimer(id) {

if(confirm("Voulez-vous vraiment supprimer cet enregistrement?")) {

  var xhr = new XMLHttpRequest();
  xhr.open("GET", "dlm.php?numéro_avocat=" + id);

  xhr.onload = function() {
    if(xhr.status === 200) { 
       alert("Enregistrement supprimé!");
       location.reload();
    }
    else {
       alert("Une erreur s'est produite!");  
    }
  }

  xhr.send();

}

}
    
</script>
    </script>

<table>
  <caption><h1>Liste des avocats</h1></caption>
  <thead>
  <tr>
    <th >id_avocat</th>
    <th >numero_avocat</th>
    <th >nom_avocat</th>
    <th >identifiant_fiscal_avocat</th>
    <th>specialite_avocat</th>
    <th >telephone_fixe</th>
    <th >telephone_mobile</th>    
    <th >adresse_bureau</th>
    <th >email</th>
   
  </tr>
  </thead>


  <tbody>
   
<?php
while($row = $result->fetch_assoc()) {

    echo "<tr>";
  
   
    echo "<td>" . $row['id_avocat'] . "</td>"; 
    echo "<td>" . $row['numéro_avocat'] . "</td>";
    echo "<td>" . $row['nom_avocat'] . "</td>";
    echo "<td>" . $row['identifiant_fiscal_avocat'] . "</td>";
    echo "<td>" . $row['spécialité_avocat'] . "</td>";
    echo "<td>" . $row['téléphone_fixe'] . "</td>";
    echo "<td>" . $row['téléphone_mobile'] . "</td>";
    echo "<td>" . $row['adresse_bureau'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td><button onclick='supprimer(" . $row['numéro_avocat'] . ")'>Supprimer</button></td>";
    echo "</tr>";
  
  }
    ?>

  </tbody>


</table>
<?php 
$conn->close();
?>
<form action="" method="post">

<footer>
        <button onclick="openForm()">Ajouter</button>
    </footer>
</form>

</body>
</html>