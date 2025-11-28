# 📦 Sistem Informasi Peminjaman Barang (Rental)

Proyek ini adalah aplikasi berbasis web untuk memfasilitasi layanan peminjaman atau penyewaan barang. Dibangun menggunakan framework **Laravel 12**, aplikasi ini memiliki fitur lengkap untuk memisahkan peran antara **Admin** (pengelola) dan **Customer** (penyewa).

## ✨ Fitur Utama

Aplikasi ini dibagi menjadi dua peran pengguna dengan fitur yang berbeda:

### 👤 Customer (Penyewa)
* **Katalog Barang:** Menelusuri daftar barang yang tersedia untuk disewa.
* **Detail Barang:** Melihat deskripsi, harga sewa, dan stok barang.
* **Keranjang Belanja (Cart):** Menambahkan barang ke keranjang sebelum checkout.
* **Pemesanan (Checkout):** Melakukan pemesanan sewa (mendukung metode pembayaran COD).
* **Riwayat Peminjaman:** Melihat status dan histori peminjaman yang pernah dilakukan.
* **Manajemen Profil:** Mengubah informasi profil dan password.
* **Informasi:** Halaman panduan cara sewa dan kebijakan pengembalian.

### 🛡️ Admin (Pengelola)
* **Dashboard:** Ringkasan statistik sistem.
* **Manajemen Kategori:** Membuat, mengedit, dan menghapus kategori barang.
* **Manajemen Barang (Items):**
    * CRUD Barang (Nama, Deskripsi, Harga Sewa, Stok, Gambar).
* **Manajemen Peminjaman (Rentals):**
    * Melihat daftar pesanan masuk.
    * Mengubah status peminjaman (Pending, Rented, Returned, Canceled).
    * Melihat detail peminjaman pengguna.
* **Manajemen Profil Admin.**

---

## 🛠️ Teknologi yang Digunakan

* **Backend Framework:** [Laravel 12](https://laravel.com)
* **Bahasa Pemrograman:** PHP ^8.2
* **Database:** MySQL
* **Frontend:** Blade Templates & Tailwind CSS (via Vite)
* **Package Tambahan:**
    * `laravel/ui` (untuk autentikasi)

---

## ⚙️ Persyaratan Sistem

Sebelum menjalankan proyek ini, pastikan komputer Anda telah terinstal:
* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL Database

---

## 🚀 Cara Instalasi & Menjalankan

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal (localhost):

1.  **Clone Repository**
    ```bash
    git clone [https://github.com/username/project-pweb-rental.git](https://github.com/username/project-pweb-rental.git)
    cd project-pweb-rental
    ```

2.  **Install Dependensi PHP (Composer)**
    ```bash
    composer install
    ```

3.  **Install Dependensi Frontend (NPM)**
    ```bash
    npm install
    ```

4.  **Konfigurasi Environment (.env)**
    * Salin file `.env.example` menjadi `.env`:
        ```bash
        cp .env.example .env
        ```
    * Buka file `.env` dan sesuaikan konfigurasi database Anda:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=nama_database_anda
        DB_USERNAME=root
        DB_PASSWORD=
        ```

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Migrasi Database**
    Jalankan perintah migrasi untuk membuat tabel (users, items, rentals, categories, dll) ke database:
    ```bash
    php artisan migrate
    ```
    *(Opsional: Jika ada seeder, jalankan `php artisan db:seed`)*

7.  **Jalankan Aplikasi**
    Buka dua terminal terpisah untuk menjalankan server Laravel dan Vite (untuk aset frontend):

    * Terminal 1 (Laravel Server):
        ```bash
        php artisan serve
        ```
    * Terminal 2 (Vite Build/Dev):
        ```bash
        npm run dev
        ```

8.  **Akses Aplikasi**
    Buka browser dan kunjungi: `http://localhost:8000`

---

## 📂 Struktur Database

Berdasarkan migrasi yang tersedia, berikut adalah tabel utama dalam sistem:

* `users`: Menyimpan data pengguna (Admin & Customer).
* `categories`: Kategori barang.
* `items`: Data barang yang disewakan (terhubung ke kategori).
* `carts` & `cart_items`: Menyimpan barang sementara sebelum checkout.
* `rentals`: Data transaksi peminjaman (tanggal sewa, status, total harga).
* `rental_details`: Detail barang apa saja yang ada dalam satu transaksi rental.

---

## 🔒 Keamanan & Hak Akses

Proyek ini menggunakan Middleware untuk membatasi akses:
* `auth`: Memastikan pengguna sudah login.
* `admin`: Middleware khusus untuk membatasi akses ke route `/admin/*`.
* `customer`: Middleware khusus untuk membatasi akses ke route `/customer/*`.

---

## 🤝 Kontribusi

Jika Anda ingin berkontribusi pada proyek ini, silakan *fork* repository ini dan buat *Pull Request* baru.

---

*Dibuat untuk memenuhi tugas Pemrograman Web (PWEB).*
````
