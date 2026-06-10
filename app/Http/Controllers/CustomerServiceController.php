<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\ContactMessage; // opsional
use App\Traits\LogsActivity;

class CustomerServiceController extends Controller
{
    use LogsActivity;
    
    public function send(Request $request)
    {
        // 1. Validasi input + anti spam honeypot
        $request->validate([
            'name'           => 'required|string|max:100',
            'email'          => 'required|email|max:100',
            'subject'        => 'required|string|max:200',
            'message'        => 'required|string|min:5',
            // Honeypot fields (harus kosong)
            'website_url'    => 'nullable|string|max:0',
            'confirm_email'  => 'nullable|string|max:0',
            'form_timestamp' => 'required|integer|min:' . (time() - 5), // minimal 5 detik
        ]);

        // 2. Simpan ke database (opsional, buat tabel contact_messages)
        //    Jika tidak ingin menyimpan, cukup kirim email
        $contact = DB::table('contact_messages')->insert([
            'name'       => $request->name,
            'email'      => $request->email,
            'subject'    => $request->subject,
            'message'    => $request->message,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
        ]);

        // 3. Kirim notifikasi email ke admin (opsional)
        //    Sesuaikan dengan mail configuration Anda
        try {
            Mail::send('emails.contact-notification', [
                'name'    => $request->name,
                'email'   => $request->email,
                'subject' => $request->subject,
                'content' => $request->message,
            ], function ($mail) use ($request) {
                $mail->to('indocahayaexpress@gmail.com')
                     ->subject('New Contact Message: ' . $request->subject)
                     ->replyTo($request->email, $request->name);
            });
        } catch (\Exception $e) {
            Log::error('Failed to send contact email: ' . $e->getMessage());
            // Jangan gagalkan proses, tetap lanjutkan
        }

        // 4. Redirect kembali dengan session success
        return redirect()->route('customer-service')
                         ->with('success', 'Pesan Anda telah terkirim. Tim kami akan menghubungi Anda segera.');
    }
}