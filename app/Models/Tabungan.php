<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    use HasFactory;

    protected $table = 'tabungan';
        
        protected $fillable = [
            'saldo','users_id'
        ];
        public $timestamps = false;

        public function setor(){
            return $this->belongsTo(Setor::class);
        }
        public function users(){
            return $this->belongsTo(User::class, 'users_id');
        }

}
