<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cuentas extends Model
{
    protected $fillable = [
        'numerocuenta', 'dinero', 'usersid','tipocuentaid','deleted','clave','mes','anu',
    ];
}
