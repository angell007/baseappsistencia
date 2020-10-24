<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titulo')</title>
    <style>
        table.minimalistBlack {
        border: 3px solid #000000;
        width: 100%;
        text-align: left;
        border-collapse: collapse;
        }
        table.minimalistBlack td, table.minimalistBlack th {
        border: 1px solid #000000;
        padding: 5px 4px;
        }
        table.minimalistBlack tbody td {
        font-size: 13px;
        }
        table.minimalistBlack tbody tr {
        text-align: center;
        }

        table.minimalistBlack thead {
        background: #CFCFCF;
        background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
        background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
        background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
        border-bottom: 3px solid #000000;
        }
        table.minimalistBlack thead th {
        font-size: 15px;
        font-weight: bold;
        color: #000000;
        text-align: center;
        },

    </style>
</head>
 <body>


        <h1 style="">Reporte de Llegadas Tarde</h1>

         <div class="container">
                   <table class="minimalistBlack">
                       <thead class="thead-dark">
                           <tr>
                               <th>Fecha</th>
                               <th>Entrada de turno</th>
                               <th>Entrada de real</th>
                               <th>Nombre del funcionario</th>
                               <th>Dependencia</th>
                               <th>Centro de costos</th>
                           </tr>
                       </thead>
                       <tbody>
                          @foreach ($llegadasTarde as $llegada)
                              <tr>
                              <td>{{$llegada->fecha}}</td>
                              <td>{{$llegada->entrada_turno}}</td>
                              <td>{{$llegada->entrada_real}}</td>
                              <td>{{$llegada->funcionario->nombres}} {{$llegada->funcionario->apellidos}}</td>
                              <td>{{$llegada->funcionario->dependencia->nombre}}</td>
                              <td>{{$llegada->funcionario->dependencia->centroCosto->nombre}}</td>

                              </tr>
                          @endforeach
                       </tbody>
                   </table>
                </div>

</body>
</html>
