<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Motivo Reprovação</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{asset('/bootstrap/bootstrap.min.css')}}" rel="stylesheet" />
        
        <link href="{{asset('css/style.css')}}" rel="stylesheet" />


        <!-- Styles -->
        <style>
            html, body {
                background-color: white;
                color: black;
     
            }
        </style>
    </head>
    <body>
    <div class="text-center">

        <img class="mt-4 mb-4" src="/imgs/logo.png" height="80px" alt="Logo_Itaipu">
            <h1 class="titulo_1">RPE</h1>
            <h3 class="log">Motivo Reprovação</h3>
            <form style="width: 500px; margin:auto;" method="POST" action="{{ route('registro.motivo',['id'  => $atividade->id])}}">
                @if(session('message'))
                <div class="alert alert-danger">
                    {{session('message')}}
                </div>
                @endif 
                @csrf
                
                <div class="mt-4">
                    <input style="border-color: black;" value="{{old('motivo')}}" type="text" class="form-control" size="10px" id="motivo" placeholder="Motivo da Reprovação" name="motivo">
                </div>
                @if ($errors->first('motivo'))
                <div style="margin-top: 10px" class="alert-danger">{{$errors->first('motivo')}}</div>
                @endif


                <div class=" mt-3">
                    <button class="btn_1" class="btn btn-lg btn-primary"> Mandar e-mail Reprovação </button>

                </div>

            </form>
    </div>
    <script type="text/javascript" src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    </body>
</html>
