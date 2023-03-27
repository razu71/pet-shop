#!/bin/bash

cp .env.example .env

#Create DB
echo -n "Enter a database username > "
read db_username
echo -n "Enter a database password > "
read db_password
echo -n "Enter a database name to create > "
read db_database
echo "creating database $db_database"
mysql -u$db_username -p$db_password -e "create database $db_database";
sleep 1
echo "Database created"

# config db name
echo "Setting db database name in .env file"
sed  -i~ "/^DB_DATABASE=/s/=.*/=$db_database/" .env

# config db username
echo "Setting db username in .env file"
sed  -i~ "/^DB_USERNAME=/s/=.*/=$db_username/" .env

# Config db password
echo "Setting db password in .env file"
sed  -i~ "/^DB_PASSWORD=/s/=.*/=$db_password/" .env

# Server run
echo "Generate an APP key"
php artisan key:generate &
echo "Migration started"
php artisan migrate --seed &
echo "Migration and seeder finished successfully"
php artisan storage:link &
echo "Storage linked"
echo "Server Ready"
php artisan serve
