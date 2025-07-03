# Proyek Aplikasi Toko (E-Commerce) - Pemrograman Web Lnajut

Aplikasi e-commerce sederhana yang dibangun menggunakan framework **CodeIgniter 4**. Proyek ini mencakup fungsionalitas dasar toko online, mulai dari autentikasi pengguna, manajemen produk, keranjang belanja, hingga proses checkout. Aplikasi ini juga dilengkapi dengan fitur-fitur khusus seperti manajemen diskon harian, manajemen pembelian oleh admin, dan penyediaan webservice untuk dashboard eksternal.

## Fitur Utama

* **Autentikasi & Peran Pengguna**:
    * Sistem login dan logout untuk pengguna.
    * Pembagian peran (role) antara **Admin** dan **Guest (Pengguna Biasa)** untuk membatasi akses ke fitur tertentu.

* **Manajemen Diskon (Khusus Admin)**:
    * Admin dapat melakukan operasi **CRUD** (Create, Read, Update, Delete) untuk data diskon harian.
    * Terdapat validasi untuk memastikan **tidak ada diskon pada tanggal yang sama**.
    * Pada form edit, input tanggal bersifat `readonly` untuk mencegah perubahan tanggal diskon.

* **Penerapan Diskon Otomatis**:
    * Sistem secara otomatis memeriksa ketersediaan diskon pada hari pengguna login.
    * Jika ada, notifikasi diskon akan muncul di header website.
    * Harga produk akan **otomatis terpotong** oleh nominal diskon saat dimasukkan ke dalam keranjang.

* **Keranjang Belanja (Shopping Cart)**:
    * Pengguna dapat menambahkan produk ke keranjang.
    * Melihat, memperbarui jumlah, dan menghapus item dari keranjang.
    * Total harga di keranjang sudah memperhitungkan potongan diskon.

* **Proses Checkout & Integrasi Ongkir**:
    * Proses checkout yang terintegrasi dengan API eksternal (misalnya RajaOngkir) untuk menghitung ongkos kirim secara dinamis berdasarkan alamat tujuan.
    
* **Manajemen Pembelian (Khusus Admin)**:
    * Admin dapat melihat **seluruh riwayat transaksi pembelian** dari semua pengguna.
    * Admin dapat mengubah status pesanan dari "Belum Selesai" menjadi "Sudah Selesai".
    * Tersedia fitur untuk melihat **detail item** pada setiap transaksi melalui modal pop-up.

* **Ekspor Dokumen (PDF)**:
    * Aplikasi memiliki kapabilitas untuk menghasilkan dokumen dalam format PDF menggunakan pustaka dompdf.
    * Fitur ini dapat dikembangkan untuk mencetak laporan penjualan atau invoice/nota untuk setiap transaksi.

* **Webservice (API) & Dashboard**:
    * Proyek ini menyediakan **API** untuk mengekspos data transaksi pembelian.
    * Terdapat aplikasi **Dashboard sederhana** terpisah yang mengonsumsi API tersebut untuk menampilkan data transaksi, lengkap dengan **jumlah total item** per transaksi.

## Penjelasan Alur Kerja Fitur

### Alur Pengguna (Guest)

1.  **Pendaftaran & Login**: Pengguna dapat mendaftar dan login ke dalam sistem. Setelah login, sistem akan membuat sebuah *session* untuk menyimpan data pengguna.
2.  **Pengecekan Diskon**: Saat login berhasil, sistem secara otomatis akan memeriksa tabel `diskon` di database. Jika terdapat diskon yang berlaku untuk tanggal hari itu, nominal diskon akan disimpan ke dalam *session* pengguna dan sebuah notifikasi akan muncul di header.
3.  **Menambahkan Produk ke Keranjang**: Saat pengguna menambahkan produk ke keranjang, sistem akan melakukan langkah berikut:
    * Mengambil harga asli produk dari database.
    * Memeriksa *session* untuk data diskon.
    * Jika diskon ada, harga asli akan dikurangi dengan nominal diskon. Harga akhir inilah yang akan disimpan ke dalam keranjang belanja.
4.  **Checkout & Transaksi**: Pengguna dapat melanjutkan ke proses checkout, di mana mereka akan mengisi alamat pengiriman. Aplikasi terintegrasi dengan webservice eksternal untuk menghitung ongkos kirim secara dinamis. Setelah pesanan dibuat, data transaksi (termasuk harga yang sudah didiskon dan ongkir) akan tersimpan di database.
5.  **Riwayat Pembelian**: Pengguna dapat melihat seluruh riwayat transaksinya sendiri melalui halaman "Profile".

