 💻 Vocab Client - Frontend Application

Ini adalah *Frontend Application* untuk **Vocab App**. Aplikasi ini bertugas menyediakan antarmuka pengguna (UI) dan berkomunikasi dengan **Vocab API** menggunakan protokol HTTP.

---

## Arsitektur Sistem

Project ini menggunakan pendekatan **Decoupled Architecture** (Pemisahan antara Frontend & Backend):
* **Frontend (Repository ini):** Dibangun dengan Laravel (Blade), Tailwind CSS, dan Vanilla JavaScript (Fetch API).
* **Backend (API):** Menggunakan layanan terpisah yang dapat dilihat di repository [english-vocab-api](https://github.com/HanifRoi/english-vocab-api).

---

## Fitur Utama

* **Autentikasi Terintegrasi:** Menu Login dan Register yang terhubung langsung dengan API Backend. Token autentikasi disimpan dengan aman di `localStorage`.
* **Manajemen Kosakata (CRUD):** 
  * Menampilkan daftar kosakata secara dinamis (*Read*).
  * Menambah kosakata baru (*Create*).
  * Mengubah detail kosakata (*Update*).
  * Menghapus kosakata (*Delete*).
* **Proteksi Rute (Middleware/Guard):** Pembatasan hak akses halaman, di mana halaman internal hanya bisa diakses oleh pengguna yang sudah terautentikasi (memiliki token).

---

## Teknologi & Tools (Tech Stack)

* **Framework:** Laravel 11 (Digunakan khusus untuk *routing* dan *view rendering*)
* **Styling Framework:** Tailwind CSS
* **HTTP Client:** Native JavaScript `fetch()`
* **Asset Bundler:** Vite

---

## Cara Menjalankan Project Secara Lokal

Ikuti langkah-langkah berikut untuk memasang dan menjalankan frontend di komputer lokal Anda:

### 1. Clone Repository & Install Dependensi
```bash
git clone https://github.com
cd vocab-client
composer install
npm install
```

### 2. Setup Environment File
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
php artisan key:generate
```
> **Catatan:** Sesuaikan konfigurasi database di file `.env` (diperlukan untuk kebutuhan internal *session* atau *cache* bawaan Laravel).

### 3. Jalankan Aplikasi & Asset Bundler
Pastikan Anda membuka dua terminal yang berbeda untuk menjalankan perintah di bawah ini secara bersamaan:

* **Terminal 1 (Jalankan Server Frontend di Port 8001):**
  ```bash
  php artisan serve --port=8001
  ```
* **Terminal 2 (Jalankan Vite Development Server):**
  ```bash
  npm run dev
  ```

> **Penting:** Pastikan layanan **API Backend** sudah menyala terlebih dahulu di port 8000 (`http://localhost:8000`) agar aplikasi frontend ini dapat bertukar data dengan lancar.

---

## Dikembangkan Oleh

* **Hanif Roihan**