# Komando Helpdesk IT - Internal IT Ticket Dashboard

Aplikasi Manajemen Tiket Support IT Internal modern berbasis web yang dibangun menggunakan **Laravel 11**, **Livewire 3**, dan **Tailwind CSS** dengan desain **3D Soft Neumorphism (Soft UI Emboss & Pressed)**, skema warna **Dark/Light Mode**, **Multi-Bahasa (Indonesia & English)**, dan **Role-Based Access Control (RBAC)**.

---

## 🔗 Link & Repositori

- **Website Live (Vercel)**: [https://internal-it-ticket-dashboard.vercel.app](https://internal-it-ticket-dashboard.vercel.app)
- **Repositori GitHub**: [https://github.com/mpermana7/Internal_IT_Ticker_Dashboard](https://github.com/mpermana7/Internal_IT_Ticker_Dashboard)
- **Dokumentasi Google Docs**: [https://docs.google.com/document/d/1Bx76BaTsnD8fYwXAon_NmqTxiCQ5IxjHg9VQdQFEA2E/edit](https://docs.google.com/document/d/1Bx76BaTsnD8fYwXAon_NmqTxiCQ5IxjHg9VQdQFEA2E/edit)

---

## 📌 1. Ringkasan Proyek (Project Overview)

**Komando Helpdesk IT** adalah sistem dashboard tiket IT internal yang dirancang untuk mempermudah pelaporan masalah teknis pengguna, penugasan tiket ke teknisi IT, pemantauan status tiket secara real-time, dan pengorganisasian kategori layanan IT.

### Keunggulan Utama:
- **Desain UI Premium 3D Neumorphism**: Tampilan modern dengan efek bayangan Soft Emboss, Inner Pressed, dan animasi mikro yang responsif.
- **Dukungan Skema Warna Ganda**: Toggle cepat untuk mode tampilan **Gelap (Dark Mode)** dan **Terang (Light Mode)**.
- **Multi-Bahasa (Multi-Language)**: Dukungan penuh untuk **Bahasa Indonesia (ID)** dan **English (EN)**.
- **Role-Based Access Control (RBAC)**: Membedakan secara tegas hak akses antara **Admin**, **Teknisi**, dan **User**.

---

## 🛠️ 2. Teknologi yang Digunakan (Technologies Used)

- **Backend Framework**: Laravel 11 (PHP 8.2+)
- **Frontend Interaktif (SPA)**: Livewire 3 (Reaktivitas tanpa reload halaman)
- **Styling & Layout**: Tailwind CSS 3 dengan Kustomisasi CSS Neumorphic Shadows
- **Database Engine**:
  - **Lokal**: MySQL / MariaDB (XAMPP)
  - **Production (Vercel)**: SQLite Serverless Database (`/tmp/database.sqlite`)
- **Autentikasi & Otorisasi**: Laravel Auth & Policy (Role Guards: Admin, Technician, User)
- **Build Tool**: Vite 6
- **Deployment**: Vercel Serverless PHP Engine (`vercel-php@0.7.3`) & GitHub Auto-Sync

---

## ⚡ 3. Fitur yang Diimplementasikan (Features Implemented)

### A. Role-Based Access Control (RBAC)
1. 👑 **Role Admin**:
   - Memiliki akses penuh untuk membuat, mengedit, menugaskan teknisi, menguji status, dan menghapus tiket.
   - Mengelola Kategori Layanan IT (Tambah, Edit, Hapus).
   - Memantau ringkasan metriks statistik secara keseluruhan.
2. 🛠️ **Role Teknisi / Staff IT**:
   - Mengakses tiket yang khusus ditugaskan kepadanya.
   - Mengubah status tiket (*Terbuka*, *Sedang Diproses*, *Selesai*, *Ditutup*).
   - Modal edit tiket bersifat *read-only* untuk menjaga integritas data masalah.
   - Dapat menambahkan Catatan Internal IT pada tiket.
3. 👤 **Role User / Pemohon**:
   - Membuat tiket bantuan IT (Identitas pemohon terisi otomatis sesuai akun yang login).
   - Memantau tiket milik sendiri secara real-time.
   - Menambahkan catatan/komentar pada detail tiket miliknya.

### B. Metriks Dashboard Real-Time
- 4 Card Metriks Utama (Total Tiket, Tiket Terbuka, Tiket Diproses, dan Tiket Prioritas Tinggi) yang terhitung secara dinamis sesuai scope role pengguna.

### C. Pencarian, Filtering, & Pengurutan Dinamis
- Search bar instan untuk mencari nomor tiket, judul, atau deskripsi.
- Filter kustom berdasarkan Status, Prioritas, dan Kategori Layanan.
- Sorting dinamis berdasarkan tanggal dibuat atau tanggal diperbarui.

### D. Multi-Bahasa & Dark Mode
- Pengubah bahasa instan ID / EN di header atas.
- Mode tampilan Dark/Light yang konsisten di seluruh halaman aplikasi.

### E. Instant Demo Quick Login
- Tombol 1-klik untuk login cepat sebagai **IT Admin**, **Technician**, atau **User** pada halaman login.

---

## 🚀 4. Instruksi Pengaturan/Instalasi (Setup Instructions)

### Persyaratan Sistem
- PHP >= 8.2
- Composer >= 2.x
- Node.js >= 18.x & NPM
- MySQL / MariaDB (XAMPP)

### Langkah Instalasi Lokal
1. **Clone Repository**:
   ```bash
   git clone https://github.com/mpermana7/Internal_IT_Ticker_Dashboard.git
   cd Internal_IT_Ticker_Dashboard
   ```
2. **Instal Dependensi**:
   ```bash
   composer install
   npm install
   ```
3. **Konfigurasi File Environment**:
   Salin `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Atur koneksi MySQL pada `.env`:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=internal_it_ticket_dashboard
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```
5. **Migrasi Database & Seeding Data**:
   ```bash
   php artisan migrate:fresh --seed
   ```
6. **Jalankan Aplikasi**:
   - Terminal 1: `npm run dev`
   - Terminal 2: `php artisan serve`
   - Buka di browser: `http://127.0.0.1:8000`

### Akun Demo Bawaan (Default Seeded Accounts)
- 👑 **IT Admin**: `admin@it.local` | Password: `password`
- 🛠️ **Technician**: `budi@it.local` | Password: `password`
- 👤 **User**: `andri@company.com` | Password: `password`
