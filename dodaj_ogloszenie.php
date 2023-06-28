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
$email = "";
$lokalizacja = "";
$tresc = "";
$data = ""; // Aktualna data
$przedmiot = "";
$zdjecie = "";
$sciezka_zdjecia = "";
$nazwa_zdjecia= "";
$mail_z = "";

if ($_SERVER["REQUEST_METHOD"] === 'POST'){
    if (isset($_POST["submit"])) {
        $email = $_POST["email"];
        $lokalizacja = $_POST["lokalizacja"];
        $tresc = $_POST["tresc"];
        $data = date("Y-m-d");
        $przedmiot = $_POST["przedmiot"];
        $zdjecie = $_FILES["zdjecie"];
        $zdjecie_tmp = $zdjecie["tmp_name"];
        $mail_z = "Nie zarezerwowano";

        // Sprawdzenie czy zostało przesłane zdjęcie
        if (!empty($zdjecie_tmp)) {
            // Katalog, w którym zostanie zapisane zdjęcie
            $katalog = "zdjecia/";
            // Generowanie unikalnej nazwy pliku na podstawie timestampa
            $nazwa_zdjecia = time() . "_" . $zdjecie["name"];
            // Ścieżka do pliku
            $sciezka_zdjecia = $katalog . $nazwa_zdjecia;
        
            // Przeniesienie przesłanego pliku do docelowego katalogu
            move_uploaded_file($zdjecie_tmp, $sciezka_zdjecia);
        } else {
            $sciezka_zdjecia = ""; // Jeśli nie ma przesłanego zdjęcia, przypisz pusty string
        }

        // Dodanie ogłoszenia do bazy danych
        
        $sql = "INSERT INTO ogloszenia (mail, data, lokalizacja, tresc, przedmiot, zdjecie, mail_z) VALUES ('$email', '$data', '$lokalizacja', '$tresc', '$przedmiot', '$nazwa_zdjecia', '$mail_z')";


        if ($conn->query($sql) === TRUE) {
            echo "Ogłoszenie dodane.";
        } else {
            echo "Błąd: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
}

?>
