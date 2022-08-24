<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>UPDATE PET</title>
</head>
<body>
    <h3>MENU</h3>

    <br><br>
    <a href="insert.php"><button>ADD NEW PET</button></a>
    <a href="update.php"><button id="update-btn">UPDATE PET</button></a>
    <a href="../index.php"><button>ALL PETS</button></a>
    <a href="retrieve.php"><button>FIND PET</button></a>
    <a href="delete.php"><button>DELETE PET</button></a>
    <br><br>
    
    <form action="../php/update.php" method="post">
        <h4>UPDATE EXISTING PET DETAILS</h4>
        <div class="container2">
            <label for="petID">Pet ID to Update:</label>
            <br>
            <input type="number" name="petID" id="petID" placeholder="Integers only" min="0" max="999" required>
            <br>
            <label for="petName">New Pet Name:</label>
            <br>
            <input type="text" name="petName" id="petName" required>
            <br>
            <label for="petSpecies">New Pet Species:</label>
            <br>
            <input type="text" name="petSpecies" id="petSpecies" required>
            <br>
            <label for="petWeight">New Pet Weight (kg):</label>
            <br>
            <input type="number" name="petWeight" id="petWeight" required>
            <br>
            <label for="petAilment">New Pet Ailment:</label>
            <br>
            <input type="text" name="petAilment" id="petAilment" required>
        </div>
        <input name='submit' type='submit' value='SUBMIT' id='input-btn'> 
    </form>

    <?php
        if (isset($_POST['submit'])) {
            $conn = mysqli_connect("localhost", "root", "", "vet_clinic_db");
                
            if ($conn === false) {
                die("ERROR: Could not connect..."
                .mysqli_connect_error());
            }
            
            $petID = $_REQUEST['petID'];
            $petName = $_REQUEST['petName'];
            $petSpecies = $_REQUEST['petSpecies'];
            $petWeight = $_REQUEST['petWeight'];
            $petAilment = $_REQUEST['petAilment'];

            try {
                $sql_check = "SELECT * FROM pet WHERE PetID = '$petID'";
                $result_check = mysqli_query($conn, $sql_check);
    
                if(mysqli_num_rows($result_check) != 0) {
                    $sql_update =  "UPDATE pet SET PetName = '$petName', PetSpecies = '$petSpecies',
                                    PetWeight = '$petWeight', PetAilment = '$petAilment'
                                    WHERE PetID = '$petID'";
                    mysqli_query($conn, $sql_update);
                    echo "<h3>Pet information updated successfully!</h3>";
                } else {
                    echo "<h3>No pet with this Pet ID.</h3>";
                }
            } catch (Exception) {
                echo "<h3>Something went wrong - Ensure that all tables were created correctly</h3>";
            }

            mysqli_close($conn);
        }
    ?>
</body>
</html>