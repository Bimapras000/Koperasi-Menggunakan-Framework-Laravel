<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    use HasFactory;

    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    protected $table = 'setor';
        
        protected $fillable = [
            'users_id','name','nominal','bukti_foto','tgl_setor','jenis_setor','jlm_setor','konfirmasi'
        ];
        public $timestamps = false;

        public function tabungan(){
            return $this->hasMany(Tabungan::class);
        }
        public function users(){
            return $this->belongsTo(User::class);
        }
}
