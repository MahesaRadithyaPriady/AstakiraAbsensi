# Design System — AstaKira Attendance System (AKAS)
**Dokumen:** UI/UX Design Specification  
**Proyek:** AstaKira Attendance System  
**Versi:** 1.0.0  
**Referensi Brand:** astakira.com  

---

## 1. Filosofi Desain

AstaKira Attendance System mengadopsi pendekatan desain **"Clean Corporate Authority"** — elegan, terpercaya, dan efisien. Terinspirasi dari identitas visual astakira.com yang menggunakan palet hijau sebagai simbol kepercayaan dan profesionalisme. Sistem ini harus terasa seperti perpanjangan alami dari brand Astakira: bersih, fungsional, dan modern tanpa kesan generik.

**Prinsip Utama:**
1. **Clarity First** — Informasi kehadiran harus terbaca dalam 2 detik
2. **Calm Confidence** — Green palette memberikan ketenangan dan kepercayaan
3. **Frictionless Flow** — Scan → Feedback → Done. Minimal langkah, maksimal efisiensi
4. **Consistent Branding** — Setiap pixel merepresentasikan brand Astakira

---

## 2. Color System

### 2.1 Brand Colors (Turunan dari astakira.com)

```css
/* ═══════════════════════════════════════════
   PRIMARY & BRAND — Astakira Colors
   Warna brand utama, dasar, CTA, active states
   (Sesuai palet warna resmi www.astakira.com)
 ═══════════════════════════════════════════ */
--color-navy:          #0a1628;   /* Latar belakang / dasar gelap ★ */
--color-deep-blue:     #0d2b55;   /* Warna biru tua / gradien */
--color-brand-blue:    #0b5ed7;   /* Warna brand utama / link default ★ */
--color-electric-blue: #3b82f6;   /* Aksen / hover link ★ */
--color-sky-accent:    #60a5fa;   /* Aksen biru muda */
--color-cyan:          #06b6d4;   /* Aksen cyan */
--color-gold:          #f59e0b;   /* Aksen emas / highlight ★ */
--color-off-white:     #f8faff;   /* Latar belakang utama web */
--color-ghost-white:   #eef2ff;   /* Putih kebiruan / bayangan */
--color-true-white:    #ffffff;   /* Latar kartu / surface */

--color-primary-50:  #f8faff;   /* off-white */
--color-primary-100: #eef2ff;   /* ghost-white */
--color-primary-200: #dbeafe;   
--color-primary-300: #bfdbfe;   
--color-primary-400: #60a5fa;   /* sky */
--color-primary-500: #3b82f6;   /* electric-blue */
--color-primary-600: #0b5ed7;   /* brand-blue ★ */
--color-primary-700: #0d2b55;   /* deep-blue */
--color-primary-800: #0a1628;   /* navy */
--color-primary-900: #050b14;   

/* ═══════════════════════════════════════════
   NEUTRALS & STATUS
 ═══════════════════════════════════════════ */
/* Success — Clock In berhasil */
--color-success-50:  #f8faff;
--color-success-500: #3b82f6;
--color-success-600: #0b5ed7;
--color-success-700: #0d2b55;

/* Warning — Terlambat */
--color-warning-50:  #fffbeb;
--color-warning-100: #fef3c7;
--color-warning-400: #fbbf24;
--color-warning-500: #f59e0b;
--color-warning-600: #d97706;

/* Danger — Error / Tidak hadir */
--color-danger-50:   #fef2f2;
--color-danger-100:  #fee2e2;
--color-danger-500:  #ef4444;
--color-danger-600:  #dc2626;

/* Info — Clock Out berhasil */
--color-info-50:     #eff6ff;
--color-info-500:    #3b82f6;
--color-info-600:    #2563eb;

/* ═══════════════════════════════════════════
   SURFACE COLORS
 ═══════════════════════════════════════════ */
--color-surface-page:    var(--color-off-white);     /* bg halaman */
--color-surface-card:    var(--color-true-white);    /* bg card */
--color-surface-sidebar: var(--color-navy);          /* sidebar dark navy */
--color-surface-header:  var(--color-true-white);    /* topbar */
```

