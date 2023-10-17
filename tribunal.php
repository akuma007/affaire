<?php

session_start();
/*
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

$sql = "SELECT * FROM tribunal";
$stmt = $conn->prepare("SELECT * FROM tribunal");
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
  border-collapse: collapse;
}

td {
  border: 1px solid #ccc;
  padding: 5px; 
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
            window.open('insert_tribunal.php');
        }

        function supprimer(id) {
  console.log("Clicked Supprimer button with id:", id); // Debugging statement
  if (confirm("Voulez-vous vraiment supprimer cet enregistrement?")) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "delet_trib.php?id_tribunal=" + id);

    xhr.onload = function() {
      console.log("XHR status:", xhr.status); // Debugging statement
      if (xhr.status === 200) {
        alert("Enregistrement supprimé!");
        location.reload();
      } else {
        alert("Une erreur s'est produite!");
      }
    };

    xhr.send();
  }
}

      
    </script>
  

<table>
  <caption><h1>قائمة المحاكم</h1></caption>
  <thead>
  <tr>
  <th>رقم المحكمة</th> 
  <th>اسم المحكمة</th>
  <th>نوع المحكمة</th>
  <th>عنوان المحكمة</th>
  <th>اختصاص المحكمة</th>  
</tr>
  </thead>


  <tbody>
   
<?php
while($row = $result->fetch_assoc()) {
 
  echo "<tr>";
  echo "<td>" . $row['id_tribunal'] . "</td>";
  echo "<td>" . $row['nom_tribunal'] . "</td>";
  echo "<td>" . $row['type_tribunal'] . "</td>";
  echo "<td>" . $row['adresse_tribunal'] . "</td>";
  echo "<td>" . $row['compétence_tribunal'] . "</td>";
  echo "<td><button onclick='supprimer(" . $row['id_tribunal'] . ")'>Supprimer</button></td>";
 echo "</tr>";
}
    ?>

  </tbody>


</table>
<?php 
$conn->close();
?>
<footer>
   <button onclick="openForm()">Ajouter</button>
</footer>
</body>
</html>