### Alur Admin

1.  **Akses Khusus**: Admin memiliki menu tambahan di sidebar yang tidak dapat diakses oleh pengguna biasa, yaitu "Manajemen Diskon" dan "Manajemen Pembelian". Akses ini dibatasi menggunakan *filter* dan pengecekan *role* pada session.
2.  **Manajemen Diskon**:
    * Admin dapat menambah, mengubah, dan menghapus diskon harian melalui halaman khusus.
    * Sistem menerapkan **validasi** untuk mencegah admin menambahkan diskon pada tanggal yang sudah terisi.
    * Saat mengedit, kolom tanggal dibuat **readonly** untuk menjaga integritas data.
3.  **Manajemen Pembelian**:
    * Admin dapat melihat **seluruh transaksi** dari semua pengguna dalam satu tabel.
    * Admin memiliki wewenang untuk **mengubah status pesanan** dari "Belum Selesai" menjadi "Sudah Selesai".
    * Admin dapat mengklik tombol **"Detail"** pada setiap transaksi untuk melihat rincian barang yang dibeli, harga asli, diskon yang didapat, subtotal, hingga ongkos kirim melalui jendela modal (pop-up).

### Arsitektur Tambahan: Webservice & Dashboard

1.  **Penyediaan API**: Aplikasi "Toko" utama menyediakan sebuah *endpoint* API (`/api`) yang aman (memerlukan API Key). Endpoint ini berfungsi untuk mengirimkan data seluruh transaksi dalam format JSON.
2.  **Perhitungan di Sisi API**: Sebelum mengirimkan data, API akan melakukan kalkulasi untuk menambahkan data baru yaitu `jumlah_item` (total item per transaksi) ke dalam setiap data transaksi. Proses ini dibuat seefisien mungkin (hanya 2 query database) untuk menjaga performa.
3.  **Dashboard Eksternal**: Sebuah file `dashboard.php` yang terpisah berfungsi sebagai aplikasi klien. Aplikasi ini akan memanggil API dari "Toko", mengambil data JSON, lalu menampilkannya dalam bentuk tabel yang mudah dibaca, termasuk menampilkan status pesanan dalam format teks ("Sudah Selesai") dan jumlah total item yang dibeli.

## Teknologi & Library yang Digunakan

### Lingkungan Pengembangan
* **PHP**: Bahasa pemrograman utama yang digunakan (disarankan versi 8.1+).
* **CodeIgniter 4**: Framework PHP utama yang menjadi fondasi seluruh aplikasi, menyediakan struktur MVC, routing, dan berbagai helper.
* **Composer**: Manajer dependensi untuk PHP, digunakan untuk menginstal dan mengelola semua pustaka pihak ketiga.
* **MySQL / MariaDB**: Sistem manajemen database relasional untuk menyimpan semua data aplikasi.
* **Apache / Nginx**: Web server untuk melayani aplikasi ke pengguna.

### Pustaka Utama (via Composer)
Folder `vendor` berisi semua pustaka yang diinstal oleh Composer. Berikut adalah beberapa yang paling penting dalam proyek ini:

* **`codeigniter4/framework`**: Pustaka inti dari CodeIgniter 4 itu sendiri.
* **`dompdf/dompdf`**: Pustaka yang sangat populer untuk membuat dan mengonversi HTML ke dalam format **PDF**. Dalam konteks proyek ini, `dompdf` bisa digunakan untuk fitur seperti mencetak laporan penjualan, invoice, atau nota pembelian.
* **`guzzlehttp/guzzle`**: Sebuah Klien HTTP yang powerful. Dalam proyek ini, `guzzle` digunakan di dalam `TransaksiController` untuk berkomunikasi dengan **API eksternal** (RajaOngkir) guna mendapatkan data ongkos kirim secara dinamis.
* **`fakerphp/faker`**: Pustaka untuk menghasilkan data palsu (fake data). Sangat berguna dalam tahap pengembangan untuk mengisi database dengan data sampel (contohnya: data pengguna atau produk) melalui *Database Seeder*.
* **`phpunit/phpunit`**: Framework standar untuk *testing* di PHP. Digunakan untuk menjalankan *unit test* atau *feature test* secara otomatis untuk memastikan setiap bagian dari kode berjalan sesuai harapan dan bebas dari bug.
* **`myclabs/php-enum`**: Pustaka yang menyediakan fungsionalitas `Enum` (Enumeration) yang lebih kuat, seringkali digunakan untuk mendefinisikan sekumpulan konstanta yang tetap, seperti status pesanan (`PENDING`, `COMPLETED`, `CANCELLED`).

