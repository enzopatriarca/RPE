<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Lista de Usuarios</title>

        <!-- Fonts -->
        <!-- Fonts -->
        <script type="text/javascript" src="{{asset('jquary/jquery-3.6.0.min.js')}}"></script>
        
        <link rel="stylesheet" type="text/css" href="{{asset('DataTables/datatables.min.css')}}" rel="stylesheet" />
        <script type="text/javascript" src="{{asset('DataTables/datatables.min.js')}}"></script>

        <!--bootstrap-->
        
        <link rel="stylesheet" type="text/css" href="{{asset('/bootstrap/bootstrap.min.css')}}" rel="stylesheet" />
       
        <link href="{{asset('css/style.css')}}" rel="stylesheet" />

        <link rel="stylesheet" type="text/css" href="{{asset('jquaryUI/jquery-ui.min.css')}}" rel="stylesheet" />
        <script type="text/javascript" src="{{asset('jquaryUI/jquery-ui.min.js')}}"></script>

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
            <!--@can('permissao_de_pagina_adm_super')
                @endcan-->
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
                    
               
                <div class="container">
                    <div class="row">
                        <div class="col-md-10">
                            <h2>Lista de Usuarios</h2>
                            <br>
                            <div class="card">
                            
                                <table id="locais" class="table display" >
                                    <thead>
                                        <tr>
                                            <td>Id</td>
                                            <td>Nome</td>
                                            <td>Cargo</td>
                                            <td>Matricula</td>
                                            <td>Lotação</td>
                                            <td>Status</td>
                                            <td>Role</td> 
                                            <td>Aprovador</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{$user->id}}</td>
                                                <td>{{$user->nome}}</td>
                                                <td>{{$user->cargo}}</td>
                                                <td>{{$user->matricula}}</td>
                                                <td>{{$user->Lotacao}}</td>
                                                @if ($user->status ==1)
                                                    <td><i class="bi bi-check-circle-fill"></i></td>
                                                @endif
                                                @if ($user->status == 0)
                                                    <td><i class="bi bi-x-circle-fill"></i></td>
                                                @endif

                                                @foreach ($users_roles as $user_role)
                                                     @foreach ($user_role->roles as $role)
                                                        @if ($user->id == $role->pivot->model_id)
                                                            <td>{{$role->name}}</td>
                                                        @endif
                                                     @endforeach
                                                @endforeach

                                                @if ($user->Aprovador ==1)
                                                    <td><i class="bi bi-check-lg"></i></td>
                                                @endif
                                                @if ($user->Aprovador == 0)
                                                    <td>X</td>
                                                @endif

                                               
                                                <td><a href="{{url("/Editar_usuario/{$user->id}")}}"><button type="button" class="btn btn-primary">Editar Usuario</button></td></a>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>  
                            </div>    
                        </div>
                    </div>      
                </div>
                
                <script>
                    $(document).ready( function () {
                        $('#locais').DataTable();
                    } );
                </script>

            
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
