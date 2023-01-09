<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Registro de Usuario</title>
        <script type="text/javascript" src="{{asset('jquary/jquery-3.6.0.min.js')}}"></script>
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

        @if(Auth::check())
        <?php	
            $user = Auth::user();
        ?>
        @else 
        <script>window.location = "/RPE/public/"</script>
        @endif
        
    </head>
    <body >
        <div class="loader">
            <div>
    
            </div>
        </div>

        <div id="container_validacao" class="container-fluid">
            @can('permissao_de_pagina_adm_super')
                <div class="row flex-nowrap">
                    <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                        <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                            <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            
                            <div class="dropdown pb-4">
                                <a href="" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(Auth::check())
                                        <?php	
                                            $user = Auth::user();
                                        ?>
                                        <h3 class="usuario_log">Usuario: {{$user->name}}</h3> 
                                        
                                    @else 
                                        <script>window.location = "/RPE/public/"</script>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                                    <li><a  class="dropdown-item" href="{{ url('/logout') }}">Sair</a></li>
                                </ul>
                            </div>
                                <hr>
                                @can('dashboard') 
                                    <li  class="nav-item">
                                        <a href="{{url('/dashboard')}}" class="nav-link align-middle px-0">
                                            <img class="icone" src = "/imgs/house.svg" alt=""/>
                                        
                                            <span style="color: white" class="ms-1 d-none d-sm-inline">Dashboard</span>
                                        </a>
                                    </li>
                                @endcan
                                
                                    <li>
                                            <a href="{{url('/registro_atividade')}}"  class="nav-link px-0 align-middle">
                                            <img class="icone" src = "/imgs/book.svg" alt=""/></i> <span style="color: white" class="ms-1 d-none d-sm-inline">Registrar Atividades</span> </a>
                                    </li>
                                
                                @can('permissao_de_pagina_adm_super')
                                    <li>
                                            <a href="{{url('/registro')}}" class="nav-link px-0 align-middle">
                                            <img class="icone" src = "/imgs/person-plus-fill.svg" alt=""/><span style="color: white" class="ms-1 d-none d-sm-inline">Registrar usuario</span></a>                                                                     
                                    </li>
                                @endcan
                                <li>
                                    <a href="{{url('/Atividades')}}" class="nav-link px-0 align-middle">
                                    <img class="icone" src = "/imgs/list.svg" alt=""/><span style="color: white" class="ms-1 d-none d-sm-inline"> Listar Atividades</span> </a>
                                </li>
                                <li>
                                    <a href="{{url('/pdf_minhas_atividades')}}" class="nav-link px-0 align-middle">
                                    <img class="icone" src = "/imgs/file-earmark-pdf.svg" alt=""/><span style="color: white" class="ms-1 d-none d-sm-inline"> Gerar pdf</span> </a>
                                </li>
                                <li>
                                    <a href="{{ url('/logout') }}" class="nav-link px-0 align-middle">
                                    <img class="icone" src = "/imgs/box-arrow-left.svg" alt=""/> <span style="color: white" class="ms-1 d-none d-sm-inline">Sair</span> </a>
                                </li>
                            </ul>
                            <hr>
                        </div>
                    </div>
                    
               
                <div class="col py-3">
                    <div class="row">
                        <div class="text-center">

                            <img class="mt-4 mb-4" src="/imgs/logo.png" height="80px" alt="Logo_Itaipu">
                                <h1 class="titulo_1">Registrar usuario</h1> 
                        </div>    
        
                        <div style="margin-left: 20px" class="col-md-4">
                            <form style="width: 500px; margin:auto;" method="POST" action="{{route('registro.user')}}">
                                
                                @if(session('message'))
                                <div class="alert alert-danger">
                                    {{session('message')}}
                                </div>
                                @endif 
                                
                                @csrf

                                <div class="mt-4">
                                    <input style="border-color: black;width:70%" value="{{old('name')}}" type="text" class="form-control" size="10px" id="name" placeholder="Nome Completo" name="name">
                                </div>
                                @if ($errors->first('name'))
                                <div style="margin-top: 10px" class="alert-danger">{{$errors->first('name')}}</div>
                                @endif
                                
                                <div class="mt-4">
                                    <input style="border-color: black; width:50%" value="{{old('username')}}" type="text" class="form-control" size="10px" id="username" placeholder="Username" name="username">
                                </div>
                                @if ($errors->first('username'))
                                <div style="margin-top: 10px" class="alert-danger">{{$errors->first('username')}}</div>
                                @endif
        
        
                                <div class="mt-4">
                                        <input style="border-color: black;width:50%" value="{{old('password')}}" type="password" class="form-control" size="10px" id="password" placeholder="Senha" name="password">                           
                                </div>
                                @if ($errors->first('password'))
                                <div style="margin-top: 10px" class="alert-danger">{{$errors->first('password')}}</div>
                                @endif

        
                                <div class="mt-4">
        
                                    <input style="border-color: black;width:70%" value="{{old('cargo')}}" type="text" class="form-control" size="10px" id="cargo" placeholder="Cargo" name="cargo">                           
                                </div>
                                @if ($errors->first('cargo'))
                                <div style="margin-top: 10px" class="alert-danger">{{$errors->first('cargo')}}</div>
                                @endif

        
                                <div class="mt-4">
        
                                        <input style="border-color: black;width:50%" value="{{old('matricula')}}" type="text" class="form-control" size="10px" id="matricula" placeholder="Matricula" name="matricula">                           
                                </div>
                                @if ($errors->first('matricula'))
                                <div style="margin-top: 10px" class="alert-danger">{{$errors->first('matricula')}}</div>
                                @endif
        
                                <div class="mt-4">
        
                                        <input style="border-color: black;width:50%" value="{{old('lotacao')}}" type="text" class="form-control" size="10px" id="Lotacao" placeholder="Lotação" name="lotacao">                           
                                </div>
                                @if ($errors->first('lotacao'))
                                <div style="margin-top: 10px" class="alert-danger">{{$errors->first('lotacao')}}</div>
                                @endif

                                <div class="mt-4">
        
                                    <input style="border-color: black;width:50%" value="{{old('autorizacao')}}" type="number" class="form-control" size="10px" id="autorizacao" placeholder="Autorização" name="autorizacao">                           
                                </div>
                                @if ($errors->first('autorizacao'))
                                <div style="margin-top: 10px" class="alert-danger">{{$errors->first('autorizacao')}}</div>
                                @endif
        
                                <div class="mt-4">
        
                                        <input style="border-color: black;width:70%" value="{{old('email')}}" type="email" class="form-control" size="10px" id="email" placeholder="email" name="email">                           
                                </div>
                                @if ($errors->first('email'))
                                <div style="margin-top: 10px" class="alert-danger">{{$errors->first('email')}}</div>
                                @endif
                            
                                
                                <div class="mt-4">
                                    <div style="border: 1px solid black; width:50%">
                                       
                                        @foreach ($roles as $role)
                                            <div class="form-check">
                                                <input class="form-check-input" name="Roles"
                                                type="radio" value="{{$role->id}}" id="{{$role->name}}">
                                                <label style="display: flex" class="form-check-label" for="{{$role->name}}"> 
                                                {{$role->name}}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    
                                </div>

                                <div class="mt-4">
                                    <div style="border: 1px solid black; width:60%" class="form-check form-switch">
                                            <input class="form-check-input" value="1" type="checkbox" role="switch" id="aprovador" name="aprovador">
                                            <label class="form-check-label" for="flexSwitchCheckDefault">Aprovador</label>
                                    </div>
                                </div>
        
                                <div style="padding-top: 8px" class=" mt-1">
                                    <button id="btn_registrar_atv" style="padding: 6px;margin:0px" class="btn_1" class="btn btn-lg btn-primary"> Registrar </button>
                                    <a href="{{url('/dashboard')}}"><button style="border: none;border-radius:10px" class="btn btn-warning" type="button">Voltar</button></a>
                                </div>

                            </form>
                        </div>
                    </div>      
        
                </div>
        
            
        
                <script type="text/javascript" src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
            @endcan
            
                @can('permissao_de_pagina_user')   
                <div class="container">
                    <div class="row">
                        <h2>Essa é uma pagina de admin</h2>
                        <div class="col-sm">
                            <a href="{{url('/dashboard')}}"><button class="btn btn-primary">Voltar para a dashboard!</button></a>
                        </div>
                        
                    </div>
                </div>
                @endcan
        </div>
        <script>
            var btn1 = document.getElementById("btn_registrar_atv");
            btn1.addEventListener("click",function(){
                $(".loader").fadeIn(300);
                $("#container_validacao").fadeOut(200);
            });
        </script>
        <script>
            $(window).on('load',function(){
                $(".loader").fadeOut(800);
                $("#container_validacao").fadeIn(1000);
            });
        </script>
    </body>
</html>
