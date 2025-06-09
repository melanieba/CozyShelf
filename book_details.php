<?php
include 'db_connect.php';

$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle progress update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['progress'])) {
    $newProgress = intval($_POST['progress']);
    $stmt = $conn->prepare("UPDATE Book SET current_progress = ? WHERE book_id = ?");
    $stmt->bind_param("ii", $newProgress, $book_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch book details
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
    body {
      background-color: #f3e2b0;
      font-family: 'Georgia';
      color: #333333;
    }

    h1 {
      color: #273E47;
      font-size: 36px;
      text-align: center;
    }

    h2 {
      color: #273E47;
      font-size: 24px;
      margin-top: 20px;
    }

    .book-detail-container {
      max-width: 800px;
      margin: 30px auto;
      background-color: #fff9e6;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: row;
      gap: 30px;
    }

    .book-detail-container img {
      width: 200px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .book-info {
      flex: 1;
    }

    .book-progress {
      margin-top: 20px;
    }

    label {
      font-weight: bold;
      color: #273E47;
      display: block;
      margin-bottom: 6px;
    }

    input[type="number"] {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      width: 100%;
      max-width: 200px;
    }

    .button {
      background-color: #D8973C;
      border-radius: 25px;
      border: 2px solid #D8973C;
      padding: 10px 20px;
      font-size: 18px;
      color: #273E47;
      text-align: center;
      margin-top: 10px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
    }

    .button:hover {
      background-color: #c58533;
    }
  </style>
</head>
<body>

<h1>Book Details</h1>

<?php if ($book): ?>
  <div class="book-detail-container">
    <img src="<?= htmlspecialchars($book['book_cover']) ?>" alt="Book Cover">
    <div class="book-info">
      <h2><?= htmlspecialchars($book['book_title']) ?></h2>
      <p><strong>Author:</strong> <?= htmlspecialchars($book['author_first_name'] . ' ' . $book['author_last_name']) ?></p>
      <p><strong>Description:</strong> <?= htmlspecialchars($book['book_description']) ?></p>
      <p><strong>Rating:</strong> <?= htmlspecialchars($book['book_rating']) ?>/5</p>
      <p><strong>Progress:</strong> <?= htmlspecialchars($book['current_progress']) ?>/<?= htmlspecialchars($book['page_count']) ?> pages</p>

      <form method="POST" class="book-progress">
        <label for="progress">Update your progress:</label>
        <input type="number" name="progress" id="progress"
               value="<?= htmlspecialchars($book['current_progress']) ?>"
               min="0" max="<?= htmlspecialchars($book['page_count']) ?>">
        <button class="button" type="submit">Update</button>
      </form>
    </div>
  </div>
<?php else: ?>
  <p style="text-align:center; color:#273E47;">Book not found.</p>
<?php endif; ?>

</body>
</html>
