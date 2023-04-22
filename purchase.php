<head>
    <h1>Purchase page</h1>
    <link rel="stylesheet" href="style.css">
</head>

<form method="post" action="">
    <label for="bookID">BookID:</label>
    <input type="text" id="bookID" name="bookID"><br><br>
    <label for="numCopies">Number of copies:</label>
    <input type="text" id="numCopies" name="numCopies"><br><br>
    <label for="customerName">Customer Name:</label>
    <input type="text" id="customerName" name="customerName"><br><br>
    <input type="submit" value="Submit">
</form>
<!-- Add this button wherever you want it on your page -->
<button onclick="goBack()">Go Back</button>

<script>
// This function takes the user back to the previous page
function goBack() {
  window.history.back();
}
</script>
<?php
require_once 'db_connect.php';

if (isset($_POST['bookID']) && isset($_POST['numCopies']) && isset($_POST['customerName'])) {
    $bookID = $_POST['bookID'];
    $numCopies = $_POST['numCopies'];
    $customerName = $_POST['customerName'];
    $purchaseDate = date('Y-m-d');

    $query = "SELECT No_Of_Copies FROM Copies WHERE BookID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $bookID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        die("Error: BookID not found");
    }

    $availableCopies = $row['No_Of_Copies'];

    if ($numCopies > $availableCopies) {
        echo "Error: Requested number of copies is more than the available copies.";
    } else {
        $newNumCopies = $availableCopies - $numCopies;
        $query = "UPDATE Copies SET No_Of_Copies = ? WHERE BookID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ii', $newNumCopies, $bookID);

        if (!mysqli_stmt_execute($stmt)) {
            die("Error: " . mysqli_error($conn));
        } else {
            $insert_query = "INSERT INTO Purchases (Customer_Name, BookID, Purchase_Date, Count) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($stmt, 'sisi', $customerName, $bookID, $purchaseDate, $numCopies);

            if (!mysqli_stmt_execute($stmt)) {
                die("Error: " . mysqli_error($conn));
            } else {
                echo "Number of copies updated successfully and purchase record added to database!";
            }
        }
    }
}
mysqli_close($conn);
?>
