<?php
include_once '../config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $articleID = $_POST['articleID'];
    $newRating = $_POST['newRating'];
    $userID = $_SESSION['userID']; // You should ensure that the user is logged in.

    // Initialize the database connection
    $pdo = config::getConnexion();

    // Check if a rating for this article and user already exists
    $existingRating = getRatingByArticleAndUser($pdo, $articleID, $userID);

    if ($existingRating) {
        // Update the existing rating
        $sql = "UPDATE rating SET note=:note WHERE id=:id";
        $params = [
            'note' => $newRating,
            'id' => $existingRating['id'],
        ];
    } else {
        // Create a new rating
        $sql = "INSERT INTO rating (note, articleID, userID) VALUES (:note, :articleID, :userID)";
        $params = [
            'note' => $newRating,
            'articleID' => $articleID,
            'userID' => $userID,
        ];
    }

    try {
        $query = $pdo->prepare($sql);
        $query->execute($params);

        // Return a success message if needed
        echo "Rating updated successfully";
    } catch (PDOException $e) {
        // Handle any errors here
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle non-POST requests here
    echo "Invalid request";
}

// Function to check if a rating already exists for the given article and user
function getRatingByArticleAndUser($pdo, $articleID, $userID) {
    $sql = "SELECT * FROM rating WHERE articleID = :articleID AND userID = :userID LIMIT 1";

    try {
        $query = $pdo->prepare($sql);
        $query->execute([
            'articleID' => $articleID,
            'userID' => $userID,
        ]);

        return $query->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle any errors here
        echo "Error: " . $e->getMessage();
        return false;
    }
}
?>
