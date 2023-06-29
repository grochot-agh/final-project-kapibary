<!DOCTYPE html>
<html>
<head>
    <title>Tablica ogłoszeń</title>
    <link rel="stylesheet" type="text/css" href="styl.css">
    <style>
        /* Styl CSS */


        .post {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .post h2 {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .post p {
            font-size: 1.2em;
            margin-bottom: 5px;
        }

        .image-container {
            overflow: hidden;
            width: 100px; /* lub dowolna inna wartość szerokości, jeśli chcesz ustawić maksymalną szerokość kontenera obrazka */
            height: 100px; /* lub dowolna inna wartość wysokości, jeśli chcesz ustawić maksymalną wysokość kontenera obrazka */
        }


        .post .reserved {
            color: red;
            font-weight: bold;
        }

        .post-content {
            display: flex;
            align-items: center;
        }

        .post-image {
            max-width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }

        .post-image:hover {
            transform: scale(1.2);
        }

        .image-container {
            width: 150px; /* lub dowolna inna wartość szerokości, jeśli chcesz ustawić stałą szerokość obrazka */
            height: 150px; /* lub dowolna inna wartość wysokości, jeśli chcesz ustawić stałą wysokość obrazka */
            margin-right: 10px;
        }

        .post-text {
            flex: 1;
        }

        .container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
        margin-right: 10px;
        }
  


    </style>
</head>
<body>
    <div class="container">
        <div class="header">
          <img src="img\logomaker.png" alt="Logo" class="logo" height=100px>
          <h1>Oddam za darmo - Kraków</h1>
        </div>

    <div class="posty">
        <h1>Aktualne Ogłoszenia</h1>
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
                echo "<h2>" . $row["przedmiot"] . "</h2>";
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
</body>
</html>
