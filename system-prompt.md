# Dokumen Master: Analisis Sistem Rumah TahfidzQu

## 1. Ringkasan Sistem & Arsitektur

- **Deskripsi Aplikasi**: Sistem Informasi Manajemen Rumah TahfidzQu, sebuah platform berbasis web yang bertujuan untuk mengelola administrasi pondok pesantren tahfidz, mencakup manajemen akademik (hafalan/halaqoh) hingga operasional keuangan.
- **Tech Stack**:
  - **Bahasa**: PHP
  - **Framework**: Yii Framework versi 1.x (Usang/End-of-Life)
  - **Database**: MySQL
  - **Library Utama**: `mPDF` dan `HTML2PDF` untuk pengeksporan laporan dokumen ke format PDF.

## 2. Daftar Fitur Utama & Modul

Berdasarkan struktur folder `protected/modules/`, sistem ini memiliki beberapa modul utama:

- **Modul Akun**: Manajemen akun pengguna aplikasi.
- **Modul API**: Endpoint untuk layanan integrasi eksternal.
- **Modul Santri**: Mengelola biodata santri, orang tua, riwayat penyakit, dan prestasi.
- **Modul Hafalan**: Pencatatan setoran hafalan (Mutabaah Tahfidz) dan persentase kelulusan target.
- **Modul Ustadz**: Manajemen data pengajar.
- **Modul Halaqoh**: Pengelompokan santri di bawah bimbingan ustadz tertentu.
- **Modul Asrama**: Manajemen kamar/pondokan santri.
- **Modul Tahun Ajaran**: Pengaturan semester dan periode ajaran baru.
- **Modul Keuangan**: Pencatatan transaksi masuk (Donasi/SPP) dan transaksi keluar (Pengeluaran).

## 3. Alur Logika Penting (Logic Flow) & Transaksi

- **Alur Data End-to-End**: Data dimasukkan melalui _form_ pada modul spesifik (misal: Ustadz memasukkan nilai mutabaah harian santri, atau staf mencatat donasi masuk). Input divalidasi oleh Controller, lalu disimpan ke tabel database menggunakan _Active Record_ Yii. Data ini kemudian diakumulasikan dan disajikan dalam bentuk GridView atau diekspor ke PDF/Excel sebagai laporan.
- **Logika Transaksi (Kritis)**: Berdasarkan inspeksi pada `DataController.php` di dalam modul keuangan (berukuran 29KB), **Data tidak ditemukan** terkait penggunaan _Atomic Transactions_ (seperti `Yii::app()->db->beginTransaction()`).
- **Rekomendasi**: Sistem transaksi finansial sangat rentan terhadap _race condition_ atau kegagalan _query_ parsial. Segera bungkus blok penyimpanan Donasi/Pengeluaran dengan metode transaksi (`beginTransaction`, `commit()`, `rollback()`). Gunakan tipe kolom `DECIMAL(15,2)` di MySQL alih-alih `FLOAT/INT` untuk akurasi nilai uang.

## 4. Integrasi Perangkat Keras (Printer & Scanner)

- **Printer Thermal**: **Data tidak ditemukan**. Tidak ada implementasi pustaka ESC/POS (seperti `mike42/escpos-php`) pada sistem ini. Pencetakan sepenuhnya mengandalkan library `mPDF` untuk cetak dokumen ukuran A4/Letter dan manipulasi CSS `@media print`.
- **Barcode Scanner**: **Data tidak ditemukan** mengenai skrip atau input yang dirancang khusus menangkap ketukan (_keystroke_) dari scanner barcode.
- **Saran Implementasi**: Mengingat ini adalah sistem tahfidz, perangkat keras POS tidak terlalu relevan. Namun, jika ke depannya kartu santri dilengkapi _barcode/QR code_ untuk absensi halaqoh atau pembayaran SPP, tambahkan _event listener_ JavaScript global (misal mendeteksi awalan spesifik) yang secara otomatis menangkap data scan tanpa harus memindahkan kursor mouse secara manual ke _input field_.

## 5. Sistem Pembayaran & API

- **Payment Gateway**: **Data tidak ditemukan**. Tidak ada penggunaan library Midtrans, Xendit, atau API QRIS lainnya dalam proyek ini. Modul keuangan bekerja secara murni manual untuk pencatatan buku kas.
- **Rekomendasi**: Demi mencegah _human error_ atau kebocoran dana setoran SPP/Donasi, sangat disarankan untuk mengintegrasikan Payment Gateway (contoh: Midtrans) pada sistem baru. Wali santri bisa langsung membayar menggunakan QRIS dinamis atau _Virtual Account_, dan status di sistem otomatis berubah menjadi "Lunas" melalui jalur _Webhook Callback_.

