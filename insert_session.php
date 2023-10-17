<?php

session_start();

// Generate a random CSRF token and store in session
if(empty($_SESSION['csrf'])) {
  $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

$csrf_token = $_SESSION['csrf'];

// Connect to database
$db = new mysqli("localhost", "root", "", "aff");

// Initialize variables  
$numero = '';
$date_session = '';
$jugement_rendu = ''; 
$decision = '';
$les_phases = '';
$id_affaire = '';

// Validate CSRF token on form submit
if($_SERVER['REQUEST_METHOD'] === 'POST') {

  if(!isset($_POST['csrf']) || $_POST['csrf'] != $csrf_token) {
    die("CSRF attack detected"); 
  }

  // Sanitize inputs
  $numero = filter_input(INPUT_POST, 'Numéro', FILTER_SANITIZE_STRING);
  $date_session = filter_input(INPUT_POST, 'date_session', FILTER_SANITIZE_STRING);
  $jugement_rendu = filter_input(INPUT_POST, 'Jugement_rendu', FILTER_SANITIZE_STRING);
  $decision = filter_input(INPUT_POST, 'décision', FILTER_SANITIZE_STRING);
  $les_phases = filter_input(INPUT_POST, 'log', FILTER_SANITIZE_STRING);
  $id_affaire = filter_input(INPUT_POST, 'id_affaire', FILTER_SANITIZE_STRING);

  // Validate and process inputs

  // Prepare SQL statement
  $stmt = $db->prepare("INSERT INTO session (Numéro, date_session, jugement_rendu, décision, les_phases, id_affaire) VALUES (?, ?, ?, ?, ?, ?)");
  
  // Bind parameters and execute statement
  $stmt->bind_param("sssssi", $numero, $date_session, $jugement_rendu, $decision, $les_phases, $id_affaire);
  $stmt->execute();

  // Check for errors
  if($stmt->errno) {
    die("Insert failed: " . $stmt->error);
  }

  $stmt->close();

}

// Regenerate session ID
session_regenerate_id();

?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Session</title>
  <style>
    /* Style the form container */
form {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #f9f9f9;
}

/* Style form labels */
label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

/* Style form input fields */
input[type="text"],
input[type="email"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

/* Style the submit button */
button[type="submit"] {
  background-color: #007bff;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 3px;
  cursor: pointer;
}

/* Style the submit button on hover */
button[type="submit"]:hover {
  background-color: #0056b3;
}

/* Add some spacing between form elements */
.form-group {
  margin-bottom: 20px;
}

  </style>
</head>

<body>

<form method="post">

<input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>">
  
  <div>
  
  <div>
    <label>Numéro:</label>
    <input type="text" name="Numéro">
  </div>

  <div>
    <label>Date:</label>
    <input type="date" name="date_session">
  </div>

  <div>
    <label>Jugement rendu:</label>
    <input type="text" name="Jugement_rendu">
  </div>

  <div>
    <label>Décision:</label>
    <input type="text" name="décision">
  </div>
  <div>
    <label>id_affaire </label>
    <input type="text" name="id_affaire">
  </div>

  <div>
  <label>phases:</label>

  <select name="log">

  <?php

    $db = new mysqli('localhost', 'root', '', 'aff');

    $sql = "SELECT nom FROM log";

    $result = $db->query($sql);

    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['nom'] . '">'  . $row['nom'] . '</option>';  
      }

    } else {
      echo '<option>No phases found</option>';
    }

    $db->close();

  ?>

  </select>

</div>



  <button type="submit">Submit</button>

</form>

</body>
</html>
