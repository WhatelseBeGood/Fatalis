<?php

// connexion à la base de données MySQL
require_once('config/config.php');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// vérification des données de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = $_POST["username"];
	$password = $_POST["password"];
	$sql = "SELECT * FROM users WHERE matricule='$username' AND password='$password'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) == 1) {
		// authentification réussie
		session_start();
		$_SESSION['loggedin'] = true;
		$_SESSION["username"] = $username;
		header("location: welcome.php");
		exit();
	} else {
		// authentification échouée
		echo $username; echo $password;
		$error = "Nom d'utilisateur ou mot de passe incorrect.";
	}
}

// fermeture de la connexion MySQL
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Page de connexion</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="script.js"></script>
</head>
<body>
	<form id="login-form" method="POST" action="login.php">
		<h2>Connexion</h2>
		<label for="username">Nom d'utilisateur:</label>
		<input type="text" id="username" name="username" required>
		<label for="password">Mot de passe:</label>
		<input type="password" id="password" name="password" required>
		<input type="submit" value="Se connecter">
		<?php if (isset($error)) { ?>
			<p class="error"><?php echo $error; ?></p>
		<?php } ?>
	</form>
</body>
</html>