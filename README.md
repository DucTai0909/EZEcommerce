![Home Page](/public/uploads/home_page.png)

# DT Ecommerce

DT Ecommerce is a small-scale, yet feature-rich e-commerce website crafted with modern technologies to offer a delightful online shopping experience. Tailored to meet the diverse needs of both customers and administrators, this platform seamlessly integrates features for smooth navigation, secure transactions, and efficient product management.

## Table of Contents

- [DT Ecommerce](#dt-ecommerce)
  - [Table of Contents](#table-of-contents)
  - [Installation](#installation)
  - [Features](#features)
  - [Technologies Used](#technologies-used)
  - [Contact](#contact)

## Installation

Follow these steps to set up and run the DT Ecommerce project locally:

1. Clone the repository: `git clone [https://github.com/DucTai0909/DT_Ecommerce.gitl]`.
2. Install project dependencies: `composer install`.
3. Install Nodejs.
4. Create the `.env` file and configure your database settings.
5. Run database migrations: `php artisan migrate`.
6. Seed the database (optional): `php artisan db:seed`.
7. Start the development server with command: `npm run dev` and `php artisan serve`.

## Features

+ Customers:
  - Search for products by brand, price.
  - Manage favorite products.
  - Manage personal information, change password.
  - Place orders and manage order history.
  - Support online payment via **VNPAY**.
  - Send order confirmation emails.
  - 
+ Admin:
  - CRUD operations for products, categories, brands, colors, and users.
  - Search, filter orders by status, update order status.
  - Send invoices to customer emails, export invoices as PDF files.
  - Product statistics, total orders by year/month/day.
  - Configure display information on the website: slider, social media links.

## Technologies Used

- **Frontend:**
  - HTML, CSS, JavaScript
  - Bootstrap, jQuery

- **Backend:**
  - Laravel

- **Database:**
  - MySQL

## Contact

For any inquiries or support, please contact us at [nguyentoductai@gmail.com].