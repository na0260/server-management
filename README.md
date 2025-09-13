# Server Management

>“Xcloud Host Laravel Developer Task 2025”


## Features

- Server Crud Rest API.
- Data visualization.
- Responsive design.

---

## Requirements

- PHP >= 8.x
- Composer
- Laravel 12.x
- MySQL

---

## Installation

1. Clone the repository:

```bash
git clone https://github.com/na0260/server-management.git

cd server-management

```
2. Install dependencies:

```bash

composer install

```

3. Set up environment variables:

```bash

cp .env.example .env

```

4. Generate application key:

```bash
php artisan key:generate

```

5. Configure database credentials in .env:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=
```

6. Run database migrations:

```bash
php artisan migrate
```
7. Start the development server:

```bash
php artisan serve
```

---

Now the application should be running at `http://localhost:8000`.


---

## API Endpoints


Authentication:
- `POST /api/login`: Authenticate a user and obtain a token.
- `POST /api/register`: Register a new user.
- `POST /api/logout`: Logout the authenticated user.

Server CRUD Operations:
- `GET /api/servers`: Retrieve a list of all servers.
- `GET /api/servers/{id}`: Retrieve details of a specific server by ID
- `POST /api/servers`: Create a new server.
- `PUT /api/servers/{id}`: Update an existing server by ID.
- `DELETE /api/servers/{id}`: Delete a server by ID.

---

## AI USAGE
- For making UI I have used ChatGPT-4.
- For Bug Fixes I have used Github Copilot + ChatGPT-4.
- For Writing Readme I have used ChatGPT-4.

---

## Credits
- Developed by [Md Nur Ahmed](https://nurahmed.me/)

