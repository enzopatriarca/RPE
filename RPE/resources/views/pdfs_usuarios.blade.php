<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" type="text/css" href="{{asset('/bootstrap/bootstrap.min.css')}}" rel="stylesheet" />
       
    <link href="{{asset('css/style.css')}}" rel="stylesheet" />
    <title>PDF Atividades</title>
    
</head>
<body>
    
    @for ($i = 0; $i < count($atividades_); $i++)
        <div style="display: flex; ">
            <img style="width:100px; heigth:100px" src="imgs/logo.png" alt="">
            <p style="display: inline-flex;color:black;font-size: 22px;font-weight: bold;">REGISTRO PERIÓDICO DE EXECUÇÃO DE TRABALHOS COM RISCO ELÉTRICO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MES REF:{{$monthName}}/{{$ano}}</p>
            
        </div>
    
        <table style="border: 1px solid black;font-size: 25px;">
            <thead style="border: 1px solid black;">
                <tr>
                    <td style="width: 600px; border: 1px solid black;"> <b>Nome:</b> <small>{{$users_[$i]->nome}}</small> </td>
                    <td style="width: 445px;border: 1px solid black;"><b>Matricula:</b> <small style="color: red">{{$users_[$i]->matricula}}</small></td>
                    <td style="width: 445px;border: 1px solid black;"><b>Autorização:</b>  <small style="color: red">{{$users_[$i]->autorizacao}}</small> </td>
        
        
                </tr>
            </thead>


        </table>

        <table style="border: 1px solid black;font-size: 25px;">
            <thead style="border: 1px solid black;">
                <tr>
                    <td style="width: 600px; border: 1px solid black;"><b>Cargo:</b>  {{$users_[$i]->cargo}} </td>
                    <td style="width: 893px;border: 1px solid black;"><b>Lotação:</b>  <small style="color: red">{{$users_[$i]->Lotacao}}</small>  </td>        
                </tr>
            </thead>

        </table>

        <br>
        <br>
        <table style="border: 1px solid black;">
            <thead style="border: 1px solid black;">
                <tr style="text-align: center">
                    <td style="width: auto; border: 1px solid black;font-size: 21px;font-weight: bold;background-color: lightgrey;">Dia(s)</td>
                    <td style="width: auto;border: 1px solid black;font-size: 21px;font-weight: bold;background-color: lightgrey;">Natureza(S) de Atividade</td>
                    <td style="width: auto;border: 1px solid black;font-size: 21px;font-weight: bold;background-color: lightgrey;">Área(S) de Risco</td>
                    <td style="width: auto;border: 1px solid black;font-size: 21px;font-weight: bold;background-color: lightgrey;">Local (S)</td>
                    <td style="width: auto;border: 1px solid black;font-size: 21px;font-weight: bold;background-color: lightgrey;">Descrição da Atividade</td>
                    <td style="width: auto;border: 1px solid black;font-size: 21px;font-weight: bold;background-color: lightgrey;">Visto do Supervisor ou Gerente</td>
                </tr>
            </thead>
                @foreach ($atividades_[$i] as $atividade)
                    <tbody>
                        <tr>  
                            <td style="width: 115px;border: 1px solid black;font-size: 21px;">{{$atividade->dias}}</td>  
                            <td style="width: 110px;border: 1px solid black;font-size: 21px;text-align: center">{{$atividade->tags_natureza}}</td>
                            <td style="width: 150px;border: 1px solid black;font-size: 21px;text-align: center">{{$atividade->tags_area}}</td>
                            <td style="width: 260px;border: 1px solid black;font-size: 21px;">{{$atividade->tags_locais}}</td>

                            <td style="width: 640px;border: 1px solid black;font-size: 21px;">{{$atividade->descricao}}</td>
                            <td style="width: 115px;border: 1px solid black;font-size: 21px;text-align: center">{{$atividade->gerente}}</td>  
                        </tr>
                    </tbody>
                @endforeach
        </table>
        <br>
        <br>
        <br>
        <table>
            <thead>
                <tr>
                    <td style="width: 500px; border: 1px solid black;font-weight: bold;background-color: lightgrey;">Assinatura:</td>
                    <td style="width: auto;border: 1px solid black;font-weight: bold;background-color: lightgrey;">Natureza da Atividade:</td>
                    <td style="width: auto;border: 1px solid black;font-weight: bold;background-color: lightgrey;">Áreas de Risco:</td>
                </tr>
            </thead>
            <tbody>
                <tr style="">
                    <td style="width: auto;border: 1px solid black;text-align: center">
                        <p>___________________________ ___/___/____</p>
                        <p>Gerente Imediato</p>
                    </td>
                    <td style="width: auto;border: 1px solid black;">
                        @foreach ($naturezas_ as $natureza)
                            <p style="color: black">{{$natureza->id}}.{{$natureza->nome_natureza}}</p>          
            
                        @endforeach
                    </td>
                    <td style="width: auto;border: 1px solid black;">
                        @foreach ($areas_ as $area)
                            <p>{{$area->id}}.{{$area->nome_area}}</p>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <div class="page_break"></div>    
    @endfor   
   
    <script type="text/javascript" src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
</body>
</html>