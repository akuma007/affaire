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
        $sql = "INSERT INTO avocat (numéro_avocat, nom_avocat, identifiant_fiscal_avocat, 
                 spécialité_avocat, téléphone_fixe, téléphone_mobile, adresse_bureau, email)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        // Check statement 
        if (!$stmt) {
            die("Prepare failed: " . $db->error);
        }

        $numéro_avocat = $_POST['numero_avocat'];
        $nom_avocat = $_POST['nom_avocat'];
        $identifiant_fiscal_avocat = $_POST['identifiant_fiscal_avocat'];
        $spécialité_avocat = $_POST['specialite_avocat'];
        $téléphone_fixe = $_POST['telephone_fixe'];
        $téléphone_mobile = $_POST['telephone_mobile'];
        $adresse_bureau = $_POST['adresse_bureau'];
        $email = $_POST['email'];

        // Bind parameters
        $stmt->bind_param('ssssssss',
            $numéro_avocat,
            $nom_avocat,
            $identifiant_fiscal_avocat,
            $spécialité_avocat,
            $téléphone_fixe,
            $téléphone_mobile,
            $adresse_bureau,
            $email
        );

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

    <label>رقم المحامي</label>
<input type="text" name="numero_avocat">

<label>اسم المحامي</label>
<input type="text" name="nom_avocat">

<label>الرقم الضريبي للمحامي</label>
<input type="text" name="identifiant_fiscal_avocat">

<label>تخصص المحامي</label>
<input type="text" name="specialite_avocat">

<label>الهاتف الثابت للمحامي</label>
<input type="text" name="telephone_fixe">

<label>الهاتف المحمول للمحامي</label>
<input type="text" name="telephone_mobile">

<label>عنوان مكتب المحامي</label>
<input type="text" name="adresse_bureau">

<label>البريد الإلكتروني للمحامي</label>
<input type="email" name="email">

<button type="submit">إرسال</button>

  </form>
</body>
</html>
