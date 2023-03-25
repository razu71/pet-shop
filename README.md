#Installation process

- Open terminal and go to your project directory.
- Run `run.sh` file by typing `/bin/bash run.sh`
  - N.B. If you are not in project directory then type full project path. Ex. `/bin/bash /opt/homebrew/var/www/pet-shop/run.sh`. Here `/opt/homebrew/var/www/pet-shop` is my project path.
- It will ask your database username. Ex. `root`
- Then ask your database password. Ex. `123456`
- Then it will your database name which you want to create. Ex. `pet_shop`
  - N.B. Follow database name rules. Like, name should not more than 64 characters, can not contain `/` `\` `.` or `-`
- Then it will create a database in your mysql db and set db credentials to `.env` file.
- Then create application key.
- Database migration and seed.
- At the end, run artisan server.
