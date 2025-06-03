# الخطوة 1: استخدم صورة PHP الرسمية
FROM php:8.2-fpm

# الخطوة 2: تثبيت الأدوات المطلوبة
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    npm \
    nodejs

# الخطوة 3: تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# الخطوة 4: إنشاء مجلد المشروع داخل الحاوية
WORKDIR /var/www

# الخطوة 5: نسخ ملفات المشروع إلى داخل الحاوية
COPY . .

# الخطوة 6: تثبيت PHP Extensions المطلوبة
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# الخطوة 7: إعداد Composer لتجاهل متطلبات النظام الأساسي
ENV COMPOSER_IGNORE_PLATFORM_REQS=1

# الخطوة 8: تثبيت الـ dependencies الخاصة بـ Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# الخطوة 9: تثبيت الـ node modules وتجهيز الواجهة لو بتستخدم Vue/React
RUN npm install && npm run build

# الخطوة 10: إعداد نقطة البدء
CMD ["php-fpm"]
