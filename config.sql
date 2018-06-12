CREATE TABLE users(
  id INT PRIMARY KEY AUTO_INCREMENT,
  Name VARCHAR(100) NOT NULL,
  Username VARCHAR(60) NOT NULL UNIQUE,
  Email VARCHAR(100) NOT NULL UNIQUE,
  Password VARCHAR(255) NOT NULL,
  Creation_data Datetime NOT NULL,
  Gender BOOLEAN NOT NULL,
  Country varchar(2) NOT NULL,
  notifications BOOLEAN NOT NULL,
  photo VARCHAR(60) NOT NULL DEFAULT 'pics/default.jpg',
  verified BOOLEAN NOT NULL DEFAULT 0
);

CREATE TABLE messages(
  id INT PRIMARY KEY AUTO_INCREMENT,
  Receiver_id INT NOT NULL,
  Message VARCHAR(700) NOT NULL,
  Sending_time Datetime NOT NULL,
  Category INT(1) NOT NULL DEFAULT '0',
  FOREIGN KEY (Receiver_id) REFERENCES users(id)
);

CREATE TABLE password_tokens(
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  token VARCHAR(64) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
);


CREATE TABLE email_tokens(
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  token VARCHAR(64) NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
);
