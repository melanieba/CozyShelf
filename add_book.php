<?php
$servername = "cssql.seattleu.edu";
$username = "sr_group7";
$password = "fYuxf+6dZhaAzLao";
$dbname = "sr_group7";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

echo "Connection successfully";

// get input from form
$title = $_POST['title'];
$author = $_POST['author']; 
$cover = $_POST['cover'] ?? '';
$genre = $_POST['genre'] ?? ''; 
$page_count = isset($_POST['page-count']) && is_numeric($_POST['page-count']) ? (int)$_POST['page-count'] : 0;

// split author name into first and last name
$parts = explode(" ", trim($author));
$first_name = array_shift($parts);
$last_name = implode(" ", $parts);

// placeholder values
$current_progress = 0;
// $book_description = "No description yet.";
// $book_rating = NULL;
// $book_description = NULL;

$sql = "INSERT INTO Book (book_title, author_first_name, author_last_name, book_cover, genre, page_count, current_progress) 
VALUES ('$title', '$first_name', '$last_name', '$cover', '$genre', $page_count, $current_progress)";

echo $sql;

if (mysqli_query($conn, $sql)) {
    echo "Book added successfully!";
    header('Location: index.php');
  } else {
    echo "Error: " . mysqli_error($conn);
}
  
mysqli_close($conn);
?>