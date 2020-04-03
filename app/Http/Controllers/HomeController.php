<?php

namespace App\Http\Controllers;

use App\cuentas;
use App\historial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cuenta = DB::table('cuentas')->select('id', 'numerocuenta', 'dinero', 'clave', 'mes', 'anu')
        ->where([ ['deleted','=', false],['usersid','=', Auth::id()],['tipocuentaid','=', 1]])->first();

        $historial = DB::table('historial')->join('tipotransferencia', 'historial.tipotransferenciaid', '=', 'tipotransferencia.id')->select('historial.id','historial.numerocuenta', 'historial.descripcion', 'historial.numerorastreo','historial.cantidad','historial.sitio','historial.cuentadestino','tipotransferencia.nombre','historial.created_at')->where([['numerocuenta','=', $cuenta->numerocuenta],['deleted','=',false]])->orderBy('historial.id', 'desc')->take(5)->get();
        $datos = 0;
        $colorr = 1;
        return view('tarjetas',compact('datos', 'cuenta','colorr','historial'));
    }

    public function credito()
    {
        

        $cuenta = DB::table('cuentas')->select('id', 'numerocuenta', 'dinero', 'clave','mes','anu')
        ->where([ ['deleted','=', false],['usersid','=', Auth::id()], ['tipocuentaid','=', 2]])->first();

        if($cuenta != null){
 
        $historial = DB::table('historial')->join('tipotransferencia', 'historial.tipotransferenciaid', '=', 'tipotransferencia.id')->select('historial.id','historial.numerocuenta', 'historial.descripcion', 'historial.numerorastreo','historial.cantidad','historial.sitio','historial.cuentadestino','tipotransferencia.nombre','historial.created_at')->where([['numerocuenta','=', $cuenta->numerocuenta],['deleted','=',false]])->orderBy('historial.id', 'desc')->take(5)->get();
        }else{
            $historial =null;
        }

        $datos = 0;
        $colorr = 0;
        return view('tarjetas',compact('datos', 'cuenta', 'colorr', 'historial'));
    }


    public function creditocrear(){
        
        $numero= '4322';
        $clave = '';
        for($i = 1; $i <= 12; $i++){
            $numero = $numero . rand( 0 , 9 );
         }

        for($i = 0; $i < 3; $i++ ){
            $clave = $clave . rand(0, 9);
        }

        $valor = cuentas::create([
            'numerocuenta' => $numero,
            'dinero' => 10000,
            'usersid'=> Auth::id(),
            'tipocuentaid' => 2,
            'deleted'=> False,
            'clave'=> $clave,
            'mes' => rand(1,12),
            'anu' => rand(20,23),
        ]);

        $cuenta = DB::table('cuentas')->select('id', 'numerocuenta', 'dinero', 'clave','mes', 'anu')
        ->where([ ['deleted','=', false],['usersid','=', Auth::id()], ['tipocuentaid','=', 2]])->first();
        $datos = 0;
        $colorr = 0;
        if($cuenta != null){
            $historial = DB::table('historial')->select('id','numerocuenta', 'descripcion', 'numerorastreo','cantidad','sitio','cuentadestino','tipotransferenciaid')->where([['id','=', $cuenta->id],['deleted','=',false]])->get();
        }else{
            $historial =null;
        }
        return view('tarjetas',compact('datos', 'cuenta', 'colorr', 'historial'));
      
    }

    public function export($type, $cuenta) {

       $data = DB::table('historial')->join('tipotransferencia', 'historial.tipotransferenciaid', '=', 'tipotransferencia.id')->select('historial.id','historial.numerocuenta', 'historial.descripcion', 'historial.numerorastreo','historial.cantidad','historial.sitio','historial.cuentadestino','tipotransferencia.nombre','historial.created_at')->where([['numerocuenta','=', $cuenta],['deleted','=',false]])->get();
       $data =json_decode(json_encode($data), true);
     //dd($data);
//       dd($s);
//       $dato = cuentas::get()->toArray();
//       dd($dato);
        return \Excel::create('Excel', function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    } 
    


    public function import(){

    \Excel::load('1/1.xlsx',function($reader){
        foreach ($reader->get() as $value) {
            dd($value);
        }


    });
        return view('pruebas', compact('resul'));


    }



    public function exportlog() {
       $type = 'csv';
       $data = DB::table('logs')->limit(40000)->get();
       $data =json_decode(json_encode($data), true);
     //dd($data);
//       dd($s);
//       $dato = cuentas::get()->toArray();
//       dd($dato);
        return \Excel::create('Log-'.strftime( "%Y-%m-%d-%H-%M-%S", time() ), function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->fromArray($data);
            });
        })->download($type);
    } 

}
