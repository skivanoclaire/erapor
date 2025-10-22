# 📚 E-Rapor SMK Muhammadiyah Plus Tanjung Selor

> Sistem Manajemen Rapor Digital berbasis Laravel dengan implementasi Kurikulum Merdeka yang lengkap dan komprehensif

![Laravel](https://img.shields.io/badge/Laravel-12.27.1-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2.29-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind-3.0-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)

---

## 📖 Tentang Proyek

**E-Rapor** adalah sistem informasi manajemen rapor digital yang dikembangkan khusus untuk **SMK Muhammadiyah Plus Tanjung Selor**. Aplikasi ini dirancang untuk mendukung implementasi **Kurikulum Merdeka** secara menyeluruh dengan berbagai fitur modern dan user-friendly.

### 🎯 Tujuan Pengembangan

- ✅ Digitalisasi proses penilaian dan rapor sekolah
- ✅ Implementasi Kurikulum Merdeka (P5, Capaian Pembelajaran)
- ✅ Meningkatkan efisiensi dan akurasi penilaian
- ✅ Mempermudah monitoring progress siswa
- ✅ Generate rapor otomatis dalam format PDF

---

## ✨ Fitur Utama

### 🔐 1. **Multi-Role Access Control (RBAC)**

Sistem akses berbasis peran dengan 2 level utama:

#### **Admin (Kepala Sekolah & Operator)**
- 🏫 Full access ke semua modul
- 👥 Management data master (Users, Kelas, Siswa, Mapel)
- 📅 Management Semester
- ⚙️ Konfigurasi sistem (Media, Tanggal Rapor)

#### **Non-Admin (Guru, Wali Kelas, Pembina, Pembimbing PKL)**
- 📝 Input & kelola penilaian
- 📊 Management P5, Ekstrakurikuler, PKL
- 👁️ View dan print rapor
- 📈 Monitor progress penilaian

### 📊 2. **Penilaian Komprehensif**

- **Teknik Asesmen Beragam:** Ulangan, Tugas, Praktik, Projek, UTS/UAS
- **Perencanaan Asesmen:** Setup bobot dan jumlah penilaian per teknik
- **Board Penilaian:** Input nilai cepat dalam format tabel interaktif
- **Auto-Calculate:** Perhitungan nilai akhir otomatis berdasarkan bobot
- **Capaian Kompetensi:** Deskripsi pencapaian per siswa per mata pelajaran

### 🎯 3. **Projek P5 (Profil Pelajar Pancasila)**

Implementasi lengkap P5 dengan **6 Dimensi Profil Pelajar:**

1. 🤲 Beriman, Bertakwa Kepada Tuhan YME, dan Berakhlak Mulia
2. 🌍 Berkebinekaan Global
3. 🤝 Bergotong Royong
4. 💪 Mandiri
5. 🧠 Bernalar Kritis
6. 💡 Kreatif

**Fitur P5:**
- Setup projek dengan tema
- Kriteria penilaian per dimensi
- Penilaian dengan skala: MB, SB, BSH, SAB
- Perhitungan nilai dimensi otomatis
- Catatan proses per siswa

### 🏆 4. **Ekstrakurikuler & PKL**

**Ekstrakurikuler:**
- CRUD ekstrakurikuler dengan pembina
- Management anggota
- Penilaian: Sangat Baik, Baik, Cukup, Kurang
- Deskripsi pencapaian

**PKL (Praktik Kerja Lapangan):**
- Management kelompok PKL
- Tujuan pembelajaran PKL
- Penilaian per tujuan pembelajaran
- Pembimbing per kelompok

### 📄 5. **Generate Rapor PDF**

**3 Jenis Rapor:**

#### **a) Rapor Semester (2 Halaman)**
- Halaman 1: Identitas siswa + nilai mata pelajaran + capaian kompetensi
- Halaman 2: Ekstrakurikuler + kehadiran + catatan wali kelas + kenaikan kelas

#### **b) Rapor P5 (2 Halaman per Projek)**
- Halaman 1: Tema projek + tabel nilai 6 dimensi + legend
- Halaman 2: Detail kriteria dengan checkmark + catatan proses + tanda tangan

#### **c) Buku Induk (7 Halaman Konsisten)**
- Halaman 1-6: Rapor per semester (Kelas 10, 11, 12 - Ganjil & Genap)
- Halaman 7: Rekapitulasi nilai semua semester

### 📅 6. **Fitur Semester (Single Active Semester)**

**Karakteristik Utama:**
- ✅ **Singleton Pattern:** Hanya 1 semester aktif per sekolah
- ✅ **Auto-Deactivation:** Aktivasi semester baru otomatis nonaktifkan semester lain
- ✅ **Transaction Safety:** Menggunakan database transaction
- ✅ **Format Semester:** `ganjil` atau `genap`
- ✅ **Status:** `berjalan` (aktif) atau `tidak_berjalan` (non-aktif)

**Relasi dengan Modul:**
- Mapel Kelas terkait semester
- Penilaian tersimpan per semester
- P5 Projects per semester
- Rapor di-generate per semester

**Workflow:**
```
1. Admin buat semester baru (2024/2025 Ganjil)
2. Set status "berjalan" → semester lain otomatis non-aktif
3. Setup mapel kelas untuk semester aktif
4. Guru input nilai sepanjang semester
5. Akhir semester: generate rapor
6. Awal semester baru: ulangi dari step 1
```

### 🔒 7. **Fitur Keamanan**

**Password Strength Validation:**
- ✅ Minimal 8 karakter
- ✅ Huruf besar (A-Z)
- ✅ Huruf kecil (a-z)
- ✅ Angka (0-9)
- ✅ Simbol (!@#$%^&*)
- ✅ Visual strength indicator (merah/kuning/hijau)
- ✅ Disable submit button jika password lemah

**Cascade Delete:**

Saat hapus siswa, otomatis menghapus:
- Nilai penilaian
- Nilai akhir
- Enrollment mata pelajaran
- Kehadiran
- Catatan wali kelas
- Kenaikan kelas
- Data P5, Ekstrakurikuler, PKL, Kokurikuler

### 📊 8. **Monitoring & Reporting**

- **Monitor Penilaian:** Progress penilaian semua mapel
- **Daftar Legger:** Rekapitulasi nilai per kelas
- **Class Board:** Dashboard rapor per kelas
- **Aksi Kelas:** Input kehadiran, catatan, kenaikan kelas

---

## 🛠 Teknologi

### Backend Stack
```
├── Framework: Laravel 12.27.1
├── PHP: 8.2.29
├── Database: MySQL 8.0 / MariaDB
└── PDF Library: SnappyPDF (wkhtmltopdf)
```

### Frontend Stack
```
├── CSS Framework: Tailwind CSS 3.x
├── JavaScript: Alpine.js
├── Template Engine: Blade
└── Icons: Heroicons / Font Awesome
```

### Development Tools
```
├── Dependency Manager: Composer
├── Package Manager: NPM
├── Version Control: Git
└── Server: Apache / Nginx
```

---

## 🚀 Instalasi

### Prasyarat

Pastikan sistem Anda memiliki:
- ✅ PHP >= 8.2
- ✅ Composer >= 2.0
- ✅ MySQL >= 8.0 atau MariaDB >= 10.5
- ✅ Apache/Nginx
- ✅ Node.js & NPM (untuk compile assets)
- ✅ wkhtmltopdf (untuk PDF generation)

### Langkah Instalasi

#### 1️⃣ **Clone Repository**
```bash
git clone https://github.com/yourusername/erapor.git
cd erapor
```

#### 2️⃣ **Install Dependencies**
```bash
composer install
npm install
```

#### 3️⃣ **Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

#### 4️⃣ **Database Configuration**

Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=erapor
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### 5️⃣ **Migrate Database**
```bash
php artisan migrate --seed
```

#### 6️⃣ **Compile Assets**
```bash
npm run build
```

#### 7️⃣ **Configure SnappyPDF**

Edit `config/snappy.php`:
```php
'pdf' => [
    'enabled' => true,
    'binary'  => 'C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf.exe', // Windows
    // 'binary' => '/usr/local/bin/wkhtmltopdf', // Linux/Mac
    'timeout' => false,
],
```

#### 8️⃣ **Start Development Server**
```bash
php artisan serve
```

Access: `http://localhost:8000`

### Default Credentials

```
Username: kepalasekolah
Password: SMK2025!@#
```

⚠️ **PENTING:** Segera ganti password setelah login pertama!

---

## 📁 Struktur Proyek

```
erapor/
├── app/
│   ├── Http/
│   │   ├── Controllers/           # Business logic controllers
│   │   │   ├── SemesterController.php
│   │   │   ├── AssessmentController.php
│   │   │   ├── P5ProjectController.php
│   │   │   └── ...
│   │   └── Middleware/            # Custom middleware (RBAC)
│   ├── Models/                    # Eloquent models
│   │   ├── Semester.php
│   │   ├── Student.php
│   │   ├── FinalGrade.php
│   │   └── ...
│   └── ...
├── database/
│   ├── migrations/                # Database schema
│   └── seeders/                   # Sample data
├── resources/
│   ├── views/                     # Blade templates
│   │   ├── semesters/
│   │   ├── rapor/
│   │   ├── p5/
│   │   └── ...
│   └── js/                        # Frontend JS
├── routes/
│   └── web.php                    # Route definitions (RBAC)
├── public/
│   └── ...                        # Public assets
├── .env.example                   # Environment template
├── MANUAL_PENGGUNA.md            # User manual (Bahasa Indonesia)
├── TESTING_REPORT.md             # Testing documentation
└── README.md                      # This file
```

---

## 🗄 Database Schema (Key Tables)

### Tabel Data Master
```sql
schools              # Profil sekolah
semesters            # Tahun ajaran & semester (single active)
users                # Guru & staff (RBAC)
classrooms           # Data kelas
students             # Data siswa
subjects             # Mata pelajaran
```

### Tabel Penilaian
```sql
class_subjects       # Assignment mapel ke kelas per semester
subject_enrollments  # Enrollment siswa ke mapel
assessment_techniques # Jenis penilaian (ulangan, tugas, dll)
assessments          # Data penilaian
assessment_scores    # Nilai siswa per penilaian
final_grades         # Nilai akhir + capaian kompetensi
```

### Tabel P5
```sql
p5_projects          # Projek P5 per semester
p5_project_students  # Anggota projek
p5_dimensions        # 6 dimensi profil pelajar
p5_project_criteria  # Kriteria penilaian per dimensi
p5_project_ratings   # Nilai P5 siswa (MB/SB/BSH/SAB)
```

### Tabel Ekstrakurikuler & PKL
```sql
extracurriculars     # Data ekstrakurikuler
extracurricular_members
extracurricular_assessments

pkl_objectives       # Tujuan pembelajaran PKL
pkl_groups           # Kelompok PKL
pkl_group_members
pkl_assessments
```

### Tabel Pelengkap
```sql
attendances          # Kehadiran (Sakit, Izin, Alpha)
notes                # Catatan wali kelas
promotions           # Kenaikan kelas
```

---

## 🔑 Role & Permission Matrix

| Fitur | Kepala Sekolah | Operator | Guru | Pembina | Pembimbing PKL |
|-------|----------------|----------|------|---------|----------------|
| **Data Master** |
| Edit Profil Sekolah | ✅ | ✅ | ❌ | ❌ | ❌ |
| Management Semester | ✅ | ✅ | ❌ | ❌ | ❌ |
| Management Users | ✅ | ✅ | ❌ | ❌ | ❌ |
| Management Kelas | ✅ | ✅ | ❌ | ❌ | ❌ |
| Management Siswa | ✅ | ✅ | ❌ | ❌ | ❌ |
| Management Mapel | ✅ | ✅ | ❌ | ❌ | ❌ |
| **Operasional** |
| View Profil Sekolah | ✅ | ✅ | ✅ | ✅ | ✅ |
| Mapel Kelas (CRUD) | ✅ | ✅ | 👁️ View | 👁️ View | 👁️ View |
| Penilaian (Full) | ✅ | ✅ | ✅ | ✅ | ✅ |
| P5 Projects | ✅ | ✅ | ✅ | ✅ | ✅ |
| Ekstrakurikuler | ✅ | ✅ | ✅ | ✅ | ✅ |
| PKL | ✅ | ✅ | ✅ | ✅ | ✅ |
| Aksi Kelas | ✅ | ✅ | ✅ | ✅ | ✅ |
| Generate Rapor | ✅ | ✅ | ✅ | ✅ | ✅ |

---

## 📚 Dokumentasi

### Manual Lengkap
📖 **[MANUAL_PENGGUNA.md](MANUAL_PENGGUNA.md)**

Berisi panduan lengkap:
- ✅ Cara login & default credentials
- ✅ Panduan berdasarkan role
- ✅ Modul data master (termasuk Semester detail)
- ✅ Modul penilaian
- ✅ Modul P5, Ekstrakurikuler, PKL
- ✅ Generate rapor (Semester, P5, Buku Induk)
- ✅ FAQ & Troubleshooting (15+ Q&A)

### Testing Report
🧪 **[TESTING_REPORT.md](TESTING_REPORT.md)**

Hasil testing manual untuk:
- ✅ Authentication & RBAC
- ✅ Semester Management
- ✅ Password Validation
- ✅ Cascade Delete
- ✅ PDF Generation
- ✅ Navbar Highlighting

---

## 🎯 Use Cases

### Use Case 1: Setup Semester Baru

```
Actor: Kepala Sekolah / Operator

Flow:
1. Login ke sistem
2. Klik menu "Semester"
3. Klik "+ Tambah Semester Baru"
4. Isi form:
   - Tahun Ajaran: 2025/2026
   - Semester: ganjil
   - Status: berjalan
5. Simpan
6. Sistem otomatis nonaktifkan semester lama
7. Setup mapel kelas untuk semester baru
```

### Use Case 2: Input Nilai Siswa

```
Actor: Guru Mata Pelajaran

Flow:
1. Login ke sistem
2. Klik "Mapel Kelas"
3. Pilih mapel yang diampu
4. Klik "Penilaian" (board view)
5. Klik "+ Tambah Penilaian" untuk buat kolom baru
6. Input nilai langsung di tabel
7. Klik "Simpan Semua"
8. Sistem auto-calculate nilai akhir
```

### Use Case 3: Generate Rapor Semester

```
Actor: Wali Kelas / Kepala Sekolah

Flow:
1. Login ke sistem
2. Klik "Aksi Kelas"
3. Pilih kelas
4. Pastikan checklist lengkap:
   ✓ Nilai akhir terisi
   ✓ Capaian kompetensi terisi
   ✓ Ekstrakurikuler dinilai
   ✓ Kehadiran terisi
   ✓ Catatan wali kelas terisi
5. Klik tombol "Semester" (biru) di baris siswa
6. PDF rapor ter-generate
7. Download / Print
```

---

## ⚙️ Konfigurasi Lanjutan

### Email Notifications (Optional)

Edit `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@smkmuhammadiyah.sch.id
MAIL_FROM_NAME="E-Rapor SMK"
```

### Queue Configuration (For Heavy Tasks)

```env
QUEUE_CONNECTION=database
```

Run queue worker:
```bash
php artisan queue:work
```

### Backup Strategy

#### Automated Backup

Install package:
```bash
composer require spatie/laravel-backup
```

Run backup:
```bash
php artisan backup:run
```

#### Manual Backup

Database:
```bash
mysqldump -u root -p erapor > backup.sql
```

Files:
```bash
tar -czf erapor_backup.tar.gz /path/to/erapor
```

---

## 🧪 Testing

### Manual Testing

Testing dilakukan untuk semua modul utama. Hasil lengkap ada di **[TESTING_REPORT.md](TESTING_REPORT.md)**.

**Test Coverage:**
- ✅ Authentication & Authorization
- ✅ Semester CRUD & Activate
- ✅ Password Strength Validation
- ✅ Student Cascade Delete
- ✅ Assessment Input & Calculate
- ✅ P5 Rating & Dimension Calculation
- ✅ PDF Generation (3 types)
- ✅ Navbar Dropdown Highlighting

### Running Automated Tests (Future)

```bash
php artisan test
```

---

## 🐛 Known Issues & Roadmap

### Known Issues
- ⚠️ Bulk import siswa belum tersedia (input manual)
- ⚠️ Export nilai ke Excel belum tersedia
- ⚠️ Email notification belum diimplementasi

### Roadmap v1.2
- [ ] Bulk import siswa via Excel
- [ ] Export nilai ke Excel
- [ ] Email notification (rapor siap, password reset)
- [ ] Dashboard analytics untuk kepala sekolah
- [ ] Mobile responsive optimization
- [ ] Automated testing suite

---

## 🤝 Kontribusi

Proyek ini dikembangkan secara proprietary untuk SMK Muhammadiyah Plus Tanjung Selor. Untuk request fitur atau bug report, hubungi developer.

---

## 👨‍💻 Developer

**PT Benuanta Technology Consultant - Bayu Adi H**

📧 Email: [developer@benuanta.web.id](mailto:developer@benuanta.web.id)
🔗 LinkedIn: [https://www.linkedin.com/in/noclaire/](https://www.linkedin.com/in/noclaire/)
💻 GitHub: [https://github.com/skivanoclaire](https://github.com/skivanoclaire)
🌐 Website: [benuanta.web.id](https://benuanta.web.id)

---

## 📄 Lisensi

**Proprietary Software** - © 2025 PT Benuanta Technology Consultant

Aplikasi ini dikembangkan khusus untuk **SMK Muhammadiyah Plus Tanjung Selor**.
Hak cipta dan hak kekayaan intelektual dilindungi undang-undang.

Penggunaan, modifikasi, dan distribusi tanpa izin tertulis dari pemilik hak cipta dilarang keras.

---

## 📝 Changelog

### Version 1.1 - 22 Oktober 2025
✨ **New Features:**
- Password strength validation dengan visual indicator
- Enhanced semester management documentation

🔧 **Improvements:**
- Update RBAC documentation
- Cascade delete untuk students
- Buku Induk 7 halaman konsisten
- Fix navbar dropdown highlighting
- Update copyright information

📚 **Documentation:**
- Comprehensive semester feature documentation
- Enhanced user manual dengan FAQ
- Testing report

### Version 1.0 - Desember 2024
🎉 **Initial Release**
- Complete Kurikulum Merdeka implementation
- P5 with 6 dimensions
- Multi-role access control
- PDF generation (Semester, P5, Buku Induk)
- Assessment & grading system
- Ekstrakurikuler & PKL management

---

## 💬 Support

Untuk pertanyaan, bantuan, atau laporan bug:

1. 📖 Baca **[MANUAL_PENGGUNA.md](MANUAL_PENGGUNA.md)** terlebih dahulu
2. 🔍 Cek FAQ section
3. 📧 Email: developer@benuanta.web.id
4. 💬 WhatsApp: [Contact via LinkedIn](https://www.linkedin.com/in/noclaire/)

---

## 🙏 Acknowledgments

Terima kasih kepada:
- **SMK Muhammadiyah Plus Tanjung Selor** - Client & user utama
- **Laravel Community** - Framework & support
- **Tailwind CSS Team** - UI framework
- **wkhtmltopdf** - PDF generation

---

<div align="center">

**Dikembangkan dengan ❤️ untuk SMK Muhammadiyah Plus Tanjung Selor**

⭐ Star this repo if you find it useful!

</div>
