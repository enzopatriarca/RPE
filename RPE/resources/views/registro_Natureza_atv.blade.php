<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Registro Natureza de Atividade</title>

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
        <div class="container-fluid">
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
                                <h1 class="titulo_1">Registrar Natureza de Atividade</h1>
                        </div>    
                        
                        <div style="margin-left: 20px" class="col-md-4">
                            <form style="width: 500px; margin:auto;" method="POST" action="{{route('registro.natureza')}}">
                                @if(session('message'))
                                <div class="alert alert-danger">
                                    {{session('message')}}
                                </div>
                                @endif 
                                @csrf
                                
                                <div class="mt-4">
                                    <input style="border-color: black;" value="{{old('natureza')}}" type="text" class="form-control" size="10px" id="natureza" placeholder="Nome da Natureza de Atividade" name="natureza">
                                </div>
                                @if ($errors->first('natureza'))
                                <div style="margin-top: 10px" class="alert-danger">{{$errors->first('natureza')}}</div>
                                @endif
        
                                <div style="padding-top: 8px" class=" mt-1">
                                    <button style="padding: 6px;margin:0px" class="btn_1" class="btn btn-lg btn-primary"> Registrar </button>
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
    
    </body>
</html>