## Prasyarat

Sebelum menjalankan proyek, pastikan Anda sudah menginstal perangkat lunak berikut:
* PHP (versi 8.1 atau lebih baru)
* Composer
* Web Server (Apache, Nginx, atau sejenisnya)
* Database (MySQL atau MariaDB)

## Struktur Proyek

Berikut adalah gambaran umum struktur folder dan file penting dalam proyek ini:

* `app/`
    * **`Controllers/`**: Berisi semua controller yang mengatur logika aplikasi, seperti `AuthController.php`, `DiskonController.php`, `PembelianController.php`, `TransaksiController.php`, dan `ApiController.php`.
    * **`Models/`**: Berisi semua model yang berinteraksi dengan database, seperti `UserModel.php`, `DiskonModel.php`, `TransactionModel.php`, dll.
    * **`Views/`**: Berisi semua file tampilan (HTML/PHP), termasuk `layout/` sebagai template utama, dan view-view spesifik seperti `v_pembelian.php` dan `v_diskon.php`.
    * **`Database/`**:
        * `Migrations/`: Berisi file-file untuk membuat dan mengelola struktur tabel database.
        * `Seeds/`: Berisi file untuk mengisi data awal ke dalam database.
    * **`Filters/`**: Mengatur filter middleware, seperti `Auth.php` untuk memeriksa apakah pengguna sudah login dan memiliki peran yang sesuai.
* `public/`
    * Folder ini adalah *document root* dari aplikasi.
    * Berisi aset seperti CSS, JavaScript, dan gambar.
    * Folder `dashboard-toko/` yang berisi aplikasi dashboard sederhana juga ditempatkan di sini.
* `.env`
    * File konfigurasi utama untuk lingkungan pengembangan, termasuk koneksi database dan variabel penting lainnya.

## Panduan Instalasi

### Tahap 1: Persiapan Awal (Instalasi Tools)

1.  **Code Editor: VS Code**
2.  **Web Server & Database: XAMPP**
    * XAMPP adalah paket yang berisi Apache (web server), PHP, dan MySQL (database) dalam satu kali instalasi.
3.  **Dependency Manager: Composer**
    * Composer adalah alat untuk menginstal pustaka (library) PHP yang dibutuhkan oleh proyek.
4.  **Version Control: Git**
    * Git digunakan untuk mengunduh (clone) kode proyek dari GitHub.

### Tahap 2: Download Proyek dan Buat Database

1.  **Buat Database Baru**
    * Buka browser dan akses **phpMyAdmin** melalui alamat `http://localhost/phpmyadmin`.
    * Klik tab **"Databases"** atau menu **"New"**.
    * Pada kolom nama database, ketik nama database baru.
    * Klik tombol **"Create"**. 

### Tahap 3: Konfigurasi Proyek

1.  **Buka Proyek di VS Code**
    * Buka aplikasi VS Code.
    * Pilih `File > Open Folder...` lalu arahkan ke folder tempat mengunduh xamppnya (ke htdocs)
2.  **Instal Library Proyek**
    * Di VS Code, buka Terminal baru melalui menu `Terminal > New Terminal`.
    * Di dalam terminal, jalankan perintah berikut untuk menginstal semua pustaka yang dibutuhkan.
        ```bash
        composer install
        ```
3.  **Atur File Konfigurasi (`.env`)**
    * Di panel file VS Code, cari file bernama `env` (tanpa titik di depan).
    * Buat salinan dari file tersebut dan beri nama `.env` (dengan titik di depan).
    * Buka file `.env` yang baru

### Tahap 4: Siapkan Tabel dan Data Awal

Masih di terminal VS Code, jalankan dua perintah berikut secara berurutan:

1.  **Buat Semua Tabel (Migrasi)**
    Perintah ini akan membaca file migrasi dan membuat semua tabel yang dibutuhkan di database.
    ```bash
    php spark migrate
    ```

2.  **Isi Data Awal (Seeding)**
    Perintah ini akan menjalankan seeder untuk mengisi data awal, contohnya data diskon.
    ```bash
    php spark db:seed DiskonSeeder
    ```

### Tahap 5: Jalankan Aplikasi

Setelah semua persiapan selesai, jalankan server lokal bawaan CodeIgniter dengan perintah berikut di terminal VS Code:

```bash
php spark serve

# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
