<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si l'utilisateur n'est pas connecté, redirigez-le vers la page login.php
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome</title>
	<style>
		.tab {
			display: none;
		}
		.active {
			display: block;
		}
	</style>
	<script>
		function openTab(evt, tabName) {
			var i, tabcontent, tablinks;
			tabcontent = document.getElementsByClassName("tab");
			for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
			}
			tablinks = document.getElementsByClassName("tablink");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			}
			document.getElementById(tabName).style.display = "block";
			evt.currentTarget.className += " active";
		}
	</script>
</head>
<body>
	<h1>Welcome</h1>
	<div>
		<button class="tablink active" onclick="openTab(event, 'users')">Utilisateurs</button>
		<button class="tablink" onclick="openTab(event, 'reports')">Rapports</button>
	</div>
	<div id="users" class="tab active">
		<?php include('users.php'); ?>
	</div>
	<div id="reports" class="tab">
		<?php include('rapports.php'); ?>
	</div>
</body>
</html>