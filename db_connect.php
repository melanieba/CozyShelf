<?php

function connect() {
  $servername = "cssql.seattleu.edu";
  $username = "sr_group7";
  $password = "fYuxf+6dZhaAzLao";
  $dbname = "sr_group7";
  
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  return $conn;  
}

function disconnect($conn) {
  mysqli_close($conn);
};



// $servername = "cssql.seattleu.edu";
// $username = "sr_group7";
// $password = "fYuxf+6dZhaAzLao";
// $dbname = "sr_group7";

// $conn = mysqli_connect($servername, $username, $password, $dbname);

// if (!$conn) {
//   die("Connection failed: " . mysqli_connect_error());
// }

// echo "Connection successfully";


// $sql = "SELECT * FROM Book";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//   echo "<table border='1' cellpadding='10'>";
//   echo "<tr>
//           <th>ID</th>
//           <th>Title</th>
//           <th>Author Last</th>
//           <th>Author First</th>
//           <th>Cover</th>
//           <th>Pages</th>
//           <th>Rating</th>
//           <th>Progress</th>
//           <th>Description</th>
//         </tr>";

//   while ($row = $result->fetch_assoc()) {
//       echo "<tr>
//               <td>{$row['book_id']}</td>
//               <td>{$row['book_title']}</td>
//               <td>{$row['author_last_name']}</td>
//               <td>{$row['author_first_name']}</td>
//               <td><img src='{$row['book_cover']}' width='50' /></td>
//               <td>{$row['page_count']}</td>
//               <td>{$row['book_rating']}</td>
//               <td>{$row['current_progress']}</td>
//               <td>{$row['book_description']}</td>
//             </tr>";
//   }

//   echo "</table>";
// } else {
//   echo "No books found.";
// }

?>