DROP TABLE IF EXISTS sample_table;
 
CREATE TABLE sample_table (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name TEXT NOT NULL
) ENGINE InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
 
INSERT INTO sample_table (name) VALUES ("昭和"),("平成"),("令和");

DROP TABLE IF EXISTS user_data;
CREATE TABLE user_data(
	UserIndex INT UNSIGNED NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (UserIndex),
	ID VARCHAR(32) NOT NULL,
	パスワード VARCHAR(32) NOT NULL,
	性別コード VARCHAR(32) NOT NULL,
	お名前 VARCHAR(64) NOT NULL,
	住所 VARCHAR(128) NOT NULL,
	電話番号 VARCHAR(32) NOT NULL,
	メールアドレス VARCHAR(64) NOT NULL
	モバイル端末コード VARCHAR(64) NOT NULL
	);

INSERT INTO user_data (ID, パスワード,  お名前, 住所, 電話番号, メールアドレス, モバイル端末コード) VALUES
	("YAMADA001", "pw01","山田太郎", 性別コード,"東京都新宿区西新宿1-1-1タイガーマンション101", "12345678901", "yamada@tarou.co.jp", モバイル端末コード),
	("SUZUKI005", "pw02", "鈴木次郎", 性別コード,"東京都葛飾区西水元1-2-3アパートABC102", "2345678901", "suzuki@jirou.co.jp", モバイル端末コード),
	("SATOU154567", "pw03", "佐藤花子", 性別コード,"東京都足立区日の出1-90-80", "45678901234", "satou@hanako.co.jp", モバイル端末コード),
	("akasaka", "pw11", "赤坂三郎", 性別コード,"東京都港区赤坂2-4-6", "67891023456", "akasa@saburou.co.jp", モバイル端末コード);