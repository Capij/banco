

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	  <link href="static/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<style>
	h1{
		text-align: center;
		text-transform: uppercase;
	}
	.contenido{
		font-size: 20px;
	}
	#primero{
		background-color: #ccc;
	}
	#segundo{
		color:#44a359;
	}
	#tercero{
		text-decoration:line-through;
	}
</style>
</head>
<body>
	<h1>MiBanco</h1>
	<hr>
                    <div class="row">
                      <div class="col-md-12">
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Sitio</th>
                                <th>No. Rastreo</th>
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
                                <th>{{$historia->nombre}}</th>
                                <th>{{$historia->created_at}}</th>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                      </div>
                    </div>
</body>
</html>
1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
<!DOCTYPE html>
<html lang="es">
<head>
 <meta charset="UTF-8">
 <title>Document</title>
<style>
 h1{
 text-align: center;
 text-transform: uppercase;
 }
 .contenido{
 font-size: 20px;
 }
 #primero{
 background-color: #ccc;
 }
 #segundo{
 color:#44a359;
 }
 #tercero{
 text-decoration:line-through;
 }
</style>
</head>
<body>
 <h1>Titulo de prueba</h1>
 <hr>
 <div class="contenido">
 <p id="primero">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
 <p id="segundo">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
 <p id="tercero">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Labore nihil illo odit aperiam alias rem voluptatem odio maiores doloribus facere recusandae suscipit animi quod voluptatibus, laudantium obcaecati quisquam minus modi.</p>
 </div>
</body>
</html>