<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadeAdministrativa extends Model
{
    use HasFactory;

    protected $table = 'unidades_administrativas';
    protected $fillable = ['nome', 'codigo', 'unidade_admin_pai_id', 'unidade_admin_folha', 'predio_id'];

    public function unidadeAdmin_pai(){
        return $this->belongsTo(UnidadeAdministrativa::class, 'unidade_admin_pai_id');
    }

    public function unidadeAdmin()
    {
        return $this->hasMany(UnidadeAdministrativa::class, 'unidade_admin_pai_id');
    }

    public function predio(){
        return $this->belongsTo(Predio::class);
    }

    public function salas(){
        return $this->belongsToMany(Sala::class, 'sala_unidades_administrativas', 'unidade_admin_id', 'sala_id');
    }

    public function patrimonios()
    {
        return $this->hasMany(Patrimonio::class);
    }
}
