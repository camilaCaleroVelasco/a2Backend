-- Status enumeration stored in separate table, accessed using primary key
CREATE TABLE UserStatus(
    userStatus_id INT PRIMARY KEY AUTO_INCREMENT,
    status VARCHAR(255)
);
-- Key = 1
INSERT INTO UserStatus(status)
VALUES('ACTIVE');
-- Key = 2
INSERT INTO UserStatus(status)
VALUES('INACTIVE');
-- Key = 3
INSERT INTO UserStatus(status)
VALUES('SUSPENDED');
-- End of setting up Status enumeration
-- PROMO STATUS ENUMERATION
CREATE TABLE PromoStatus(
    promoStatus_id INT PRIMARY KEY AUTO_INCREMENT,
    promoStatus VARCHAR(255)
);
-- Key = 1
INSERT INTO PromoStatus(promoStatus)
VALUES('ACTIVE');
-- Key = 2
INSERT INTO PromoStatus(promoStatus)
VALUES('INACTIVE');
-- END OF ENUMERATION
CREATE TABLE Promotion(
    promo_id INT PRIMARY KEY AUTO_INCREMENT,
    promoName VARCHAR(255),
    promoCode VARCHAR(255),
    startDay INT,
    startMonth INT,
    endDay INT,
    endMonth INT,
    promoStatus_id INT,
    FOREIGN KEY (promoStatus_id) REFERENCES PromoStatus(promoStatus_id),
    percentDiscount INT
);
-- Create User Type Enumeration
CREATE TABLE UserType(
    userType_id INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(255)
);
-- Key = 1
INSERT INTO UserType(type)
VALUES('CUSTOMER');
-- Key = 2
INSERT INTO UserType(type)
VALUES('ADMIN');
-- END OF ENUMERATION
CREATE TABLE BillingAddress(
    billing_id INT PRIMARY KEY AUTO_INCREMENT,
    billingStreetAddress VARCHAR(255),
    billingCity VARCHAR(255),
    billingState VARCHAR(255),
    billingZipCode VARCHAR(255)
);
CREATE TABLE DeliveryAddress(
    delivery_id INT PRIMARY KEY AUTO_INCREMENT,
    deliveryStreetAddress VARCHAR(255),
    deliveryCity VARCHAR(255),
    deliveryState VARCHAR(255),
    deliveryZipCode VARCHAR(255)
);
-- PromoSubscription enumeration
CREATE TABLE PromoSubscription(
    promoSub_id INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(255)
);
-- Key = 1 (SUBSCRIBED)
INSERT INTO PromoSubscription(type)
VALUES('SUBSCRIBED');
-- Key = 2 (NOT SUBSCRIBED)
INSERT INTO PromoSubscription(type)
VALUES('NOT-SUBSCRIBED');
-- END OF ENUMERATION
-- Create Users table
CREATE TABLE Users(
    users_id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255),
    password VARCHAR(255),
    firstName VARCHAR(255),
    lastName VARCHAR(255),
    phoneNumber VARCHAR(255),
    userStatus_id INT,
    userType_id INT,
    pwdResetPin1 INT,
    pwdResetPin2 INT,
    pwdResetPin3 INT,
    pwdResetPin4 INT,
    FOREIGN KEY (userStatus_id) REFERENCES UserStatus(userStatus_id),
    FOREIGN KEY (userType_id) REFERENCES UserType(userType_id),
    promoSub_id INT,
    FOREIGN KEY (promoSub_id) REFERENCES PromoSubscription(promoSub_id),
    billing_id INT,
    FOREIGN KEY (billing_id) REFERENCES BillingAddress(billing_id),
    delivery_id INT,
    FOREIGN KEY (delivery_id) REFERENCES DeliveryAddress(delivery_id)
);
-- PAYMENT CARD TYPE ENUMERATION
CREATE TABLE PaymentCardType(
    cardType_id INT PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(255)
);
-- Key = 1
INSERT INTO PaymentCardType(type)
VALUES('VISA');
-- Key = 2
INSERT INTO PaymentCardType(type)
VALUES('MASTERCARD');
-- Key = 3
INSERT INTO PaymentCardType(type)
VALUES('AMERICAN EXPRESS');
-- END OF ENUMERATION
CREATE TABLE PaymentCard1(
    card1_id INT PRIMARY KEY AUTO_INCREMENT,
    cardNum VARCHAR(255),
    lastFour INT,
    cardType_id INT,
    expMonth VARCHAR(255),
    expYear VARCHAR(255),
    firstName VARCHAR(255),
    lastName VARCHAR(255),
    users_id INT,
    FOREIGN KEY (users_id) REFERENCES Users(users_id),
    FOREIGN KEY (cardType_id) REFERENCES PaymentCardType(cardType_id)
);
CREATE TABLE PaymentCard2(
    card2_id INT PRIMARY KEY AUTO_INCREMENT,
    cardNum VARCHAR(255),
    lastFour INT,
    cardType_id INT,
    expMonth VARCHAR(255),
    expYear VARCHAR(255),
    firstName VARCHAR(255),
    lastName VARCHAR(255),
    users_id INT,
    FOREIGN KEY (users_id) REFERENCES Users(users_id),
    FOREIGN KEY (cardType_id) REFERENCES PaymentCardType(cardType_id)
);
CREATE TABLE PaymentCard3(
    card3_id INT PRIMARY KEY AUTO_INCREMENT,
    cardNum VARCHAR(255),
    lastFour INT,
    cardType_id INT,
    expMonth VARCHAR(255),
    expYear VARCHAR(255),
    firstName VARCHAR(255),
    lastName VARCHAR(255),
    users_id INT,
    FOREIGN KEY (users_id) REFERENCES Users(users_id),
    FOREIGN KEY (cardType_id) REFERENCES PaymentCardType(cardType_id)
);
-- BOOKING STATUS ENUMERATION
CREATE TABLE BookingStatus(
    bookingStatus_id INT PRIMARY KEY AUTO_INCREMENT,
    bookingStatus VARCHAR(255)
);
-- Key = 1
INSERT INTO BookingStatus(bookingStatus)
VALUES('ACTIVE');
-- Key = 2
INSERT INTO BookingStatus(bookingStatus)
VALUES('EXPIRED');
-- END OF ENUMERATION
CREATE TABLE Booking(
    booking_id INT PRIMARY KEY AUTO_INCREMENT,
    bookingDate VARCHAR(255),
    bookingStatus_id INT,
    FOREIGN KEY (bookingStatus_id) REFERENCES BookingStatus(bookingStatus_id),
    numberOfSeats INT,
    promo_id INT,
    FOREIGN KEY (promo_id) REFERENCES Promotion(promo_id),
    users_id INT,
    FOREIGN KEY (users_id) REFERENCES Users(users_id),
    priceTotal INT
);
-- TICKET TYPE ENUMERATION
CREATE TABLE TicketType(
    ticketType_id INT PRIMARY KEY AUTO_INCREMENT,
    ticketType VARCHAR(255),
    ticketPrice INT
);
-- Key = 1
INSERT INTO TicketType(ticketType, ticketPrice)
VALUES('CHILD', '10');
-- Key = 2
INSERT INTO TicketType(ticketType, ticketPrice)
VALUES('ADULT', '15');
-- Key = 3
INSERT INTO TicketType(ticketType, ticketPrice)
VALUES('SENIOR', '12');
-- END OF ENUMERATION
CREATE TABLE Theater(
    theater_id INT PRIMARY KEY AUTO_INCREMENT,
    theaterName VARCHAR(255),
    theaterLocation VARCHAR(255),
    numOfShowrooms INT
);
INSERT INTO Theater(theaterName, theaterLocation, numOfShowrooms)
VALUES('A2Theater', '123 Athens', 3);
CREATE TABLE Room(
    room_id INT PRIMARY KEY AUTO_INCREMENT,
    totalNumOfSeats INT,
    roomTitle VARCHAR(255),
    roomNumber VARCHAR(255),
    theater_id INT,
    FOREIGN KEY (theater_id) REFERENCES Theater(theater_id)
);
-- Key = 1
INSERT INTO Room(
        totalNumOfSeats,
        roomTitle,
        roomNumber,
        theater_id
    )
