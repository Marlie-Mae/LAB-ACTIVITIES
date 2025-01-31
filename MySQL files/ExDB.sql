-- Create the database
CREATE DATABASE ExDB;

-- Select the database to use
USE ExDB;

-- Create the Customers table
CREATE TABLE Customers (
    CustomerID INT NOT NULL IDENTITY(1,1),
    LastName VARCHAR(255),
    FirstName VARCHAR(255),
    Age INT,
    Address VARCHAR(255),
    PRIMARY KEY (CustomerID)
);

-- Insert data into the Customers table
INSERT INTO Customers (
    LastName, FirstName, Age, Address)
    VALUES ('Awayan', 'Marlie Mae', 20, 'Mandaluyong City');

-- Select all records from the Customers table
SELECT * FROM Customers;
