<!DOCTYPE html>
<html>
    <head>
        <title>Tablica ogłoszeń</title>
        <link rel="stylesheet" type="text/css" href="styl.css">
    </head>
<body>
    <h1>Tablica ogłoszeń - Oddam za darmo - Kraków</h1>

    <?php
    // Połączenie z bazą danych
    $servername = "mysql.agh.edu.pl";
    $username = "ogadomsk";
    $password = "3RGHN8eemi1oFupB";
    $dbname = "ogadomsk";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Nieudane połączenie z bazą danych: " . $conn->connect_error);
    }

    // Pobranie ogłoszeń z bazy danych
    $sql = "SELECT * FROM ogloszenia";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Data</th><th>Lokalizacja</th><th>Treść</th><th>Zarezerwowane</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["data"] . "</td>";
            echo "<td>" . $row["lokalizacja"] . "</td>";
            echo "<td>" . $row["tresc"] . "</td>";
            echo "<td>" . $row["zarezerwowane"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Brak ogłoszeń.";
    }

    $conn->close();
    ?>

    <h2>Dodaj nowe ogłoszenie</h2>
    <form method="POST" action="dodaj_ogloszenie.php">
        <label for="email">Twój e-mail:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="lokalizacja">Lokalizacja:</label>
        <input type="text" id="lokalizacja" name="lokalizacja" required><br>

        <label for="tresc">Treść ogłoszenia:</label>
        <textarea id="tresc" name="tresc" required></textarea><br>

        <label for="zdjecie">Zdjęcie:</label>
        <input type="file" id="zdjecie" name="zdjecie"><br>

        <input type="submit" value="Dodaj ogłoszenie">
    </form>

    <h2>Zarezerwuj ogłoszenie</h2>
    <form method="POST" action="zarezerwuj_ogloszenie.php">
        <label for="email_rezerwacja">Twój e-mail:</label>
        <input type="email" id="email_rezerwacja" name="email_rezerwacja" required><br>

        <label for="id_ogloszenia">ID ogłoszenia:</label>
        <input type="text" id="id_ogloszenia" name="id_ogloszenia" required><br>

        <input type="submit" value="Zarezerwuj">
    </form>

    <div class="posty">
        <?php
        // ...
        while ($row = $result->fetch_assoc()) {
            echo '<div class="post">';
            echo '<div class="post-data">' . $row["data"] . '</div>';
            echo '<div class="post-lokalizacja">' . $row["lokalizacja"] . '</div>';
            echo '<div class="post-tresc">' . $row["tresc"] . '</div>';
            echo '<div class="post-zdjecie"><img src="' . $row["zdjecie"] . '" alt="Zdjęcie ogłoszenia"></div>';
            echo '<div class="post-zarezerwowane">' . $row["zarezerwowane"] . '</div>';
            echo '</div>';
        }
        ?>
    </div>
    
</body>
</html>
