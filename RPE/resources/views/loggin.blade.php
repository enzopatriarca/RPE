<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Loggin</title>

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
        <h3 class="log">LOGIN</h3>

    <form style="width: 500px; margin:auto;" method="POST" action="{{route('auth.user')}}">



        @if(session('danger'))

            <div class="alert alert-danger">
                {{session('danger')}}
            </div>

        @endif    
     
        @csrf
        
        <div class="mt-4">
            <label class="titulo_2" for="Username"> Digite seu usuario:</label>
            <input style="border-color: black;border-left: none;border-right: none;border-top:none" value="{{old('username')}}" type="text" class="form-control" size="10px" id="username" placeholder="Username" name="username">
        </div>
        @if ($errors->first('username'))
        <div style="margin-top: 10px" class="alert-danger">{{$errors->first('username')}}</div>
        @endif


        <div class="mt-4">
            <label class="titulo_2" for="pass">Digite sua senha: </label>

                <input style="border-color: black;border-left: none;border-right: none;border-top:none" value="{{old('password')}}" type="password" class="form-control" size="10px" id="password" placeholder="password" name="password">                           
        </div>
        @if ($errors->first('password'))
        <div style="margin-top: 10px" class="alert-danger">{{$errors->first('password')}}</div>
        @endif

        <div class=" mt-3">
                <button class="btn_1" class="btn btn-lg btn-primary">Entrar</button>

        </div>

    </form>

    </div>    


    <script type="text/javascript" src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    </body>
</html>
