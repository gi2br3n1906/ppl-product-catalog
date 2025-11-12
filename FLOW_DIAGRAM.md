# 🔄 Flow Diagram - Sistem Autentikasi

## 📊 Diagram Alur Lengkap

### 1. Alur Registrasi (Register Flow)

```
┌─────────────────────────────────────────────────────────────────────┐
│                        REGISTRASI FLOW                              │
└─────────────────────────────────────────────────────────────────────┘

    User
      │
      │ (1) Akses /register
      ▼
┌───────────────┐
│ Middleware    │───── Cek: Sudah login? ──── Yes ──► Redirect /dashboard
│ 'guest'       │
└───────┬───────┘
        │
        │ No (belum login)
        ▼
┌───────────────┐
│ AuthController│
│ @showRegister │
└───────┬───────┘
        │
        │ (2) Tampilkan form
        ▼
┌───────────────┐
│ register.     │
│ blade.php     │
└───────┬───────┘
        │
        │ (3) User isi form:
        │     - Nama
        │     - Email
        │     - Password
        │     - Konfirmasi
        │
        │ (4) Submit form (POST /register)
        ▼
┌───────────────┐
│ AuthController│
│ @register     │
└───────┬───────┘
        │
        │ (5) Validasi Input
        ▼
    ┌───────────────┐
    │  Validation   │
    │   Rules       │
    └───┬───────┬───┘
        │       │
    Invalid   Valid
        │       │
        │       ▼
        │   ┌──────────────┐
        │   │ Hash         │
        │   │ Password     │
        │   └──────┬───────┘
        │          │
        │          │ (6) Simpan ke database
        │          ▼
        │   ┌──────────────┐
        │   │ Create User  │
        │   │ in Database  │
        │   └──────┬───────┘
        │          │
        │          │ (7) Auto Login
        │          ▼
        │   ┌──────────────┐
        │   │ Auth::login()│
        │   └──────┬───────┘
        │          │
        │          │ (8) Redirect dengan success message
        │          ▼
        │   ┌──────────────┐
        │   │  Dashboard   │
        │   └──────────────┘
        │
        │ (Error case)
        ▼
  ┌──────────────┐
  │ Back to form │
  │ with errors  │
  └──────────────┘
```

### Validasi Detail (Registrasi)

```
┌─────────────────────────────────────────┐
│         VALIDASI REGISTRASI             │
└─────────────────────────────────────────┘

Input: Nama
  │
  ├─► Required? ────── No ──► Error: "Nama wajib diisi"
  │        Yes
  │         │
  └─► Max 255 char? ── No ──► Error: "Nama terlalu panjang"
           Yes
            │
            ▼
          PASS ✓

Input: Email
  │
  ├─► Required? ────── No ──► Error: "Email wajib diisi"
  │        Yes
  │         │
  ├─► Valid format? ── No ──► Error: "Format email tidak valid"
  │        Yes
  │         │
  └─► Unique in DB? ── No ──► Error: "Email sudah terdaftar"
           Yes
            │
            ▼
          PASS ✓

Input: Password
  │
  ├─► Required? ────── No ──► Error: "Password wajib diisi"
  │        Yes
  │         │
  ├─► Min 8 char? ──── No ──► Error: "Password min 8 karakter"
  │        Yes
  │         │
  ├─► Has uppercase? ─ No ──► Error: "Harus ada huruf besar"
  │        Yes
  │         │
  ├─► Has lowercase? ─ No ──► Error: "Harus ada huruf kecil"
  │        Yes
  │         │
  ├─► Has number? ──── No ──► Error: "Harus ada angka"
  │        Yes
  │         │
  ├─► Has symbol? ──── No ──► Error: "Harus ada simbol"
  │        Yes
  │         │
  └─► Match confirm? ─ No ──► Error: "Konfirmasi tidak cocok"
           Yes
            │
            ▼
          PASS ✓

All Valid?
    │
    Yes
    │
    ▼
 PROCEED
```

---

### 2. Alur Login (Login Flow)

