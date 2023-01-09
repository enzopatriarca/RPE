<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Email reenvio</title>
</head>
<body>
    <div id="container_validacao">
        <h2>Bom Dia.</h2>
        <h2>Sr. {{$atividade->user_aprovacao}}</h2>
        <h1>Atividade de Risco</h1>
    
    
    
        <table style="border-collapse: collapse;font-size: 16px;">
            <thead style="border: 1px solid black;">
                <tr>
                    <td style="width: auto; border: 1px solid black;">Data Inicio</td>
                    <td style="width: auto; border: 1px solid black;">Data Final</td>
                    <td style="width: auto;border: 1px solid black;">Local (S)</td>
                    <td style="width: auto;border: 1px solid black;">Descrição da Atividade</td>
                    <td style="width: auto;border: 1px solid black;">Supervisor ou Gerente</td>
    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 70px;border: 1px solid black;font-size: 14px;">{{$atividade->data_inicio}}</td>
                    <td style="width: 70px;border: 1px solid black;font-size: 14px;">{{$atividade->data_final}}</td>
                    <td style="width: auto;border: 1px solid black;font-size: 14px;">{{$atividade->tags_locais}}</td>
                    <td style="width: auto;border: 1px solid black;font-size: 14px;">{{$atividade->descricao}}</td>
                    <td style="width: auto;border: 1px solid black;font-size: 14px;">{{$atividade->gerente}}</td>
                </tr>
            </tbody>
        </table>

        <h3>Participantes:</h3>
        <table style="border-collapse: collapse;font-size: 16px;">
            <thead>
                <tr>
                    <td style="width: 250px; border-left: none;border-bottom: 1px solid;">Nome</td>
                    <td style="width: 300px; border-left: none;border-bottom: 1px solid;">Cargo</td>
                </tr>
            </thead>
        </table>
        @foreach ($participantes_ as $participante)
            <table style="border-collapse: collapse;font-size: 16px;">
                <tbody>
                    <tr>
                        <td style="width: 250px; border: none;border-top: none;border-right: none;">{{($participante->nome)}}</td>
                        <td style="width: 300px; border: none;border-top: none;border-right: none;">{{($participante->cargo)}}</td>
                    </tr>
                </tbody>
            </table>
        @endforeach

        <h3>LINK DE APROVAÇÃO: {{ url("http://{$ip}/validacao/{$hash_aprv}/{$atividade->id}")}} </h3>

        <h3>LINK DE REPROVAÇÃO: {{ url("http://{$ip}/reprovar/{$hash_rprv}/{$atividade->id}")}}</h3>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(window).on('load',function(){
            $(".loader").fadeOut(800);
            $("#container_validacao").fadeIn(1000);
        });
    </script>
</body>
</html>