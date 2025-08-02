<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masjid extends Model
{
    use HasFactory;
    protected $connection = 'peta_dakwah';
    protected $table = 'masjid';
    protected $primaryKey = 'id';

    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'kode_masjid',
        'nama_masjid',
        'nama_ketua',
        'nama_bendahara',
        'tipe_masjid',
        'lokasi_masjid',
        'sarana_masjid',
        'daya_tampung',
        'aktivitas_masjid',
        'alamat_lengkap',
        'nama_sekretaris',
        'aktivitas_kajian_khusus',
        'aktivitas_ekonomi',
        'lembaga_sosial',
        'infaq_perbulan',
        'garis_lintang',
        'garis_bujur',
        'geo_address',
        'category',
        'jalan_besar',
        'gang_sempit',
        'shalat_lima_waktu',
        'khotbah',
        'tabligh_akbar',
        'ceramah_rutin',
        'maghrib_mengaji',
        'tahsin_alquran',
        'tahfidz_quran',
        'wirid_remaja',
        'didikan_subuh',
        'pelaksanaan_fardhu_kifayah',
    ];
}
