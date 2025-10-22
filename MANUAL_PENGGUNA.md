# MANUAL PENGGUNA E-RAPOR
## Sistem Manajemen Rapor Digital SMK Muhammadiyah Plus Tanjung Selor

---

**Versi:** 1.0
**Tanggal:** Desember 2025
**Developer:** PT Benuanta Technology Consultant

---

## DAFTAR ISI

1. [Pengenalan Aplikasi](#1-pengenalan-aplikasi)
2. [Spesifikasi Sistem](#2-spesifikasi-sistem)
3. [Cara Login](#3-cara-login)
4. [Panduan Berdasarkan Role](#4-panduan-berdasarkan-role)
5. [Modul Data Master](#5-modul-data-master)
6. [Modul Penilaian](#6-modul-penilaian)
7. [Modul P5 (Profil Pelajar Pancasila)](#7-modul-p5-profil-pelajar-pancasila)
8. [Modul Ekstrakurikuler](#8-modul-ekstrakurikuler)
9. [Modul PKL](#9-modul-pkl)
10. [Generate Rapor](#10-generate-rapor)
11. [FAQ & Troubleshooting](#11-faq--troubleshooting)

---

## 1. PENGENALAN APLIKASI

### 1.1 Tentang E-Rapor

E-Rapor adalah sistem manajemen rapor digital berbasis web yang dikembangkan khusus untuk SMK Muhammadiyah Plus Tanjung Selor. Aplikasi ini mengimplementasikan Kurikulum Merdeka dengan fitur lengkap untuk:

- Manajemen data sekolah, guru, siswa, dan kelas
- Penilaian berbasis Kurikulum Merdeka
- Projek Penguatan Profil Pelajar Pancasila (P5)
- Ekstrakurikuler dan PKL
- Generate rapor otomatis (Semester, P5, Buku Induk)

### 1.2 Fitur Utama

✅ **Multi-role Access Control** - Akses berbeda untuk Kepala Sekolah, Operator, Guru, Pembina, dan Pembimbing PKL
✅ **Penilaian Komprehensif** - Support berbagai teknik penilaian (ulangan, tugas, praktik, projek)
✅ **Capaian Kompetensi** - Input deskripsi capaian per mata pelajaran
✅ **P5 Projects** - Management projek penguatan profil pelajar dengan 6 dimensi
✅ **Auto Calculate** - Perhitungan otomatis nilai akhir dari berbagai penilaian
✅ **PDF Generation** - Generate rapor dalam format PDF siap cetak

---

## 2. SPESIFIKASI SISTEM

### 2.1 Kebutuhan Sistem

**Server Requirements:**
- PHP >= 8.2
- MySQL/MariaDB
- Apache/Nginx Web Server
- Composer

**Browser Requirements:**
- Google Chrome (Recommended)
- Mozilla Firefox
- Microsoft Edge
- Safari

### 2.2 Teknologi yang Digunakan

- **Framework:** Laravel 12.27.1
- **CSS Framework:** Tailwind CSS
- **JavaScript:** Alpine.js
- **PDF Library:** SnappyPDF (wkhtmltopdf)

---

## 3. CARA LOGIN

### 3.1 Akses Halaman Login

1. Buka browser (Chrome/Firefox/Edge)
2. Ketik URL: `http://localhost/erapor/public/login` atau sesuai domain yang diberikan
3. Halaman login akan muncul

### 3.2 Proses Login

1. Masukkan **Username** yang telah diberikan
2. Masukkan **Password**
3. Klik tombol **"Masuk"**
4. Sistem akan mengarahkan ke dashboard sesuai role Anda

### 3.3 Default Credentials

**Password Default untuk Semua User:** `SMK2025!@#`

**Username yang Tersedia:**
- `kepalasekolah` - Kepala Sekolah (Full Access)
- `walikelasX` - Wali Kelas X
- `walikelasXI` - Wali Kelas XI
- `walikelasXII` - Wali Kelas XII

⚠️ **PENTING:** Ganti password default setelah login pertama kali!

### 3.4 Ketentuan Password Baru

Saat menambah user baru, password harus memenuhi kriteria berikut:

✅ **Minimal 8 karakter**
✅ **Mengandung huruf besar (A-Z)**
✅ **Mengandung huruf kecil (a-z)**
✅ **Mengandung angka (0-9)**
✅ **Mengandung simbol (!@#$%^&* dll)**

Sistem akan menampilkan indikator kekuatan password:
- 🔴 **Merah** = Password Lemah (tidak bisa disimpan)
- 🟡 **Kuning** = Password Sedang (tidak bisa disimpan)
- 🟢 **Hijau** = Password Kuat (bisa disimpan)

Contoh password yang memenuhi syarat: `Smk2025!@#`

### 3.5 Lupa Password

Hubungi operator sekolah atau administrator sistem untuk reset password.

---

## 4. PANDUAN BERDASARKAN ROLE

### 4.1 Kepala Sekolah & Operator

**Hak Akses:** FULL ACCESS ke semua fitur

**Dashboard:** Redirect ke Profil Sekolah

**Menu yang Dapat Diakses:**
- ✅ Sekolah (Profil & Edit)
- ✅ Semester (Management tahun ajaran)
- ✅ Users (Guru & Staff)
- ✅ Kelas
- ✅ Siswa
- ✅ Mata Pelajaran
- ✅ Mapel Kelas (Assignment)
- ✅ Penilaian (Semua modul)
- ✅ P5BK, Ekstrakurikuler, PKL
- ✅ Rapor (Generate & Print)

**Tugas Utama:**
1. Setup data master (sekolah, semester, users, kelas, siswa, mapel)
2. Monitoring penilaian
3. Generate rapor
4. Cetak rapor untuk distribusi

### 4.2 Guru / Guru Mapel / Wali Kelas

**Hak Akses:** Akses penuh ke penilaian, P5, ekstrakurikuler, PKL, kokurikuler, dan rapor

**Dashboard:** Redirect ke Mapel Kelas

**Menu yang Dapat Diakses:**
- ✅ Sekolah (View only)
- ✅ Mapel Kelas (View & Input Nilai)
- ✅ Penilaian (Input nilai untuk mapel yang diampu)
  - ✅ Perencanaan Asesmen
  - ✅ Input Nilai per Penilaian
  - ✅ Board Penilaian (Tabel cepat)
  - ✅ Nilai Akhir & Capaian Kompetensi
  - ✅ Monitor Penilaian
  - ✅ Daftar Legger
- ✅ Aksi Kelas
  - ✅ Kehadiran (Sakit, Izin, Alpha)
  - ✅ Catatan Wali Kelas
  - ✅ Kenaikan Kelas
- ✅ P5BK (Full CRUD)
  - ✅ Buat/Edit/Hapus Projek
  - ✅ Kelola Anggota
  - ✅ Setup Kriteria & Dimensi
  - ✅ Input Penilaian P5
- ✅ Ekstrakurikuler (Full CRUD)
  - ✅ Buat/Edit/Hapus Ekskul
  - ✅ Kelola Anggota
  - ✅ Input Penilaian
- ✅ PKL (Full CRUD)
  - ✅ Kelola Kelompok
  - ✅ Tujuan Pembelajaran
  - ✅ Input Penilaian
- ✅ Kokurikuler (Full CRUD)
- ✅ Rapor (View & Print)
  - ✅ Rapor Semester
  - ✅ Rapor P5
  - ✅ Buku Induk
- ❌ Management data master (No Access)
  - ❌ Edit Sekolah
  - ❌ Semester
  - ❌ Users
  - ❌ Kelas
  - ❌ Siswa
  - ❌ Mata Pelajaran
  - ❌ Teknik Asesmen
  - ❌ Media/Tanggal Rapor

**Tugas Utama:**
1. Input nilai penilaian siswa untuk mapel yang diampu
2. Input capaian kompetensi (deskripsi)
3. Input nilai akhir
4. Kelola P5 project dan penilaiannya
5. Kelola ekstrakurikuler dan penilaiannya
6. Kelola PKL dan penilaiannya
7. Input kehadiran, catatan, dan kenaikan kelas
8. View & print rapor siswa

### 4.3 Pembina Ekstrakurikuler

**Hak Akses:** Sama dengan Guru (akses penuh ke semua fitur operasional)

**Menu yang Dapat Diakses:**
- ✅ Semua menu yang dapat diakses Guru/Wali Kelas (lihat section 4.2)
- ✅ Fokus utama: Ekstrakurikuler (CRUD, Anggota, Penilaian)

**Tugas Utama:**
1. Kelola data ekstrakurikuler
2. Kelola anggota ekstrakurikuler
3. Input penilaian ekstrakurikuler
4. Dapat juga akses fitur lain (penilaian mapel, P5, PKL, rapor)

### 4.4 Pembimbing PKL

**Hak Akses:** Sama dengan Guru (akses penuh ke semua fitur operasional)

**Menu yang Dapat Diakses:**
- ✅ Semua menu yang dapat diakses Guru/Wali Kelas (lihat section 4.2)
- ✅ Fokus utama: PKL (Groups, Members, Objectives, Penilaian)

**Tugas Utama:**
1. Kelola kelompok PKL
2. Kelola tujuan pembelajaran PKL
3. Input penilaian PKL
4. Dapat juga akses fitur lain (penilaian mapel, P5, ekstrakurikuler, rapor)

⚠️ **CATATAN PENTING TENTANG HAK AKSES:**

Dalam implementasi sistem saat ini, semua user yang sudah login (kecuali Kepala Sekolah dan Operator) memiliki akses yang SAMA ke fitur-fitur operasional. Perbedaan role (guru, guru_mapel, pembina, pembimbing_pkl) lebih bersifat **label administratif** untuk identifikasi tugas utama mereka.

**Yang HANYA bisa diakses Kepala Sekolah & Operator:**
1. Edit Profil Sekolah
2. Management Semester (Tambah/Edit/Aktifkan)
3. Management Users (Tambah/Edit/Hapus)
4. Management Kelas (Tambah/Edit/Hapus)
5. Management Siswa (Tambah/Edit/Hapus)
6. Management Mata Pelajaran (Tambah/Edit/Hapus)
7. Management Mapel Kelas (Tambah/Edit/Hapus/Toggle)
8. Enrollment Siswa ke Mapel (Tambah/Hapus)
9. CRUD Teknik Asesmen
10. Upload Media Rapor
11. Setting Tanggal Rapor

**Yang bisa diakses SEMUA user (termasuk Guru):**
- View Profil Sekolah
- Mapel Kelas (View list)
- Semua fitur Penilaian (Assessment, Scores, Final Grades, Board)
- Monitor Penilaian & Legger
- P5BK (Full CRUD)
- Ekstrakurikuler (Full CRUD)
- PKL (Full CRUD)
- Kokurikuler (Full CRUD)
- Aksi Kelas (Kehadiran, Catatan, Kenaikan)
- Generate & Print Rapor

---

## 5. MODUL DATA MASTER

### 5.1 Profil Sekolah

**Akses:** Menu **Sekolah**

**Fungsi:** Mengelola data profil sekolah

**Data yang Dikelola:**
- Nama Sekolah
- NPSN
- Jenjang (SMK)
- Email & Website
- Alamat Lengkap
- Logo Sekolah

**Cara Edit:**
1. Klik menu **Sekolah**
2. Klik tombol **Edit Profil**
3. Ubah data yang diperlukan
4. Klik **Simpan**

### 5.2 Semester / Tahun Ajaran

**Akses:** Menu **Semester**

**Fungsi:** Mengelola tahun ajaran dan semester aktif untuk sistem penilaian

#### 📋 Data yang Dikelola

- **Tahun Ajaran:** Format string, contoh: `2024/2025`, `2025/2026`
- **Semester:** Pilihan antara `ganjil` (Semester 1) atau `genap` (Semester 2)
- **Status:**
  - `berjalan` - Semester yang sedang aktif
  - `tidak_berjalan` - Semester yang non-aktif
- **Sekolah:** Relasi ke sekolah (multi-sekolah support)

#### ⚙️ Karakteristik Sistem

**Single Active Semester (Singleton Pattern):**
- ✅ Hanya 1 semester yang boleh berstatus `berjalan` dalam satu waktu per sekolah
- ✅ Saat mengaktifkan semester baru, semester lama otomatis di-nonaktifkan
- ✅ Menggunakan database transaction untuk menjaga konsistensi data
- ✅ Mencegah konflik data penilaian antar semester

**Relasi dengan Modul Lain:**

Semester aktif digunakan oleh:
1. **Mapel Kelas** - Assignment mata pelajaran ke kelas per semester
2. **Penilaian** - Semua nilai tersimpan per semester
3. **P5 Projects** - Projek P5 dibuat per semester
4. **Rapor** - Generate rapor berdasarkan semester
5. **Kehadiran** - Data kehadiran per semester
6. **Kenaikan Kelas** - Keputusan naik/tidak naik per semester

#### 📝 Cara Menambah Semester Baru

1. **Login sebagai Kepala Sekolah atau Operator**
2. **Klik menu Semester** di navbar
3. **Klik tombol "+ Tambah Semester Baru"**
4. **Isi form dengan lengkap:**
   ```
   Sekolah: [Pilih dari dropdown]
   Tahun Ajaran: 2024/2025
   Semester: ganjil
   Status: berjalan
   ```
5. **Klik "Simpan"**
6. **Sistem akan:**
   - Validasi data input
   - Jika status = `berjalan`, otomatis nonaktifkan semester lain
   - Simpan semester baru
   - Tampilkan notifikasi sukses

#### 🔄 Cara Mengaktifkan Semester

**Skenario:** Anda ingin mengaktifkan semester yang sudah ada (misalnya kembali ke semester lalu untuk input nilai)

1. **Buka menu Semester**
2. **Lihat daftar semester:**
   - Semester aktif ditandai badge hijau `berjalan`
   - Semester non-aktif ditandai badge abu-abu `tidak_berjalan`
3. **Klik tombol hijau "Aktifkan"** di baris semester yang diinginkan
4. **Sistem akan otomatis:**
   - Nonaktifkan semester yang sebelumnya aktif
   - Aktifkan semester yang dipilih
   - Refresh halaman dengan notifikasi sukses

⚠️ **PENTING:** Proses aktivasi menggunakan transaction, jadi data dijamin konsisten!

#### ✏️ Cara Edit Semester

1. **Klik tombol "Edit"** pada baris semester
2. **Form edit muncul** dengan data yang sudah terisi
3. **Ubah data yang diperlukan:**
   - Tahun Ajaran
   - Semester (ganjil/genap)
   - Status (berjalan/tidak_berjalan)
4. **Klik "Simpan"**

⚠️ **PERHATIAN:**
- Sebaiknya tidak mengubah tahun ajaran/semester jika sudah ada data penilaian
- Hati-hati saat mengubah status menjadi `berjalan` - semester lain tidak akan otomatis di-nonaktifkan lewat edit

#### 🔍 Validasi & Aturan Bisnis

**Validasi Input:**
```
✓ Sekolah: Wajib diisi, harus ada di database
✓ Tahun Ajaran: Wajib, maksimal 20 karakter
✓ Semester: Wajib, hanya 'ganjil' atau 'genap'
✓ Status: Wajib, hanya 'berjalan' atau 'tidak_berjalan'
```

**Aturan Bisnis:**
1. **One Active Semester Rule:** Satu sekolah hanya boleh punya 1 semester aktif
2. **Auto-Deactivation:** Saat buat semester baru dengan status `berjalan`, semester lain otomatis non-aktif
3. **Transaction Safety:** Aktivasi semester menggunakan DB transaction untuk atomicity

#### 💡 Best Practices

**✅ DO (Lakukan):**
- Setup semester baru di awal tahun ajaran
- Pastikan data master (kelas, siswa, mapel) sudah lengkap sebelum aktifkan semester
- Lengkapi semua penilaian semester sebelumnya sebelum pindah semester baru
- Gunakan format konsisten untuk tahun ajaran (contoh: 2024/2025)

**❌ DON'T (Jangan):**
- Jangan hapus semester yang sudah ada data penilaian (fitur hapus memang tidak tersedia)
- Jangan edit tahun ajaran/semester setelah ada data penilaian
- Jangan coba mengaktifkan 2 semester sekaligus (sistem akan mencegah)
- Jangan lupa mengaktifkan semester setelah membuatnya

#### 🎯 Use Case Scenarios

**Scenario 1: Awal Tahun Ajaran Baru**
```
1. Semester lama: 2023/2024 Genap (status: berjalan)
2. Admin buat semester baru: 2024/2025 Ganjil (status: berjalan)
3. Sistem otomatis nonaktifkan 2023/2024 Genap
4. Sekarang 2024/2025 Ganjil yang aktif
5. Semua mapel kelas baru akan menggunakan semester ini
```

**Scenario 2: Input Nilai Semester Lalu**
```
1. Semester aktif: 2024/2025 Genap
2. Guru lupa input nilai semester ganjil
3. Admin klik "Aktifkan" di 2024/2025 Ganjil
4. Guru input nilai yang tertinggal
5. Admin klik "Aktifkan" kembali di 2024/2025 Genap
6. Sistem kembali normal
```

**Scenario 3: Generate Rapor Semester Tertentu**
```
1. Admin bisa generate rapor semester manapun
2. Tidak perlu mengaktifkan semester tersebut
3. Pilih semester langsung saat generate rapor
4. Buku Induk otomatis ambil data semua semester (fixed 6 semester)
```

#### ❓ FAQ Semester

**Q: Kenapa hanya boleh 1 semester aktif?**
**A:** Untuk mencegah konflik data. Bayangkan jika 2 semester aktif, saat guru input nilai, sistem bingung nilai masuk ke semester yang mana. Single active semester memastikan konsistensi.

**Q: Bagaimana jika saya hapus semester aktif?**
**A:** Fitur hapus semester tidak tersedia untuk menjaga integritas data. Jika benar-benar perlu, hubungi developer untuk manual deletion via database.

**Q: Apakah bisa punya 2 sekolah dengan semester aktif berbeda?**
**A:** Ya! Aturan "1 semester aktif" berlaku PER SEKOLAH. Sekolah A bisa aktif di semester ganjil, sementara Sekolah B aktif di semester genap.

**Q: Data semester lama hilang saat ganti semester?**
**A:** TIDAK! Data tidak hilang. Hanya status yang berubah dari `berjalan` ke `tidak_berjalan`. Semua data penilaian, nilai akhir, dll tetap tersimpan dan bisa diakses kapan saja.

**Q: Buku Induk kok tampil semester yang belum ada datanya?**
**A:** Buku Induk dirancang menampilkan 7 halaman fixed (6 semester kelas 10-12 + 1 rekapitulasi). Jika semester belum ada data, akan tampil halaman kosong. Ini normal untuk menjaga format konsisten.

#### 🗄️ Technical Details

**Database Schema:**
```sql
CREATE TABLE semesters (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    school_id BIGINT UNSIGNED NOT NULL,
    tahun_ajaran VARCHAR(20) NOT NULL,
    semester ENUM('ganjil', 'genap') NOT NULL,
    status ENUM('berjalan', 'tidak_berjalan') DEFAULT 'tidak_berjalan',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE
);
```

**Controller Logic (Aktivasi):**
```php
public function activate(Semester $semester)
{
    DB::transaction(function () use ($semester) {
        // Nonaktifkan semua semester di sekolah yang sama
        Semester::where('school_id', $semester->school_id)
                ->update(['status' => 'tidak_berjalan']);

        // Aktifkan semester yang dipilih
        $semester->update(['status' => 'berjalan']);
    });

    return back()->with('ok', 'Semester diaktifkan.');
}
```

### 5.3 Management Users

**Akses:** Menu **Users**

**Fungsi:** Mengelola akun guru dan staff

**Data yang Dikelola:**
- Username
- Nama Lengkap
- NIK & NIP
- Jenis PTK (Role):
  - `kepala_sekolah` - Kepala Sekolah
  - `operator` - Operator
  - `guru` - Guru Mata Pelajaran
  - `guru_mapel` - Guru Mapel (sama dengan guru)
  - `pembina` - Pembina Ekstrakurikuler
  - `pembimbing_pkl` - Pembimbing PKL
- Status Aktif

**Cara Menambah User Baru:**
1. Klik menu **Users**
2. Klik tombol **Tambah User**
3. Isi form:
   - Sekolah: Pilih sekolah
   - Username: `username_unik`
   - Password: **WAJIB diisi** dengan password yang memenuhi syarat (minimal 8 karakter, huruf besar, huruf kecil, angka, dan simbol)
   - Nama: Nama lengkap
   - Jenis PTK: Pilih role
   - Status: Aktif
4. Perhatikan **indikator kekuatan password**:
   - Pastikan password menunjukkan status **Kuat** (hijau)
   - Checklist harus semua centang hijau
   - Tombol Simpan akan ter-disable jika password lemah
5. Klik **Simpan**

⚠️ **PENTING:** Password wajib memenuhi kriteria kuat sebelum bisa disimpan!

**Cara Edit User:**
1. Klik tombol **Edit** pada baris user
2. Ubah data yang diperlukan
3. Klik **Simpan**

**Cara Reset Password:**
1. Edit user
2. Kosongkan field password lama
3. Masukkan password baru
4. Klik **Simpan**

### 5.4 Management Kelas

**Akses:** Menu **Kelas**

**Fungsi:** Mengelola data kelas

**Data yang Dikelola:**
- Nama Kelas (contoh: X - TKJ)
- Tingkat (10, 11, 12)
- Wali Kelas
- Tahun Masuk
- Status Aktif

**Cara Menambah Kelas Baru:**
1. Klik menu **Kelas**
2. Klik tombol **Tambah Kelas**
3. Isi form:
   - Nama Kelas: `X - TKJ`
   - Tingkat: `10`
   - Wali Kelas: Pilih dari dropdown
   - Tahun Masuk: `2024`
4. Klik **Simpan**

### 5.5 Management Siswa

**Akses:** Menu **Siswa**

**Fungsi:** Mengelola data siswa

**Data yang Dikelola:**
- NISN & NIS
- Nama Lengkap
- Kelas
- Tanggal Lahir
- Jenis Kelamin
- Alamat
- Status Aktif

**Cara Menambah Siswa Baru:**
1. Klik menu **Siswa**
2. Klik tombol **Tambah Siswa**
3. Isi form lengkap
4. Klik **Simpan**

**Cara Import Siswa (Bulk):**
_(Fitur ini belum tersedia, silakan input manual satu per satu)_

### 5.6 Management Mata Pelajaran

**Akses:** Menu **Mapel**

**Fungsi:** Mengelola master data mata pelajaran

**Data yang Dikelola:**
- Kode Mapel
- Nama Mata Pelajaran
- Kelompok (A, B, C)
- Status Aktif

**Cara Menambah Mapel Baru:**
1. Klik menu **Mapel**
2. Klik tombol **Tambah Mapel**
3. Isi form:
   - Kode: `B-IND`
   - Nama: `Bahasa Indonesia`
   - Kelompok: `A`
4. Klik **Simpan**

---

## 6. MODUL PENILAIAN

### 6.1 Setup Mapel Kelas

**Akses:** Menu **Mapel Kelas**

**Fungsi:** Assign mata pelajaran ke kelas tertentu

**Cara Setup:**
1. Klik menu **Mapel Kelas**
2. Klik tombol **Tambah Mapel Kelas**
3. Pilih:
   - Sekolah
   - Semester (yang aktif)
   - Kelas
   - Mata Pelajaran
   - Guru Pengampu
4. Klik **Simpan**

### 6.2 Enrollment Siswa

**Fungsi:** Mendaftarkan siswa yang mengikuti mapel tertentu

**Cara:**
1. Dari daftar **Mapel Kelas**, klik **Enrollments**
2. Klik **Enroll Semua Siswa** (jika seluruh kelas ikut)
3. Atau tambah siswa satu per satu
4. Klik **Simpan**

### 6.3 Setup Teknik Penilaian

**Akses:** Menu **Penilaian** → **Teknik Asesmen**

**Fungsi:** Mendefinisikan jenis-jenis penilaian

**Teknik yang Tersedia:**
- Ulangan Harian
- Tugas
- Praktik
- Projek
- UTS/UAS
- dll.

**Cara Menambah Teknik Baru:**
1. Klik **Teknik Asesmen**
2. Klik **Tambah**
3. Isi nama teknik
4. Klik **Simpan**

### 6.4 Setup Perencanaan Asesmen

**Fungsi:** Merencanakan penilaian untuk mapel tertentu

**Cara:**
1. Dari **Mapel Kelas**, klik mata pelajaran
2. Klik **Perencanaan**
3. Tambahkan komponen penilaian:
   - Jenis Teknik
   - Bobot (%)
   - Target jumlah penilaian
4. Klik **Simpan**

### 6.5 Input Penilaian (Assessment)

**Metode 1: Input via Assessments Menu**

1. Dari **Mapel Kelas**, klik **Assessments**
2. Klik **Tambah Penilaian**
3. Isi data:
   - Judul: `Ulangan Harian Bab 1`
   - Teknik: Pilih teknik
   - Bobot: `20`
   - Skor Maksimal: `100`
   - Tanggal
4. Klik **Simpan**
5. Klik **Input Nilai** pada penilaian yang dibuat
6. Masukkan nilai per siswa
7. Klik **Simpan**

**Metode 2: Input via Penilaian Board (Recommended)**

1. Dari **Mapel Kelas**, klik **Penilaian**
2. Tampilan board akan muncul dengan tabel siswa vs penilaian
3. Klik **Tambah Penilaian** untuk membuat kolom baru
4. Input nilai langsung di tabel
5. Klik **Simpan Semua**

### 6.6 Input Nilai Akhir & Capaian Kompetensi

**Fungsi:** Memasukkan nilai akhir semester dan deskripsi capaian

**Cara:**
1. Dari **Mapel Kelas**, klik **Nilai Akhir**
2. Bisa klik **Hitung dari Penilaian** untuk auto-calculate, atau
3. Input manual nilai akhir per siswa
4. **PENTING:** Isi kolom **Capaian Kompetensi (Deskripsi)** untuk setiap siswa:
   - Contoh: "Menunjukkan penguasaan yang sangat baik dalam memahami teks narasi dan mampu menganalisis struktur teks dengan tepat."
5. Klik **Simpan**

⚠️ **WAJIB:** Deskripsi capaian kompetensi akan muncul di rapor!

### 6.7 Monitoring Penilaian

**Akses:** Menu **Penilaian** → **Monitor Penilaian**

**Fungsi:** Melihat progress penilaian semua mapel

**Informasi yang Ditampilkan:**
- Mapel yang sudah/belum dinilai
- Jumlah siswa
- Progress persentase

---

## 7. MODUL P5 (PROFIL PELAJAR PANCASILA)

### 7.1 Tentang P5

P5 (Projek Penguatan Profil Pelajar Pancasila) adalah pembelajaran berbasis projek yang mengembangkan 6 dimensi profil pelajar:

1. **Beriman, Bertakwa Kepada Tuhan YME, dan Berakhlak Mulia**
2. **Bernalar Kritis**
3. **Mandiri**
4. **Berkebinekaan Global**
5. **Kreatif**
6. **Bergotong Royong**

### 7.2 Membuat Projek P5

**Akses:** Menu **P5BK**

**Cara:**
1. Klik menu **P5BK**
2. Klik **Tambah Projek**
3. Isi form:
   - Semester: Pilih semester aktif
   - Tema: `Pengelolaan Sampah Plastik`
   - Deskripsi: Jelaskan projek
4. Klik **Simpan**

### 7.3 Setup Kriteria Penilaian P5

**Fungsi:** Mendefinisikan kriteria yang dinilai dalam projek

**Cara:**
1. Dari daftar P5 Projects, klik **Kriteria**
2. Klik **Tambah Kriteria**
3. Isi:
   - No. Urut: `1`
   - Judul Kriteria: `Menjaga Lingkungan Alam Sekitar`
   - **Dimensi**: Pilih salah satu dari 6 dimensi
4. Klik **Simpan**
5. Ulangi untuk kriteria lainnya

⚠️ **PENTING:** Pastikan setiap kriteria di-assign ke dimensi yang sesuai!

### 7.4 Enrollment Siswa ke P5

**Cara:**
1. Dari P5 Project, klik **Anggota**
2. Klik **Enroll All Students** untuk mendaftarkan semua siswa kelas
3. Atau tambah siswa manual satu per satu
4. Klik **Simpan**

### 7.5 Input Penilaian P5

**Cara:**
1. Dari P5 Project, klik **Penilaian**
2. Pilih siswa
3. Beri nilai per kriteria dengan skala:
   - **MB** = Mulai Berkembang
   - **SB** = Sedang Berkembang
   - **BSH** = Berkembang Sesuai Harapan
   - **SAB** = Sangat Berkembang
4. Isi **Catatan Proses** (deskripsi)
5. Klik **Simpan**

**Perhitungan Dimensi:**
Sistem akan otomatis menghitung nilai dimensi berdasarkan nilai dominan dari kriteria-kriteria yang masuk dalam dimensi tersebut.

---

## 8. MODUL EKSTRAKURIKULER

### 8.1 Membuat Ekstrakurikuler

**Akses:** Menu **Ekskul**

**Cara:**
1. Klik menu **Ekskul**
2. Klik **Tambah Ekstrakurikuler**
3. Isi:
   - Nama: `Tapak Suci`
   - Pembina: Pilih dari dropdown
4. Klik **Simpan**

### 8.2 Enrollment Anggota

**Cara:**
1. Dari daftar Ekstrakurikuler, klik **Anggota**
2. Tambah siswa satu per satu atau
3. Klik **Add All from Class** untuk tambah seluruh kelas
4. Klik **Simpan**

### 8.3 Input Penilaian Ekstrakurikuler

**Cara:**
1. Dari Ekstrakurikuler, klik **Penilaian**
2. Pilih semester
3. Input nilai per siswa:
   - Nilai: `Sangat Baik`, `Baik`, `Cukup`, `Kurang`
   - Deskripsi: Jelaskan pencapaian siswa
4. Klik **Simpan**

---

## 9. MODUL PKL

### 9.1 Setup Tujuan Pembelajaran PKL

**Akses:** Menu **PKL** → **Learning Objectives**

**Cara:**
1. Klik **Learning Objectives**
2. Klik **Tambah**
3. Isi tujuan pembelajaran PKL
4. Klik **Simpan**

### 9.2 Membuat Kelompok PKL

**Akses:** Menu **PKL** → **PKL Groups**

**Cara:**
1. Klik **PKL Groups**
2. Klik **Tambah Kelompok**
3. Isi:
   - Semester
   - Nama Kelompok/Perusahaan
   - Pembimbing
4. Klik **Simpan**

### 9.3 Enrollment Anggota PKL

**Cara:**
1. Dari PKL Group, klik **Members**
2. Tambah siswa yang PKL di tempat tersebut
3. Klik **Simpan**

### 9.4 Input Penilaian PKL

**Cara:**
1. Dari PKL Group, klik **Penilaian**
2. Pilih siswa dan tujuan pembelajaran
3. Input nilai (angka)
4. Klik **Simpan**

---

## 10. GENERATE RAPOR

### 10.1 Akses Manajemen Rapor

**Akses:** Menu **Pengaturan** → **Rapor Kelas**

Atau langsung ke: Menu **Aksi Kelas**

### 10.2 Persiapan Sebelum Generate Rapor

**Checklist:**
- ✅ Semua nilai akhir sudah diinput
- ✅ Capaian kompetensi sudah diisi
- ✅ P5 sudah dinilai
- ✅ Ekstrakurikuler sudah dinilai
- ✅ Kehadiran sudah diinput (Sakit, Izin, Alpha)
- ✅ Catatan wali kelas sudah diisi
- ✅ Keputusan naik/tidak naik sudah ditetapkan

### 10.3 Generate Rapor Semester

**Fungsi:** Rapor semester berisi nilai mata pelajaran

**Cara:**
1. Pilih kelas
2. Klik tombol **Semester** (biru) pada baris siswa
3. PDF rapor semester akan ter-generate dan muncul
4. Klik **Download** atau **Print**

**Isi Rapor Semester:**
- Halaman 1:
  - Identitas siswa
  - Nilai mata pelajaran + capaian kompetensi
- Halaman 2:
  - Ekstrakurikuler
  - Kehadiran
  - Catatan wali kelas
  - Keputusan kenaikan
  - Tanda tangan

### 10.4 Generate Rapor P5BK

**Fungsi:** Rapor P5 berisi penilaian projek

**Cara:**
1. Pilih kelas
2. Klik tombol **P5BK** (merah) pada baris siswa
3. PDF rapor P5 akan ter-generate
4. Download/Print

**Isi Rapor P5 (Per Projek = 2 Halaman):**
- Halaman 1:
  - Tema projek
  - Tabel nilai 6 dimensi
  - Legend (MB, SB, BSH, SAB)
  - Tanda tangan wali kelas
- Halaman 2:
  - Tabel detail kriteria dengan checkmark
  - Catatan proses
  - Tanda tangan orang tua, wali kelas, kepala sekolah

### 10.5 Generate Buku Induk

**Fungsi:** Rekapitulasi lengkap semua semester (Kelas 10-12)

**Cara:**
1. Pilih kelas
2. Klik tombol **Buku Induk** (kuning) pada baris siswa
3. PDF buku induk akan ter-generate
4. Download/Print

**Isi Buku Induk:**
- Halaman 1-6: Rapor per semester (Kelas 10 Ganjil/Genap, 11 Ganjil/Genap, 12 Ganjil/Genap)
- Halaman 7: Rekapitulasi nilai semua semester
- Halaman 8: Status kelulusan

---

## 11. FAQ & TROUBLESHOOTING

### Q1: Lupa password, bagaimana cara reset?

**A:** Hubungi operator sekolah atau kepala sekolah untuk melakukan reset password dari menu Users.

---

### Q2: Kenapa menu tertentu tidak muncul?

**A:** Setiap role memiliki akses yang berbeda. Pastikan Anda login dengan akun yang sesuai. Hanya Kepala Sekolah dan Operator yang memiliki full access.

---

### Q3: Nilai akhir tidak muncul di rapor

**A:** Pastikan:
1. Nilai akhir sudah diinput di menu **Nilai Akhir**
2. Capaian kompetensi sudah diisi
3. Semester yang dipilih sudah benar

---

### Q4: Capaian kompetensi kosong di rapor

**A:** Anda harus mengisi kolom **Capaian Kompetensi (Deskripsi)** di menu **Nilai Akhir** untuk setiap mata pelajaran dan setiap siswa.

---

### Q5: Dimensi P5 menunjukkan tanda "-"

**A:** Pastikan:
1. Setiap kriteria P5 sudah di-assign ke dimensi yang benar
2. Penilaian P5 sudah diinput (bukan kosong)
3. Refresh halaman atau generate ulang rapor

---

### Q6: Rapor tidak bisa di-print

**A:**
1. Pastikan browser sudah allow pop-up
2. Coba browser lain (Chrome recommended)
3. Check koneksi internet
4. Hubungi admin jika masalah berlanjut

---

### Q7: Error 403 Forbidden saat akses menu

**A:** Anda tidak memiliki akses ke menu tersebut. Hubungi kepala sekolah atau operator untuk upgrade role jika diperlukan.

---

### Q8: Siswa tidak muncul di daftar penilaian

**A:** Pastikan siswa sudah di-enroll ke mata pelajaran tersebut melalui menu **Enrollments**.

---

### Q9: Rapor siswa tidak lengkap

**A:** Checklist:
- ✅ Semua nilai mata pelajaran sudah diinput
- ✅ Deskripsi capaian kompetensi terisi
- ✅ P5 sudah dinilai (jika ada projek)
- ✅ Ekstrakurikuler sudah dinilai
- ✅ Kehadiran terisi
- ✅ Catatan wali kelas terisi

---

### Q10: Cara mengganti logo sekolah di rapor

**A:**
1. Login sebagai Kepala Sekolah/Operator
2. Klik menu **Sekolah**
3. Klik **Edit Profil**
4. Upload logo baru
5. Klik **Simpan**

---

### Q11: Password tidak bisa disimpan saat tambah user baru

**A:** Pastikan password memenuhi semua kriteria:
1. Minimal 8 karakter
2. Ada huruf besar (A-Z)
3. Ada huruf kecil (a-z)
4. Ada angka (0-9)
5. Ada simbol (!@#$%^&* dll)

Perhatikan indikator kekuatan password. Jika masih merah atau kuning, password belum cukup kuat. Tombol Simpan akan ter-disable sampai password menunjukkan status **Kuat** (hijau).

Contoh password yang memenuhi syarat: `Smk2025!@#`, `Guru123!`, `Admin2025#`

---

### Q12: Error saat hapus siswa (Foreign Key Constraint)

**A:** Sistem sudah dilengkapi dengan cascade delete otomatis. Saat menghapus siswa, sistem akan otomatis menghapus semua data terkait:
- Nilai penilaian
- Nilai akhir
- Enrollment mata pelajaran
- Kehadiran
- Catatan wali kelas
- Kenaikan kelas
- Data P5
- Data ekstrakurikuler
- Data PKL
- Data kokurikuler

Jika masih error, hubungi developer.

---

### Q13: Buku Induk tidak menampilkan 7 halaman

**A:** Sistem akan otomatis generate 7 halaman untuk Buku Induk:
- Halaman 1-2: Kelas 10 (Ganjil & Genap)
- Halaman 3-4: Kelas 11 (Ganjil & Genap)
- Halaman 5-6: Kelas 12 (Ganjil & Genap)
- Halaman 7: Rekapitulasi

Jika semester belum ada datanya, akan ditampilkan sebagai halaman kosong. Ini adalah behavior normal untuk menjaga konsistensi format Buku Induk.

---

### Q14: Menu navbar tidak sesuai dengan role saya

**A:** Sistem menggunakan 2 level akses:
1. **Admin (Kepala Sekolah & Operator):** Akses penuh ke semua menu termasuk data master
2. **Non-Admin (Guru, Pembina, Pembimbing):** Akses ke semua menu operasional kecuali data master

Jika Anda login sebagai Guru tapi tidak bisa akses menu tertentu, pastikan:
- Anda sudah login dengan akun yang benar
- Semester sudah aktif
- Data master sudah di-setup oleh admin

---

### Q15: Dropdown menu salah highlight (yang lain ikut biru)

**A:** Issue ini sudah diperbaiki. Setiap dropdown sekarang memiliki highlight independent:
- Dropdown **Penilaian** akan highlight biru jika Anda di menu Teknik Asesmen, Monitor Penilaian, atau Legger
- Dropdown **PKL** akan highlight biru jika Anda di menu Kelompok PKL atau Tujuan PKL
- Dropdown **Pengaturan** akan highlight biru jika Anda di menu Media atau Tanggal Rapor

Refresh browser jika masih ada issue.

---

## KONTAK & SUPPORT

**Developer:** PT Benuanta Technology Consultant - Bayu Adi H

**Links:**
- Website : benuanta.web.id
- LinkedIn: [https://www.linkedin.com/in/noclaire/](https://www.linkedin.com/in/noclaire/)
- GitHub: [https://github.com/skivanoclaire](https://github.com/skivanoclaire)

---

**© 2025 E-Rapor - PT Benuanta Technology Consultant**

_Manual ini akan diupdate seiring dengan perkembangan fitur aplikasi._

---

## CHANGELOG

**Version 1.1 - 22 Oktober 2025**
- Update dokumentasi RBAC (Role-Based Access Control)
- Penjelasan detail hak akses per role
- Tambah dokumentasi password strength validation
- Tambah FAQ tentang cascade delete, Buku Induk, dan dropdown highlighting
- Update informasi kontak developer

**Version 1.0 - Desember 2024**
- Initial release
- Dokumentasi lengkap semua modul
- FAQ & Troubleshooting

---

**END OF MANUAL**
