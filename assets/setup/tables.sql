--USERS TABLE--
CREATE TABLE `user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- AGENTS TABLE
CREATE TABLE agent_activity (
    id INT PRIMARY KEY AUTO_INCREMENT,
    agent_id INT,
    email VARCHAR(255) NOT NULL,
    deposit DECIMAL(10, 2) DEFAULT 0.00,
    withdraw DECIMAL(10, 2) DEFAULT 0.00,
    testimony INT DEFAULT 0,
    transactions INT DEFAULT 0,
    investments DECIMAL(10, 2) DEFAULT 0.00,
    total_earned DECIMAL(10, 2) DEFAULT 0.00,
    referral_code VARCHAR(10) UNIQUE,
    referrer_id INT, -- The ID of the referring agent
    level INT DEFAULT 1 -- The MLM level of the agent
);

ALTER TABLE agent_activity ADD COLUMN referral_code VARCHAR(20);



-- withdrawal requests 
CREATE TABLE withdrawal_requests (
    request_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    mpesa_number VARCHAR(255),
    amount_withdrawn DECIMAL(10, 2),
    request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Pending', 'Completed', 'Rejected') DEFAULT 'Pending'
);

ALTER TABLE withdrawal_requests MODIFY COLUMN user_id VARCHAR(255);

-- Agents Deposits
-- CREATE TABLE agent_deposits (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     agent_id VARCHAR(255) NOT NULL,
--     amount DECIMAL(10, 2) NOT NULL,
--     mpesa_transaction_id VARCHAR(255) NOT NULL,
--     status VARCHAR(20) DEFAULT 'Pending',
--     deposit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     -- Add any other columns you need for additional information
--     FOREIGN KEY (agent_id) REFERENCES agent_activity(user_id)
-- );

-- agent deposits

CREATE TABLE agent_deposits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agent_id VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    mpesa_number VARCHAR(255) NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending',
    deposit_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CheckoutRequestID VARCHAR(255), -- Added column for CheckoutRequestID
    MerchantRequestID VARCHAR(255), -- Added column for MerchantRequestID
    mpesa_receipt VARCHAR(255), -- Updated column name from payments table
    FOREIGN KEY (agent_id) REFERENCES agent_activity(user_id)
);


-- LOGIN ATTEMPTS
CREATE TABLE login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    attempts INT DEFAULT 0,
    last_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);




--TOKENS TBL--

CREATE TABLE `auth_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token_UNIQUE` (`token`),
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--RESET TOKENS--
CREATE TABLE `password_reset_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token_UNIQUE` (`token`),
  CONSTRAINT `fk_user_id_reset` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `cart` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) NOT NULL,
  `product_id` varchar(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4

ALTER TABLE cart
ADD COLUMN size VARCHAR(50);  -- You can adjust the data type and length as needed


CREATE TABLE guest_cart (
    guest_id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL, -- Identifies the guest's session
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

ALTER TABLE guest_cart
ADD COLUMN size VARCHAR(50);  -- You can adjust the data type and length as needed


CREATE TABLE `products` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` decimal(10, 2) NOT NULL,
  `category` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4;

ALTER TABLE `products`
ADD COLUMN `discount` decimal(10, 2) DEFAULT NULL AFTER `price`;
ALTER TABLE products ADD COLUMN size VARCHAR(255);





--ORDERS--

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(255) NOT NULL,
    zip VARCHAR(10) NOT NULL,
    payment_method VARCHAR(255) NOT NULL,
    total_products TEXT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    order_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    phone_number VARCHAR(15) NOT NULL, -- Add this column for phone number
    order_no VARCHAR(20) NOT NULL     -- Add this column for order number
);


CREATE TABLE payments (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    MerchantRequestID VARCHAR(50),
    CheckoutRequestID VARCHAR(50),
    Phone VARCHAR(15),
    OrderNo VARCHAR(20),
    Amount DECIMAL(10, 2),
    PaymentStatus VARCHAR(20),
    TotalProducts TEXT, -- Add this field to store product information
    Timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
ALTER TABLE payments
ADD mpesa_receipt VARCHAR(50);



ALTER TABLE orders
MODIFY COLUMN total_price VARCHAR(255); -- You can adjust the VARCHAR length as needed


ALTER TABLE orders
ADD order_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER total_price;

ALTER TABLE orders
ADD COLUMN status VARCHAR(50) NOT NULL DEFAULT 'pending';

UPDATE orders
SET status = 'confirmed'
WHERE order_id = <order_id>;

UPDATE orders
SET status = 'shipped'
WHERE order_id = <order_id>;





CREATE TABLE `wishlist` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` VARCHAR(255) NOT NULL,  -- Match the data type
  `product_id` INT NOT NULL,
  `added_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `user_info`(`email`),  -- Reference the email column in user_info
  FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE jobs (
    job_id INT AUTO_INCREMENT PRIMARY KEY,
    job_name VARCHAR(100) NOT NULL,
    job_category VARCHAR(100),
    job_location VARCHAR(100),
    job_description TEXT,
    job_responsibility JSON,
    job_qualifications JSON,
    vacancy_number INT,
    job_nature VARCHAR(100),
    deadline TIMESTAMP,
    salary_range VARCHAR(100),
    company_name VARCHAR(100) NOT NULL,
    posted_date DATETIME NOT NULL,
    job_poster_email VARCHAR(100) NOT NULL
);


 CREATE TABLE models (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    caption TEXT NOT NULL
);

CREATE TABLE product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES products(id)
);






