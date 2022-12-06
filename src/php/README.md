1. docker-compose up
2. docker exec -it app /usr/bin/supervisor #TO START consuming
3. docker exec -it app php producer.php #TO PUBLISH MESSAGES
4. localhost -> to get requests count