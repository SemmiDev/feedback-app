<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Feedback;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Create sample feedbacks
        $feedbacks = [
            [
                'nama_penceramah' => 'Ustadz Ahmad',
                'nama_masjid' => 'Masjid Al-Ikhlas',
                'imapp_id_penceramah' => null,
                'imapp_id_masjid' => null,
                'relevansi_rating' => 5,
                'kejelasan_rating' => 4,
                'pemahaman_jamaah_rating' => 5,
                'kesesuaian_waktu_rating' => 4,
                'interaksi_jamaah_rating' => 5,
                'saran' => 'Materi sangat relevan dan mudah dipahami. Sesi tanya jawab sangat interaktif!',
            ],
            [
                'nama_penceramah' => 'Ustadzah Fatimah',
                'nama_masjid' => 'Masjid An-Nur',
                'imapp_id_penceramah' => null,
                'imapp_id_masjid' => null,
                'relevansi_rating' => 4,
                'kejelasan_rating' => 4,
                'pemahaman_jamaah_rating' => 3,
                'kesesuaian_waktu_rating' => 4,
                'interaksi_jamaah_rating' => 3,
                'saran' => 'Penyampaian cukup jelas, tapi durasi sedikit terlalu panjang.',
            ],
            [
                'nama_penceramah' => 'Ustadz Budi',
                'nama_masjid' => 'Masjid Al-Hidayah',
                'imapp_id_penceramah' => null,
                'imapp_id_masjid' => null,
                'relevansi_rating' => 3,
                'kejelasan_rating' => 3,
                'pemahaman_jamaah_rating' => 3,
                'kesesuaian_waktu_rating' => 2,
                'interaksi_jamaah_rating' => 3,
                'saran' => 'Materi cukup relevan, tapi kurang interaktif dan durasi kurang sesuai.',
            ],
            [
                'nama_penceramah' => 'Ustadzah Sarah',
                'nama_masjid' => 'Masjid Al-Madinah',
                'imapp_id_penceramah' => null,
                'imapp_id_masjid' => null,
                'relevansi_rating' => 5,
                'kejelasan_rating' => 5,
                'pemahaman_jamaah_rating' => 5,
                'kesesuaian_waktu_rating' => 5,
                'interaksi_jamaah_rating' => 4,
                'saran' => 'Ceramah sangat menarik dan sesuai dengan kebutuhan jamaah!',
            ],
            [
                'nama_penceramah' => 'Ustadz Rahmat',
                'nama_masjid' => 'Masjid Al-Falah',
                'imapp_id_penceramah' => null,
                'imapp_id_masjid' => null,
                'relevansi_rating' => 2,
                'kejelasan_rating' => 2,
                'pemahaman_jamaah_rating' => 2,
                'kesesuaian_waktu_rating' => 3,
                'interaksi_jamaah_rating' => 2,
                'saran' => 'Penyampaian kurang jelas dan kurang menarik bagi jamaah.',
            ],
            [
                'nama_penceramah' => 'Ustadzah Aisyah',
                'nama_masjid' => 'Masjid Al-Barakah',
                'imapp_id_penceramah' => null,
                'imapp_id_masjid' => null,
                'relevansi_rating' => 4,
                'kejelasan_rating' => 3,
                'pemahaman_jamaah_rating' => 4,
                'kesesuaian_waktu_rating' => 4,
                'interaksi_jamaah_rating' => 3,
                'saran' => 'Materi baik, tapi perlu lebih banyak interaksi dengan jamaah.',
            ],
            [
                'nama_penceramah' => 'Ustadz Hasan',
                'nama_masjid' => 'Masjid Al-Taqwa',
                'imapp_id_penceramah' => null,
                'imapp_id_masjid' => null,
                'relevansi_rating' => 5,
                'kejelasan_rating' => 5,
                'pemahaman_jamaah_rating' => 5,
                'kesesuaian_waktu_rating' => 5,
                'interaksi_jamaah_rating' => 5,
                'saran' => null, // No comment
            ],
            [
                'nama_penceramah' => 'Ustadzah Nurul',
                'nama_masjid' => 'Masjid Al-Iman',
                'imapp_id_penceramah' => null,
                'imapp_id_masjid' => null,
                'relevansi_rating' => 1,
                'kejelasan_rating' => 1,
                'pemahaman_jamaah_rating' => 1,
                'kesesuaian_waktu_rating' => 2,
                'interaksi_jamaah_rating' => 1,
                'saran' => 'Materi kurang relevan dan penyampaian sulit dipahami.',
            ],
        ];

        foreach ($feedbacks as $feedback) {
            Feedback::create($feedback);
        }
    }
}
