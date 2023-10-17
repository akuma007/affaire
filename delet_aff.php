<?php
// Connectez-vous à la base de données
$conn = mysqli_connect("localhost", "root", "", "aff");

// Vérifiez si l'ID a été passé en tant que paramètre
if (isset($_GET['id_affaire'])) {
    $id_affaire = $_GET['id_affaire'];

    // Évitez les injections SQL en utilisant des requêtes préparées
    $query = "DELETE FROM affaire WHERE id_affaire = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_affaire); // Corrected variable name

    // Exécutez la requête
    if (mysqli_stmt_execute($stmt)) {
        echo "Enregistrement supprimé avec succès.";
    } else {
        echo "Erreur lors de la suppression de l'enregistrement : " . mysqli_error($conn);
    }

    // Fermez la connexion à la base de données
    mysqli_close($conn);
} else {
    echo "ID non spécifié.";
}
?>
