CREATE DATABASE hanoi_marathon;

USE hanoi_marathon;

CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    nationality VARCHAR(50),
    sex ENUM('Male', 'Female', 'Other'),
    age INT,
    passport_no VARCHAR(50),
    current_address TEXT,
    email VARCHAR(100),
    mobile_number VARCHAR(20),
);

CREATE TABLE Races (
    race_id INT AUTO_INCREMENT PRIMARY KEY,
    race_name VARCHAR(100),
    date DATE
);

CREATE TABLE Participants (
    participant_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    race_id INT,
    hotel_name VARCHAR(100),
    entry_number INT,
    race_bib VARCHAR(50),
    standings INT,
    marathon_time_record TIME,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (race_id) REFERENCES Races(race_id)
);

CREATE TABLE Gallery (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    race_id INT,
    stage_name VARCHAR(100),
    image_path VARCHAR(255),
    thumbnail_path VARCHAR(255),
    FOREIGN KEY (race_id) REFERENCES Races(race_id)
);

CREATE TABLE Past_Races (
    past_race_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    race_name VARCHAR(255) NOT NULL,
    race_date DATE NOT NULL,
    race_bib VARCHAR(20) NOT NULL,
    marathon_time_record VARCHAR(20) NOT NULL,
    standings INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
);


-- ALTER TABLE participants AUTO_INCREMENT = value;
-- ALTER TABLE past_races AUTO_INCREMENT = value;
