# Dockerfile
FROM mariadb:latest
RUN apt-get update && apt-get install -y mysql-client