<?php
// Start der Sitzung
session_start();

// Überprüfung, ob der Benutzer bereits angemeldet ist
if(isset($_SESSION['username'])){
  header("Location: willkommensseite.php");
  exit();
}

// Überprüfung des Login-Vorgangs
if(isset($_POST['login'])){
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Überprüfung der Benutzerdaten mit der externen Datei 'Nutzerdatenspeicherung.txt'
  $user_data = file_get_contents('Nutzerdatenspeicherung.txt');
  $users = unserialize($user_data);

  if(isset($users[$username]) && $users[$username]['password'] == $password){
    $_SESSION['username'] = $username;
    header("Location: willkommensseite.php");
    exit();
  } else {
    echo "Ungültiger Benutzername oder Passwort";
  }
}

// Registrierungsvorgang
if(isset($_POST['registrieren'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $email = $_POST['email'];

  // Überprüfen, ob der Benutzername bereits existiert
  $user_data = file_get_contents('Nutzerdatenspeicherung.txt');
  $users = unserialize($user_data);

  if(isset($users[$username])){
    echo "Benutzername existiert bereits";
  } else {
    // Hinzufügen des neuen Benutzers zur Nutzerdatenspeicherung
    $users[$username] = array('password' => $password, 'email' => $email);
    file_put_contents('Nutzerdatenspeicherung.txt', serialize($users));
    echo "Registrierung erfolgreich";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Anmeldeseite</title>
</head>
<body>
  <h2>Login</h2>
  <form method="POST" action="">
    <input type="text" name="username" placeholder="Benutzername" required><br>
    <input type="password" name="password" placeholder="Passwort" required><br>
    <input type="submit" name="login" value="Login">
  </form>

  <h2>Registrierung</h2>
  <form method="POST" action="">
    <input type="text" name="username" placeholder="Benutzername" required><br>
    <input type="password" name="password" placeholder="Passwort" required><br>
    <input type="email" name="email" placeholder="E-Mail-Adresse" required><br>
    <input type="submit" name="registrieren" value="Registrieren">
  </form>
</body>
</html>