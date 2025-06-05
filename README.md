# 🎨 QALA – The Artist Platform

**QALA** is a web-based platform designed to empower home-based artists by providing a professional, accessible space to showcase and sell their handcrafted artwork. It supports seamless commission requests, intelligent recommendations, and a user-friendly experience for customers, artists, and administrators.

---

## 🚀 Features

### 🔸 Customer Side
- Browse and search handcrafted artworks
- Place orders and custom commission requests
- View artist profiles and rate purchases
- Receive notifications about orders and updates

### 🎨 Artist Side
- Manage personal profile and artworks
- Accept or reject commission requests
- Track orders and sales
- View ratings and feedback

### 🛠️ Admin Panel
- Manage users (customers and artists)
- Manage and view products
- Monitor total sales, orders, and uploads
- Oversee platform-wide content and data

---

## 🧠 AI-Driven Features
- **Product Recommendations** using collaborative filtering

---

## 🛠️ Tech Stack

| Layer           | Technology                         |
|----------------|-------------------------------------|
| Backend         | Laravel 11 (PHP)                   |
| Frontend        | Blade Templates (HTML/CSS/JS)      |
| Database        | MySQL                              |
| ML Integration  | Python (for product recommendations)|
| Server          | XAMPP (Apache for local dev)       |

---

## ⚙️ How to Run Locally

### Step 1: Clone the Repository
git clone https://github.com/maryamzia4/qala.git
cd qala
### Step 2: Install Dependencies
composer install
npm install
npm run dev
### Step 3: Set Up Environment
Update .env with your database credentials and Google Mail credentials
php artisan key:generate
### Step 4: Run Migrations and Serve
php artisan migrate
php artisan serve
⚠️ Note: If images do not display correctly, delete the public/storage folder and re-link it:

php artisan storage:link

## 🌱 Future Improvements

1.Stripe/PayPal integration for secure payments

2.Advanced image-based recommendations (YOLO/CLIP)

3.Real-time artist chat for commission requests

4.Mobile-responsive design for all user roles

## 📄 License
This project is developed for academic purposes and is not licensed for commercial use.
