<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;
    
    protected $table = 'peminjaman';
        
        protected $fillable = [
            'alamat','no_tlp','keperluan','nominal','tgl_pinjaman','tgl_pengembalian','bunga','total','konfirmasi','users_id'
        ];
        public $timestamps = false;

        public function users(){
            return $this->belongsTo(User::class);
        }

        
}
