<?php
session_start();

// Generate a random CSRF token if it doesn't exist in the session
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32)); // Generate a 32-byte random token
}

// Check if the form is submitted
if (isset($_POST['submit'])) { // Assuming you have a "submit" button with name="submit"
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
        $sql = "INSERT INTO tribunal (id_tribunal, nom_tribunal, type_tribunal, adresse_tribunal, compétence_tribunal, phase_de_retroaction)
                 VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        // Check statement 
        if (!$stmt) {
            die("Prepare failed: " . $db->error);
        }

        $id_tribunal = $_POST['id_tribunal'];
        $nom_tribunal = $_POST['nom_tribunal'];
        $type_tribunal = $_POST['type_tribunal'];
        $adresse_tribunal = $_POST['adresse_tribunal'];
        $compétence_tribunal = $_POST['compétence_tribunal'];
        $phase_de_retroaction = $_POST['phase_de_retroaction'];

        // Bind parameters
        $stmt->bind_param('ssssss',
            $id_tribunal,
            $nom_tribunal,
            $type_tribunal,
            $adresse_tribunal,
            $compétence_tribunal,
            $phase_de_retroaction
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
    
    <label>ID المحكمة</label>
    <input type="text" name="id_tribunal">

    <label>اسم المحكمة</label>
    <input type="text" name="nom_tribunal">

    <label>نوع المحكمة</label>
    <input type="text" name="type_tribunal">

    <label>عنوان المحكمة</label>
    <input type="text" name="adresse_tribunal">

    <label>اختصاص المحكمة</label>
    <input type="text" name="compétence_tribunal">

    <label>مرحلة التغذية الراجعة</label>
    <input type="text" name="phase_de_retroaction">

    <button type="submit" name="submit">إرسال</button>
  </form>
</body>
</html>
