<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'guard_name',
        'descripcion',

    ];
    protected $hidden = ['pivot','id','guard_name'];
 
    public function roles(){
        return $this->belongsToMany(Rol::class,'role_has_permissions','permission_id','role_id');
    }
     
    // public $timestamps = false;
}
