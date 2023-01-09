<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>E-mail Usuarios</title>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
        <link rel="stylesheet" type="text/css" href="css/style.css">

        

        <!-- Styles -->
        <style>
            html, body {
                background-color: white;
                color: black;
     
            }
        </style>
    </head>
    <body>
        <div class="loader">
            <div>
        
            </div>
        </div>
        
        <div id="container_validacao">
            <h2>Bom Dia.</h2>
            <h2>Atividade de Risco APROVADA</h2>
            <h2>Data Aprovação: {{$atividade_->data_situacao}}</h2>
        
            <table style="border-collapse: collapse;font-size: 16px;">
                <thead style="border: 1px solid black;">
                    <tr>
                        <td style="width: auto; border: 1px solid black;">Data Inicio</td>
                        <td style="width: auto; border: 1px solid black;">Data Final</td>
                        <td style="width: auto;border: 1px solid black;">Natureza(S) de Atividade</td>
                        <td style="width: auto;border: 1px solid black;">Área(S) de Risco</td>
                        <td style="width: auto;border: 1px solid black;">Local (S)</td>
                        <td style="width: auto;border: 1px solid black;">Descrição da Atividade</td>
                        <td style="width: auto;border: 1px solid black;">Supervisor</td>
                        <td style="width: auto;border: 1px solid black;">Aprovador/Reprovador</td>
        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 70px;border: 1px solid black;font-size: 14px;">{{$atividade_->data_inicio}}</td>
                        <td style="width: 70px;border: 1px solid black;font-size: 14px;">{{$atividade_->data_final}}</td>
                        <td style="width: auto;border: 1px solid black;font-size: 14px;">{{$atividade_->tags_natureza}}</td>
                        <td style="width: auto;border: 1px solid black;font-size: 14px;">{{$atividade_->tags_area}}</td>
                        <td style="width: auto;border: 1px solid black;font-size: 14px;">{{$atividade_->tags_locais}}</td>
                        <td style="width: auto;border: 1px solid black;font-size: 14px;">{{$atividade_->descricao}}</td>
                        <td style="width: auto;border: 1px solid black;font-size: 14px;">{{$atividade_->gerente}}</td>
                        <td style="width: auto;border: 1px solid black;font-size: 14px;">{{$atividade_->user_aprovacao}}</td>
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
            @foreach ($user_participantes as $participante)
                <table style="border-collapse: collapse;font-size: 16px;">
                    <tbody>
                        <tr>
                            <td style="width: 250px; border: none;border-top: none;border-right: none;font-size: 14px;">{{($participante->nome)}}</td>
                            <td style="width: 300px; border: none;border-top: none;border-right: none;font-size: 14px;">{{($participante->cargo)}}</td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
 
        </div>
    
        <script>
            $(window).on('load',function(){
                $(".loader").fadeOut(800);
                $("#container_validacao").fadeIn(1000);
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
