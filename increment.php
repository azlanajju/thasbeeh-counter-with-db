<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "ajax");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (isset($_SESSION['UniqueId'])) {
        $UniqueId = $_SESSION['UniqueId'];

        // Get the current Thasbeeh_count from the database
        $query = "SELECT Thasbeeh_count FROM Thasbeeh WHERE UniqueId = '$UniqueId'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $currentLikes = $row['Thasbeeh_count'];

            // Increment the Thasbeeh_count
            $newLikes = $currentLikes + 1;

            // Update the Thasbeeh_count in the database
            $updateQuery = "UPDATE Thasbeeh SET Thasbeeh_count = $newLikes WHERE UniqueId = '$UniqueId'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                // Return the updated Thasbeeh_count
                echo $newLikes;
            } else {
                echo "Error updating Thasbeeh count";
            }
        } else {
            echo "Error retrieving Thasbeeh count";
        }
    } else {
        echo "User not logged in.";
    }
}

mysqli_close($conn);
?>
