CREATE TABLE orders(
   id INT NOT NULL AUTO_INCREMENT,
   ordernumber INT NOT NULL,
   amount INT NOT NULL,
   name VARCHAR(200),
   orderdescription TEXT,
   email VARCHAR(200),
   orderdate TIMESTAMP,
   PRIMARY KEY (id)
);