# 🏙️ UrbanKicks – Online Shoe Store

**UrbanKicks** is a full-stack PHP web application for an online shoe store. Users can browse shoes, add them to cart, and place orders with ease. Administrators can manage products, categories, and inventory through a secure admin panel.

---

## 🛠️ Tech Stack

**Backend:** PHP (Core PHP)  
**Frontend:** HTML, CSS, Bootstrap, JavaScript, jQuery  
**Database:** MySQL  
**Server:** Apache (via XAMPP)

---

## ✨ Features

### 👟 User Side:
- Register and log in to manage orders.
- Browse products by category.
- View detailed product information including images and pricing.
- Add/remove items to/from the cart.
- Checkout and place orders.
- View past orders and purchase history.

### 🛠️ Admin Side:
- Secure admin login system.
- Add, update, and delete product listings.
- Manage categories and inventory stock.
- View customer orders and update their status.

---

## 🖥️ How to Download and Run on Your Local System

Follow these steps to run the **UrbanKicks** e-commerce website on your local machine:

### 1️⃣ Download the Project
- Click the green **Code** button on this repository.
- Select **Download ZIP** and extract it on your computer.

### 2️⃣ Open Project in XAMPP
- Move the extracted folder (`URBANKICKS/`) into the `htdocs` directory:
  ```
  C:\xampp\htdocs\URBANKICKS
  ```

### 3️⃣ Setup MySQL Database
- Start **Apache** and **MySQL** in XAMPP Control Panel.
- Open **phpMyAdmin** at:
  ```
  http://localhost/phpmyadmin
  ```
- Create a new database, e.g.:
  ```sql
  CREATE DATABASE urbankicks;
  ```
- Import the provided SQL file (`urbankicks.sql`) located in the project directory to create necessary tables and data.

### 4️⃣ Configure Database Connection
- Open the file `db_connect.php`.
- Update the following variables with your local credentials:
  ```php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "urbankicks";
  ```

### 5️⃣ Run the Application
- Open your browser and navigate to:
  ```
  http://localhost/URBANKICKS/
  ```
- Register or log in as a user to start shopping.
- To access the admin panel:
  ```
  http://localhost/URBANKICKS/admin/
  ```

---

## 🙌 Thank You

Thanks for checking out the **UrbanKicks** project!  
This project is a great starting point to learn full-stack web development using **PHP, MySQL, HTML, CSS, and JavaScript**.

If you find this project helpful, feel free to ⭐ star the repository and share it.  
Have suggestions or improvements? Submit a pull request or open an issue.

Happy Coding! 👟💻🚀
