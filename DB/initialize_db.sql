

-- Create User table
CREATE TABLE User(
    id INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    status_id INT,
    promotion VARCHAR(255),
    FOREIGN KEY (status_id) REFERENCES Status(status_id)
);

-- Status enumeration stored in separate table, accessed using primary key
CREATE TABLE Status(
    id INT PRIMARY KEY AUTO_INCREMENT,
    status VARCHAR(255)
);

-- Key = 1
INSERT INTO Status(status)
VALUES(
    'ACTIVE'
);

-- Key = 2
INSERT INTO Status(status)
VALUES(
    'INACTIVE'
);

-- Key = 3
INSERT INTO Status(status)
VALUES(
    'SUSPENDED'
);
-- End of setting up Status enumeration
    
-- Create Admin table, store reference to parent object in User table
CREATE TABLE Administrator(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    firstName VARCHAR(255),
    lastName VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES User(user_id)
);

-- Create Customer table, store reference to parent object in User table
CREATE TABLE Customer(
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    firstName VARCHAR(255),
    lastName VARCHAR(255),
    card1_id INT,
    card2_id INT,
    card3_id INT,
    FOREIGN KEY (user_id) REFERENCES User(user_id),
    FOREIGN KEY (card1_id) REFERENCES PaymentCard(card1_id),
    FOREIGN KEY (card2_id) REFERENCES PaymentCard(card2_id),
    FOREIGN KEY (card3_id) REFERENCES PaymentCard(card3_id)
);
-- INHERITANCE: Child and Parent have separate tables, child table stores key to parent table.
-- Requires LEFT OUTER JOIN to retrieve all attributes.
-- Syntax:
-- SELECT * FROM
-- Parent LEFT OUTER JOIN Child ON
-- Parent.id = Child.parentid;


CREATE TABLE PaymentCard(
    id INT PRIMARY KEY AUTO_INCREMENT,
    cardNum INT,
    billingAddress VARCHAR(255),
    expDate VARCHAR(255),
    name VARCHAR(255),
    customer_id INT,
    FOREIGN KEY (customer_id) REFERENCES Customer(customer_id)
);