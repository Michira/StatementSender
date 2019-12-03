# StatementSender
An app that sends statements to clients via Email

# How to set up
1. Clone the app to the server
2. Run composer update to install dependencies
3. Run the command cp .env.example .env to copy env configurations
4. Set the correct DB configurations and email configs
5. Run the command php artisan migrate:refresh --seed to run migrations and seed data to the DB
6. Ensure right permissions for the /storage and /bootstrap/cache folders
7. You can edit the DB to add an entry of a client who has your credentials so that you receive the email. Also add an entry in client_products to assign the client a product. Then give the client transactions in the transactions table.
