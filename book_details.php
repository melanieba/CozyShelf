<?php
include 'db_connect.php';

$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle progress update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['progress'])) {
        $newProgress = intval($_POST['progress']);
        $stmt = $conn->prepare("UPDATE Book SET current_progress = ? WHERE book_id = ?");
        $stmt->bind_param("ii", $newProgress, $book_id);
        $stmt->execute();
        $stmt->close();
    }

    if (isset($_POST['note_content']) && !empty(trim($_POST['note_content']))) {
        $note = trim($_POST['note_content']);
        $stmt = $conn->prepare("INSERT INTO Note (note_date, note_time, note_content, book_id) VALUES (CURDATE(), CURTIME(), ?, ?)");
        $stmt->bind_param("si", $note, $book_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Fetch book details
$stmt = $conn->prepare("SELECT * FROM Book WHERE book_id = ?");
$stmt->bind_param("i", $book_id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();
$stmt->close();

// Fetch notes
$note_stmt = $conn->prepare("SELECT note_date, note_time, note_content FROM Note WHERE book_id = ? ORDER BY note_date DESC, note_time DESC");
$note_stmt->bind_param("i", $book_id);
$note_stmt->execute();
$notes_result = $note_stmt->get_result();
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

    .book-progress, .book-notes {
      margin-top: 20px;
    }

    label {
      font-weight: bold;
      color: #273E47;
      display: block;
      margin-bottom: 6px;
    }

    input[type="number"], textarea {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      width: 100%;
      max-width: 400px;
      box-sizing: border-box;
    }

    textarea {
      height: 100px;
      resize: vertical;
      margin-top: 8px;
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

    .note {
      background-color: #fff;
      border: 1px solid #ddd;
      padding: 12px;
      border-radius: 8px;
      margin-top: 10px;
    }

    .note-date {
      font-size: 14px;
      color: #666;
      margin-bottom: 6px;
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

      <div class="book-notes">
        <h2>Notes</h2>
        <form method="POST">
          <label for="note_content">Add a note:</label>
          <textarea name="note_content" id="note_content" placeholder="Write your thoughts..."></textarea>
          <button class="button" type="submit">Add Note</button>
        </form>

        <?php while ($note = $notes_result->fetch_assoc()): ?>
          <div class="note">
            <div class="note-date"><?= htmlspecialchars($note['note_date']) ?> <?= htmlspecialchars($note['note_time']) ?></div>
            <div><?= htmlspecialchars($note['note_content']) ?></div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
<?php else: ?>
  <p style="text-align:center; color:#273E47;">Book not found.</p>
<?php endif; ?>

</body>
</html>

