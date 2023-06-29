<!DOCTYPE html>
<html>
    <head>
        <title>Tablica ogłoszeń</title>
        <link rel="stylesheet" type="text/css" href="styl.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Caprasimo&family=Raleway:wght@300&display=swap" rel="stylesheet">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Pobierz dane pogodowe z API OpenWeatherMap
            $.ajax({
                url: 'https://api.openweathermap.org/data/2.5/weather?q=Krakow&appid=f25f1ccf7c5c6ee011862ff6fe043a51&units=metric',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Przetwórz i wyświetl dane pogodowe
                    var temperatura = data.main.temp;
                    var opis = data.weather[0].description;
                    var ikona = 'https://openweathermap.org/img/w/' + data.weather[0].icon + '.png';
                    var pogodaHTML = '<h2>Aktualna pogoda w Krakowie</h2>' +
                                     '<p>Temperatura: ' + temperatura + '°C</p>' +
                                     '<p>Opis: ' + opis + '</p>' +
                                     '<img src="' + ikona + '" alt="Pogoda">';
                    $('#pogoda').html(pogodaHTML);
                },
                error: function() {
                    $('#pogoda').html('Nie można pobrać danych pogodowych.');
                }
            });
        });
    </script>


    </head>
<body>
<body>
<div class="container">
    <div class="header">
        <img src="img\logomaker.png" alt="Logo" class="logo" height="120px">
        <h1>Oddam za darmo - Kraków</h1>
    </div>

    <div class="form-box">
        <form method="POST" action="dodaj_ogloszenie.php" enctype="multipart/form-data">
            <h2>Dodaj nowe ogłoszenie</h2>
            <label for="email">Twój e-mail:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="lokalizacja">Lokalizacja:</label>
            <input type="text" id="lokalizacja" name="lokalizacja" required><br>

            <label for="tresc">Treść ogłoszenia:</label>
            <textarea id="tresc" name="tresc" required></textarea><br>

            <label for="przedmiot">Nazwa Przedmiotu:</label>
            <input type="text" id="przedmiot" name="przedmiot" required><br>

            <label for="zdjecie">Zdjęcie:</label>
            <input type="file" id="zdjecie" name="zdjecie"><br>

            <input type="submit" name="submit" value="Dodaj ogłoszenie">
        </form>

        <form method="POST" action="zarezerwuj_ogloszenie.php">
            <h2>Zarezerwuj ogłoszenie</h2>
            <label for="email_rezerwacja">Twój e-mail:</label>
            <input type="email" id="email_rezerwacja" name="email_rezerwacja" required><br>

            <label for="id_ogloszenia">ID ogłoszenia:</label>
            <input type="text" id="id_ogloszenia" name="id_ogloszenia" required><br>

            <input type="submit" value="Zarezerwuj" name="zarezerwuj">
        </form>
    </div>

    <div class="posty">
        <h2>Aktualne Ogłoszenia</h2>
        <?php
        // Połączenie z bazą danych
        $servername = "mysql.agh.edu.pl";
        $username = "ogadomsk";
        $password = "3RGHN8eemi1oFupB";
        $dbname = "ogadomsk";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            echo "Nieudane połączenie z bazą danych: " . $conn->connect_error;
        }

        // Pobranie ogłoszeń z bazy danych
        $sql = "SELECT * FROM ogloszenia";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $reserved = $row["zarezerwowane"] == 0 ? "Nie" : "Tak";
                $zdj = $row["zdjecie"];
                $postClass = $row["zarezerwowane"] == 0 ? "" : "reserved";

                echo "<div class='post $postClass'>";
                echo "<div class='post-content'>";
                echo "<div class='image-container'>";
                echo "<a href='zdjecia/$zdj' target='_blank'>";
                echo "<img src='zdjecia/$zdj' alt='Zdjęcie' class='post-image'>";
                echo "</a>";
                echo "</div>";
                echo "<div class='post-text'>";
                echo "<h2>ID: " . $row["ID"] . " - " . $row["przedmiot"] . "</h2>";
                echo "<p>" . $row["tresc"] . "</p>";
                echo "<p>Lokalizacja: " . $row["lokalizacja"] . "</p>";
                echo "<p>Data: " . $row["data"] . "</p>";
                echo "<p class='reserved'>Zarezerwowane: " . $reserved . "</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                

            }
        } else {
            echo "Brak ogłoszeń.";
        }

        $conn->close();
        ?>
    </div>

    <div class="footer">
        <p>®KrkOgl, 2023 All Rights Reserved</p>
        <a href="img\Regulamin.pdf" download>  Regulamin</a>
    </div>

</body>
</html>
