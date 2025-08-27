# Use uma imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instala dependências do sistema necessárias para as extensões do PHP
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# Instala as extensões do PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mysqli pdo_mysql zip dom

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia os arquivos de dependência do Composer
COPY composer.json composer.lock ./

# Instala as dependências do Composer
RUN composer install --no-dev --optimize-autoloader

# Copia o restante dos arquivos da aplicação
COPY . .

# Altera o proprietário dos arquivos para o usuário do Apache
RUN chown -R www-data:www-data /var/www/html

# Expõe a porta 80
EXPOSE 80
