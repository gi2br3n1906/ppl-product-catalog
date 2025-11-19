<?php

namespace App\Http\Controllers;

use App\Models\SellerRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class SellerRegistrationController extends Controller
{
    /**
     * Menampilkan form registrasi seller
     */
    public function showRegistrationForm()
    {
        return view('seller.register');
    }

    /**
     * Memproses registrasi seller
     */
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            // Data Toko
            'nama_toko' => ['required', 'string', 'max:255'],
            'deskripsi_singkat' => ['required', 'string', 'max:1000'],
            
            // Data PIC
            'nama_pic' => ['required', 'string', 'max:255'],
            'no_hp_pic' => ['required', 'string', 'max:20'],
            'email_pic' => ['required', 'string', 'email', 'max:255', 'unique:seller_registrations,email_pic'],
            
            // Alamat PIC
            'jalan' => ['required', 'string', 'max:255'],
            'rt' => ['required', 'string', 'max:10'],
            'rw' => ['required', 'string', 'max:10'],
            'kelurahan' => ['required', 'string', 'max:100'],
            'kab_kota' => ['required', 'string', 'max:100'],
            'provinsi' => ['required', 'string', 'max:100'],
            
            // Dokumen Identitas PIC
            'no_ktp_pic' => ['required', 'string', 'max:20'],
            'foto_pic' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // max 2MB
            'file_ktp' => ['required', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // max 5MB
            
            // Password
            'password' => ['required', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
            ],
        ], [
            'nama_toko.required' => 'Nama toko wajib diisi',
            'deskripsi_singkat.required' => 'Deskripsi singkat wajib diisi',
            'nama_pic.required' => 'Nama PIC wajib diisi',
            'no_hp_pic.required' => 'No HP PIC wajib diisi',
            'email_pic.required' => 'Email PIC wajib diisi',
            'email_pic.email' => 'Format email tidak valid',
            'email_pic.unique' => 'Email sudah terdaftar',
            'jalan.required' => 'Alamat jalan wajib diisi',
            'rt.required' => 'RT wajib diisi',
            'rw.required' => 'RW wajib diisi',
            'kelurahan.required' => 'Kelurahan wajib diisi',
            'kab_kota.required' => 'Kabupaten/Kota wajib diisi',
            'provinsi.required' => 'Provinsi wajib diisi',
            'no_ktp_pic.required' => 'No KTP PIC wajib diisi',
            'foto_pic.required' => 'Foto PIC wajib diupload',
            'foto_pic.image' => 'File harus berupa gambar',
            'foto_pic.mimes' => 'Foto harus format jpg, jpeg, atau png',
            'foto_pic.max' => 'Ukuran foto maksimal 2MB',
            'file_ktp.required' => 'File KTP wajib diupload',
            'file_ktp.mimes' => 'File KTP harus format jpg, jpeg, png, atau pdf',
            'file_ktp.max' => 'Ukuran file KTP maksimal 5MB',
            'password.required' => 'Password wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        // Upload files
        $fotoPicPath = $request->file('foto_pic')->store('seller/photos', 'public');
        $fileKtpPath = $request->file('file_ktp')->store('seller/ktp', 'public');

        // Simpan data registrasi
        $registration = SellerRegistration::create([
            'nama_toko' => $validated['nama_toko'],
            'deskripsi_singkat' => $validated['deskripsi_singkat'],
            'nama_pic' => $validated['nama_pic'],
            'no_hp_pic' => $validated['no_hp_pic'],
            'email_pic' => $validated['email_pic'],
            'jalan' => $validated['jalan'],
            'rt' => $validated['rt'],
            'rw' => $validated['rw'],
            'kelurahan' => $validated['kelurahan'],
            'kab_kota' => $validated['kab_kota'],
            'provinsi' => $validated['provinsi'],
            'no_ktp_pic' => $validated['no_ktp_pic'],
            'foto_pic' => $fotoPicPath,
            'file_ktp' => $fileKtpPath,
            'password' => Hash::make($validated['password']),
            'status' => 'pending',
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('seller.registration.success')
            ->with('success', 'Registrasi berhasil! Silakan tunggu verifikasi dari admin. Kami akan mengirimkan email notifikasi setelah proses verifikasi selesai.');
    }

    /**
     * Menampilkan halaman sukses registrasi
     */
    public function registrationSuccess()
    {
        return view('seller.registration-success');
    }

    /**
     * Admin: Menampilkan daftar registrasi yang perlu diverifikasi
     */
    public function index()
    {
        $registrations = SellerRegistration::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.seller-registrations.index', compact('registrations'));
    }

    /**
     * Admin: Menampilkan detail registrasi
     */
    public function show($id)
    {
        $registration = SellerRegistration::findOrFail($id);
        return view('admin.seller-registrations.show', compact('registration'));
    }

    /**
     * Admin: Approve registrasi
     */
    public function approve($id)
    {
        $registration = SellerRegistration::findOrFail($id);

        if ($registration->status !== 'pending') {
            return back()->with('error', 'Registrasi ini sudah diproses sebelumnya.');
        }

        // Update status
        $registration->update([
            'status' => 'approved',
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

                // Buat akun user untuk seller
        $user = User::create([
            'name' => $registration->nama_pic,
            'email' => $registration->email_pic,
            'password' => $registration->password, // Password sudah di-hash dari registrasi
            'role' => 'seller',
        ]);

        // Kirim email notifikasi approval
        // TODO: Implementasi email notification
        // Mail::to($registration->email_pic)->send(new SellerApproved($registration));

        return back()->with('success', 'Registrasi berhasil disetujui! Email notifikasi telah dikirim ke seller.');
    }

    /**
     * Admin: Reject registrasi
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi',
        ]);

        $registration = SellerRegistration::findOrFail($id);

        if ($registration->status !== 'pending') {
            return back()->with('error', 'Registrasi ini sudah diproses sebelumnya.');
        }

        // Update status
        $registration->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);

        // Kirim email notifikasi rejection
        // TODO: Implementasi email notification
        // Mail::to($registration->email_pic)->send(new SellerRejected($registration));

        return back()->with('success', 'Registrasi ditolak. Email notifikasi telah dikirim ke seller.');
    }
}
