# 🏥 SRME - Sistem Rekam Medis Elektronik

**SRME** adalah aplikasi berbasis web yang dirancang untuk mendigitalkan proses operasional klinik, mulai dari pendaftaran pasien, rekam medis, antrean, hingga farmasi dan penagihan.

![SRME Dashboard](https://via.placeholder.com/800x400?text=SRME+Dashboard+Preview)

---

## 🚀 Fitur Utama

Sistem ini memiliki berbagai modul yang terintegrasi:

- **👥 Manajemen Pasien**: Pencatatan data demografis dan riwayat kunjungan pasien.
- **📋 Rekam Medis Elektronik (EMR)**: Pencatatan diagnosa, tindakan, dan riwayat medis oleh dokter.
- **📅 Pendaftaran & Antrean**: Manajemen jadwal temu (appointment) dan sistem antrean *real-time* untuk poli.
- **💊 Farmasi & Inventori**: Manajemen stok obat, resep digital, dan pemrosesan obat.
- **💰 Kasir & Penagihan**: Pembuatan invoice otomatis dan pencetakan bukti pembayaran.
- **🔬 Laboratorium**: (Opsional/Dalam Pengembangan) Manajemen permintaan dan hasil lab.
- **🔐 Manajemen Pengguna**: Kontrol akses berbasis peran (Role-Based Access Control) untuk Admin, Dokter, Perawat, Front Office, dan Farmasi.

---

## 🛠️ Teknologi yang Digunakan

- **Backend**: [Laravel 12](https://laravel.com) (PHP Framework)
- **Frontend**: [Blade Templates](https://laravel.com/docs/blade), [Tailwind CSS](https://tailwindcss.com)
- **Interaktivitas**: [Alpine.js](https://alpinejs.dev)
- **Database**: MySQL
- **Authentication**: Laravel Breeze / Spatie Permission

---

## ⚙️ Instalasi & Konfigurasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di lingkungan lokal Anda.

### Prasyarat
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/danyakmallun9999/srme.git
   cd srme
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.
   ```bash
   cp .env.example .env
   ```
   Buka file `.env` dan atur koneksi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=srme_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Generate App Key**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi & Seeding Database**
   Jalankan migrasi untuk membuat tabel dan seeder untuk data awal (user admin, roles, dll).
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan Aplikasi**
   Buka dua terminal terpisah untuk menjalankan server Laravel dan Vite (frontend build).
   
   *Terminal 1:*
   ```bash
   php artisan serve
   ```
   
   *Terminal 2:*
   ```bash
   npm run dev
   ```

7. **Akses Aplikasi**
   Buka browser dan kunjungi `http://localhost:8000`.

---

## 📖 Panduan Penggunaan Singkat

### Login Default
Jika Anda menggunakan seeder bawaan, berikut adalah beberapa akun default (password biasanya `password` atau `12345678` - cek `DatabaseSeeder.php`):

- **Admin**: Akses penuh ke seluruh sistem.
- **Dokter**: Akses ke modul pasien, rekam medis, dan jadwal.
- **Front Office**: Akses ke pendaftaran dan pembayaran.
- **Farmasi**: Akses ke resep dan inventori.

### Alur Kerja Umum
1. **Pendaftaran**: Front Office mendaftarkan pasien baru atau membuat janji temu.
2. **Pemeriksaan**: Dokter memanggil pasien dari antrean, melakukan pemeriksaan, dan input rekam medis + resep.
3. **Farmasi**: Bagian farmasi menerima resep digital dan menyiapkan obat.
4. **Pembayaran**: Kasir membuat invoice berdasarkan tindakan dan obat, lalu mencetak bukti bayar.

---

## 🤝 Kontribusi

Kontribusi selalu diterima! Silakan buat *Pull Request* atau laporkan *Issue* jika Anda menemukan bug.

## 📄 Lisensi

Aplikasi ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).
