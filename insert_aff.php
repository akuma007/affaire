<?php
session_start(); // Start or resume the session

// Generate a random CSRF token if it doesn't exist in the session
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32)); // Generate a 32-byte random token
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check that the submitted CSRF token matches the one stored in the session
    if (isset($_POST['csrf']) && $_POST['csrf'] === $_SESSION['csrf']) {
        // CSRF token is valid; process the form

        // Connect to database
        $db = new mysqli('localhost', 'root', '', 'aff');

        // Check connection
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        // Prepare statement 
        $sql = "INSERT INTO affaire (id_affaire, numéro_affaire, Date_affaire, Nom_affaire, Tribunal, Avocat_affaire, demandeur, Défendeur)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        // Check statement
        if (!$stmt) {
            die("Prepare failed: " . $db->error);
        }

        // Bind parameters
        $id_affaire = $_POST['id_affaire'];
        $numéro_affaire = $_POST['numéro_affaire'];
        if(isset($_POST['Date_affaire'])) {
          $Date_affaire = $_POST['Date_affaire']; 
        }
      
        $Nom_affaire = $_POST['Nom_affaire'];
        $Tribunal = $_POST['Tribunal'];
        $Avocat_affaire = $_POST['Avocat_affaire'];
        $demandeur = $_POST['demandeur'];
        $Défendeur = $_POST['Défendeur'];

        $stmt->bind_param('ssssssss',
            $id_affaire,
            $numéro_affaire,
            $Date_affaire,
            $Nom_affaire,
            $Tribunal,
            $Avocat_affaire,
            $demandeur,
            $Défendeur
        );;

// Execute statement
if (!$stmt->execute()) {
die("Insert failed: " . $stmt->error);
}

// Close statement
$stmt->close();


        // Close connection
        $db->close();
    } else {
        // CSRF token validation failed; handle the error
        die("CSRF token validation failed");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>ajouter</title>
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

    <label>id_affaire</label>
    <input type="text" name="id_affaire" required>

    <label>numéro_affaire</label>
    <input type="text" name="numéro_affaire" required>

    <label>Date_affaire</label>
    <input type="text" name="Date_affaire" required>

    <label>Nom_affaire</label>
    <input type="text" name="Nom_affaire" required>

    <label>Tribunal</label>
    <input type="text" name="Tribunal" required>

    <label>Avocat_affaire</label>
    <input type="text" name="Avocat_affaire" required>

    <label>demandeur</label>
    <input type="text" name="demandeur" required>

    <label>Défendeur</label>
    <input type="text" name="Défendeur" required>>

    <button type="submit">إرسال</button>
</form>

  </form>
</body>
</html>
