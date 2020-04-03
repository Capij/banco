<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class historial extends Model
{

    protected $fillable = [
        'id','numerocuenta', 'descripcion', 'numerorastreo','cantidad','sitio','cuentadestino','tipotransferenciaid','deleted',
    ];

}
