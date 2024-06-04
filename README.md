Book Management System

This project is a RESTful API for managing book records, developed using PHP and the Laravel framework. The API allows users to add, retrieve, update, and delete book entries. Each book record includes an ID, title, author, and publication year.

Features
- CRUD Operations: Create, Read, Update, Delete book records.
- JSON Responses: API responses are formatted in JSON.
- Data Persistence: Uses PostgreSQL for data storage.
- Validation and Error Handling: Ensures no empty fields and positive publication year, with meaningful error messages.
- Security: Secures API with JWT (JSON Web Token) for authentication and authorization.
- Testing: Comprehensive unit and feature tests using PHPUnit.
- Documentation: API endpoints documented using Swagger.

Requirements
- PHP 7.4 or higher
- Composer
- Docker and Docker Compose
- PostgreSQL
- PgAdmin 

Setup Instructions
1. Clone the Repository
https://github.com/denishalimajj/bookStore.git
cd book-management
2. Copy .env.example to .env
cp .env.example .env
3. Configure Environment Variables
Update the .env file with your database and JWT settings:
DB_CONNECTION=pgsql
DB_HOST=postgres <-- Make sure that the container name is passed here
DB_PORT=5432
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

JWT_SECRET=your_jwt_secret
4. Install Dependencies
composer install
5. Generate Application Key
php artisan key:generate
6. Start Docker Containers
docker-compose up -d
7. Run Migrations
docker exec -it laravel_app php artisan migrate
8. Seed the Database (Optional)
docker exec -it laravel_app php artisan db:seed

pgAdmin Setup
1. Access pgAdmin
Open your web browser and navigate to http://localhost:5050.

2. Log In
Log in using the default email and password provided in the docker-compose.yml file (or as configured in your setup):

Email: admin@admin.com
Password: admin
3. Register a Server
- Right-click on "Servers" in the Browser panel.
- Select "Register" -> "Server".
- In the "General" tab, enter a name for the server (e.g., Book Management PostgreSQL).
- In the "Connection" tab, enter the following details:
Host: postgres
Port: 5432
Maintenance database: your_database
Username: your_username
Password: your_password
Click "Save".
You should now see your PostgreSQL server listed under "Servers" in pgAdmin, and you can manage your database from there.


Usage
Running the Application
The application will be available at http://localhost:8000.

API Endpoints
Create a Book: POST /api/books
Retrieve All Books: GET /api/books
Retrieve a Single Book: GET /api/books/{id}
Update a Book: PUT /api/books/{id}
Delete a Book: DELETE /api/books/{id}

Example Requests
Create a Book
curl -X POST http://localhost:8000/api/books -H "Content-Type: application/json" -d '{"title": "Book Title", "author": "Author Name", "publication_year": 2020}'
Retrieve All Books
curl http://localhost:8000/api/books

Testing
Run the tests using PHPUnit:
docker exec -it laravel_app php artisan test

Documentation
API documentation is available at http://localhost:8000/api/documentation.

