
<!-- this is the landing page -->
<!DOCTYPE html>
<html>
  <head>
    <title>CozyShelf</title>
    <link rel="stylesheet" href="styles.css">
  </head>
<body>

<h1>CozyShelf</h1>

<div class="container">
  <a class="button"> 36 Stars</a>
  <a class="button" onclick="window.location.href='goalOverview.html'">Goal Overview</a>
</div>

<div class="bookshelf-container">
  <?php
    include 'db_connect.php';
    $conn = connect();

    $sql = "SELECT * FROM Book";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
      echo "<h2>No books on your shelf</h2>";
    } else {
      $cover_placeholder_url = 'https://bookstoreromanceday.org/wp-content/uploads/2020/08/book-cover-placeholder.png';
      $count = 0;
      $books_per_row = 4;

      while ($row = $result->fetch_assoc()) {
        if ($count % $books_per_row == 0) {
        // Start new shelf row
        echo '<div class="bookshelf"><div class="books">';
      }

        $cover_url = !empty($row['book_cover']) ? $row['book_cover'] : $cover_placeholder_url;
        $book_id = htmlspecialchars($row['book_id']);
        $safe_cover_url = htmlspecialchars($cover_url);

        echo "<a class='book' href='show_book.php?book_id={$book_id}' style='background-image: url(\"{$safe_cover_url}\");'></a>";
          
        $count++;

        if ($count % $books_per_row == 0) {
          // Close full shelf row
          echo '</div></div>';
        }

      }
      if ($count % $books_per_row != 0) {
        // Close an incomplete last row
        echo '</div></div>';
      }
      
    }

    disconnect($conn);
  ?>
</div>

<div class="center-container">
  <a class="button" onclick="window.location.href='newBookForm.html'">Add New Book</a>
</div>


</body>
</html>