### 2.2 Penggunaan Warna per Konteks
| Konteks | Warna |
|---------|-------|
| Primary Button | `primary-600` bg (#0b5ed7), `white` text |
| Secondary Button | `primary-50` bg, `primary-700` text |
| Sidebar | `#0a1628` (Navy) |
| Sidebar Active Item | `primary-600` bg (#0b5ed7) |
| Badge "Hadir" | `success-100` bg, `success-700` text |
| Badge "Terlambat" | `warning-100` bg, `warning-700` text |
| Badge "Alpha" | `danger-100` bg, `danger-700` text |
| Badge "Izin/Sakit" | `info-100` bg, `info-700` text |
| Scan Success (Clock In) | `success-600` full screen overlay |
| Scan Success (Clock Out) | `info-600` full screen overlay |
| Scan Error | `danger-600` full screen overlay |

---

## 3. Typography

### 3.1 Font Stack
```css
/* Heading — Inter (professional, modern) */
--font-heading: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;

/* Body — Inter */
--font-body: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;

/* Monospace — untuk NIK, waktu, kode */
--font-mono: 'JetBrains Mono', 'Fira Code', 'Cascadia Code', monospace;
```

**Import di `index.html`:**
```html


```

### 3.2 Type Scale
```css
/* Display — nama karyawan di halaman scan */
--text-display:   2.25rem;  /* 36px, weight: 700 */

/* H1 — judul halaman */
--text-h1:        1.875rem; /* 30px, weight: 700 */

/* H2 — judul section */
--text-h2:        1.5rem;   /* 24px, weight: 600 */

/* H3 — judul card */
--text-h3:        1.125rem; /* 18px, weight: 600 */

/* Body Large — konten utama */
--text-lg:        1rem;     /* 16px, weight: 400/500 */

/* Body Default */
--text-base:      0.875rem; /* 14px, weight: 400 */

/* Small — label, caption */
--text-sm:        0.75rem;  /* 12px, weight: 400/500 */

/* XS — badge, chip */
--text-xs:        0.6875rem;/* 11px, weight: 500/600 */
```

### 3.3 Contoh Penggunaan
```css
/* Page title */
.page-title {
  font-size: var(--text-h1);
  font-weight: 700;
  color: var(--color-neutral-900);
  letter-spacing: -0.025em;
}

/* Card title */
.card-title {
  font-size: var(--text-h3);
  font-weight: 600;
  color: var(--color-neutral-800);
}

/* Stat number besar */
.stat-value {
  font-size: 2.5rem;
  font-weight: 800;
  color: var(--color-primary-700);
  font-variant-numeric: tabular-nums;
}

/* Timestamp */
.timestamp {
  font-family: var(--font-mono);
  font-size: var(--text-sm);
  color: var(--color-neutral-600);
}
```

---

## 4. Spacing & Layout

### 4.1 Spacing Scale
```css
/* Gunakan Tailwind spacing, referensi: */
--space-1:  0.25rem;   /* 4px */
--space-2:  0.5rem;    /* 8px */
--space-3:  0.75rem;   /* 12px */
--space-4:  1rem;      /* 16px */
--space-5:  1.25rem;   /* 20px */
--space-6:  1.5rem;    /* 24px */
--space-8:  2rem;      /* 32px */
--space-10: 2.5rem;    /* 40px */
--space-12: 3rem;      /* 48px */
--space-16: 4rem;      /* 64px */
```

### 4.2 Layout Utama (Authenticated)
```
┌──────────────────────────────────────────────────────────────┐
│                    TOP HEADER (64px)                         │
│  [≡ Logo Astakira]           [🔔] [Avatar: Nama User ▾]     │
├──────────────┬───────────────────────────────────────────────┤
│              │                                               │
│   SIDEBAR    │              MAIN CONTENT                     │
│   (240px)    │              (flex-1)                        │
│              │                                               │
│  • Dashboard │   ┌─────────────────────────────────────┐   │
│  • Karyawan  │   │  Page Title + Breadcrumb             │   │
│  • Absensi   │   ├─────────────────────────────────────┤   │
│  • Laporan   │   │                                     │   │
│  • Pengaturan│   │         Content Area                 │   │
│              │   │         (padding: 24px)              │   │
│  ─────────── │   │                                     │   │
│  [Logout]    │   └─────────────────────────────────────┘   │
└──────────────┴───────────────────────────────────────────────┘
```

### 4.3 Grid System
```
Container max-width: 1280px
Content padding: 24px (desktop), 16px (tablet), 12px (mobile)

Dashboard grid:
- Stats row: 4 kolom (desktop) → 2 kolom (tablet) → 1 kolom (mobile)
- Chart + Table: 7:5 split (desktop) → stacked (tablet)

Karyawan list:
- Table view (desktop)
- Card grid 2 kolom (tablet)
- Card list 1 kolom (mobile)
```

---

## 5. Component Library

### 5.1 Button

```jsx
/* Variants */

// Primary — aksi utama

  Simpan

// Secondary — aksi sekunder


// Danger — delete, nonaktifkan


// Ghost — subtle action


/* Sizes */
sm:  px-3 py-1.5 text-xs
md:  px-4 py-2.5 text-sm  (default)
lg:  px-6 py-3   text-base
xl:  px-8 py-4   text-lg  (CTA scan page)
```

### 5.2 Card

```jsx
// Base card


// Stat card (dashboard)

  {/* Accent bar kiri */}
  
  
  
    Total Karyawan
    127
    ↑ 3 dari bulan lalu
  

```

### 5.3 Badge / Status Pill

```jsx
// Komponen Badge universal
const Badge = ({ status }) => {
  const variants = {
    hadir:    "bg-success-100 text-success-700 border border-success-200",
    terlambat:"bg-warning-100 text-warning-700 border border-warning-200",
    alpha:    "bg-danger-100  text-danger-700  border border-danger-200",
    izin:     "bg-info-100    text-info-700    border border-info-200",
    sakit:    "bg-neutral-100 text-neutral-600 border border-neutral-200",
  }
  const labels = {
    hadir: "✓ Hadir", terlambat: "⏰ Terlambat",
    alpha: "✗ Alpha", izin: "📋 Izin", sakit: "🏥 Sakit"
  }
  return (
    
      {labels[status]}
    
  )
}
```

### 5.4 Input Field

```jsx
// Text input

  
    Nama Lengkap
  
  


// Error state
input.className += " border-danger-500 focus:ring-danger-500"

// Helper text error

  ⚠ Nama tidak boleh kosong

```

### 5.5 Table

```jsx
// Data table dengan styling Astakira

  
    
      
        
          NIK
        
        {/* ... */}
      
    
    
      
        
          AK-0042
        
        {/* ... */}
      
    
  

```

### 5.6 Sidebar Navigation

```jsx
// Sidebar dengan Navy Astakira

  {/* Logo area */}
  
    
  

  {/* Navigation */}
  
    {navItems.map(item => (
      <NavLink
        key={item.path}
        to={item.path}
        className={({ isActive }) => `
          flex items-center gap-3 px-3 py-2.5
          rounded-lg text-sm font-medium
          transition-all duration-150
          ${isActive
            ? 'bg-primary-600 text-white shadow-sm'
            : 'text-slate-400 hover:bg-white/5 hover:text-white'
          }
        `}
      >
        
        {item.label}
      
    ))}
  

  {/* User info + Logout */}
  
    
      
      Keluar
    
  

```

---

## 6. Screen Specifications

### 6.1 Halaman Login

```
Layout: Full-screen split
- Kiri (40%): Gambar/ilustrasi + branding Astakira
  - Background: Navy to Deep Blue gradient (#0a1628 → #0d2b55)
  - Logo Astakira putih di tengah
  - Tagline: "Sistem Kehadiran Digital Astakira"
  
- Kanan (60%): Form login
  - Background: white
  - Padding: 64px horizontal
  - Konten center vertical

Form elements:
  - Heading: "Selamat Datang" (H1, neutral-900)
  - Sub: "Masuk ke portal kehadiran Astakira" (body, neutral-500)
  - Input Email
  - Input Password (dengan toggle show/hide)
  - Tombol Login (primary, full width, lg size)
  - Link "Lupa Password?"

Footer:
  - © 2026 Astakira. All rights reserved.

Mobile:
  - Single column, logo di atas form
  - Hapus split layout
```

### 6.2 Dashboard HR/Admin

```
Layout: Sidebar + Main content

SECTION 1 — Stats Row (4 card)
┌────────────┐ ┌────────────┐ ┌────────────┐ ┌────────────┐
│Total Aktif │ │Hadir Hari  │ │ Terlambat  │ │Belum Absen │
│    127     │ │  112 (88%) │ │     8      │ │     7      │
│ ↑ 3 baru  │ │            │ │  6.3%      │ │  5.5%      │
└────────────┘ └────────────┘ └────────────┘ └────────────┘

Warna accent bar:
- Total: primary-600 (green)
- Hadir: success-500 (green)
- Terlambat: warning-500 (amber)
- Belum: danger-500 (red)

SECTION 2 — Grafik + Live Feed
┌──────────────────────────────┐ ┌──────────────────┐
│  Grafik Kehadiran 7 Hari     │ │  Aktivitas Hari  │
│  (Line chart: Hadir vs       │ │  Ini (live feed) │
│  Target 127 karyawan)        │ │                  │
│                              │ │  08:01 — Andi A  │
│                              │ │  ✓ Masuk         │
│                              │ │                  │
│                              │ │  08:03 — Siti R  │
│                              │ │  ✓ Masuk         │
│                              │ │  ...             │
└──────────────────────────────┘ └──────────────────┘

SECTION 3 — Tabel Karyawan Terlambat Hari Ini
(compact table, max 5 rows, link "Lihat semua →")
```

### 6.3 Halaman Scan Absensi (CRITICAL SCREEN)

```
Layout: Full-screen, minimal chrome
Background: dark neutral (#0f172a)

ZONE 1 — Header minimal (64px)
[Logo Astakira putih kecil]   [Tanggal + Jam real-time: 14:32:07]

ZONE 2 — Camera Viewfinder (dominant)
┌─────────────────────────────────────┐
│                                     │
│   ┌─────────────────────────────┐   │
│   │                             │   │
│   │     [CAMERA FEED]           │   │
│   │                             │   │
│   │    Arahkan QR Code ke sini  │   │
│   │    ───────────────────      │   │
│   │    Kotak scan animasi       │   │
│   │    (corner brackets         │   │
│   │     berwarna primary-500)   │   │
│   │                             │   │
│   └─────────────────────────────┘   │
│                                     │
│   [●] Kamera aktif • Siap scan      │
└─────────────────────────────────────┘

ZONE 3 — Instruksi (40px)
"Tempelkan QR Code lanyard Anda ke kamera"

STATE: SUKSES CLOCK IN
→ Full-screen overlay CYAN (#06b6d4)
→ Checkmark besar animasi ✓
→ Nama: "BUDI SANTOSO"
→ Status: "ABSEN MASUK TERCATAT"  
→ Waktu: "08:47:23"
→ Auto-dismiss: 3 detik

STATE: SUKSES CLOCK OUT
→ Full-screen overlay BLUE (#0b5ed7)
→ Checkmark ✓
→ Nama + "ABSEN KELUAR TERCATAT"
→ Durasi kerja: "8 Jam 42 Menit"
→ Auto-dismiss: 3 detik

STATE: ERROR
→ Full-screen overlay RED (#dc2626)
→ X mark ✗
→ Pesan error (QR tidak valid / sudah absen / nonaktif)
→ Auto-dismiss: 2 detik

Mobile optimization:
- Full-screen camera, tanpa elemen yang mengganggu
- Tombol "Flash" untuk kondisi gelap
- Works landscape + portrait
```

### 6.4 Manajemen Karyawan

```
Layout: Sidebar + Main

HEADER AREA:
[← Karyawan]    [🔍 Cari karyawan...]    [Filter ▾]    [+ Tambah Karyawan]

FILTER BAR (collapsed by default):
Departemen: [Semua ▾]  Status: [Aktif ▾]  Jabatan: [Semua ▾]

TABLE:
Kolom: Checkbox | Foto+Nama | NIK | Departemen | Jabatan | Status | QR | Aksi

Row Actions (hover):
[👁 Detail] [✏ Edit] [🖨 Cetak QR] [⋮ More]

More dropdown:
- Generate Ulang QR
- Nonaktifkan
- Hapus (danger)

EMPTY STATE:
Ilustrasi karyawan + "Belum ada karyawan terdaftar"
[+ Tambah Karyawan Pertama] [Import Excel]
```

### 6.5 Form Tambah / Edit Karyawan

```
Layout: Modal (medium, max-w-xl) ATAU Slide-over panel dari kanan

SECTION: Informasi Dasar
- Foto profil (upload, drag & drop, 1:1 crop)
- Nama Lengkap *
- NIK (auto-generate atau manual) *
- Email *
- Nomor HP *

SECTION: Pekerjaan
- Departemen * (searchable dropdown)
- Jabatan / Posisi *
- Tanggal Bergabung *

SECTION: Akses Sistem
- Toggle "Berikan akses login ke sistem"
  → Jika ON: auto-kirim email undangan

FOOTER:
[Batal]   [Simpan Karyawan ▶]
```

### 6.6 Halaman Laporan Bulanan

```
HEADER:
Laporan Kehadiran Bulanan
[◀ Juni 2026 ▶]   [Filter Departemen ▾]   [Export Excel] [Export PDF]

SUMMARY CARDS (3 card):
┌──────────────────┐ ┌──────────────────┐ ┌──────────────────┐
│ Rata-rata         │ │ Karyawan         │ │ Total Alpha      │
│ Kehadiran        │ │ Terbaik          │ │ (bulan ini)      │
│   91.3%          │ │ Andi Saputra     │ │   47 hari        │
│ (target: 95%)    │ │ 100% hadir       │ │ dari 127 org     │
└──────────────────┘ └──────────────────┘ └──────────────────┘

TABLE — Full monthly view:
Kolom: Nama | NIK | [Tgl 1] [Tgl 2] ... [Tgl 30] | Total H | T | A | %

Cell per tanggal:
  H = kotak hijau kecil (hadir)
  T = kotak kuning (terlambat)
  A = kotak merah (alpha)
  I = kotak biru (izin)
  - = abu (hari libur/weekend)

Footer table:
[1-20 dari 127]  [< 1 2 3 ... 7 >]
```

### 6.7 Halaman Pengaturan

```
Layout: Sidebar + Content dengan sub-navigation

SUB NAV (horizontal tabs):
[Jam Kerja] [Departemen] [Pengguna Admin] [Keamanan]

TAB: Jam Kerja
  Jam Masuk Default: [08 : 00]
  Jam Keluar Default: [17 : 00]
  Toleransi Keterlambatan: [15] menit
  
  Hari Kerja:
  [✓ Sen] [✓ Sel] [✓ Rab] [✓ Kam] [✓ Jum] [○ Sab] [○ Min]
  
  [Simpan Pengaturan]

TAB: Departemen
  Table: Nama Dept | Kepala | Jml Karyawan | Jam Kerja | Aksi
  [+ Tambah Departemen]

TAB: Pengguna Admin
  Table: Nama | Email | Role | Status | Last Login | Aksi
  [+ Tambah Admin]
```

---

## 7. Iconography

Gunakan **Lucide React** untuk konsistensi.

```jsx
import {
  LayoutDashboard,   // Dashboard
  Users,             // Karyawan
  QrCode,            // Absensi / Scan
  BarChart3,         // Laporan
  Settings,          // Pengaturan
  LogOut,            // Keluar
  Plus,              // Tambah
  Search,            // Cari
  Filter,            // Filter
  Download,          // Export
  Printer,           // Cetak
  RefreshCw,         // Generate ulang
  CheckCircle2,      // Berhasil / Hadir
  XCircle,           // Error / Alpha
  Clock,             // Waktu / Terlambat
  CalendarDays,      // Tanggal
  TrendingUp,        // Statistik naik
  Bell,              // Notifikasi
  ChevronDown,       // Dropdown
  MoreVertical,      // More actions
  Upload,            // Import
  Eye,               // Detail
  Pencil,            // Edit
  Trash2,            // Hapus
} from 'lucide-react'

// Ukuran standar
// - Sidebar nav: size={18}
// - Tombol: size={16}
// - Icon besar header: size={20}
// - Scan feedback: size={80}
```

---

## 8. Motion & Animation

```css
/* Durasi standar */
--duration-fast:   100ms;   /* hover micro-interactions */
--duration-base:   150ms;   /* button press, toggle */
--duration-slow:   300ms;   /* modal open, sidebar */
--duration-scan:   250ms;   /* scan feedback overlay */

/* Easing */
--ease-standard: cubic-bezier(0.4, 0, 0.2, 1);
--ease-enter:    cubic-bezier(0, 0, 0.2, 1);
--ease-exit:     cubic-bezier(0.4, 0, 1, 1);
```

```jsx
// Scan success animation (Framer Motion)
const scanSuccessVariants = {
  initial: { opacity: 0, scale: 0.8 },
  animate: {
    opacity: 1,
    scale: 1,
    transition: { duration: 0.25, ease: [0, 0, 0.2, 1] }
  },
  exit: {
    opacity: 0,
    scale: 0.9,
    transition: { duration: 0.15 }
  }
}

// Checkmark draw animation (SVG)
const checkmarkVariants = {
  initial: { pathLength: 0 },
  animate: {
    pathLength: 1,
    transition: { duration: 0.4, delay: 0.1, ease: "easeOut" }
  }
}

// Stat card hover
.stat-card {
  transition: transform 150ms ease, box-shadow 150ms ease;
}
.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px -5px rgba(22, 163, 74, 0.15);
}

// Live feed items (new scan appear)
.feed-item-enter {
  animation: slideInFromTop 300ms ease forwards;
}
@keyframes slideInFromTop {
  from { opacity: 0; transform: translateY(-8px); }
  to   { opacity: 1; transform: translateY(0); }
}
```

---

## 9. Responsive Breakpoints

```css
/* Tailwind breakpoints */
sm:  640px   /* HP landscape, kiosk kecil */
md:  768px   /* Tablet portrait */
lg:  1024px  /* Tablet landscape, laptop kecil */
xl:  1280px  /* Desktop (main target HR dashboard) */
2xl: 1536px  /* Large desktop */
```

### Adaptive Strategy per Screen
|
 Screen 
|
 Sidebar 
|
 Content 
|
|
--------
|
---------
|
---------
|
|
 Mobile (< 768px) 
|
 Hidden (hamburger toggle) 
|
 Full width, stack layout 
|
|
 Tablet (768-1024px) 
|
 Collapsed (icon only, 56px) 
|
 Flexible grid 
|
|
 Desktop (> 1024px) 
|
 Full (240px) 
|
 Rich layout 
|

---

## 10. Halaman Scan — QR Scanner Component

```jsx
// Struktur komponen scanner
const QRScannerPage = () => {
  return (
    
      {/* Header */}
      
        
        
          
            
          
          
            {formatDate(new Date())}
          
        
      

      {/* Scanner area */}
      
        
          {/* Camera feed */}
          
            
            
            {/* Scan overlay — corner brackets */}
            
              
            
          
          
          {/* Status text */}
          
            Arahkan QR Code lanyard ke kamera
          
        
      

      {/* Scan result overlay */}
      
        {scanResult && (
          
        )}
      
    
  )
}

// Scan Frame dengan corner brackets animated
const ScanFrame = ({ isScanning }) => (
  
    {/* Corners */}
    {['top-0 left-0', 'top-0 right-0', 'bottom-0 left-0', 'bottom-0 right-0'].map((pos, i) => (
      
        {/* Corner SVG */}
      
    ))}
    
    {/* Scan line animation */}
    {isScanning && (
      
    )}
  
)
```

---

## 11. Cetak QR Lanyard — Layout Template PDF

```
Ukuran kartu: 85mm × 54mm (CR80 standard) — landscape
DPI untuk cetak: 300dpi

Layout:
┌─────────────────────────────────────────────┐
│ [Logo Astakira]              [Garis dekoratif│
│ ─────────────────────────────── green]       │
│                                              │
│  ┌──────┐   BUDI SANTOSO                    │
│  │      │   NIK: AK-0042                    │
│  │ FOTO │   IT Department                   │
│  │      │                                   │
│  └──────┘        ┌─────────┐               │
│                  │  [QR]   │               │
│                  │         │               │
│                  └─────────┘               │
│                  SCAN UNTUK ABSEN           │
└─────────────────────────────────────────────┘

Warna:
- Header stripe: primary-600 green (#16a34a)
- Background: white
- Text nama: neutral-900, bold, 14pt
- NIK/Dept: neutral-600, 9pt
- "SCAN UNTUK ABSEN": primary-700, 7pt, semibold

Generate dengan: Laravel DomPDF + CSS print styles
```

---

## 12. Tailwind Config

```js
// tailwind.config.js
export default {
  content: ['./index.html', './src/**/*.{js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        primary: {
          50:  '#f8faff',
          100: '#eef2ff',
          200: '#dbeafe',
          300: '#bfdbfe',
          400: '#60a5fa',
          500: '#3b82f6',
          600: '#0b5ed7',  // ← main brand color
          700: '#0d2b55',
          800: '#0a1628',
          900: '#050b14',
        },
        // Semantic aliases
        success: {
          50:  '#f8faff',
          500: '#3b82f6',
          600: '#0b5ed7',
          700: '#0d2b55',
        },
        warning: {
          50: '#fffbeb', 100: '#fef3c7',
          400: '#fbbf24', 500: '#f59e0b', 600: '#d97706',
        },
        danger: {
          50: '#fef2f2', 100: '#fee2e2',
          500: '#ef4444', 600: '#dc2626', 700: '#b91c1c',
        },
        info: {
          50: '#eff6ff', 100: '#dbeafe',
          500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8',
        },
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        mono: ['JetBrains Mono', 'monospace'],
      },
      animation: {
        'scanLine': 'scanLine 2s ease-in-out infinite',
        'fadeInUp': 'fadeInUp 0.3s ease forwards',
        'pulse-green': 'pulseGreen 2s ease-in-out infinite',
      },
      keyframes: {
        scanLine: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(256px)' },
        },
        fadeInUp: {
          from: { opacity: '0', transform: 'translateY(8px)' },
          to:   { opacity: '1', transform: 'translateY(0)' },
        },
        pulseGreen: {
          '0%, 100%': { boxShadow: '0 0 0 0 rgba(22, 163, 74, 0.4)' },
          '50%':       { boxShadow: '0 0 0 12px rgba(22, 163, 74, 0)' },
        }
      },
      boxShadow: {
        'card': '0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px -1px rgba(0,0,0,0.1)',
        'card-hover': '0 10px 25px -5px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05)',
        'primary-glow': '0 0 20px rgba(11, 94, 215, 0.3)',
      }
    },
  },
  plugins: [],
}
```

---

## 13. Folder Structure (Frontend)

```
src/
├── assets/
│   ├── images/
│   │   ├── logo-astakira.svg
│   │   └── logo-astakira-white.svg
│   └── icons/
│
├── components/
│   ├── ui/                    # Primitive components
│   │   ├── Button.tsx
│   │   ├── Badge.tsx
│   │   ├── Card.tsx
│   │   ├── Input.tsx
│   │   ├── Modal.tsx
│   │   ├── Table.tsx
│   │   ├── Dropdown.tsx
│   │   └── Spinner.tsx
│   │
│   ├── layout/                # Layout components
│   │   ├── Sidebar.tsx
│   │   ├── Header.tsx
│   │   ├── PageWrapper.tsx
│   │   └── AuthLayout.tsx
│   │
│   ├── attendance/            # Domain components
│   │   ├── QRScanner.tsx
│   │   ├── ScanResultOverlay.tsx
│   │   ├── ScanFrame.tsx
│   │   ├── AttendanceTable.tsx
│   │   └── LiveFeed.tsx
│   │
│   ├── employee/
│   │   ├── EmployeeCard.tsx
│   │   ├── EmployeeForm.tsx
│   │   └── QRPrintPreview.tsx
│   │
│   └── reports/
│       ├── MonthlyCalendar.tsx
│       └── AttendanceChart.tsx
│
├── pages/
│   ├── auth/
│   │   └── LoginPage.tsx
│   ├── dashboard/
│   │   └── DashboardPage.tsx
│   ├── employees/
│   │   ├── EmployeeListPage.tsx
│   │   └── EmployeeDetailPage.tsx
│   ├── attendance/
│   │   ├── ScanPage.tsx           # Public scan page
│   │   └── AttendanceLogPage.tsx
│   └── reports/
│       ├── DailyReportPage.tsx
│       ├── WeeklyReportPage.tsx
│       └── MonthlyReportPage.tsx
│
├── hooks/
│   ├── useQRScanner.ts
│   ├── useAttendance.ts
│   └── useEmployees.ts
│
├── stores/
│   ├── authStore.ts
│   └── uiStore.ts
│
├── services/
│   └── api.ts                 # Axios instance + interceptors
│
├── types/
│   ├── employee.ts
│   ├── attendance.ts
│   └── report.ts
│
└── utils/
    ├── date.ts
    ├── format.ts
    └── constants.ts
```

---

*Design System ini adalah dokumen living. Update setiap kali ada penambahan komponen atau perubahan brand.*