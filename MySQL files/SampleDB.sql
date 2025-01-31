-- Table structure for table `user_details`--

IF OBJECT_ID('user_details', 'U') IS NOT NULL
DROP TABLE user_details;

CREATE TABLE user_details (
  user_id int IDENTITY(1,1) PRIMARY KEY,
  username nvarchar(255) NULL,
  first_name nvarchar(50) NULL,
  last_name nvarchar(50) NULL,
  gender nvarchar(10) NULL,
  password nvarchar(50) NULL,
  status tinyint NULL
);

-- Dumping data for table `user_details`--

INSERT INTO user_details (username, first_name, last_name, gender, password, status) VALUES
('rogers63', 'david', 'john', 'Female', 'e6a33eee180b07e563d74fee8c2c66b8', 1),
('mike28', 'rogers', 'paul', 'Male', '2e7dc6b8a1598f4f75c3eaa47958ee2f', 1),
('rivera92', 'david', 'john', 'Male', '1c3a8e03f448d211904161a6f5849b68', 1),
('ross95', 'maria', 'sanders', 'Male', '62f0a68a4179c5cdd997189760cbcf18', 1),
('paul85', 'morris', 'miller', 'Female', '61bd060b07bddfecccea56a82b850ecf', 1),
('smith34', 'daniel', 'michael', 'Female', '7055b3d9f5cb2829c26cd7e0e601cde5', 1),
('james84', 'sanders', 'paul', 'Female', 'b7f72d6eb92b45458020748c8d1a3573', 1),
('daniel53', 'mark', 'mike', 'Male', '299cbf7171ad1b2967408ed200b4e26c', 1),
('brooks80', 'morgan', 'maria', 'Female', 'aa736a35dc15934d67c0a999dccff8f6', 1),
('morgan65', 'paul', 'miller', 'Female', 'a28dca31f5aa5792e1cefd1dfd098569', 1);
('marlie1234', 'marlie', 'lee', 'Female', 'abduhru2rhu2wjfbjbfwjbwjbjbjwjw', 1)

-- Selecting data from the table
SELECT * FROM user_details;
