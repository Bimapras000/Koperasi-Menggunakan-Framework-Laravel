<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
        
        protected $fillable = [
            'alamat','no_tlp','keperluan','tgl_peminjaman','tgl_pengembalian','bunga','konfirmasi','users_id'
        ];
        public $timestamps = false;

        public function users(){
            return $this->belongsTo(User::class);
        }

        
}
