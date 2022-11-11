DROP TABLE IF EXISTS sample_table;
 
CREATE TABLE sample_table (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name TEXT NOT NULL
) ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
 
INSERT INTO sample_table (name) VALUES ("昭和"),("平成"),("令和");

DROP TABLE IF EXISTS users_data;
CREATE TABLE users_data (
	user_id VARCHAR(24) NOT NULL,
	user_password VARCHAR(24) NOT NULL,
	user_name VARCHAR(32) NOT NULL,
	user_sex INT(1) NOT NULL,
	user_address VARCHAR(128) NOT NULL,
	user_tel VARCHAR(16) NOT NULL,
	user_mail_address VARCHAR(64) NOT NULL,
	user_mobile_device INT(1) NOT NULL
	);

INSERT INTO users_data (user_id, user_password, user_name, user_sex, user_address, user_tel, user_mail_address, user_mobile_device) VALUES
	("YAMADA001", "pw01", "山田太郎", 1, "東京都新宿区西新宿1-1-1タイガーマンション101", "12345678901", "yamada@tarou.co.jp", 1),
	("SUZUKI005", "pw02", "鈴木次郎", 1, "東京都葛飾区西水元1-2-3アパートABC102", "2345678901", "suzuki@jirou.co.jp", 2),
	("SATOU154567", "pw03", "佐藤花子", 2, "東京都足立区日の出1-90-80", "45678901234", "satou@hanako.co.jp", 1),
	("akasaka", "pw11", "赤坂三郎", 1, "東京都港区赤坂2-4-6", "67891023456", "akasa@saburou.co.jp", 1),
	("OGI256", "pw02", "荻窪康太", 1, "東京都杉並区荻窪5-4-6", "78912345678", "akasa@saburou.co.jp", 3);