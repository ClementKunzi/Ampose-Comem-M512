# Ampose-Comem-M512


Installation

1. Installing Laravel
1.1. Access root of project
1.2. Install laravel with laravel new / laravel
1.3. In the setup, choose MYSQL as db system. All other options can be set as default.

2. Installing Vite
2.1. Access /laravel folder
2.2. npm install 

3. Installing Vuejs
3.1. Access /laravel folder
3.2. Install Vuejs with npm install --save-dev @vitejs/plugin-vue


Once repo is cloned
1. composer install
2. create .env file
3. Generate application key : php artisan key:generate
4. Migrate DB : php artisan migrate:fresh --seed
5. Instal Vite and Vue : npm install
6. Run Backend : php artisan serve
7. Run frontend : npm run dev
