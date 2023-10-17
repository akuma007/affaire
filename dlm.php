<?php
// Connectez-vous à la base de données
$conn = mysqli_connect("localhost", "root", "", "aff");

// Vérifiez si l'ID a été passé en tant que paramètre
if (isset($_GET['numéro_avocat'])) {
    $numéro_avocat= $_GET['numéro_avocat'];

    // Évitez les injections SQL en utilisant des requêtes préparées
    $query = "DELETE FROM avocat WHERE numéro_avocat = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $numéro_avocat);

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