```
┌─────────────────────────────────────────────────────────────────────┐
│                          LOGIN FLOW                                 │
└─────────────────────────────────────────────────────────────────────┘

    User
      │
      │ (1) Akses /login
      ▼
┌───────────────┐
│ Middleware    │───── Cek: Sudah login? ──── Yes ──► Redirect /dashboard
│ 'guest'       │
└───────┬───────┘
        │
        │ No (belum login)
        ▼
┌───────────────┐
│ AuthController│
│ @showLogin    │
└───────┬───────┘
        │
        │ (2) Tampilkan form login
        ▼
┌───────────────┐
│ login.        │
│ blade.php     │
└───────┬───────┘
        │
        │ (3) User isi:
        │     - Email
        │     - Password
        │     - Remember (optional)
        │
        │ (4) Submit (POST /login)
        ▼
┌───────────────┐
│ AuthController│
│ @login        │
└───────┬───────┘
        │
        │ (5) Validasi format
        ▼
    ┌───────────────┐
    │  Validation   │
    │   Rules       │
    └───┬───────┬───┘
        │       │
    Invalid   Valid
        │       │
        │       │ (6) Attempt login
        │       ▼
        │   ┌──────────────┐
        │   │ Auth::attempt│
        │   │ (credentials)│
        │   └──────┬───────┘
        │          │
        │      ┌───┴───┐
        │      │       │
        │    Fail    Success
        │      │       │
        │      │       │ (7) Regenerate session
        │      │       ▼
        │      │   ┌──────────────┐
        │      │   │ Regenerate   │
        │      │   │ Session ID   │
        │      │   └──────┬───────┘
        │      │          │
        │      │          │ (8) Set remember token (if checked)
        │      │          │
        │      │          │ (9) Redirect
        │      │          ▼
        │      │   ┌──────────────┐
        │      │   │  Dashboard   │
        │      │   └──────────────┘
        │      │
        │      │ (Login failed)
        │      ▼
        │   ┌──────────────┐
        │   │ Back to login│
        │   │ with error   │
        │   └──────────────┘
        │
        │ (Validation failed)
        ▼
  ┌──────────────┐
  │ Back to form │
  │ with errors  │
  └──────────────┘
```

---

### 3. Alur Logout (Logout Flow)

```
┌─────────────────────────────────────────────────────────────────────┐
│                         LOGOUT FLOW                                 │
└─────────────────────────────────────────────────────────────────────┘

    User (logged in)
      │
      │ (1) Click Logout button
      ▼
┌───────────────┐
│ POST /logout  │
└───────┬───────┘
        │
        │ (2) Check middleware
        ▼
┌───────────────┐
│ Middleware    │───── Not logged in? ──── Yes ──► Redirect /login
│ 'auth'        │
└───────┬───────┘
        │
        │ Logged in
        ▼
┌───────────────┐
│ AuthController│
│ @logout       │
└───────┬───────┘
        │
        │ (3) Logout user
        ▼
    ┌──────────────┐
    │ Auth::logout │
    └──────┬───────┘
           │
           │ (4) Invalidate session
           ▼
    ┌──────────────┐
    │ Invalidate   │
    │ Session      │
    └──────┬───────┘
           │
           │ (5) Regenerate CSRF token
           ▼
    ┌──────────────┐
    │ Regenerate   │
    │ Token        │
    └──────┬───────┘
           │
           │ (6) Redirect dengan success message
           ▼
    ┌──────────────┐
    │ Login Page   │
    │ (with msg)   │
    └──────────────┘
```

---

### 4. Alur Middleware Protection

```
┌─────────────────────────────────────────────────────────────────────┐
│                    MIDDLEWARE PROTECTION                            │
└─────────────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────┐
│        Guest Middleware                  │
│  (untuk /login, /register)               │
└──────────────────────────────────────────┘

Request
   │
   │ (1) Akses /login atau /register
   ▼
┌────────────┐
│ Middleware │
│  'guest'   │
└─────┬──────┘
      │
      │ (2) Cek status auth
      ▼
  ┌───────┐
  │ Auth? │
  └───┬───┘
      │
  ┌───┴────┐
  │        │
  No      Yes (sudah login)
  │        │
  │        │ (3) Redirect
  │        ▼
  │   ┌─────────┐
  │   │Dashboard│
  │   └─────────┘
  │
  │ (belum login)
  │
  │ (4) Lanjutkan ke route
  ▼
┌──────────┐
│ Show Page│
└──────────┘


┌──────────────────────────────────────────┐
│        Auth Middleware                   │
│  (untuk /dashboard, /logout)             │
└──────────────────────────────────────────┘

Request
   │
   │ (1) Akses /dashboard
   ▼
┌────────────┐
│ Middleware │
│   'auth'   │
└─────┬──────┘
      │
      │ (2) Cek status auth
      ▼
  ┌───────┐
  │ Auth? │
  └───┬───┘
      │
  ┌───┴────┐
  │        │
 Yes       No (belum login)
  │        │
  │        │ (3) Redirect
  │        ▼
  │   ┌────────┐
  │   │ Login  │
  │   └────────┘
  │
  │ (sudah login)
  │
  │ (4) Lanjutkan ke route
  ▼
┌──────────┐
│ Show Page│
└──────────┘
```

