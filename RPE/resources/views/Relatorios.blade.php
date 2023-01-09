<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Relatórios</title>
        <script type="text/javascript" src="{{asset('jquary/jquery-3.6.0.min.js')}}"></script>
        <!-- Fonts -->
        
        <link rel="stylesheet" type="text/css" href="{{asset('/bootstrap/bootstrap.min.css')}}" rel="stylesheet" />
       
        <link href="{{asset('css/style.css')}}" rel="stylesheet" />

        <script type="text/javascript" src="{{asset('chartjs/chart.min.js')}}"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"> </script>-->

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
                        <div class="container">
                            <div>
                                <div style="display: flex" class="div">
                                    <details style="margin-bottom: 10px">
                                        <summary>Como preencher em firefox</summary>
                                        <p>Em Firefox escrever o ano seguido pelo mes, Ex: 2022-07</p>
                                    </details>
                                </div>
                                <form style="width: 500px;" method="POST" action="{{route('mostrar.relatorios')}}">
                                    @csrf
                                    <label for="">Mes: </label> <input id="mes_relatorio" name="mes_relatorio" value=""  type="month">
                                    <button style="padding: 6px; margin:0px;" class="btn_1" class="btn btn-lg btn-primary">Mostrar Relatório</button>
                                </form>
                                
                            </div>
                            <div style="margin-top: 10px">
                                @if ($request->mes_relatorio == null)
                                <h3>Mes: Mostrando mes atual</h3>
                                @else
                                    <h3>Mes:{{$request->mes_relatorio}}</h3>
                                @endif
                                
                            </div>
                            <div style="margin-top: 15px" class="row">
                                <h3>Atividades por Pessoa</h3>
                                <div class="col-md-10">
                                    <canvas id="usuarios" ></canvas>
                                </div>
                            </div>

                            <div style="margin-top: 50px;display:flex;justify-content:center" class="row">
                                <div class="col-md-6">
                                    <h3>Todas as Atividades</h3>
                                    <canvas id="pie_char" ></canvas>
                                </div>  
                               
                            </div>

                            <div class="row">
                                <div class="col-md-10">
                                    <h3>Quantidade de Atividades por Locais</h3>
                                    <canvas id="donut_char" ></canvas>
                                </div>
                            </div>
                        </div>
                  
                    
                </div>
            </div>
        </div>
        <script>
            const js_array = [<?php echo '"'.implode('","', $l_locais).'"' ?>];
            const js_nomes = [<?php echo '"'.implode('","', $users_array).'"' ?>];
        </script>
        <script>
            const users = document.getElementById('usuarios').getContext('2d');
            const users_ = new Chart(users, {
                type: 'bar',
                data: {
                    labels: js_nomes ,
                    datasets: [{
                        label: 'Atividades Realizadas',
                        data: [{!! implode(',',$user_count) !!}],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    indexAxis: 'y',
                }
            });
        </script>

        <script>
            
            const char = document.getElementById('donut_char').getContext('2d');
            const donut_char = new Chart(char, {
                type: 'bar',
                data: {
                    labels: js_array,
                    datasets: [{
                        label: 'Quantidade de Atividades por Locais',
                        data: [{!! implode(',',$l_count) !!}],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(9, 102, 121, 0.2)',
                            'rgba(121,22,9,0.2)',
                            'rgba(84,206,235,0.2)',
                            'rgba(27,23,142,0.2)',
                            'rgba(224,132,10,0.2)',
                            'rgba(224,78,10,0.2)',
                            'rgba(183,194,0,0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(9, 102, 121, 100)',
                            'rgba(121,22,9,1)',
                            'rgba(84,206,235,100)',
                            'rgba(27,23,142,100)',
                            'rgba(224,132,10,100)',
                            'rgba(224,78,10,100)',
                            'rgba(183,194,0,100)',

                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    
                }
            });
        </script>

        <script>
            const pie = document.getElementById('pie_char').getContext('2d');
            const pie_char = new Chart(pie, {
                type: 'pie',
                data: {
                    labels: ['Aprovadas','Reprovadas','Aguardando'],
                    datasets: [{
                        label: '# of Votes',
                        data: [{!! implode(',',$dados_atv) !!}],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <script>
            $(window).on('load',function(){
                $(".loader").fadeOut(800);
                $("#container_validacao").fadeIn(1000);
            });
        </script>
        <script type="text/javascript" src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    </body>
</html>
