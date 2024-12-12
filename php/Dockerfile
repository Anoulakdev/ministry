# FROM php:8.2-apache
FROM php:8.2-apache

# Enable mod_rewrite
RUN a2enmod rewrite

# Install mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y

# Copy PHP application files
COPY . src:/var/www/html/

# Create an .htaccess file to remove .php extension
RUN echo "RewriteEngine On" >> src:/var/www/html/.htaccess
RUN echo "RewriteCond %{REQUEST_FILENAME} !-d" >> src:/var/www/html/.htaccess
RUN echo "RewriteCond %{REQUEST_FILENAME} !-f" >> src:/var/www/html/.htaccess
RUN echo "RewriteRule ^([^\.]+)$ $1.php [NC,L]" >> src:/var/www/html/.htaccess