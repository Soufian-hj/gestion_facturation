# gestion_facturation

## Setup Instructions

After cloning this repository, follow these steps to set up your Laravel application:

1. **Install Composer dependencies**
   ```bash
   composer install
   ```

2. **Install NPM dependencies** (for frontend assets)
   ```bash
   npm install
   ```

3. **Copy the example environment file and configure it**
   ```bash
   cp .env.example .env
   ```
   Edit the `.env` file to set your database and other environment variables.

4. **Generate the application key**
   ```bash
   php artisan key:generate
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **(Optional) Seed the database**
   ```bash
   php artisan db:seed
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

Your Laravel app should now be running at http://localhost:8000