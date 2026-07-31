<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Users
        $admin = User::create([
            'name' => 'IT Admin Lead',
            'email' => 'admin@it.local',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department' => 'IT Infrastructure',
        ]);

        $tech1 = User::create([
            'name' => 'Budi Santoso (Tech)',
            'email' => 'budi@it.local',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'department' => 'Hardware & Service Desk',
        ]);

        $tech2 = User::create([
            'name' => 'Siti Rahma (Network Tech)',
            'email' => 'siti@it.local',
            'password' => Hash::make('password'),
            'role' => 'technician',
            'department' => 'Network & Security',
        ]);

        $user1 = User::create([
            'name' => 'Andri Wijaya',
            'email' => 'andri@company.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'department' => 'Finance & Accounting',
        ]);

        $user2 = User::create([
            'name' => 'Dina Kartika',
            'email' => 'dina@company.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'department' => 'Human Capital',
        ]);

        // 2. Create Categories
        $catHardware = Category::create([
            'name' => 'Hardware & Devices',
            'slug' => 'hardware-devices',
            'icon' => 'cpu-chip',
            'description' => 'Issues with PC, Laptop, Monitor, Mouse, Keyboard, and external drives.',
        ]);

        $catSoftware = Category::create([
            'name' => 'Software & Applications',
            'slug' => 'software-apps',
            'icon' => 'code-bracket',
            'description' => 'ERP, Email client, OS updates, office suite, or custom software errors.',
        ]);

        $catNetwork = Category::create([
            'name' => 'Network & Wi-Fi',
            'slug' => 'network-wifi',
            'icon' => 'wifi',
            'description' => 'Office Wi-Fi, VPN connectivity, LAN socket issues, and DNS troubleshooting.',
        ]);

        $catAccess = Category::create([
            'name' => 'Account Access & Security',
            'slug' => 'account-access',
            'icon' => 'lock-closed',
            'description' => 'Password reset, permission grant, 2FA reset, or email delegation requests.',
        ]);

        $catPrinter = Category::create([
            'name' => 'Printer & Peripherals',
            'slug' => 'printer-peripherals',
            'icon' => 'printer',
            'description' => 'Network printer offline, paper jam, toner replacement, or scanner connection.',
        ]);

        // 3. Create Sample Tickets
        $ticket1 = Ticket::create([
            'ticket_number' => 'TKT-2026-0001',
            'title' => 'Laptop Finance Mati Total Saat Processing Payroll',
            'description' => 'Laptop Dell Latitude 5420 tiba-tiba mati dan indikator charger tidak menyala. Mohon bantuan mendesak karena sedang proses gaji bulanan.',
            'category_id' => $catHardware->id,
            'priority' => 'urgent',
            'status' => 'in_progress',
            'user_id' => $user1->id,
            'assigned_to' => $tech1->id,
            'created_at' => now()->subHours(5),
        ]);

        TicketComment::create([
            'ticket_id' => $ticket1->id,
            'user_id' => $tech1->id,
            'comment' => 'Unit sudah diserahterimakan ke tim Hardware Desk. Sedang dicek adapter dan motherboard.',
            'is_internal_note' => false,
            'created_at' => now()->subHours(4),
        ]);

        TicketComment::create([
            'ticket_id' => $ticket1->id,
            'user_id' => $tech1->id,
            'comment' => 'Mainboard short di jalur power delivery. Menyiapkan laptop cadangan sementara.',
            'is_internal_note' => true,
            'created_at' => now()->subHours(2),
        ]);

        $ticket2 = Ticket::create([
            'ticket_number' => 'TKT-2026-0002',
            'title' => 'Akses VPN Kantor Gagal Authentication Timeout',
            'description' => 'Saat koneksi FortiClient VPN dari rumah muncul notifikasi "Credential wrong or server timeout". IP & akun sudah benar.',
            'category_id' => $catNetwork->id,
            'priority' => 'high',
            'status' => 'open',
            'user_id' => $user2->id,
            'assigned_to' => $tech2->id,
            'created_at' => now()->subHours(2),
        ]);

        $ticket3 = Ticket::create([
            'ticket_number' => 'TKT-2026-0003',
            'title' => 'Reset Password Email Baru Karyawan HR',
            'description' => 'Mohon bantuan untuk reset temp password email dina.k@company.com karena lupa password default.',
            'category_id' => $catAccess->id,
            'priority' => 'medium',
            'status' => 'resolved',
            'user_id' => $user2->id,
            'assigned_to' => $tech1->id,
            'resolved_at' => now()->subHours(1),
            'created_at' => now()->subDays(1),
        ]);

        TicketComment::create([
            'ticket_id' => $ticket3->id,
            'user_id' => $tech1->id,
            'comment' => 'Password sudah diset ulang dan dikirimkan via WhatsApp terverifikasi.',
            'is_internal_note' => false,
            'created_at' => now()->subHours(1),
        ]);

        $ticket4 = Ticket::create([
            'ticket_number' => 'TKT-2026-0004',
            'title' => 'Printer Floor 3 Paper Jam dan Indicator Red Light',
            'description' => 'Printer HP LaserJet 400 di lantai 3 tidak bisa print dokumen audit.',
            'category_id' => $catPrinter->id,
            'priority' => 'low',
            'status' => 'open',
            'user_id' => $user1->id,
            'assigned_to' => null,
            'created_at' => now()->subMinutes(45),
        ]);
    }
}
