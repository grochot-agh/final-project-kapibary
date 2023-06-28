<!DOCTYPE html>
<html>
    <head>
        <title>Tablica ogłoszeń</title>
        <link rel="stylesheet" type="text/css" href="styl.css">
        <style>

        th {
            height: 20px;
            font-weight: bold;
            font-size: 1.2em;
        }

        tr {
            height: 80px;
        }

        td {
            text-align: center;
            font-size: 1em;
        }
    </style>
    </head>
<body>
<div class="posty">
    <h1>Wszystkie Ogłoszenia</h1>
<?php
    // Połączenie z bazą danych
    $servername = "mysql.agh.edu.pl";
    $username = "ogadomsk";
    $password = "3RGHN8eemi1oFupB";
    $dbname = "ogadomsk";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        div("Nieudane połączenie z bazą danych: " . $conn->connect_error);
    }

    // Pobranie ogłoszeń z bazy danych
    $sql = "SELECT * FROM ogloszenia";
    $result = $conn->query($sql);
    $reserved = "";
    $zdj = "";
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Zdjecie</th><th>Przedmiot</th><th>Treść</th><th>Lokalizacja</th><th>Data</th><th>Zarezerwowane?</th></tr>";

        while ($row = $result->fetch_assoc()) {
            if ($row["zarezerwowane"] == 0) {
                $reserved = "Nie";
            } else {
                $reserved = "Tak";
            }

            $zdj = $row["zdjecie"];

            echo "<tr>";
            echo "<td>" . $row["ID"] . "</td>";
            echo "<td><a href=\"zdjecia/$zdj\" target=\"_blank\"><img src=\"zdjecia/$zdj\" width=\"60\" height=\"60\"></a></td>\n";
            echo "<td>" . $row["przedmiot"] . "</td>";
            echo "<td>" . $row["tresc"] . "</td>";
            echo "<td>" . $row["lokalizacja"] . "</td>";
            echo "<td>" . $row["data"] . "</td>";
            echo "<td>" . $reserved . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Brak ogłoszeń.";
    }

    $conn->close();
    ?>
    </div>
</body>
</html>
