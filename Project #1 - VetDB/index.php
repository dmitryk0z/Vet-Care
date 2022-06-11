<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>VetClinic Records</title>
</head>
<body>
    <h3>MENU</h3>

    <br><br>
    <a href="php/insert.php"><button>ADD NEW PET</button></a>
    <a href="php/update.php"><button>UPDATE PET</button></a>
    <a href="index.php"><button id="all-btn">ALL PETS</button></a>
    <a href="php/retrieve.php"><button>FIND PET</button></a>
    <a href="php/delete.php"><button>DELETE PET</button></a>
    <br><br><br><br>

    <?php
        $conn = mysqli_connect("localhost", "root", "", "vet_clinic_db");

        if ($conn === false) {
            die("ERROR: Could not connect..."
            .mysqli_connect_error());
        }
        
        try {
            $sql = "SELECT PetID, PetName, PetSpecies, PetWeight,
            PetAilment, pet_owner.OwnerFirstName, pet_owner.OwnerLastName,
            vet.VetFirstName, vet.VetLastName
            FROM pet
            JOIN vet
            ON pet.VetID = vet.VetID
            JOIN pet_owner
            ON pet.OwnerID = pet_owner.OwnerID";
            $result = mysqli_query($conn, $sql);

            if(mysqli_num_rows($result) != 0) {
                echo
                "<table id='records_table'>
                <tr>
                <th>Pet ID</th>
                <th>Pet Name</th>
                <th>Pet Species</th>
                <th>Pet Weight</th>
                <th>Pet Ailment</th>
                <th>Owner Name</th>
                <th>Vet Name</th>
                </tr>";
                while($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['PetID'] . "</td>";
                    echo "<td>" . $row['PetName'] . "</td>";
                    echo "<td>" . $row['PetSpecies'] . "</td>";
                    echo "<td>" . $row['PetWeight'] . "</td>";
                    echo "<td>" . $row['PetAilment'] . "</td>";
                    echo "<td>" . $row['OwnerFirstName'] . " " . $row['OwnerLastName'] . "</td>";
                    echo "<td>" . $row['VetFirstName'] . " " . $row['VetLastName'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<h3>No pet records found in the Database!</h3>";
            }
        } catch (Exception) {
            echo "<h3>Something went wrong - Ensure that all tables were created correctly</h3>";
        }

        mysqli_close($conn);
    ?>
</body>
</html>