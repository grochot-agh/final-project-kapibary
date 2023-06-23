<?php
// Połączenie z bazą danych (takie same dane jak w poprzednim kodzie)
$servername = "localhost";
$username = "ogadomsk";
$password = "3RGHN8eemi1oFupB";
$dbname = "ogadomsk";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Nieudane połączenie z bazą danych: " . $conn->connect_error);
}

// Pobranie danych z formularza
$email = $_POST['email'];
$lokalizacja = $_POST['lokalizacja'];
$tresc = $_POST['tresc'];
$data = date("Y-m-d"); // Aktualna data

// Dodanie ogłoszenia do bazy danych
$sql = "INSERT INTO ogloszenia (mail, data, lokalizacja, tresc) VALUES ('$email', '$data', '$lokalizacja', '$tresc')";

if ($conn->query($sql) === TRUE) {
    echo "Ogłoszenie dodane.";
} else {
    echo "Błąd: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
