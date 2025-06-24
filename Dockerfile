FROM php:8.2-apache

# Copia o projeto
COPY . /var/www/html/

# Ativa o mod_rewrite
RUN a2enmod rewrite

# Instala driver PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Habilita .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Expõe a porta usada pelo Railway
EXPOSE 8080

# Muda a porta do Apache para 8080 (padrão Railway)
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf /etc/apache2/sites-enabled/000-default.conf

CMD ["apache2-foreground"]
