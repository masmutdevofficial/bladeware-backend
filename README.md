# Bladeware Backend Installation on Coolify

This guide provides step-by-step instructions for deploying the Bladeware backend application on Coolify using a private GitHub repository, starting from a fresh Ubuntu 24.04 server.

## Prerequisites

1.  A server running Ubuntu 24.04.
2.  A Coolify instance installed and running.
3.  A private GitHub repository containing the Bladeware backend source code.
4.  A GitHub App configured for Coolify to access your private repository.

---

## Step 1: Install Coolify on Your Server

1.  SSH into your Ubuntu 24.04 server.
2.  Run the official Coolify installation script:
    ```bash
    wget -q https://get.coolify.io/coolify.sh
    bash ./coolify.sh
    ```
3.  Follow the on-screen instructions to complete the installation. Once finished, access your Coolify dashboard via the server's IP address or configured domain.

---

## Step 2: Connect Coolify to Your GitHub Account

1.  In the Coolify dashboard, navigate to the **"Source Control"** section from the sidebar.
2.  Select **"GitHub App"**.
3.  Follow the instructions to create a new GitHub App under your GitHub account or organization.
    *   **Homepage URL**: Your Coolify instance URL.
    *   **Callback URL**: Provided by the Coolify interface.
    *   **Webhook URL**: Provided by the Coolify interface.
4.  During the GitHub App setup, grant it access to your private `bladeware-backend` repository.
5.  Install the app and return to Coolify to finalize the connection.

---

## Step 3: Deploying the Laravel Application

1.  From the Coolify dashboard, click **"Create New Resource"**.
2.  Select **"Application"** as the resource type.
3.  **Choose Source:**
    *   Select **"GitHub"** as the source.
    *   Choose your `bladeware-backend` repository from the list.
    *   Select the branch you want to deploy (e.g., `main`).
4.  **Build & Install Configuration:**
    *   **Build Pack:** Coolify should automatically detect it as a **Laravel** application. If not, select `Nixpacks`.
    *   **Install Command:** `composer install --no-dev --optimize-autoloader`
    *   **Build Command:** `php artisan optimize:clear` (or leave empty if not needed).
    *   **Start Command:** `php artisan serve --host 0.0.0.0 --port 8000`
5.  **Environment Variables:**
    *   Navigate to the **"Environment Variables"** tab for your new application.
    *   Copy the contents of your local `.env.example` or `.env` file and paste them here.
    *   **Crucially, update the following variables:**
        *   `APP_URL`: The public URL of your application.
        *   `DB_CONNECTION`: `mysql`
        *   `DB_HOST`: The service name of your database in Coolify (e.g., `mysql-db`).
        *   `DB_PORT`: `3306`
        *   `DB_DATABASE`: Your database name.
        *   `DB_USERNAME`: Your database username.
        *   `DB_PASSWORD`: Your database password.
        *   `APP_KEY`: Generate a new one by running `php artisan key:generate --show` locally and pasting the result.
6.  **Persistent Storage:**
    *   Go to the **"Storage"** tab.
    *   Add the following persistent volume mappings to ensure your data is not lost on redeploys:
        *   `storage/app` -> `/app/storage/app`
        *   `storage/framework` -> `/app/storage/framework`
        *   `storage/logs` -> `/app/storage/logs`
        *   `public/storage` -> `/app/public/storage`
7.  **Deploy:**
    *   Click the **"Deploy"** button. Coolify will now pull the code, install dependencies, and start the application.
    *   After the first deployment, run the database migrations by opening a shell into the running container and executing:
        ```bash
        php artisan migrate --seed
        php artisan storage:link
        ```

Your Bladeware backend is now deployed and running on Coolify!
