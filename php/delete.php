<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>DELETE PET</title>
</head>
<body>
    <h3>MENU</h3>

    <br><br>
    <a href="insert.php"><button>ADD NEW PET</button></a>
    <a href="update.php"><button>UPDATE PET</button></a>
    <a href="../index.php"><button>ALL PETS</button></a>
    <a href="retrieve.php"><button>FIND PET</button></a>
    <a href="delete.php"><button id="update-btn">DELETE PET</button></a>
    <br><br>
    
    <form action="../php/delete.php" method="post">
        <h4>DELETE PET FROM THE DATABASE</h4>
        <div class="container2">
            <label for="deletePet">Remove Pet record using Pet ID:</label>
            <input type="number" name="deletePet" id="deletePet" placeholder="Integers only" min="0" max="999" required>
            <input name='submit' type='submit' value='SUBMIT' id='input-btn'>
        </div>
    </form>

    <?php
        if (isset($_POST['submit'])) {
            $conn = mysqli_connect("localhost", "root", "", "vet_clinic_db");
                
            if ($conn === false) {
                die("ERROR: Could not connect..."
                .mysqli_connect_error());
            }
            
            $deletePet = $_REQUEST['deletePet'];
            
            try {
                $sql_check = "SELECT * FROM pet WHERE PetID = $deletePet";
                $result_check = mysqli_query($conn, $sql_check);
    
                if(mysqli_num_rows($result_check) != 0) {
                    $sql_delete =  "DELETE FROM pet
                                    WHERE PetID = $deletePet";
                    mysqli_query($conn, $sql_delete);
                    echo "<h3>Pet information was deleted successfully!</h3>";
                } else {
                    echo "<h3>No pet with this Pet ID.</h3>";
                }
            } catch(Exception) {
                echo "<h3>Something went wrong - Ensure that all tables were created correctly</h3>";
            }

            mysqli_close($conn);
        }
    ?>
</body>
</html>