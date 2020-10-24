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

        table thead, tbody {
             font-family: 'Montserrat';
        }

        .table-top, .table-resumen-pago {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
            margin: 0 ;
        }

        .table-top td,th {
            border: 1px solid #ddd;
            text-align: left;

        }

        .table-top th {
            padding: 12px;
            text-align:center;

        }

        .table-top td {
            padding: 2px;
            text-align: center;

        }

        .table-resumen-pago, td,th {
            border: 1px solid #ddd;
            text-align: left;
            padding: 5px;
        }

        .table-resumen-pago thead th:last-child {
            text-align: right;
        }
        .table-resumen-pago tbody td:last-child {
            text-align: right;
        }

        .table-retenciones-deducciones {
            border-collapse: collapse;
            width: 40%;
            font-size: 12px;
        }

        .table-retenciones-deducciones thead th:last-child {
            text-align: right;
        }
        .table-retenciones-deducciones tbody td:last-child {
            text-align: right;
        }

        .resume-title{
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .resume-title-left {
            display: flex;
            align-items: center;
            justify-content: left;
        }

        .offset {
            width: 7%;
        }

        h2,h3, small {
            font-weight: 500;
            text-align: center;
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

    <title>Colilla de Pago</title>
</head>
<body class="bg-white">
    <div class="container">

    <h2>Colilla de Pago</h2>


    <div class="resume-title">
        <table class="table-top">
            <thead>
                <tr class="text-center">
                    <th>Empresa</th>
                    <th>Funcionario</th>
                    <th>Periodo de Pago</th>
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
                    {{$funcionario['inicio']}} al {{$funcionario['fin']}}
                </td>
                </tr>
            </tbody>
        </table>
    </div>


    <h3 class="text-center font-weight-bold">Resumen de pago</h3>


   <div class="resume-title">
        <table class="table-resumen-pago">
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-right">Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td>Salario</td>
            <td class="text-right">@money($funcionario['salario'])</td>
            </tr>
            <tr>
            <td>Auxilio de transporte</td>
            <td class="text-right">@money($funcionario['auxilio_transporte'])</td>
            </tr>
            <tr>
            <td>Retenciones y deducciones</td>
            <td class="text-right">@money($funcionario['retenciones'])</td>
            </tr>
            <tr>
            <td class="font-weight-bold bg-light">Total neto a pagar</td>
            <td class="text-right font-weight-bold bg-light">@money($funcionario['salario_neto'])</td>
            </tr>
        </tbody>
    </table>
   </div>



   <h4 class="font-weight-bold text-center">Retenciones y deducciones</h4>


        <div class="resume-title-left">
            <div class="offset"></div>
            <table class="table-retenciones-deducciones">
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th class="text-right">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>Retenciones</td>
                    <td class="text-right">@money($funcionario['retenciones'])</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p class="text-center font-weight-bold text-muted">GeneticApp © 2020. Software de gestión de empleados y nómina en la nube<br>
        https://geneticapp.co</p>

    </footer>
</body>
</html>
