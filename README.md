## Laravel

Link Demo : https://testims.moanfs.com

Test developer pada PT. INOVASI MITRA SEJATI, pada test ini dibuat menggunakan tech berikut:

-   [Laravel 10](https://laravel.com/docs/10.x).
-   [Mysql](https://www.mysql.com/).

## Installation

```
git clone https://github.com/moanfs/test-ims-finance.git

```

## Usege

### backend

1. pada folder root jalankan

```
composer install
```

2. setelah rename file dengan nama .evn.example menjasi .env

```
mv .env.example .env
```

3. setelah itu generate key dengan copy dibawah

```
php artisan key:generate
```

4. lanjut dengan migrasi database dan seeder

```
php artisan migrate --seed
```

5. lanjut dengan menjalankan project dengan

```
php artisan serve
```
