<!-- this is page to add a new book to database and update notes and progress -->
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['progress'])) {
    $newProgress = intval($_POST['progress']);
    $updateStmt = $conn->prepare("UPDATE Book SET current_progress = ? WHERE book_id = ?");
    $updateStmt->bind_param("ii", $newProgress, $_GET["book_id"]);
    $updateStmt->execute();
    $updateStmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['note_content']) && !empty(trim($_POST['note_content']))) {
    $note = trim($_POST['note_content']);
    $noteStmt = $conn->prepare("INSERT INTO Note (note_date, note_time, note_content, book_id) VALUES (CURDATE(), CURTIME(), ?, ?)");
    $noteStmt->bind_param("si", $note, $_GET["book_id"]);
    $noteStmt->execute();
    $noteStmt->close();
}

$noteQuery = $conn->prepare("SELECT note_date, note_time, note_content FROM Note WHERE book_id = ? ORDER BY note_date DESC, note_time DESC");
$noteQuery->bind_param("i", $_GET["book_id"]);
$noteQuery->execute();
$notesResult = $noteQuery->get_result();
        $sql = "SELECT * FROM Book where book_id=" . htmlspecialchars($_GET["book_id"]);

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
          // Fetch the first row as an associative array
          $row = $result->fetch_assoc();

  ?>

  <div>
    Title: <label type="text"><?= $row['book_title']?></label><br>
    Author: <label type="text"><?= $row['author_first_name']?></label>&nbsp;<label type="text"><?= $row['author_last_name']?></label><br>
<p><strong>Rating:</strong> <?= htmlspecialchars($row['book_rating']) ?>/5</p>
<p><strong>Progress:</strong> <?= htmlspecialchars($row['current_progress']) ?>/<?= htmlspecialchars($row['page_count']) ?> pages</p>

<form method="POST" class="book-progress">
  <label for="progress">Update your progress:</label>
  <input type="number" name="progress" id="progress"
         value="<?= htmlspecialchars($row['current_progress']) ?>"
         min="0" max="<?= htmlspecialchars($row['page_count']) ?>">
  <button class="button" type="submit">Update</button>
</form>

<div class="book-notes">
  <h2>Notes</h2>
  <form method="POST">
    <label for="note_content">Add a note:</label>
    <textarea name="note_content" id="note_content" placeholder="Write your thoughts..."></textarea>
    <button class="button" type="submit">Add Note</button>
  </form>

  <?php while ($note = $notesResult->fetch_assoc()): ?>
    <div class="note">
      <div class="note-date"><?= htmlspecialchars($note['note_date']) ?> <?= htmlspecialchars($note['note_time']) ?></div>
      <div><?= htmlspecialchars($note['note_content']) ?></div>
    </div>
  <?php endwhile; ?>
</div>
$row['author_last_name']?></label><br>
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