---

### 5. Session Management Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│                    SESSION MANAGEMENT                               │
└─────────────────────────────────────────────────────────────────────┘

┌────────────┐
│   LOGIN    │
└─────┬──────┘
      │
      │ (1) User login berhasil
      ▼
┌──────────────────┐
│ Create Session   │
│ - user_id        │
│ - session_id     │
│ - remember_token │
│ - csrf_token     │
└─────┬────────────┘
      │
      │ (2) Regenerate session ID
      ▼
┌──────────────────┐
│ New Session ID   │
│ (prevent fixation)
└─────┬────────────┘
      │
      │ (3) Store in:
      ▼
  ┌───────────┐
  │  Cookie   │──────┐
  └───────────┘      │
                     │
  ┌───────────┐      │
  │  Server   │◄─────┘
  │  Storage  │
  └───────────┘


┌────────────┐
│  LOGOUT    │
└─────┬──────┘
      │
      │ (1) User logout
      ▼
┌──────────────────┐
│ Destroy Session  │
│ - Remove user_id │
│ - Clear data     │
└─────┬────────────┘
      │
      │ (2) Invalidate session
      ▼
┌──────────────────┐
│ Delete Session ID│
└─────┬────────────┘
      │
      │ (3) Regenerate token
      ▼
┌──────────────────┐
│ New CSRF Token   │
└─────┬────────────┘
      │
      │ (4) Clear cookie
      ▼
┌──────────────────┐
│ Remove Cookie    │
└──────────────────┘
```

---

### 6. Complete User Journey

```
┌─────────────────────────────────────────────────────────────────────┐
│                   COMPLETE USER JOURNEY                             │
└─────────────────────────────────────────────────────────────────────┘

    ┌──────────┐
    │ New User │
    └────┬─────┘
         │
         │ Akses aplikasi
         ▼
    ┌──────────┐
    │    /     │
    └────┬─────┘
         │
         │ Redirect
         ▼
    ┌──────────┐     Pilih Register
    │  /login  │────────────────────┐
    └────┬─────┘                    │
         │                          │
         │ Sudah punya akun         │
         │                          ▼
         │                    ┌──────────┐
         │                    │/register │
         │                    └────┬─────┘
         │                         │
         │                         │ Isi form
         │                         │
         │                         │ Submit
         │                         ▼
         │                    ┌──────────┐
         │                    │ Validasi │
         │                    └────┬─────┘
         │                         │
         │              ┌──────────┴──────────┐
         │              │                     │
         │           Valid                 Invalid
         │              │                     │
         │              ▼                     │
         │         ┌──────────┐               │
         │         │Save User │               │
         │         └────┬─────┘               │
         │              │                     │
         │              │ Auto Login          │
         │              │                     │
         │              │                     │
         │              │          ┌──────────┘
         │              │          │
         │              │          │ Show errors
         │              │          │
         │              │          │
    ┌────┴──────────────┴──────────┴────┐
    │         DASHBOARD                  │
    │  - Welcome message                 │
    │  - User info                       │
    │  - Statistics                      │
    │  - Logout button                   │
    └────┬───────────────────────────────┘
         │
         │ Use aplikasi
         │
         │ Selesai, klik Logout
         ▼
    ┌──────────┐
    │ Logout   │
    └────┬─────┘
         │
         │ Session destroyed
         ▼
    ┌──────────┐
    │  /login  │
    │ (message:│
    │  berhasil│
    │  logout) │
    └──────────┘
         │
         │ Login lagi kapanpun
         ▼
    ┌──────────┐
    │  CYCLE   │
    │ REPEATS  │
    └──────────┘
