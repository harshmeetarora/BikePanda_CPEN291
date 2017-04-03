CREATE TABLE bikedata ( 
	rowid INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	userid INT NOT NULL,
	time DATETIME, 
	trip_number INT, 
	longitude DECIMAL(9,6), 
	latitude DECIMAL(9,6),
	speed FLOAT,
	altitude FLOAT,
	trip_distance FLOAT,
	total_distance FLOAT,
);


CREATE TABLE users ( 
	userid INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
	first_name varchar(15), 
	last_name varchar(15), 
	username varchar(15), 
	email VARCHAR(320),
	password VARCHAR(320)
);