<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\cuentas;
use App\historial;
use Fpdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class transferencias extends Controller
{

  function microtime_float()
{
list($useg, $seg) = explode(" ", microtime());
return ((float)$useg + (float)$seg);
}



    public function traspaso($cuentadestino, $cuentaorigen, $monto ){
       header("Access-Control-Allow-Origin: *");
       header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
      $cuenta = DB::table('cuentas')->select('id','numerocuenta', 'dinero')
       ->where([ ['deleted','=', false],['numerocuenta','=', $cuentaorigen]])->first();

      $cuenta2 = DB::table('cuentas')->select('id','numerocuenta', 'dinero')
       ->where([ ['deleted','=', false],['numerocuenta','=', $cuentadestino]])->first();

    if($cuenta2 != null ){
      if(floatval($monto) <= $cuenta->dinero){

            $valor =DB::table('cuentas')->where([['id', $cuenta->id ]])->update(['dinero' =>  $cuenta->dinero - $monto]);
            

      		$rastero = '';
      		for($i = 1; $i <= 6; $i++){
            	$rastero = $rastero . rand( 0 , 9 );
         	}
          
      		$valor = DB::table('historial')->insert([
       		'numerocuenta' => $cuentaorigen,
       		'descripcion' => "Retiro de tu cuenta", 
       		'numerorastreo' => $rastero,
       		'cantidad' => floatval($monto),
       		'sitio' => 'Mibanco',
       		'cuentadestino' => $cuentadestino,
       		'tipotransferenciaid' => 1,
       		'deleted' => False,
          'created_at' =>strftime( "%Y-%m-%d-%H-%M-%S", time() ),
      		]);


      		$valor =DB::table('cuentas')->where([['id', $cuenta2->id ]])->update(['dinero' =>  $cuenta2->dinero + $monto]);

      		$rastero = '';
      		for($i = 1; $i <= 6; $i++){
            	$rastero = $rastero . rand( 0 , 9 );
         	}

      		$valor = DB::table('historial')->insert([
       		'numerocuenta' => $cuentadestino,
       		'descripcion' => "Agregado", 
       		'numerorastreo' => $rastero,
       		'cantidad' => floatval($monto),
       		'sitio' => 'Mibanco',
       		'cuentadestino' => $cuentaorigen,
       		'tipotransferenciaid' => 2,
       		'deleted' => False,
          'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
      		]);
          $rastero = '';
          for($i = 1; $i <= 6; $i++){
              $rastero = $rastero . rand( 0 , 9 );
          }
      return $rastero;
      }else{
   return 0;
      }
      }else{
                $data = array('parametro1' => "valor1", 'parametro2' => "valor2");
                // buscra entre los usuarios del otro equipo
                $url = '192.168.43.241/Banco/verificar_cuenta.php?cuenta_usuario='. $cuentausuario .'&monto='. $monto . '&sitio=Mibanco&descripcion=traspaso de dinero'. "&rastreo=".$rastero ;
                // Se crea un manejador CURL
                $ch=curl_init ();
                 
                // Se establece la URL y algunas opciones
                curl_setopt($ch, CURLOPT_URL, $url);
                 
                // Indicamos que enviaremos las variables en POST
                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                 
                // Adjuntamos las variables
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                 
                // Indicamos que el resultado lo devuelva curl_exec()
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                 
                // Se obtiene la URL indicada
                $result=curl_exec($ch);
                 

      	return 0;
      }

    }

    public function tienda($cuentausuario,$cuentatienda,$monto,$sitio,$descripcion){
       
       header("Access-Control-Allow-Origin: *");
       header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
       
       $cuenta = DB::table('cuentas')->select('id','numerocuenta','tipocuentaid', 'dinero')
       ->where([ ['deleted','=', false],['numerocuenta','=', $cuentatienda]])->first();
       
       if($cuenta != null){


       	       $cuentauser = DB::table('cuentas')->select('id','numerocuenta', 'tipocuentaid','dinero')
               ->where([ ['deleted','=', false],['numerocuenta','=', $cuentausuario]])->first();
               if($cuentauser != null){
               if($cuentauser->dinero >= $monto){
               	
                $valorupdate = microtime(true);
                $valor =DB::table('cuentas')->where([['id', $cuentauser->id ]])->update(['dinero' =>  $cuentauser->dinero - $monto]);
                $valorupdate = $valorupdate - microtime(true);

      						$rastero = '';
      						for($i = 1; $i <= 6; $i++){
            					$rastero = $rastero . rand( 0 , 9 );
         					}
                  $valorinsert= microtime(true);
      						$valor = DB::table('historial')->insert([
       								'numerocuenta' => $cuentausuario,
       								'descripcion' => "Retiro de tu cuenta", 
       								'numerorastreo' => $rastero,
       								'cantidad' => floatval($monto),
       								'sitio' => $sitio,
       								'cuentadestino' => $cuentatienda,
       								'tipotransferenciaid' => 2,
       								'deleted' => False,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
      						]);            
                 $valorinsert = $valorinsert - microtime(true);


                  $valor = DB::table('logs')->insert([
                      'operacion' => 1,
                      'alfa1' => floatval($valorinsert * -1), 
                      'alfa2' => floatval($valorupdate * -1),
                      'tiporetiro' => 1,
                      'tipoestado' => 1,
                      'tipocuenta' => $cuentauser->tipocuentaid,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);

                $valorupdate = microtime(true);
      						$valor =DB::table('cuentas')->where([['id', $cuenta->id ]])->update(['dinero' =>  $cuenta->dinero + $monto]);

                $valorupdate = $valorupdate - microtime(true);
                  $valorinsert= microtime(true);

      						$valor = DB::table('historial')->insert([
       								'numerocuenta' => $cuentatienda,
       								'descripcion' => "Retiro de tu cuenta", 
       								'numerorastreo' => $rastero,
       								'cantidad' => floatval($monto),
       								'sitio' => $sitio,
       								'cuentadestino' =>$cuentausuario,
       								'tipotransferenciaid' => 1,
       								'deleted' => False,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
      						]);


                 $valorinsert = $valorinsert - microtime(true);

                    $valor = DB::table('logs')->insert([
                      'operacion' => 2,
                      'alfa1' => floatval($valorinsert * -1), 
                      'alfa2' => floatval($valorupdate * -1),
                      'tiporetiro' => 2,
                      'tipoestado' => 1,
                      'tipocuenta' => $cuenta->tipocuentaid,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);

               	return $rastero;
                 
                 }else{

                  $rastero = '';
                  for($i = 1; $i <= 6; $i++){
                      $rastero = $rastero . rand( 0 , 9 );
                  }
                  $valorinsert= microtime(true);
                  $valor = DB::table('historial')->insert([
                      'numerocuenta' => $cuentatienda,
                      'descripcion' => "No cuenta con sufucueinte dinero", 
                      'numerorastreo' => $rastero,
                      'cantidad' => floatval($monto),
                      'sitio' => $sitio,
                      'cuentadestino' => $cuentausuario,
                      'tipotransferenciaid' => 1,
                      'deleted' => False,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);


                 $valorinsert = $valorinsert - microtime(true);


                  $valor = DB::table('logs')->insert([
                      'operacion' => 1,
                      'alfa1' => floatval($valorinsert * -1), 
                      'alfa2' => 0,
                      'tiporetiro' => 1,
                      'tipoestado' => 1,
                      'tipocuenta' => $cuenta->tipocuentaid,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);
                 /*
                  $valor = DB::table('logs')->insert([
                      'operacion' => 1,
                      'alfa1' => $valorinsert, 
                      'alfa2' => $valorupdate,
                      'tiporetiro' => floatval($monto),
                      'tipoestado' => 1,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);
*/
                    return $rastero;
                }
 
                  
                }else{

                $rastero = '';
                for($i = 1; $i <= 6; $i++){
                      $rastero = $rastero . rand( 0 , 9 );
                }
                $data = array('parametro1' => "valor1", 'parametro2' => "valor2");
                // buscra entre los usuarios del otro equipo
                $url = '192.168.43.241/Banco/verificar_cuenta.php?cuenta_usuario='. $cuentausuario .'&monto='. $monto . '&sitio=' . $sitio. '&descripcion='. $descripcion;
                // Se crea un manejador CURL
                $ch=curl_init ();
                 
                // Se establece la URL y algunas opciones
                curl_setopt($ch, CURLOPT_URL, $url);
                 
                // Indicamos que enviaremos las variables en POST
                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                 
                // Adjuntamos las variables
                //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                 
                // Indicamos que el resultado lo devuelva curl_exec()
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                

                // Se obtiene la URL indicada
                $result=curl_exec($ch);
    
               //echo "El resultado de la web es: ".(string)((int)$result+2);
                if((int)$result != 0){
                   //return $monto;
                   $valorupdate= microtime(true);
                   $valor =DB::table('cuentas')->where([['id', $cuenta->id ]])->update(['dinero' =>  $cuenta->dinero + $monto]);
                   $valorupdate = $valorupdate - microtime(true);



                    $rastero = '';
                    for($i = 1; $i <= 6; $i++){
                        $rastero = $rastero . rand( 0 , 9 );
                    }
                    $valorinsert= microtime(true);
                    $valor = DB::table('historial')->insert([
                    'numerocuenta' => $cuentatienda,
                    'descripcion' => $descripcion, 
                    'numerorastreo' => $result,
                    'cantidad' => floatval($monto),
                    'sitio' => $sitio,
                    'cuentadestino' => $cuentausuario,
                    'tipotransferenciaid' => 1,
                    'deleted' => False,
                    'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                    ]);
                   $valorinsert = $valorinsert - microtime(true);

                   $valor = DB::table('logs')->insert([
                      'operacion' => 3,
                      'alfa1' => floatval($valorinsert * -1), 
                      'alfa2' => floatval($valorupdate * -1),
                      'tiporetiro' => 1,
                      'tipoestado' => 1,
                      'tipocuenta' => $cuenta->tipocuentaid,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);
                   return $result;
                }
                return 2;
                }

       }else{
       	return 1;
       }
    }

    public function buscar($cuentausuario,$tienda,$monto,$sitio,$descripcion){
    	$cuenta = DB::table('cuentas')->select('id','numerocuenta', 'dinero')
               ->where([ ['deleted','=', false],['numerocuenta','=', $cuentausuario]])->first();


      if($cuenta != null){

   
                            $valor =DB::table('cuentas')->where([['id', $cuenta->id ]])->update(['dinero' =>  $cuenta->dinero - $monto]);
            
                 
                  $rastero = '';
                  for($i = 1; $i <= 6; $i++){
                      $rastero = $rastero . rand( 0 , 9 );
                  }
          
                  $valor = DB::table('historial')->insert([
                      'numerocuenta' => $cuentausuario,
                      'descripcion' => "Retiro de tu cuenta", 
                      'numerorastreo' => $rastero,
                      'cantidad' => floatval($monto),
                      'sitio' => $sitio,
                      'cuentadestino' => $tienda,
                      'tipotransferenciaid' => 2,
                      'deleted' => False,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);


        return $rastero;
      }
      else{
        return 0;
      }
      
    	return 0;
    }




public function imprimir($numerocuenta){

        $historial = DB::table('historial')
         ->join('tipotransferencia', 'historial.tipotransferenciaid', '=', 'tipotransferencia.id')
         ->select('historial.id','historial.numerocuenta', 'historial.descripcion', 'historial.numerorastreo','historial.cantidad','historial.sitio','historial.cuentadestino','tipotransferencia.nombre','historial.created_at')
         ->where([['numerocuenta','=', $numerocuenta],['deleted','=',false]])
         ->orderBy('historial.id', 'desc')->get();

     $pdf = \PDF::loadView('ejemplo', compact('historial'));
        return $pdf->download('ejemplo.pdf');
}




public function log(){
   
    for($i = 0; $i <= 1000; $i++){
     $cliente1 = rand(3, 6);
     do{
     $cliente2 = rand(3, 6); 

     }while($cliente1 == $cliente2);

     $cuenta = DB::table('cuentas')->select('id','numerocuenta','tipocuentaid', 'dinero')
     ->where([ ['deleted','=', false],['id','=', $cliente1]])->first();

     $cuentauser = DB::table('cuentas')->select('id','numerocuenta','tipocuentaid', 'dinero')
     ->where([ ['deleted','=', false],['id','=', $cliente2]])->first();
     
     $cuentausuario = $cuentauser->numerocuenta;
     $cuentatienda= $cuenta->numerocuenta;
     $monto = rand(100,200);
     $sitio = "pruebas log";
     $descripcion = "pruebas log";
          header("Access-Control-Allow-Origin: *");
       header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

       if($cuenta != null){

               if($cuentauser != null){
               if($cuentauser->dinero >= $monto){
                
                $valorupdate = microtime(true);
                $valor =DB::table('cuentas')->where([['id', $cuentauser->id ]])->update(['dinero' =>  $cuentauser->dinero - $monto]);
                $valorupdate = $valorupdate - microtime(true);


                  $rastero = '';
                  for($i = 1; $i <= 6; $i++){
                      $rastero = $rastero . rand( 0 , 9 );
                  }
                  $valorinsert= microtime(true);
                  $valor = DB::table('historial')->insert([
                      'numerocuenta' => $cuentausuario,
                      'descripcion' => "Retiro de tu cuenta", 
                      'numerorastreo' => $rastero,
                      'cantidad' => floatval($monto),
                      'sitio' => $sitio,
                      'cuentadestino' => $cuentatienda,
                      'tipotransferenciaid' => 1,
                      'deleted' => False,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);            
                 $valorinsert = $valorinsert - microtime(true);


                  $valor = DB::table('logs')->insert([
                      'operacion' => 1,
                      'alfa1' => floatval($valorinsert * -1), 
                      'alfa2' => floatval($valorupdate * -1),
                      'tiporetiro' => 1,
                      'tipoestado' => 1,
                      'tipocuenta' => $cuentauser->tipocuentaid,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);

                $valorupdate = microtime(true);
                  $valor =DB::table('cuentas')->where([['id', $cuenta->id ]])->update(['dinero' =>  $cuenta->dinero + $monto]);

                $valorupdate = $valorupdate - microtime(true);
                  $valorinsert= microtime(true);

                  $valor = DB::table('historial')->insert([
                      'numerocuenta' => $cuentatienda,
                      'descripcion' => "Retiro de tu cuenta", 
                      'numerorastreo' => $rastero,
                      'cantidad' => floatval($monto),
                      'sitio' => $sitio,
                      'cuentadestino' =>$cuentausuario,
                      'tipotransferenciaid' => 2,
                      'deleted' => False,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);


                 $valorinsert = $valorinsert - microtime(true);

                    $valor = DB::table('logs')->insert([
                      'operacion' => 2,
                      'alfa1' => floatval($valorinsert * -1), 
                      'alfa2' => floatval($valorupdate * -1),
                      'tiporetiro' => 2,
                      'tipoestado' => 1,
                      'tipocuenta' => $cuenta->tipocuentaid,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);

             //   return $rastero;
                 
                 }else{

                  $rastero = '';
                  for($i = 1; $i <= 6; $i++){
                      $rastero = $rastero . rand( 0 , 9 );
                  }
                  $valorinsert= microtime(true);
                  $valor = DB::table('historial')->insert([
                      'numerocuenta' => $cuentatienda,
                      'descripcion' => "No cuenta con sufucueinte dinero", 
                      'numerorastreo' => $rastero,
                      'cantidad' => floatval($monto),
                      'sitio' => $sitio,
                      'cuentadestino' => $cuentausuario,
                      'tipotransferenciaid' => 1,
                      'deleted' => False,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);


                 $valorinsert = $valorinsert - microtime(true);


                  $valor = DB::table('logs')->insert([
                      'operacion' => 1,
                      'alfa1' => floatval($valorinsert * -1), 
                      'alfa2' => 0,
                      'tiporetiro' => 1,
                      'tipoestado' => 1,
                      'tipocuenta' => $cuenta->tipocuentaid,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);
                 /*
                  $valor = DB::table('logs')->insert([
                      'operacion' => 1,
                      'alfa1' => $valorinsert, 
                      'alfa2' => $valorupdate,
                      'tiporetiro' => floatval($monto),
                      'tipoestado' => 1,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);
*/
                //    return $rastero;
                }
 
                  
                }else{

                $rastero = '';
                for($i = 1; $i <= 6; $i++){
                      $rastero = $rastero . rand( 0 , 9 );
                }

                $data = array('parametro1' => "valor1", 'parametro2' => "valor2");
                // buscra entre los usuarios del otro equipo
                $url = '192.168.43.241/Banco/verificar_cuenta.php?cuenta_usuario='. $cuentausuario .'&monto='. $monto . '&sitio=' . $sitio. '&descripcion='. $descripcion;
                // Se crea un manejador CURL
                $ch=curl_init ();
                 
                // Se establece la URL y algunas opciones
                curl_setopt($ch, CURLOPT_URL, $url);
                 
                // Indicamos que enviaremos las variables en POST
                curl_setopt($ch, CURLOPT_HTTPGET, 1);
                 
                // Adjuntamos las variables
                //curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                 
                // Indicamos que el resultado lo devuelva curl_exec()
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                

                // Se obtiene la URL indicada
                $result=curl_exec($ch);
    
                 
               //echo "El resultado de la web es: ".(string)((int)$result+2);
                if((int)$result != 0){
                   //return $monto;
                   $valorupdate= microtime(true);
                   $valor =DB::table('cuentas')->where([['id', $cuenta->id ]])->update(['dinero' =>  $cuenta->dinero + $monto]);
                   $valorupdate = $valorupdate - microtime(true);



                    $rastero = '';
                    for($i = 1; $i <= 6; $i++){
                        $rastero = $rastero . rand( 0 , 9 );
                    }
                    $valorinsert= microtime(true);
                    $valor = DB::table('historial')->insert([
                    'numerocuenta' => $cuentatienda,
                    'descripcion' => $descripcion, 
                    'numerorastreo' => $result,
                    'cantidad' => floatval($monto),
                    'sitio' => $sitio,
                    'cuentadestino' => $cuentausuario,
                    'tipotransferenciaid' => 2,
                    'deleted' => False,
                    'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                    ]);
                   $valorinsert = $valorinsert - microtime(true);

                   $valor = DB::table('logs')->insert([
                      'operacion' => 3,
                      'alfa1' => floatval($valorinsert * -1), 
                      'alfa2' => floatval($valorupdate * -1),
                      'tiporetiro' => 1,
                      'tipoestado' => 1,
                      'tipocuenta' => $cuenta->tipocuentaid,
                      'created_at' => strftime( "%Y-%m-%d-%H-%M-%S", time() ),
                  ]);
            //       return $result;
                }
          //      return 2;
                }

       }else{
        //return 1;
       }
     }

}






}
