<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penceramah extends Model
{
    use HasFactory;
    protected $connection = 'peta_dakwah';
    protected $table = 'penceramah';
    protected $prmaryKey = 'id';

    protected $dates = ['created_at', 'updated_at'];

    protected $fillable = [
        'kode_penceramah',
        'nama_penceramah',
        'no_hp',
        'tempat_lahir',
        'tanggal_lahir',
        'pendidikan_terakhir',
        'madzhab_fiqih',
        'organisasi',
        'hafalan_alquran',
        'kompetensi_ibadah',
        'kompetensi_aqidah',
        'kompetensi_bahasa',
        'kompetensi_keterampilan',
        'kompetensi_ekonomi',
        'prestasi',
        'jurusan_ijazah_terakhir',
        'alamat_domisili_asal',
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
