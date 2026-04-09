# Akademi Balatkop UKM - E-Learning Platform
## Getting Started Guide

### System Overview
A professional e-learning platform built with Laravel 12, featuring role-based access control with three user types:
- **Admin**: Platform management, user management, program oversight
- **Mentor**: Class management, material delivery, grading
- **Peserta (Student)**: Learning, assignment submission, progress tracking

---

## 📋 Setup Instructions

### Database Migration (Already Complete)
```bash
php artisan migrate
```

### Seed Test Data (Already Complete)
```bash
php artisan db:seed
```

### Compile Frontend Assets (Already Complete)
```bash
npm run build
# or for development with watch:
npm run dev
```

### Start Application
```bash
php artisan serve
# Visit: http://localhost:8000
```

---

## 🔐 Test Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@akademi.test | password123 |
| Mentor | mentor@akademi.test | password123 |
| Peserta | peserta@akademi.test | password123 |

---

## 🏗️ Project Structure

### Database Schema
```
USER
├── id, name, email, password
├── role (enum: admin, mentor, peserta)
├── username, foto_profil, instansi, no_hp

PROGRAM (Training Categories)
├── id, nama, deskripsi, icon

KELAS (Courses)
├── id, program_id, nama, deskripsi
├── mentor_id (foreign key → User)
├── mulai, selesai, kapasitas, status

KELAS_ENROLLMENTS (Student Enrollment)
├── peserta_id → User
├── kelas_id → Kelas
├── nilai_akhir, kehadiran, status, sudah_sertifikat

MATERI (Learning Materials)
├── kelas_id, judul, isi
├── tipe (pdf, ppt, video, link, artikel)

TUGAS (Assignments)
├── kelas_id, judul, deskripsi, deadline
├── nilai_maksimal, file_soal, status

QUIZZES (Tests)
├── kelas_id, judul, durasi, nilai_maksimal
├── random_soal, auto_grade, mulai, selesai

QUIZ_QUESTIONS
├── quiz_id, pertanyaan, tipe (pilgan, essay)

ABSENSI (Attendance)
├── kelas_id, pertemuan, mulai, selesai, status

NILAI (Grades)
├── peserta_id, kelas_id, jenis, nilai_diterima
```

### Route Structure
```
GET  /                              → Landing page
POST /login                         → Login (auth)
POST /register                      → Register (auth routes)

Authenticated Routes:
GET  /dashboard                     → Role-based redirect
GET  /admin/dashboard               → Admin dashboard (role:admin)
GET  /mentor/dashboard              → Mentor dashboard (role:mentor)
GET  /peserta/dashboard             → Student dashboard (role:peserta)
```

### Controller Structure
```
app/Http/Controllers/
├── PageController.php              → landing()
├── Admin/
│   └── DashboardController.php      → Admin stats & management
├── Mentor/
│   └── DashboardController.php      → Class management
└── Peserta/
    └── DashboardController.php      → Student learning dashboard
```

### View Structure
```
resources/views/
├── landing.blade.php               → Public landing page
├── layouts/app.blade.php           → Base layout (inherited by dashboards)
├── admin/
│   └── dashboard.blade.php         → Admin dashboard
├── mentor/
│   └── dashboard.blade.php         → Mentor dashboard
└── peserta/
    └── dashboard.blade.php         → Student dashboard
```

---

## 🔗 Database Relationships

```
User (1) ──→ (many) Kelas (as mentor)
User (1) ──→ (many) KelasEnrollment (as peserta)

Program (1) ──→ (many) Kelas

Kelas (1) ──→ (many) Materi
Kelas (1) ──→ (many) Tugas
Kelas (1) ──→ (many) Quiz
Kelas (1) ──→ (many) Absensi
Kelas (1) ──→ (many) Nilai
Kelas (1) ──→ (many) KelasEnrollment

Quiz (1) ──→ (many) QuizQuestion

KelasEnrollment ties Peserta to Kelas with enrollment details
```

---

## 📊 Key Features Implemented

### ✅ Authentication & Authorization
- Laravel's built-in authentication system
- Role-based access control middleware
- User enumeration: admin, mentor, peserta

### ✅ Landing Page
- Professional, responsive design
- Statistics dashboard
- Program showcase
- Testimonials
- Call-to-action sections

### ✅ Role-Based Dashboards
- **Admin**: User statistics, program management quick links
- **Mentor**: Class management, student tracking
- **Peserta**: Enrolled classes, progress tracking, quick actions

### ✅ Database Structure
- Complete schema with all necessary tables
- Foreign key constraints
- Proper indexing
- CASCADE delete for data integrity

### ✅ Test Data
- 3 sample users (one per role)
- 2 programs with descriptions
- 2 classes with one student enrolled

---

## 🧪 Testing

Run tests to verify setup:
```bash
php artisan test tests/Feature/DashboardRoutingTest.php
```

This verifies:
- Landing page accessibility
- Role-based dashboard redirects
- Access control enforcement
- Proper view rendering

---

## 🎨 Design & Styling

- **Framework**: Tailwind CSS v4
- **Icons**: FontAwesome 6.4.0
- **Responsive**: Mobile-first design
- **Color Scheme**: Professional purple/blue gradient
- **Typography**: Clean, modern fonts

---

## 📝 Next Steps (Optional)

To expand the platform, you can add:

1. **Admin Module**
   - User CRUD (create, read, update, delete)
   - Program management
   - Class management
   - System reports
   - User role management

2. **Mentor Module**
   - Material upload/management
   - Assignment creation and grading
   - Quiz builder
   - Attendance management
   - Grade entry and reports

3. **Peserta Module**
   - Material viewing
   - Assignment submission
   - Quiz taking
   - Certificate download
   - Progress visualization

4. **Additional Features**
   - Notification system
   - Discussion forums
   - Live chat support
   - Video streaming
   - Progress analytics
   - Automated email notifications
   - Certificate generation

---

## 🐛 Troubleshooting

**Issue**: Frontend changes not showing
- **Solution**: Run `npm run build` or `npm run dev`

**Issue**: Database migration errors
- **Solution**: Run `php artisan migrate:fresh --seed`

**Issue**: Cache issues
- **Solution**: Run `php artisan cache:clear` and `php artisan config:cache`

**Issue**: Cannot access dashboards after login
- **Solution**: Verify middleware is registered in `bootstrap/app.php`

---

## 📞 Support

For questions or issues with specific features, check:
- Laravel Framework: https://laravel.com
- Database structure: `/database/migrations`
- Route definitions: `/routes/web.php`
- Models: `/app/Models`

---

**Platform Version**: 1.0.0  
**Last Updated**: 2026-04-08  
**Environment**: PHP 8.2, Laravel 12
