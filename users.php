<?php
require_once 'config/config.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs soumises
    $matricule = $_POST['matricule'];
    $password = generateRandomPassword();
    $grade = $_POST['grade'];

    // Connexion à la base de données
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Vérifier si la connexion est réussie
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Préparer la requête SQL pour insérer l'utilisateur dans la table des utilisateurs
    $sql = "INSERT INTO users (matricule, password, grade) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $matricule, $password, $grade);
    $stmt->execute();

    // Vérifier si l'insertion a réussi
    if ($stmt->affected_rows > 0) {
        echo "L'utilisateur a été ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur.";
    }

    // Fermer la connexion à la base de données
    $stmt->close();
    $conn->close();
}

// Générer un mot de passe aléatoire de 16 caractères
function generateRandomPassword() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $password = '';
    for ($i = 0; $i < 16; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $password .= $characters[$index];
    }
    return $password;
}
?>

<form method="post" action="users.php">
    <label for="matricule">Matricule :</label>
    <input type="text" id="matricule" name="matricule"><br>

    <label for="grade">Grade :</label>
    <input type="number" id="grade" name="grade" min="0" max="9"><br>

    <button type="submit">Ajouter l'utilisateur</button>
</form>