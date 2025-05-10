create table message_from_user(
    id int AUTO_INCREMENT,
    name varchar(50) NOT NULL,
    email varchar(50) NOT NULL,
    phone varchar(10) NOT NULL,
    subject varchar(15) NOT NULL,
    message longtext,
    sent_at timestamp,
    primary key(id)
);
CREATE TABLE users (
    UserID INT NOT NULL AUTO_INCREMENT,
    FirstName VARCHAR(255),
    LastName VARCHAR(255),
    Email VARCHAR(255) UNIQUE,
    Phone VARCHAR(20),
    BirthDate DATE,
    Gender VARCHAR(10),
    SubCity VARCHAR(255),
    Kebele VARCHAR(255),
    HomeNo VARCHAR(255),
    Username VARCHAR(255) UNIQUE,
    Password VARCHAR(255),
    UserType VARCHAR(50),
    RegistrationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Status VARCHAR(50),
    QR_Code_URL VARCHAR(255),
    ID_Generated VARCHAR(255),
    Reciept_image varchar(255),
    insurance_expiry DATETIME DEFAULT 2024-01-01,
    paid_status varchar(10),
    PRIMARY KEY(UserID)
);

CREATE TABLE comments (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    customer_name TEXT NOT NULL,
    comment TEXT NOT NULL,
    date_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

 INSERT INTO Users (FirstName, LastName, Email, Phone, BirthDate, Gender, SubCity, Kebele, HomeNo, UserType, Username, Password) VALUES ('markos', 'Nakachew', 'markosnakachew@gmail.com', '0912345678', '1999/03/21', 'Male', 'Dejen', '01', '333', 'Admin', 'Mark', '$2y$10$fnJx0oRaT/5NHl7ojd1bTeL3ENssn0WJZuIHcVAweJ83.ENa.AASm');

 CREATE TABLE messages (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    image varchar(255),
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

