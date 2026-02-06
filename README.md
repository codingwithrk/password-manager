<p align="center"><a href="https://codingwithrk.com/landing-page/password-manger" target="_blank"><img src="https://codingwithrk.com/assets/landing-pages/password-manager/main.png" width="400" alt="Password manager logo"></a></p>

# Password manager Mobile App

This is a password manager mobile application built using the [Laravel framework](https://laravel.com/). It provides users with a secure and convenient way to store and manage their passwords.

## Technologies Used

- [Laravel](https://laravel.com/): A powerful PHP framework for building web applications.
- [Livewire](https://laravel-livewire.com/): A full-stack framework for Laravel that makes building dynamic interfaces simple.
- [Tailwind CSS](https://tailwindcss.com/): A utility-first CSS framework for rapidly building custom user interfaces.
- [FluxUI](https://fluxui.dev/): A collection of pre-built UI components for Tailwind CSS.
- [Alpine.js](https://alpinejs.dev/): A minimal JavaScript framework for adding interactivity to your HTML.
- [SQLite](https://www.sqlite.org/index.html): A lightweight, file-based database engine.
- [NativePHP](https://nativephp.com/): A framework for building native mobile applications using PHP.

## How to Use

### Prerequisites

- PHP 8.0 or higher
- Composer
- NPM
- NativePHP plugins
    - [Mobile Biometrics](https://nativephp.com/plugins/nativephp/mobile-biometrics) (Paid)
    - [Mobile Secure Storage](https://nativephp.com/plugins/nativephp/mobile-secure-storage) (Paid)
    - [Mobile Dialog](https://nativephp.com/plugins/nativephp/mobile-dialog)
    - [Mobile Browser](https://nativephp.com/plugins/nativephp/mobile-browser)

1. Clone the repository:
   ```bash
   git clone https://github.com/codingwithrk/password-manager.git
    ```
2. Navigate to the project directory:
    ```bash
   cd password-manager
   ```
3. Install the dependencies:
    ```bash
   composer install
   ```
4. Copy the `.env.example` file to `.env` and configure your database settings:
    ```bash
   cp .env.example .env
   ```
5. Generate the application key:
    ```bash
   php artisan key:generate
   ```
6. Edit the `.env`:
    ```env
    NATIVEPHP_APP_ID=com.yourcompany.yourapp
    NATIVEPHP_APP_VERSION="DEBUG"
    NATIVEPHP_APP_VERSION_CODE="1"
    ```
7. Install NativePHP:
    ```bash
   php artisan native:install
    ```
8. Register NativePHP plugins [For Reference](https://nativephp.com/docs/mobile/3/plugins/using-plugins):
    ```bash
   // To Installed paid plugins, you can find this in your NativePHP account dashboard.
   composer config repositories.nativephp-plugins composer https://plugins.nativephp.com
   composer config http-basic.plugins.nativephp.com [EmailID] [KEY]
   
    php artisan vendor:publish --tag=nativephp-plugins-provider
    
    // Install Mobile Biometrics plugin
    php artisan native:plugin:register nativephp/mobile-biometrics
    
    // Install Mobile Secure Storage plugin
    php artisan native:plugin:register nativephp/mobile-secure-storage
    
    // Install Mobile Dialog plugin
    php artisan native:plugin:register nativephp/mobile-dialog
    
    // Install Mobile Browser plugin
    php artisan native:plugin:register nativephp/mobile-browser
    
    // Want to check installed plugins?
    php artisan native:plugin:list
    ```
9. Run the application in development mode:
    ```bash
   php artisan native:run
    ```

> For more detailed instructions and troubleshooting, please refer to the [NativePHP documentation](https://nativephp.com/docs/mobile/3/getting-started/introduction).

## License

This is open-sourced project licensed under the [MIT license](/LICENSE).