## 6. Struktur Database & ERD

- **Tabel Utama**: `User`, `Santri`, `Donasi`, `Pengeluaran`, `MutabaahTahfidz`, `Halaqoh`, `Pondokan`.
- **Entity-Relationship Diagram (Teks)**:
  - `User` (Peran: Ustadz) (1) ===Membimbing=== (N) `Halaqoh`
  - `Halaqoh` (1) ===Memiliki=== (N) `Santri`
  - `Santri` (1) ===Melakukan=== (N) `MutabaahTahfidz` (Riwayat Hafalan Harian)
  - `Santri` (1) ===Menempati=== (1) `Pondokan` (Kamar Asrama)
  - `Santri` (1) ===Membayar=== (N) `Donasi` (SPP/Infaq)

## 7. UML & Manajemen Akses

- **User Persona**: Admin Pusat, Ustadz (Pengajar), Bagian Keuangan, dan (opsional) Santri/Wali Santri.
- **Manajemen Hak Akses**: Sistem menggunakan _Role-Based Access Control_ (RBAC) yang cukup rapi, dikelola lewat `GroupController`, `AccessController`, dan `MenuController`.
- **Diagram Use Case (Teks)**:
  - **Ustadz**: Login -> Pilih Menu Halaqoh -> Input Hafalan Santri -> Lihat Rapor Hafalan.
  - **Keuangan**: Login -> Masuk Modul Keuangan -> Input Uang Masuk/Keluar -> Cetak Laporan Pemasukan.
  - **Admin**: Login -> Kelola Master Data (Santri, Tahun Ajaran, User) -> Konfigurasi Hak Akses Modul.

## 8. Analisis Keamanan & Konfigurasi

- **Audit Celah Keamanan**: Menggunakan Yii 1.x saat ini sangat berisiko karena framework tersebut sudah _End-Of-Life_ (tidak ada lagi _patch_ keamanan dari pengembang resmi), membuatnya rentan terhadap eksploitasi terbaru.
- **Konfigurasi Hardcoded**: **Ditemukan Celah Kritis**. Kredensial koneksi database (_username_, _password_, _dbname_) ditulis secara gamblang (hardcoded) di dalam file konfigurasi `protected/config/main.php`.
- **Rekomendasi Mutlak**: Hapus semua kredensial dari _source code_. Gunakan library seperti `vlucas/phpdotenv` untuk membaca variabel dari file `.env` yang tidak di-_commit_ ke repositori Git (`.gitignore`).

## 9. Analisis Tampilan & Rekomendasi UI/UX

- **Evaluasi Tampilan**: Tema yang digunakan (`themes`) mengandalkan layout _blueprint CSS_ lawas bawaan Yii. Desain kaku, tidak dinamis, dan kemungkinan besar berantakan jika diakses melalui _smartphone_ (tidak mobile-responsive).
- **Rekomendasi UI/UX**: Transformasi antarmuka secara menyeluruh menggunakan framework CSS modern (Tailwind CSS atau Bootstrap 5). Pastikan desain bersifat _Mobile-First_, karena pengguna utama (Ustadz) sangat mungkin menginput setoran hafalan santri sambil duduk di halaqoh hanya menggunakan _smartphone_. Tambahkan elemen _Dashboard_ analitik yang menarik, seperti diagram progres hafalan dan metrik dana donasi.

## 10. Standardisasi Pengembangan (Coding Standard)

- **Evaluasi Struktur Kode**: Kode lawas ini mematuhi struktur MVC bawaan Yii 1, namun banyak logika validasi dan bisnis yang menumpuk di area _Controller_ (terdeteksi _fat-controller_ hingga 29KB pada modul keuangan).
- **Rekomendasi Sistem Baru**: Terapkan standar industri _"Thin Controller, Fat Model"_. Pindahkan logika perhitungan dan validasi kompleks ke layer _Service_ atau _Model_. Jika memutuskan untuk me-rewrite sistem, sangat disarankan bermigrasi ke framework modern seperti **Laravel** (PHP) atau **Next.js** (Node.js). Gunakan fitur modern seperti _Form Request Validation_, implementasi ORM secara ketat, dan gunakan konvensi penamaan _camelCase_ untuk properti serta _PascalCase_ untuk Class agar kode bersih, modular, dan mudah di-maintain.
