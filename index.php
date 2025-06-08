<?php
include 'db_connect.php';
$result = $conn->query("SELECT book_id, book_title, book_cover FROM Book");
?>

<!DOCTYPE html>
<html>
<head>
  <title>CozyShelf</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .books {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 30px;
      margin-top: -20px;
    }
  </style>
</head>
<body>

<h1>CozyShelf</h1>

<div class="container">
  <a class="button" href="#left"> {number} Stars</a>
  <a class="button" href="#right">Goal Overview</a>
</div>

<div class="bookshelf-container">
  <div class="bookshelf">
    <div class="books">
      <?php while ($row = $result->fetch_assoc()): ?>
        <a class="book"
           href="book-details.php?id=<?= $row['book_id'] ?>"
           style="background-image: url('<?= htmlspecialchars($row['book_cover']) ?>');"
           title="<?= htmlspecialchars($row['book_title']) ?>">
        </a>
      <?php endwhile; ?>
    </div>
  </div>
</div>

<div class="center-container">
  <a class="button" href="newBookForm.html">Add New Book</a>
</div>

</body>
</html>