VALUES(54, 'Platinum', '101', 1);
-- Key = 2
INSERT INTO Room(
        totalNumOfSeats,
        roomTitle,
        roomNumber,
        theater_id
    )
VALUES(54, 'Royal', '102', 1);
-- Key = 3
INSERT INTO Room(
        totalNumOfSeats,
        roomTitle,
        roomNumber,
        theater_id
    )
VALUES(54, 'VIP', '103', 1);
-- SHOW PERIOD ENUMERATION
CREATE TABLE ShowPeriod(
    showPeriod_id INT PRIMARY KEY AUTO_INCREMENT,
    startTime VARCHAR(255)
);
-- Key = 1
INSERT INTO ShowPeriod(startTime)
VALUES('11:00 AM');
-- Key = 2
INSERT INTO ShowPeriod(startTime)
VALUES('1:00 PM');
-- Key = 3
INSERT INTO ShowPeriod(startTime)
VALUES('4:30 PM');
-- Key = 4
INSERT INTO ShowPeriod(startTime)
VALUES('7:30 PM');
-- END OF ENUMERATION
CREATE TABLE Showing(
    show_id INT PRIMARY KEY AUTO_INCREMENT,
    movie_id INT,
    FOREIGN KEY (movie_id) REFERENCES Movies(movie_id),
    room_id INT,
    FOREIGN KEY (room_id) REFERENCES Room(room_id),
    showPeriod_id INT,
    FOREIGN KEY (showPeriod_id) REFERENCES ShowPeriod(showPeriod_id),
    showDate VARCHAR(255),
    showTime VARCHAR(255),
    numOfAvailableSeats INT
);
CREATE TABLE Seats(
    seat_id INT PRIMARY KEY AUTO_INCREMENT,
    show_id INT,
    FOREIGN KEY (show_id) REFERENCES Showing(show_id),
    seatRow VARCHAR(255),
    seatColumn int,
    isAvailable VARCHAR(255)
);
CREATE TABLE Ticket(
    ticket_id INT PRIMARY KEY AUTO_INCREMENT,
    ticketType_id INT,
    FOREIGN KEY (ticketType_id) REFERENCES TicketType(ticketType_id),
    booking_id INT,
    FOREIGN KEY (booking_id) REFERENCES Booking(booking_id),
    show_id INT,
    FOREIGN KEY (show_id) REFERENCES Showing(show_id),
    seat_id INT,
    FOREIGN KEY (seat_id) REFERENCES Seats(seat_id)
);
CREATE TABLE PromoCodeUse (
    promo_id INT(11),
    user_id INT(11),
    FOREIGN KEY (promo_id) REFERENCES Promotion(promo_id),
    FOREIGN KEY (user_id) REFERENCES Users(users_id)
);