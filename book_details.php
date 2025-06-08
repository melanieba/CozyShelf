<?php
include 'db_connect.php';

$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['progress'])) {
    $newProgress = intval($_POST['progress']);
    $stmt = $conn->prepare("UPDATE Book SET current_progress = ? WHERE book_id = ?");
    $stmt->bind_param("ii", $newProgress, $book_id);
    $stmt->execute();
    $stmt->close();
}

$stmt = $conn->prepare("SELECT * FROM Book WHERE book_id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Book Details - CozyShelf</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .book-detail-container {
      max-width: 800px;
      margin: auto;
      background-color: #fff9e6;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .book-detail-container img {
      width: 200px;
      float: left;
      margin-right: 20px;
    }

    .book-detail-container h2 {
      margin-top: 0;
    }

    .book-progress {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <h1>Book Details</h1>
  <div class="book-detail-container">
    <?php if ($book): ?>
      <img src="<?= htmlspecialchars($book['book_cover']) ?>" alt="Book Cover">
      <h2><?= htmlspecialchars($book['book_title']) ?></h2>
      <p><strong>Author:</strong> <?= htmlspecialchars($book['author_first_name'] . ' ' . $book['author_last_name']) ?></p>
      <p><strong>Description:</strong> <?= htmlspecialchars($book['book_description']) ?></p>
      <p><strong>Rating:</strong> <?= $book['book_rating'] ?>/5</p>
      <p><strong>Progress:</strong> <?= $book['current_progress'] ?>/<?= $book['page_count'] ?> pages</p>

      <form method="POST" class="book-progress">
        <label for="progress">Update your progress:</label>
        <input type="number" name="progress" id="progress" value="<?= $book['current_progress'] ?>" min="0" max="<?= $book['page_count'] ?>">
        <button class="button" type="submit">Update</button>
      </form>
    <?php else: ?>
      <p>Book not found.</p>
    <?php endif; ?>
  </div>
</body>
</html>