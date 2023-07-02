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

$email_rezerwacja = "";
$id_ogloszenia = "";
// Pobranie danych z formularza

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["zarezerwuj"])) {
        $email_rezerwacja = $_POST['email_rezerwacja'];
        $id_ogloszenia = $_POST['id_ogloszenia'];
        
        // Sprawdzenie, czy ogłoszenie jest już zarezerwowane
        $sql_check = "SELECT zarezerwowane FROM ogloszenia WHERE id = '$id_ogloszenia'";
        $result_check = $conn->query($sql_check);
        
        if ($result_check->num_rows > 0) {
            $row_check = $result_check->fetch_assoc();
            $zarezerwowane = $row_check['zarezerwowane'];
        
            if ($zarezerwowane == 1) {
                echo "<script>alert('To ogłoszenie jest już zarezerwowane.')</script>";
                header("Refresh:0.2; url=index.php");
                exit();
            }
            else{
                // Aktualizacja rekordu w bazie danych
                $sql = "UPDATE ogloszenia SET zarezerwowane = 1, mail_z = '$email_rezerwacja' WHERE id = '$id_ogloszenia'";
            }
        }
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Ogłoszenie zarezerwowane')</script>";
            header("Refresh:0.2; url=index.php"); 
        } else {
            echo "Błąd: " . $sql . "<br>" . $conn->error;
        }
    }
    
    $conn->close();
}
?>

    
    $conn->close();
}
?>
