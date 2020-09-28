up:
	docker-compose up -d; docker-compose ps;
	docker exec -it restwecont_webserver /var/www/html/script/updatabase.sh
	docker exec restwecont_webserver composer install --prefer-dist --working-dir=/var/www/html/restwecont
	docker exec restwecont_webserver redis-server --daemonize yes --protected-mode no

down:
	docker-compose down

dbup:
	docker exec -it restwecont_webserver /var/www/html/script/updatabase.sh

genPass:
	@docker exec restwecont_webserver php -r 'echo password_hash("$(password)", PASSWORD_ARGON2I);'