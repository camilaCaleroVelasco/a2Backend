
-- Status enumeration stored in separate table, accessed using primary key
CREATE TABLE UserStatus(
    userStatus_id INT PRIMARY KEY AUTO_INCREMENT,
    status VARCHAR(255)
);

-- Key = 1
INSERT INTO UserStatus(status)
VALUES(
    'ACTIVE'
);

-- Key = 2
INSERT INTO UserStatus(status)
VALUES(
    'INACTIVE'
);

-- Key = 3
INSERT INTO UserStatus(status)
VALUES(
    'SUSPENDED'
);
-- End of setting up Status enumeration
    

-- Create User Type Enumeration
CREATE TABLE UserType(
userType_id INT PRIMARY KEY AUTO_INCREMENT,
type VARCHAR(255)
);

-- Key = 1
INSERT INTO UserType(type)
VALUES(
    'CUSTOMER'
);

-- Key = 2
INSERT INTO UserType(type)
VALUES(
    'ADMIN'
);
-- END OF ENUMERATION


-- Create Users table
CREATE TABLE Users(
    users_id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255),
    password VARCHAR(255),
    firstName VARCHAR(255),
    lastName VARCHAR(255),
    numOfCards INT,
    userStatus_id INT,
    userType_id INT,
    FOREIGN KEY (userStatus_id) REFERENCES UserStatus(userStatus_id),
    FOREIGN KEY (userType_id) REFERENCES UserType(userType_id)
);


-- PAYMENT CARD TYPE ENUMERATION
CREATE TABLE PaymentCardType(
    cardType_id INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(255)
);

-- Key = 1
INSERT INTO PaymentCardType(type)
VALUES(
    'VISA'
);

-- Key = 2
INSERT INTO PaymentCardType(type)
VALUES(
    'MASTERCARD'
);

-- Key = 3
INSERT INTO PaymentCardType(type)
VALUES(
    'AMERICAN EXPRESS'
);
-- END OF ENUMERATION


CREATE TABLE PaymentCard(
    card_id INT PRIMARY KEY AUTO_INCREMENT,
    cardNum INT,
    cardType_id INT, 
    expMonth VARCHAR(255),
    expYear VARCHAR(255),
    securityCode INT,
    name VARCHAR(255),
    users_id INT,
    FOREIGN KEY (users_id) REFERENCES Users(users_id),
    FOREIGN KEY (cardType_id) REFERENCES PaymentCardType(cardType_id)
);

-- PROMO STATUS ENUMERATION
CREATE TABLE PromoStatus(
    promoStatus_id INT PRIMARY KEY AUTO_INCREMENT,
    promoStatus VARCHAR(255)  
);

-- Key = 1
INSERT INTO PromoStatus(promoStatus)
VALUES(
    'ACTIVE'
);

-- Key = 2
INSERT INTO PromoStatus(promoStatus)
VALUES(
    'INACTIVE'
);
-- END OF ENUMERATION


CREATE TABLE Promotion(
    promo_id INT PRIMARY KEY AUTO_INCREMENT,
    startDay INT,
    startMonth INT,
    endDay INT,
    endMonth INT,
    promoStatus_id INT,
    FOREIGN KEY (promoStatus_id) REFERENCES PromoStatus(promoStatus_id),
    percentDiscount INT
);
