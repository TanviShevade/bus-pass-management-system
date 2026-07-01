# 🚌 Bus Pass Management System

![PHP](https://img.shields.io/badge/PHP-8-blue?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-Database-blue?logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-purple?logo=bootstrap)
![License](https://img.shields.io/badge/License-Educational-orange)

A web-based **Bus Pass Management System** developed using **PHP, MySQL, HTML5, CSS3, Bootstrap, and JavaScript**. The application digitizes the traditional bus pass process by allowing users to apply for bus passes, renew them, make online payments, track application status, and download digital bus passes. Administrators can efficiently manage users, applications, payments, and reports through an administrative dashboard.

> 🎓 Developed as an **BCA Final Year Project**.

---

# 📖 Project Overview

The Bus Pass Management System is designed to automate the bus pass application process for students and working professionals. It eliminates paperwork by providing an online platform where users can register, apply for new bus passes, renew existing passes, make payments, and download digital passes. The system also enables administrators to manage applications, users, payments, and generate reports efficiently.

---

# ✨ Features

## 👤 User Features

- User Registration & Login
- Forgot Password & Password Reset
- Apply for New Bus Pass
- Renew Existing Bus Pass
- Track Application Status
- Online Payment Module
- Download Bus Pass (PDF)
- View Bus Pass Details
- Update User Profile
- Contact Support
- Submit Feedback
- Responsive User Dashboard

---

## 👨‍💼 Admin Features

- Secure Admin Login
- Admin Dashboard
- Manage Users
- Manage Bus Pass Applications
- Approve / Reject Applications
- Manage Bus Pass Records
- View Payment Details
- View Contact Messages
- View User Feedback
- Generate User Reports

---

# 🛠 Tech Stack

## Frontend

- HTML5
- CSS3
- Bootstrap 5
- JavaScript

## Backend

- PHP

## Database

- MySQL

## Libraries Used

- PHPMailer
- TCPDF
- FPDF

## Server

- XAMPP (Apache + MySQL)

---

# 📂 Project Structure

```text
bus_pass_system/
│
├── admin/
├── uploads/
├── PHPMailer/
├── tcpdf/
├── fpdf/
├── screenshots/
├── config.php
├── index.php
├── login.php
├── register.php
├── dashboard.php
├── bus_pass_management.sql
├── README.md
└── .gitignore
```

---

# 🚀 Installation Guide

## 1. Clone Repository

```bash
git clone https://github.com/TanviShevade/bus-pass-management-system.git

cd bus-pass-management-system
```

---

## 2. Move Project

Copy the project folder into:

```text
xampp/htdocs/
```

---

## 3. Create Database

Open **phpMyAdmin** and create a database named:

```sql
bus_pass_management
```

---

## 4. Import Database

Import:

```text
bus_pass_management.sql
```

---

## 5. Configure Database

Open:

```text
config.php
```

Update your database credentials if necessary:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "bus_pass_management";
```

---

## 6. Start XAMPP

Start:

- Apache
- MySQL

---

## 7. Run the Project

User Panel

```text
http://localhost/bus_pass_system/
```

Admin Panel

```text
http://localhost/bus_pass_system/admin/admin_login.php
```

---

# 📸 Project Screenshots

## 🏠 Home Page

![Home](uploads/screenshots/indexPage.png)

---

## 🏠 Home Page (Alternative View)

![Home 2](uploads/screenshots/indexPage%20copy.png)

---

## 📝 User Registration

![Registration](uploads/screenshots/Registration.png)

---

## 📝 Registration Form

![Registration Copy](uploads/screenshots/Registration%20copy.png)

---

## 🔐 User Login

![Login](uploads/screenshots/Login.png)

---

## 🔑 Forgot Password

![Forgot Password](uploads/screenshots/Forgotpassword.png)

---

## 🔄 Reset Password

![Reset Password](uploads/screenshots/ResetPassword.png)

---

## 👤 User Dashboard

![Dashboard](uploads/screenshots/UserDashboard.png)

---

## 🚌 Apply for Bus Pass

![Apply Pass](uploads/screenshots/ApplyForPass.png)

---

## 💳 Payment Form

![Payment](uploads/screenshots/PaymentForm.png)

---

## 🎫 View Bus Pass

![View Pass](uploads/screenshots/ViewPass.png)

---

## 📄 Download Bus Pass (PDF)

![Download Pass](uploads/screenshots/DownloadPass(PDF).png)

---

## 🔄 Renew Bus Pass

![Renew Pass](uploads/screenshots/RenewPass.png)

---

## 📍 Track Application Status

![Track Status](uploads/screenshots/TrackApplicationStatus.png)

---

## 👤 Update Profile

![Update Profile](uploads/screenshots/UpdateProfile.png)

---

## 📞 Contact Us

![Contact](uploads/screenshots/ContactUs.png)

---

## ❓ FAQs

![FAQs](uploads/screenshots/FAQs.png)

---

## 💬 Feedback Form

![Feedback](uploads/screenshots/FeedbackForm.png)

---

# 👨‍💼 Admin Screens

## 🔐 Admin Login

![Admin Login](uploads/screenshots/AdminLogin.png)

---

## 📊 Admin Dashboard

![Admin Dashboard](uploads/screenshots/AdminDashboard.png)

---

## 👥 Manage Users

![Manage Users](uploads/screenshots/ManageUsers.png)

---

## 🚌 Manage Bus Pass

![Manage Bus Pass](uploads/screenshots/ManageBusPass.png)

---

## 📋 Manage Bus Pass Records

![Manage Bus Pass Records](uploads/screenshots/ManageBusPassRecords.png)

---

## 💳 View Payments

![View Payment](uploads/screenshots/ViewPayment.png)

---

## 📞 View Contact Messages

![View Contact](uploads/screenshots/ViewContact.png)

---

## 💬 View Feedback

![View Feedback](uploads/screenshots/ViewFeedback.png)

---

## 📈 User Report

![User Report](uploads/screenshots/UserReport.png)

---

# ✨ Key Functionalities

- Secure User Authentication
- Online Bus Pass Application
- Bus Pass Renewal
- Online Payment System
- PDF Bus Pass Generation
- Email Notifications
- Pass Status Tracking
- User Profile Management
- Contact & Feedback Module
- Admin Dashboard
- Report Generation

---

# 🔮 Future Enhancements

- QR Code Verification
- Razorpay Payment Gateway
- SMS Notifications
- Email Reminder for Pass Expiry
- Mobile Application
- Multi-language Support
- AI Chatbot Support
- Advanced Analytics Dashboard

---

# 🏛 System Architecture

```text
User
   │
   ▼
Browser
   │
   ▼
PHP Application
   │
   ▼
MySQL Database
```

---

# 👩‍💻 Developer

**Tanvi Shevade**

🎓 MCA Student

💻 Aspiring Full Stack Developer

### Connect with Me

- **GitHub:** https://github.com/TanviShevade
- **LinkedIn:** https://www.linkedin.com/in/tanvi-shevade-aabbb6280

---

# ⭐ Support

If you found this project helpful, please consider giving it a ⭐ on GitHub.

---

# 📄 License

This project was developed as an **BCA Final Year Project** 
