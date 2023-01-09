<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Dashboard</title>
        <script type="text/javascript" src="{{asset('jquary/jquery-3.6.0.min.js')}}"></script>
        <!-- Fonts -->

        
        <link rel="stylesheet" type="text/css" href="{{asset('/bootstrap/bootstrap.min.css')}}" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
       
        <link href="{{asset('css/style.css')}}" rel="stylesheet" />


    </head>

    <body>
        <div class="loader">
            <div>
    
            </div>
        </div>
       
        <div id="container_validacao" class="container-fluid">
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

                <div style="background-color: white" class="col py-3">
                      
                    @if (session()->has('flash_notification.success')) 
                        <div class="alert alert-success">{!! session('flash_notification.success') !!}</div>
                    @endif

                    @if(session('msg1'))

                    <div class="alert alert-success">
                        {{session('msg1')}}
                    </div>
        
                    @endif


                    <div id="dashboard_container">

                        @can('permissao_de_pagina_user')   
                        <div style="padding-bottom: 25px; " class="container">
                           
                            <h2 style="text-align:center"></h2>

                            <div style="display:flex;" class="row">
                                <img class="icone" src = "/imgs/" alt=""/>
                                <div class="col-lg-auto  col-md-auto col-sm-auto">
                                    <a href="{{url('/registro_atividade')}}"><button id="btn_green"  type="button" class="btn btn-primary"> <img class="icone" src = "/imgs/book.svg" alt=""/><br> Registrar atividades</button></a>
                                    <a href="{{url('/Atividades')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/eye.svg" alt=""/></i> <br> ver atividades</button></a>    
                                    <br>
                                    <a href="{{url('/Naturezas')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/list.svg" alt=""/> <br> Listar Natureza de Atividade</button></a>
                                    <a href="{{url('/Locais')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/list.svg" alt=""/> <br> Listar Locais</button></a>
                                </div>
        
                                <div class="col-lg-auto col-md-auto col-sm-auto">
                                    <a href="{{url('/Areas')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/list.svg" alt=""/> <br> Listar Areas</button></a>
                                    <a href="{{url('/Usuarios')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/list.svg" alt=""/> <br> Listar Usuarios</button></a>
                                    <br>

                                    
                                    
                                </div>

                                <div class="col-lg-auto col-md-auto col-sm-auto">
                                    <a href="{{url('/pdf_minhas_atividades')}}"><button id="btn_grey" type="button" class="btn btn-primary"><img class="icone" src = "/imgs/file-earmark-pdf.svg" alt=""/> <br> gerar pdf</button></a>
                                    <a href="{{url('/relatorios')}}"><button id="btn_grey" type="button" class="btn btn-primary"><img class="icone" src = "/imgs/eye.svg" alt=""/></i> <br>Ver Relatorios</button></a>                                    
                                    <br>
                                </div>

                            </div>
                            

                        </div>
                        @endcan

                        @can('permissao_de_pagina_adm')
                        <div style="padding-bottom: 25px; " class="container">
                            <h2 style="text-align:center"></h2>

                            <div style="display:flex;" class="row">
                                <div class="col-lg-auto col-md-auto col-sm-auto">
                                    <a href="{{url('/registro')}}"><button id="btn_green"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/person-plus-fill.svg" alt=""/> <br> Registrar Usuario</button></a>
                                    <a href="{{url('/registro_Natureza_atividade')}}"><button id="btn_green"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/activity.svg" alt=""/> <br> Registrar Natureza de atividade</button></a>
                                    <br>
                                    <a href="{{url('/registro_local')}}"><button id="btn_green"  class="btn btn-primary"> <img class="icone" src = "/imgs/geo-alt.svg" alt=""/> <br> Registrar Locais</button></a>
                                    <a href="{{url('/registro_area')}}"><button id="btn_green"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/map.svg" alt=""/> <br> Registrar Area de Risco</button></a>
                                </div>
        
                                <div class="col-lg-auto  col-md-auto col-sm-auto">
                                    <a href="{{url('/registro_atividade')}}"><button id="btn_green"  type="button" class="btn btn-primary"> <img class="icone" src = "/imgs/book.svg" alt=""/> <br> Registrar atividades</button></a>
                                    <a href="{{url('/Atividades')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/eye.svg" alt=""/></i> <br> ver atividades</button></a>    
                                    <br>
                                    <a href="{{url('/Naturezas')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/list.svg" alt=""/> <br> Listar Natureza de Atividade</button></a>
                                    <a href="{{url('/Locais')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/list.svg" alt=""/> <br> Listar Locais</button></a>
                                </div>
        
                                <div class="col-lg-auto col-md-auto col-sm-auto">

                                    <a href="{{url('/Areas')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/list.svg" alt=""/> <br> Listar Areas</button></a>
                                    <a href="{{url('/Usuarios')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/list.svg" alt=""/> <br> Listar Usuarios</button></a>    
                                    <br>
                                    <a href="{{url('/Logs')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/list.svg" alt=""/> <br> Listar Logs</button></a>
                                    <a href="{{url('/Editar_usuarios')}}"><button id="btn_blue" type="button" class="btn btn-primary"><img class="icone" src = "/imgs/pencil.svg" alt=""/></i> <br>  Editar Usuario</button></a>            
                                </div>

                            </div>
                            


                        </div>

                        <div class="container">

                            <div style="display:flex;" class="row">

                                <div class="col-lg-auto col-md-auto col-sm-auto"> 
                                    <a href="{{url('/pdf_minhas_atividades')}}"><button id="btn_grey" type="button" class="btn btn-primary"><img class="icone" src = "/imgs/file-earmark-pdf.svg" alt=""/> <br> gerar pdf</button></a>
                                    <a href="{{url('/relatorios')}}"><button id="btn_grey" type="button" class="btn btn-primary"><img class="icone" src = "/imgs/eye.svg" alt=""/></i> <br> Ver Relatórios</button></a>
                                </div>
                            </div>

                        </div>
                        @endcan
                        
                        @can('permissao_de_pagina_supervisor')
                        <div style="padding-bottom: 25px; " class="container">
                            <h2 style="text-align:center"></h2>

                            <div style="display:flex;" class="row">
                                <div class="col-lg-auto col-md-auto col-sm-auto">
                                    <a href="{{url('/registro')}}"><button id="btn_green"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/person-plus-fill.svg" alt=""/> <br> Registrar Usuario</button></a>
                                    <a href="{{url('/registro_Natureza_atividade')}}"><button id="btn_green"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/activity.svg" alt=""/> <br> Registrar Natureza de atividade</button></a>
                                    <br>
                                    <a href="{{url('/registro_local')}}"><button id="btn_green"  class="btn btn-primary"> <img class="icone" src = "/imgs/geo-alt.svg" alt=""/> <br> Registrar Locais</button></a>
                                    <a href="{{url('/registro_area')}}"><button id="btn_green"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/book.svg" alt=""/> <br> Registrar Area de Risco</button></a>
                                </div>
        
                                <div class="col-lg-auto  col-md-auto col-sm-auto">
                                    <a href="{{url('/registro_atividade')}}"><button id="btn_green"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/book.svg" alt=""/> <br> Registrar atividades</button></a>
                                    <a href="{{url('/Atividades')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/eye.svg" alt=""/></i> <br> ver atividades</button></a>    
                                    <br>
                                    <a href="{{url('/Naturezas')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/list.svg" alt=""/> <br> Listar Natureza de Atividade</button></a>
                                    <a href="{{url('/Locais')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/list.svg" alt=""/> <br> Listar Locais</button></a>
                                </div>
        
                                <div class="col-lg-auto col-md-auto col-sm-auto">

                                    <a href="{{url('/Areas')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/list.svg" alt=""/> <br> Listar Areas</button></a>
                                    <a href="{{url('/Usuarios')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/list.svg" alt=""/> <br> Listar Usuarios</button></a>    
                                    <br>
                                    <a href="{{url('/Logs')}}"><button id="btn_salmon"  type="button" class="btn btn-primary"><img class="icone" src = "/imgs/list.svg" alt=""/> <br> Listar Logs</button></a>
                                    <a href="{{url('/Editar_usuarios')}}"><button id="btn_blue" type="button" class="btn btn-primary"><img class="icone" src = "/imgs/pencil.svg" alt=""/></i> <br>  Editar Usuario</button></a>            
                                </div>

                            </div>
                            


                        </div>

                        <div class="container">

                            <div style="display:flex;" class="row">

                                <div class="col-lg-auto col-md-auto col-sm-auto"> 
                                    <a href="{{url('/pdf_minhas_atividades')}}"><button id="btn_grey" type="button" class="btn btn-primary"><img class="icone" src = "/imgs/file-earmark-pdf.svg" alt=""/> <br> gerar pdf</button></a>
                                    <a href="{{url('/relatorios')}}"><button id="btn_grey" type="button" class="btn btn-primary"><img class="icone" src = "/imgs/eye.svg" alt=""/></i> <br> Ver Relatórios</button></a>
                                </div>
                            </div>

                        </div>
                        @endcan

                        <br>
                        <div style=" padding-bottom: 25px;" class="container">
                            <h2 style="text-align:center"></h2>
                            <div style="display:flex;" class="row">
                                <div class="col-sm">
                                    <a href="{{url('/logout')}}"><button id="btn_red" style="background-color: red" type="button" class="btn btn-primary"><img class="icone" src = "/imgs/box-arrow-left.svg" alt=""/></i> <br> Sair</button></a>
                                </div>
                            </div>


                            
                        </div>
                    </div>

                    
                </div>

                
            </div>
        </div>
        </div>

        <script>
            $(window).on('load',function(){
                $(".loader").fadeOut(800);
                $("#container_validacao").fadeIn(1000);
            });
        </script>
         <script type="text/javascript" src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    </body>
</html>
