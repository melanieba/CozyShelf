<!-- this is page to add a new book to database -->
<!DOCTYPE html>
<html>
  <head>
    <title>CozyShelf</title>
    <link rel="stylesheet" href="styles.css">
  </head>
<body>

<h1>CozyShelf</h1>

<div class="container">
  <a class="button" onclick="window.location.href='index.php'"> Back</a>
  <!-- <a class="button" href="#right">Goal Overview</a> -->
</div>

<!-- needs to be abstracted for database retrieval -->
<div class="form-container">
  <h2>Book details</h2>

  <?php 
        include 'db_connect.php';

        $conn = connect();

        $sql = "SELECT * FROM Book where book_id=" . htmlspecialchars($_GET["book_id"]);

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          // Fetch the first row as an associative array
          $row = $result->fetch_assoc();

  ?>

  <div>
    Title: <label type="text"><?= $row['book_title']?></label><br>
    Author: <label type="text"><?= $row['author_first_name']?></label>&nbsp;<label type="text"><?= $row['author_last_name']?></label><br>
    Genre: <label type="text"><?= $row['genre']?></label><br>
    Cover: <img type="text" class="book-cover" src="<?= $row['book_cover']?>"><br>
    Page Count: <label type="number"><?= $row['page_count']?></label><br>

    <br>
    <br>
    <br>

    
  </div>

  <?php 
          $result->free();
        } else {
            echo "No results found or query failed.";
        }

    disconnect($conn);
  ?>
  

</div>

</body>
</html>