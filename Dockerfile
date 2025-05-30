# Use an official PHP image with Apache as the base image.
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html
# Copy the rest of the application code
COPY . .

# Install system dependencies.
# Update package list and install common dependencies + PHP extensions dependencies
RUN apt-get update && apt-get install -y \
    apt-utils \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    vim \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions.
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip bcmath

RUN docker-php-ext-install mysqli

# Configure Apache
# Enable Apache rewrite module
RUN a2enmod rewrite

ENV CHOKIDAR_USEPOLLING=true

# Expose port 80
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
