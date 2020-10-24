<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
     
    <style>
        @font-face {
        font-family: 'Montserrat';
        src: url({{ storage_path('fonts/Montserrat-Regular.ttf') }}) format("truetype");
        }

        table {
             font-family: 'Montserrat';
        }

        .table-top {
            border-collapse: collapse;
            width: 85%;
            font-size: 12px;
            margin: 0 auto;
        }

        .table-top td,th {
            border: 1px solid #ddd;
            text-align: center;
            padding: 12px;
           
        }

        .table-top td {
            padding: 2px;
            text-align: center;
           
        }

      .container-tables {
          overflow: hidden;
      }

      .table-float-left {
          width: 50%;
          float: left;
      }

      .table-float-right {
          width: 50%;
          float: right;
      }

        .table-periodo-liquidacion, .table-bases-liquidacion {
            border-collapse: collapse;
            width: 40%;
            font-size: 12px;
        }

        .table-periodo-liquidacion tbody td, .table-bases-liquidacion tbody td {
            border: 1px solid #ddd;
            text-align: left;
            pading: 8px;
           
        }
        
        .table-periodo-liquidacion tbody td:last-child, .table-bases-liquidacion tbody td:last-child {
            text-align: right;
        }

       


        h2,h3,small {
            font-weight: 500;
            text-align: center;
            font-family: 'Montserrat';
        }

        h4 {
            font-weight: 500;
            text-align: left;
            font-family: 'Montserrat';  
        }
      
        footer {
            margin-top: 30px;
        }
        footer p {
            font-size: 12px;
            text-align: center;
             font-family: 'Montserrat';
        }
     
    </style>

    <title>Liquidación Funcionario</title>
</head>
<body>

<h2>Liquidación Laboral</h2>

<div class="resume-title">
    <table class="table-top">
        <thead>
            <tr class="text-center">
                <th>Empresa</th>
                <th>Funcionario</th>
                <th>Causa de liquidación</th>
            </tr>
        </thead>
    <tbody>
            <tr class="text-center">
            <td>{{$funcionario['empresa']}}</td>
            <td>
            <p> {{$funcionario['nombres']}} {{$funcionario['apellidos']}}</p>
            <p> C.C {{$funcionario['identidad']}}</p>
            <p> <small class="font-weight-bold">{{$funcionario['cargo']}}</small></p>
            </td>
            <td>
                Causa de liquidación
            </td>
            </tr> 
        </tbody>
    </table>
</div>







    <h4>Periodo de liquidación</h4>
   
    <table class="table-periodo-liquidacion">
        <tbody>
            <tr>
            <td>Fecha de inicio de contrato</td>
            <td>{{$funcionario['fecha_ingreso']}}</td>
            </tr>
            <tr>
            <td>Fecha de terminación de contrato</td>
            <td>{{$funcionario['fecha_retiro']}}</td>
            </tr>
            <tr>
            <td>Días a liquidar</td>
            <td>{{$funcionario['dias_liquidacion']}}</td>
            </tr>
        </tbody>
    </table>

<h4>Bases de liquidación</h4>
      

   
    <table class="table-bases-liquidacion">
        <tbody>
            <tr>
            <td>Salario promedio</td>
            <td>{{$funcionario['salario']}}</td>
            </tr>
            <tr>
            <td>Base vacaciones</td>
            <td>{{$funcionario['base_vacaciones']}}</td>
            </tr>
            <tr>
            <td>Base cesantías</td>
            <td>{{$funcionario['base_cesantias']}}</td>
            </tr>
            <tr>
            <td>Base prima</td>
            <td>{{$funcionario['base_prima']}}</td>
            </tr>
        </tbody>
    </table>


   
</body>
</html>