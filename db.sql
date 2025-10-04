-- db.sql
CREATE DATABASE IF NOT EXISTS mini_ecommerce CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mini_ecommerce;

-- Users (owner/admin)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('owner','customer') DEFAULT 'customer',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL UNIQUE
);

-- Products
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  category_id INT NOT NULL,
  stock INT DEFAULT 0,
  image VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Orders (basic)
CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  total DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Order items
CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  qty INT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Seed categories (as requested)
INSERT INTO categories (name) VALUES
('Male Clothes'), ('Female Clothes'), ('Groceries'), ('TV'), ('Laptops'), ('Phones'), ('Watches'), ('Children Clothes');

-- Seed a few products
INSERT INTO products (name, description, price, category_id, stock) VALUES
('Classic Men T-Shirt', 'Comfortable cotton t-shirt', 12.99, (SELECT id FROM categories WHERE name='Male Clothes'), 50),
('Women Summer Dress', 'Light summer dress', 29.50, (SELECT id FROM categories WHERE name='Female Clothes'), 30),
('Organic Rice 5kg', 'High-quality rice', 15.00, (SELECT id FROM categories WHERE name='Groceries'), 100),
('Smart LED TV 42"', '42-inch Smart TV', 299.99, (SELECT id FROM categories WHERE name='TV'), 10),
('Ultra Laptop 14"', 'Thin-and-light laptop', 899.00, (SELECT id FROM categories WHERE name='Laptops'), 5),
('Smartphone X', 'Latest smartphone', 599.00, (SELECT id FROM categories WHERE name='Phones'), 20),
('Classic Wrist Watch', 'Analog watch', 79.99, (SELECT id FROM categories WHERE name='Watches'), 15),
('Children Trousers', 'Comfortable trousers for kids', 14.00, (SELECT id FROM categories WHERE name='Children Clothes'), 40);

-- Create an owner user (password = change_me)
-- Note: replace password_hash value after generating securely, or set a known password with PHP's password_hash()
INSERT INTO users (username, password_hash, role)
VALUES ('owner', '$2y$10$EXAMPLEPASSWORDHASHCHANGEIT', 'owner');

-- IMPORTANT:
-- Replace the example hash above with a real hash. Example to generate a hash:
-- In PHP: echo password_hash('yourpassword', PASSWORD_DEFAULT);
