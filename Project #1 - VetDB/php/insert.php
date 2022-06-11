<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>ADD NEW PET</title>
</head>
<body>
    <h3>MENU</h3>

    <br><br>
    <a href="insert.php"><button id="update-btn">ADD NEW PET</button></a>
    <a href="update.php"><button>UPDATE PET</button></a>
    <a href="../index.php"><button>ALL PETS</button></a>
    <a href="retrieve.php"><button>FIND PET</button></a>
    <a href="delete.php"><button>DELETE PET</button></a>
    <br><br>

    <form action="../php/insert.php" method="post">
        <h4>NEW PET DETAILS</h4>
        <div class="container">
            <label for="petName">Pet Name:</label>
            <br>
            <input type="text" name="petName" id="petName" required>
            <br>
            <label for="petSpecies">Pet Species:</label>
            <br>
            <input type="text" name="petSpecies" id="petSpecies" required>
        </div>
        <div class="container">
            <label for="petWeight">Pet Weight (kg):</label>
            <br>
            <input type="number" name="petWeight" id="petWeight" required>
            <br>
            <label for="petAilment">Pet Ailment:</label>
            <br>
            <input type="text" name="petAilment" id="petAilment" required>
        </div>

        <h4>OWNER DETAILS</h4>
        <div class="container">
            <label for="ownerFirstName">Owner First Name:</label>
            <br>
            <input type="text" name="ownerFirstName" id="ownerFirstName" required>
            <br>
            <label for="ownerLastName">Owner Last Name:</label>
            <br>
            <input type="text" name="ownerLastName" id="ownerLastName" required>
            <br>
            <label for="ownerPhone">Owner Phone Number:</label>
            <br>
            <input type="tel" name="ownerPhone" id="ownerPhone" placeholder="10 digit number" pattern="[0-9]{10}" required>
            <br>
            <label for="street">Street:</label>
            <br>
            <input type="text" name="street" id="street" required>
        </div>
        <div class="container">
            <label for="city">City:</label>
            <br>
            <input type="text" name="city" id="city" required>
            <br>
            <label for="county">County:</label>
            <br>
            <input type="text" name="county" id="county" required>
            <br>
            <label for="country">Country:</label>
            <br>
            <input type="text" name="country" id="country" required>
            <br>
            <label for="postCode">Post Code:</label>
            <br>
            <input type="text" name="postCode" id="postCode" required>
        </div>

        <?php
            $conn = mysqli_connect("localhost", "root", "", "vet_clinic_db");
            
            if ($conn === false) {
                die("ERROR: Could not connect..."
                .mysqli_connect_error());
            }
            
            try {
                $sql = "SELECT * FROM vet";
                $result = mysqli_query($conn, $sql);
    
                if(mysqli_num_rows($result) != 0) {
                    echo "<h4>CHOOSE AVAILABLE VET</h4>";
                    echo "<select name='availableVet' id='availableVet'>";
                    while($row = mysqli_fetch_array($result)) {
                        echo "<option>" . $row['VetFirstName'] . " " . $row['VetLastName'] . "</option>";
                    }
                    echo "</select>";
                    echo "<input name='submit' type='submit' value='SUBMIT' id='input-btn'>";
                } else {
                    echo "<h3>Sorry, all vets are currently busy.</h3>";
                }
            } catch (Exception) {
                echo "<h3>Something went wrong - Ensure that all tables were created correctly</h3>";
            }
        ?>
    </form>
    
    <?php
        if (isset($_POST['submit'])) {
            $petName = $_REQUEST['petName'];
            $petSpecies = $_REQUEST['petSpecies'];
            $petWeight = $_REQUEST['petWeight'];
            $petAilment = $_REQUEST['petAilment'];
    
            $ownerFirstName = $_REQUEST['ownerFirstName'];
            $ownerLastName = $_REQUEST['ownerLastName'];
            $ownerPhone = $_REQUEST['ownerPhone'];
            $street = $_REQUEST['street'];
            $city = $_REQUEST['city'];
            $county = $_REQUEST['county'];
            $country = $_REQUEST['country'];
            $postCode = $_REQUEST['postCode'];

            $availableVet = $_REQUEST['availableVet'];
            $availableVet = explode(" ", $availableVet);
            
            try {
                $sqlFindVet = "SELECT VetID FROM vet 
                        WHERE VetFirstName = '$availableVet[0]' AND VetLastName = '$availableVet[1]'";
                $sqlFindVet = mysqli_query($conn, $sqlFindVet);
                $vetID = mysqli_fetch_array($sqlFindVet);

                $sqlAddress = "INSERT INTO addresses (Street, City, County, Country, PostCode)  
                        VALUES ('$street', '$city', '$county', '$country', '$postCode')";
                mysqli_query($conn, $sqlAddress);
                $addressID = mysqli_insert_id($conn);

                $sqlOwner = "INSERT INTO pet_owner (OwnerFirstName, OwnerLastName, OwnerPhone, AddressID)  
                        VALUES ('$ownerFirstName', '$ownerLastName', '$ownerPhone', '$addressID')";
                mysqli_query($conn, $sqlOwner);
                $ownerID = mysqli_insert_id($conn);
                
                $sqlPet = "INSERT INTO pet (PetName, PetSpecies, PetWeight, PetAilment, OwnerID, VetID)  
                        VALUES ('$petName', '$petSpecies', '$petWeight', '$petAilment', '$ownerID', '$vetID[0]')";
                mysqli_query($conn, $sqlPet);
                
                echo "<h3>Pet information was stored successfully!</h3>";
            } catch (Exception) {
                echo "<h3>Something went wrong - Ensure that all tables were created correctly</h3>";
            }
            
            mysqli_close($conn);
        }
    ?>
</body>
</html>