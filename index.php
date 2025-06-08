
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
  <a class="button" href="#left"> {number} Stars</a>
  <a class="button" onclick="window.location.href='goalOverview.html'">Goal Overview</a>
</div>

<div class="bookshelf-container">
  <div class="bookshelf">
    <div class="books">
    <?php
      include 'db_connect.php';

      $conn = connect();

      $sql = "SELECT * FROM Book";
      $result = $conn->query($sql);

      if ($result->num_rows == 0) {
        echo "<H1>No books on your shelf</H1>";
      } else {
        while ($row = $result->fetch_assoc()) {

          // need to find a good one
          $cover_placeholder_url = 'https://bookstoreromanceday.org/wp-content/uploads/2020/08/book-cover-placeholder.png';
          
          $cover_url = $row['book_cover'];

          if (is_null($cover_url) or empty($cover_url)) {
            $cover_url = $cover_placeholder_url;
          }

          ?>

            <a class="book" href="show_book.php?book_id=<?= $row['book_id']?>"
                style="background-image: url('<?= $cover_url; ?>');"></a>

          <?php
        }
      }

      disconnect($conn);
    ?>

          <!-- // these are all field we can use
          // <td>{$row['book_id']}</td>
          // <td>{$row['book_title']}</td>
          // <td>{$row['author_last_name']}</td>
          // <td>{$row['author_first_name']}</td>
          // <td><img src='{$row['book_cover']}' width='50' /></td>
          // <td>{$row['page_count']}</td>
          // <td>{$row['book_rating']}</td>
          // <td>{$row['current_progress']}</td>
          // <td>{$row['book_description']}</td> -->
   
      <!-- link will be replaced with details page of the book -->
      <!-- image will be replaced with the data pulled from the database -->
      <!-- <a class="book" href="https://www.goodreads.com/book/show/50214741" target="_blank"
         style="background-image: url('https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1581128232l/50214741.jpg');"></a>
      <a class="book" href="https://www.goodreads.com/book/show/42505366" target="_blank"
         style="background-image: url('https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1544204706l/42505366.jpg');"></a>
      <a class="book" href="https://www.goodreads.com/book/show/42201395" target="_blank"
         style="background-image: url('https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1541621322l/42201395.jpg');"></a>
      <a class="book" href="https://www.goodreads.com/book/show/43263520" target="_blank"
         style="background-image: url('https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1548518877l/43263520._SY475_.jpg');"></a> -->
    </div>
  </div>
</div>

<div class="center-container">
  <a class="button" onclick="window.location.href='newBookForm.html'">Add New Book</a>
</div>


</body>
</html>