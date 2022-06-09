#Lauku dati
##Prerequisites
* Docker Engine
* Docker CLI
* Docker Compose
For windows users: Docker Desktop on Windows

##Launch web-page locally
* service docker start
* docker-compose up


###First time launch
####May requare gain access to /storage folder:
* cd web-backend/
* chmod -R ugo+rwe /storage

###To manually create all tables:
* docker-compose exec web-backend bash
* php artisan migrate
