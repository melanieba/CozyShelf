SHOW DATABASES;
USE sr_group7;
SHOW TABLES;

CREATE TABLE test_table (
  id INT AUTO_INCREMENT PRIMARY KEY,
  message VARCHAR(100)
);

INSERT INTO test_table (message) VALUES ('Connection successful!');
SELECT * FROM test_table;
