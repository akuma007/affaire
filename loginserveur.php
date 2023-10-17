<?php

$host = "localhost";
$username = "root";
$password = "";  
$db = "aff";

$conn = mysqli_connect($host, $username, $password, $db);

if($_SERVER['REQUEST_METHOD'] == 'POST') {

  $user = $_POST['Num'];
  $pass = $_POST['mdp'];

  if(empty($user) || empty($pass)) {
    echo "Veuillez remplir tous les champs";
    exit;
  }

  // Hacher le mot de passe
  $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
  
  // Requête avec mot de passe haché  
  $sql = "SELECT * FROM login WHERE Num = '$user' AND mdp = '$hashed_pass'";

  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {

    // Générer un jeton CSRF aléatoire
    $csrf_token = bin2hex(random_bytes(32));
    
    // Démarrer la session 
    session_start();

    // Stocker jeton CSRF en session
    $_SESSION['csrf_token'] = $csrf_token;

    // Renouveler l'ID de session
    session_regenerate_id();

    // Expiration au bout de 5 min d'inactivité
    $_SESSION['expires_at'] = time() + 300; 
    if(mysqli_num_rows($result) > 0) {
      session_start();
      $_SESSION['user'] = $user;

    header("Location: acceuil.html");
    exit;

    }else {

    $error = "Identifiant ou mot de passe incorrect";

  }

} else {

  echo "<script>alert('Identifiant ou mot de passe incorrect');</script>";
  
  echo "<script>window.location.replace('acceuil.html');</script>";

}
}
?>