```

---

### 7. Error Handling Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│                      ERROR HANDLING                                 │
└─────────────────────────────────────────────────────────────────────┘

    User Input
        │
        ▼
    ┌────────────┐
    │ Validation │
    └─────┬──────┘
          │
    ┌─────┴─────┐
    │           │
  Valid      Invalid
    │           │
    │           ▼
    │     ┌──────────────┐
    │     │ Collect      │
    │     │ Errors       │
    │     └──────┬───────┘
    │            │
    │            │ Error messages:
    │            │ - Nama wajib diisi
    │            │ - Email tidak valid
    │            │ - Password lemah
    │            │ - dll
    │            ▼
    │     ┌──────────────┐
    │     │ Flash to     │
    │     │ Session      │
    │     └──────┬───────┘
    │            │
    │            │ Redirect back
    │            ▼
    │     ┌──────────────┐
    │     │ Show Form    │
    │     │ with Errors  │
    │     └──────┬───────┘
    │            │
    │            │ Display:
    │            │ - Red error boxes
    │            │ - Keep old input
    │            │ - Highlight fields
    │            │
    │            ▼
    │     ┌──────────────┐
    │     │ User Fix     │
    │     │ & Resubmit   │
    │     └──────────────┘
    │
    │ (Valid case)
    ▼
┌────────────┐
│  Process   │
│  Request   │
└────────────┘
```

---

### 8. Database Interaction Flow

```
┌─────────────────────────────────────────────────────────────────────┐
│                    DATABASE INTERACTION                             │
└─────────────────────────────────────────────────────────────────────┘

REGISTER:
    Input Data
        │
        │ name, email, password
        ▼
    ┌──────────────┐
    │ Hash Password│
    │ (bcrypt)     │
    └──────┬───────┘
           │
           │ hashed_password
           ▼
    ┌──────────────┐
    │ User::create │
    │ ([...])      │
    └──────┬───────┘
           │
           │ INSERT INTO users
           ▼
    ┌──────────────────────┐
    │ Database (MySQL)     │
    │ Table: users         │
    │ - id (auto increment)│
    │ - name               │
    │ - email (unique)     │
    │ - password (hashed)  │
    │ - created_at         │
    │ - updated_at         │
    └──────┬───────────────┘
           │
           │ Return user object
           ▼
    ┌──────────────┐
    │ $user        │
    └──────────────┘


LOGIN:
    Credentials
        │
        │ email, password
        ▼
    ┌──────────────┐
    │Auth::attempt │
    └──────┬───────┘
           │
           │ SELECT * FROM users WHERE email = ?
           ▼
    ┌──────────────────────┐
    │ Database (MySQL)     │
    └──────┬───────────────┘
           │
           │ User found?
           ▼
       ┌───┴───┐
       │       │
      Yes      No
       │       │
       │       └──► Return false
       │
       │ Compare passwords
       ▼
    ┌──────────────┐
    │ Hash::check  │
    │ (input, hash)│
    └──────┬───────┘
           │
       ┌───┴───┐
       │       │
     Match   Not Match
       │       │
       │       └──► Return false
       │
       │ Login success
       ▼
    ┌──────────────┐
    │ Return true  │
    └──────────────┘
```

---

## 📊 Sequence Diagram

### Registration Sequence

```
User          Browser         Laravel         Controller      Database
 │               │               │               │               │
 │ Click Register│               │               │               │
 ├──────────────►│               │               │               │
 │               │ GET /register │               │               │
 │               ├──────────────►│               │               │
 │               │               │ Route::get    │               │
 │               │               ├──────────────►│               │
 │               │               │               │showRegister   │
 │               │               │               │               │
 │               │               │◄──────────────┤               │
 │               │ View: register.blade.php      │               │
 │               │◄──────────────┤               │               │
 │◄──────────────┤               │               │               │
 │               │               │               │               │
 │ Fill & Submit │               │               │               │
 ├──────────────►│               │               │               │
 │               │POST /register │               │               │
 │               ├──────────────►│               │               │
 │               │               │ Route::post   │               │
 │               │               ├──────────────►│               │
 │               │               │               │ @register     │
 │               │               │               ├───────┐       │
 │               │               │               │Validate│      │
 │               │               │               │◄──────┘       │
 │               │               │               │               │
 │               │               │               │ Hash Password │
 │               │               │               │               │
 │               │               │               │ Create User   │
 │               │               │               ├──────────────►│
 │               │               │               │               │INSERT
 │               │               │               │◄──────────────┤
 │               │               │               │ User created  │
 │               │               │               │               │
 │               │               │               │ Auth::login   │
 │               │               │               │               │
 │               │               │◄──────────────┤               │
 │               │ Redirect: /dashboard          │               │
 │               │◄──────────────┤               │               │
 │◄──────────────┤               │               │               │
 │               │               │               │               │
```

---

**File ini berisi visualisasi lengkap dari semua alur dalam sistem autentikasi**

Untuk penjelasan text, lihat: **AUTH_README.md**  
Untuk quick start, lihat: **QUICK_START.md**
