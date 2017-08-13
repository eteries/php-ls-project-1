CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(255) NOT NULL,
  email CHAR(128) UNIQUE NOT NULL,
  phone CHAR(128)
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  address TEXT(2048),
  comment TEXT(2048),
  payment CHAR(128),
  callback CHAR(128),
  user_id INT NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id)
);