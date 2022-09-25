<?php

namespace App\Models;


use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasRoles;
    protected $table = 'roles';
  
    protected $fillable = [
        'name',
        'guard_name',
        'descripcion',

    ];
    protected $hidden = array('pivot');
    public function permisos(){
        return $this->belongsToMany(Permiso::class,'role_has_permissions','role_id','permission_id');
    }
}
