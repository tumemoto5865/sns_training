DROP TABLE IF EXISTS sample_table;
 
CREATE TABLE sample_table (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name TEXT NOT NULL
) ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
 
INSERT INTO sample_table (name) VALUES ("昭和"),("平成"),("令和");
