@extends('layouts.dashboard')

@section('content')
<style type="text/css">
.tarjeta{
  border: 1px solid #2222;
  padding: 90px;
  border-radius: 10px;
  background-color: #0c6d8ac9;
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

                        <div class="col-md-6">
                          <div style="position:  absolute;width: 13%;height: 16%;background-color: #9E9E9E;top: 26%;left: 20%;border-radius: 10px;"></div>
                          <div> <img style="position:  absolute;width: 40%;top: 5%;left: 5%;" src="static/img/mibanco.png"></div>
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
                    <h4>Saldo: <span>{{$cuenta->dinero}}</span></h4>

                    <div> <h6>Historial reciente</h6></div>

                    <div class="row">
                      <div class="col-md-12">
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>John</td>
                                <td>Doe</td>
                                <td>john@example.com</td>
                              </tr>
                              <tr>
                                <td>Mary</td>
                                <td>Moe</td>
                                <td>mary@example.com</td>
                              </tr>
                              <tr>
                                <td>July</td>
                                <td>Dooley</td>
                                <td>july@example.com</td>
                              </tr>
                            </tbody>
                          </table>
                      </div>
                    </div>
 
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
