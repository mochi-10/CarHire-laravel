# CarHire - Car Rental Management System

<p align="center">
  <img src="public/images/logo.png" alt="CarHire Logo" width="200">
</p>

A comprehensive car rental management system built with Laravel that allows users to browse, book, and manage car rentals online. The system includes both customer-facing and administrative interfaces for complete rental management.

## Features

- **User Authentication**
  - User registration and login
  - Password reset functionality
  - User profile management

- **Car Management**
  - Browse available cars with filters
  - Detailed car listings with images and specifications
  - Car availability calendar

- **Booking System**
  - Online booking with real-time availability
  - Booking management for customers and administrators
  - Booking confirmation and notifications

- **Admin Dashboard**
  - Manage cars, bookings, and users
  - View reports and analytics
  - Configure system settings

## Technologies Used

- **Backend**: Laravel 10.x
- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **Deployment**: XAMPP

## Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL
- XAMPP (for local development)

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/carhire.git
   cd carhire
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install NPM dependencies:
   ```bash
   npm install
   npm run dev
   ```

4. Create a copy of the .env file and generate an application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure your database in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=carhire
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Run database migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```

8. Access the application at `http://localhost:8000`

## Default Admin Credentials

- **Email**: admin@carhire.com
- **Password**: password

## Screenshots

(Add screenshots of your application here)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-source and available under the [MIT License](LICENSE).
