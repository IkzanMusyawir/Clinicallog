# 🏥 Clinicallog CMS

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-13.16.1-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.4.13-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" />
  <img src="https://img.shields.io/badge/Vite-Build_Tool-646CFF?style=for-the-badge&logo=vite&logoColor=white" />
</p>

<p align="center">
  <strong>Clinicallog CMS</strong> merupakan sistem manajemen website klinik (Content Management System) berbasis <strong>Laravel 13</strong> yang dikembangkan sebagai proyek mata kuliah <strong>Proyek Informatika</strong>.
</p>

---

# 📖 Deskripsi

Clinicallog CMS merupakan aplikasi berbasis web yang dirancang untuk membantu pengelolaan website klinik melalui dashboard admin yang mudah digunakan.

Website ini menyediakan Landing Page modern untuk pengunjung sekaligus Content Management System (CMS) yang memungkinkan administrator mengelola berbagai informasi pada website secara efisien.

---

# ✨ Fitur

* 🏠 Landing Page Modern
* 📅 Manajemen Appointment
* ⚙️ Dashboard Administrator
* ⭐ Manajemen Feature Website
* 📱 Responsive Design
* 🔐 Authentication Admin
* ⚡ Fast Performance menggunakan Laravel 13
* 🎨 UI Modern menggunakan Tailwind CSS

---

# 🛠️ Teknologi

| Teknologi    | Versi                |
| ------------ | -------------------- |
| Laravel      | 13.16.1              |
| PHP          | 8.4.13               |
| Composer     | 2.8.12               |
| MySQL        | Database             |
| Blade        | Template Engine      |
| Tailwind CSS | Frontend UI          |
| JavaScript   | Frontend Interaction |
| Vite         | Asset Bundler        |

---

# 📂 Struktur Project

```text
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
tests/
```

---

# 🚀 Instalasi

## 1. Clone Repository

```bash
git clone https://github.com/IkzanMusyawir/Clinicallog.git
```

## 2. Masuk ke Folder Project

```bash
cd Clinicallog
```

## 3. Install Dependency

```bash
composer install
```

```bash
npm install
```

## 4. Salin File Environment

Windows

```bash
copy .env.example .env
```

Linux / Mac

```bash
cp .env.example .env
```

## 5. Generate Application Key

```bash
php artisan key:generate
```

## 6. Konfigurasi Database

Edit file `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clinicallog
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan dengan database yang digunakan.

## 7. Jalankan Migrasi

```bash
php artisan migrate
```

Jika project menggunakan seeder

```bash
php artisan db:seed
```

atau

```bash
php artisan migrate --seed
```

## 8. Jalankan Aplikasi

Terminal pertama

```bash
php artisan serve
```

Terminal kedua

```bash
npm run dev
```

Aplikasi dapat diakses melalui

```
http://127.0.0.1:8000
```

---



# ⚙️ Environment

| Item     | Nilai        |
| -------- | ------------ |
| Laravel  | 13.16.1      |
| PHP      | 8.4.13       |
| Composer | 2.8.12       |
| Database | MySQL        |
| Timezone | Asia/Jakarta |
| Locale   | id           |

---

# 👨‍💻 Developer

**Ikzan Musyawir**

Program Studi Teknik Informatika dan Komputer

Universitas Negeri Makassar

---

# 📄 Lisensi

Project ini dikembangkan untuk keperluan pembelajaran dan penyelesaian tugas mata kuliah **Proyek Informatika**.

Repository ini dapat digunakan sebagai referensi pembelajaran dengan tetap menghormati hak cipta pengembang.

---

⭐ **Terima kasih telah mengunjungi repository ini.**
