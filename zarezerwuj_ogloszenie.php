<?php
// Połączenie z bazą danych (takie same dane jak w poprzednim kodzie)
$servername = "mysql.agh.edu.pl";
$username = "ogadomsk";
$password = "3RGHN8eemi1oFupB";
$dbname = "ogadomsk";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Nieudane połączenie z bazą danych: " . $conn->connect_error);
}

// Pobranie danych z formularza
$email_rezerwacja = $_POST['email_rezerwacja'];
$id_ogloszenia = $_POST['id_ogloszenia'];

// Aktualizacja rekordu w bazie danych
$sql = "UPDATE ogloszenia SET zarezerwowane = '$email_rezerwacja' WHERE id = '$id_ogloszenia'";

if ($conn->query($sql) === TRUE) {
    echo "Ogłoszenie zarezerwowane.";
} else {
    echo "Błąd: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
