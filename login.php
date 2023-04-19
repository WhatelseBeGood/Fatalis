<?php
// connexion à la base de données MySQL
$servername = "localhost";
$config->username = "";
$config->password = "";
$config->dbname = "";

if (file_exists(__DIR__ . 'config.local.php')) {
	require_once(__DIR__ . 'config.local.php');

$conn = mysqli_connect($servername, $username, $password, $dbname);


}

// vérification des données de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = $_POST["username"];
	$password = $_POST["password"];
	$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) == 1) {
		// authentification réussie
		session_start();
		$_SESSION["username"] = $username;
		header("location: welcome.php");
		exit();
	} else {
		// authentification échouée
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
