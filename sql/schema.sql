CREATE TABLE countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alias VARCHAR(64) NOT NULL UNIQUE,
    name_common VARCHAR(255) NOT NULL,
    name_official VARCHAR(255) NOT NULL,
    capital VARCHAR(255),
    region VARCHAR(128),
    subregion VARCHAR(128),
    population BIGINT,
    area DOUBLE,
    timezones TEXT,
    languages TEXT,
    currencies TEXT,
    flag_png VARCHAR(255),
    flag_svg VARCHAR(255)
);

CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alias VARCHAR(64) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    country_id INT NOT NULL,
    population BIGINT,
    area DOUBLE,
    timezone VARCHAR(64),
    FOREIGN KEY (country_id) REFERENCES countries(id)
);

