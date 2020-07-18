<?php
// Ustawiamy odpowiedni nagłówek dla kodowania treści
header("Content-Type: text/html; charset=UTF-8");
// Rozpoczynamy sesję
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['login'])) {
        // można dodatkowo wyświetlić odpowiedni komunikat jeżeli hasło jest puste
        $pass = $_POST['pass'] ?? null;
        $admin_hash = require_once 'haslo.php';
        // możemy nadpisać tablicę samym hasłem
        $admin_hash = array_key_exists('pass', $admin_hash) ? $admin_hash['pass'] : null;
        if (!empty($pass) && password_verify($pass, $admin_hash)) {
            $_SESSION['admin'] = true;
           
        } else {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  			<strong>Zle haslo!</strong> Zaloguj ponownie.
  			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    			<span aria-hidden="true">&times;</span>
  			</button>	
		</div>';
        }
    } elseif (isset($_POST['logout'])) {
        $_SESSION['admin'] = false;
        session_regenerate_id();
    }
}
// tutaj umieścimy kod sprawdzający

// sprawdzamy czy użytkownik jest zalogowany (true), lub zwracamy false
$is_admin = $_SESSION['admin'] ?? false;
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"/>
    <title>Podaj dane logowania</title>
</head>
<body>
    <main>
	<div class="container-lg">
	<div class="card">
		<div class="card-header">
    			Featured
  		</div>
        <?php if (!$is_admin): ?>
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Zaloguj</button>
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
    			<div class="modal-content">
      				<div class="modal-header">
        				<h5 class="modal-title" id="exampleModalLabel">New message</h5>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          					<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
      				<div class="modal-body">	
        				<p>Aby kontynuować musisz podać hasło:</p>
        				<form action="" method="POST">
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">Recipient:</label>
            						<input class="form-control" name="pass" type="password" placeholder="Podaj hasło"/>
						</div>
        				
				</div>
				<div class="modal-footer">
        					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        					<button name="login" type="submit" class="btn btn-primary">Zaloguj</button>
					</form>
      				</div>	
			</div>
		</div>

    <?php else: ?>
        <form action="" method="POST">
		<button name="logout" class="btn btn-dangeer" type="submit">Wyloguj</button>
        </form>
    <?php endif; ?>

	   
