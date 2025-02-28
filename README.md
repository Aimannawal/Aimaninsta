# Aimaninsta

Aimaninsta adalah platform berbagi foto dan teks yang dibuat dengan Laravel. Pengguna dapat mendaftar, masuk, mengunggah postingan, memberikan like, dan berkomentar.

## Fitur

### 1. Register dan Login
- Pengguna dapat mendaftar menggunakan email dan password.
- Login untuk mengakses fitur aplikasi.
- Logout untuk keluar dari akun.

### 2. Posting Teks dan Gambar
- Pengguna dapat mengunggah gambar dengan teks sebagai caption.
- Setiap postingan akan disimpan di database dan ditampilkan di halaman utama.

### 3. Like dan Komentar
- Pengguna dapat menyukai postingan.
- Pengguna dapat memberikan komentar pada setiap postingan.

### 4. Autentikasi Pengguna
- Sistem menggunakan Laravel Authentication untuk mengamankan akses pengguna.
- Middleware digunakan untuk memastikan hanya pengguna terautentikasi yang dapat mengakses fitur tertentu.

### 5. Hak Akses terhadap Post, Like, dan Komentar
- Pengguna hanya bisa mengedit atau menghapus postingan milik mereka sendiri.
- Like dan komentar hanya dapat dilakukan oleh pengguna yang sudah login.
- Admin memiliki kontrol penuh atas semua postingan, komentar, dan pengguna.

## Instalasi

Ikuti langkah-langkah berikut untuk menginstal dan menjalankan proyek ini di lokal:

### 1. Clone Repository
```sh
git clone https://github.com/username/Aimaninsta.git
cd Aimaninsta
```

### 2. Install Dependencies
```sh
composer install
npm install
```

### 3. Konfigurasi Environment
- Duplikasi file `.env.example` menjadi `.env`
```sh
cp .env.example .env
```
- Edit `.env` dan sesuaikan dengan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=aimaninsta
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Key
```sh
php artisan key:generate
```

### 5. Migrasi dan Seeder Database
```sh
php artisan migrate --seed
```

### 6. Konfigurasi Storage Link
```sh
php artisan storage:link
```

### 7. Jalankan Server
```sh
php artisan serve
```

### 8. Jalankan Vite untuk Frontend 
```sh
npm run dev
```

