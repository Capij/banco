@extends('layouts.dashboard')

@section('content')
<style type="text/css">
.tarjeta{
  border: 1px solid #2222;
  padding: 90px;
  border-radius: 10px;
  @if($colorr == 1)
  background-color: #0c6d8ac9;
  @else
  background-color: #656565;
  @endif
  color: #fff;

}

</style>
<div class="container" style="margin-bottom: 6%; margin-top: 6%">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body" style="display: inline;">
                    <div class="row">
                  @if($cuenta != null)
                        <div class="col-md-6">
                          <div style="position:  absolute;width: 13%;height: 16%;background-color: #9E9E9E;top: 26%;left: 20%;border-radius: 10px;"></div>
                          <div> <img style="position:  absolute;width: 40%;top: 5%;left: 5%;" src="static/img/mibanco.png"></div>
                          <div style="position: absolute;top: 70%;left: 37%;color:  #fff;">{{$cuenta->mes}}/{{$cuenta->anu}}</div>
                            <div class="tarjeta">

                                @for($i = 0; $i < 16; $i++)
                                 @if(($i%4) == 0)
                                  @if($i != 0) 
                                  {{'-'}}
                                  @endif
                                 @endif
                                 {{$cuenta->numerocuenta[$i]}}
                                @endfor

                            </div>
                            <div> <img style="position:  absolute;width:  90px;top: 70%;left: 70%;"  src="static/img/Master.png"></div>
                        </div>
                        <div class="col-md-6">

                            <div style="width: 20%;height: 25%;background-color: #9e9e9e;position:  absolute;border-radius:  20px;top: 65%;left: 10%;"></div>
                          <div style="position:  absolute;width: 93.5%;height:  30px;background-color: #555;top: 30px;"></div>
                            <div class="tarjeta">
                              <div style="background-color: #fff; border: 1px solid #fff; color: #000;">
                                {{$cuenta->clave}}
                              </div>  
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-6" > 
                      <h4>Saldo: <span>{{$cuenta->dinero}}</span></h4>
                      </div >
                      <div class="col-md-6">
                        <div class="row">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Retiro</button>
                        </div>
                        <div class="col-md-3">
                            <a
                             type="button" href="{{url('/imprimir')}}/{{$cuenta->numerocuenta}}" target="_blank"  class="btn btn-info">PDF</a>
                        </div>
                        <div class="col-md-3">
                            <a type="button" href="{{ url('/descargar-productos/csv')}}/{{$cuenta->numerocuenta}}" target="_blank"  class="btn btn-info" >EXCEL</a>
                        </div>
                        <form action="{{ url('/descargar-productos/csv')}}/{{$cuenta->numerocuenta}}" method="POST"  enctype="multipart/form--data">
              {{csrf_field()}}
              <input type="file" name="file"><br>

              <input type="submit" value="subir">
            </form>
                        <!--<div class="col-md-3">
                            <a type="button" href="{{ url('/pruebaslog')}}" target="_blank"  class="btn btn-info" >LOG</a>
                        </div>-->
                        <div class="col-md-3">
                          @if(Auth::id() == 3)
                            <a type="button" href="{{ url('/log')}}" target="_blank"  class="btn btn-info" >LOG excel</a>
                            @endif
                        </div>
                        </div>
                    </div>
                    </div>

                    <div> <h6>Historial reciente</h6></div>

                    <div class="row">
                      <div class="col-md-12">
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Sitio</th>
                                <th>No.Rastreo</th>
                                <th>Monto</th>
                                <th>Tipo</th>
                                <th>Fecha</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($historial as $historia)
                              <tr>
                                <td>{{$historia->sitio}}</td>
                                <td>{{$historia->numerorastreo}}</td>
                                <th>${{$historia->cantidad}}</th>
                                <th>@if($historia->nombre != null){{$historia->nombre}}@endif</th>
                                <th>@if($historia->created_at != null){{$historia->created_at}}@endif</th>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                      </div>
                    </div>

              @else 
              <div>
                <p> <h3> Usted aun no tiene una cuenta de credito precione el siguiente boton si desea recibir pagos en su paguina web</h3></p>
            <form method="POST" action="{{url('/credito')}}">
              {{ csrf_field() }}
              <button type="sumit" class="btn btn-info" style="display: block; margin-left: auto; margin-right: auto;">Crear credito</button>
              </div>
            </form>
              @endif
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>Cuenta </p>
        <input type="text" name="cuenta" id="cuenta">
        <p>Monto</p>
        <input type="text" name="monto" id="monto">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-default" onclick="retiro()">Aceptar</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">

  function moda(){
    $('#myModal').show();
  }
  
  function retiro(){
    @if($cuenta != null)
     $.ajax({
                    url: '/transferencia/'+ $('#cuenta').val().replace(/ /g,"").replace(/-/g,"") +'/{{$cuenta->numerocuenta}}/' + $('#monto').val(),
                    //url :'/tienda/4321628545479415/4322237854040043/200/mundo/hola',
                    type: 'GET',
                    dataType: 'json',

                    success: function (json) {

                       console.log(json);
                       location.reload(true);

                    },
                    error: function (xhr, status) {
                        alert('Disculpe, existió un problema');
                    },
                    complete: function (xhr, status) {

                    }
                });
     @endif

  }
  function ver(){

    $.get("http://192.168.1.1/transferencia/4444/2222/100",
       function(data){
       alert(data);
        });
   
  }

</script>
@endsection
