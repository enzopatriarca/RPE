<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Atividades</title>

        <!--<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>-->
        
        <!--jquary-->
        <script type="text/javascript" src="{{asset('jquary/jquery-3.6.0.min.js')}}"></script>
        
        <!-- Datatables
                <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
                <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" ></script>
        -->
        <link rel="stylesheet" type="text/css" href="{{asset('DataTables/datatables.min.css')}}" rel="stylesheet" />
        <script type="text/javascript" src="{{asset('DataTables/datatables.min.js')}}"></script>

        <!--bootstrap-->
        
        <link rel="stylesheet" type="text/css" href="{{asset('/bootstrap/bootstrap.min.css')}}" rel="stylesheet" />

        <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">-->
        
        <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet"> -->


        
        <link href="{{asset('css/style.css')}}" rel="stylesheet" />


        <!-- Jquary ui
                <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        -->
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
                                <h1 class="titulo_1">Selecione Uma opção</h1>
                                @if(session('msg1'))

                                    <div class="alert alert-danger">
                                        {{session('msg1')}}
                                    </div>
                    
                                @endif
                                @if(session('msg2'))

                                    <div class="alert alert-success">
                                        {{session('msg2')}}
                                    </div>
                
                                @endif
                                <button id="atv_btn" style="display: flex;margin: 20px;" type="button" class="btn btn-primary">Filtrar</button>
                                
                                <form style="border: 3px solid black;width: 80%;" id="atvs_form" method="POST" action="{{route('filtrar.Atv')}}">
                                    @csrf
                                    <div style="margin-left: 10px"  class="form-check">
                                        <input class="form-check-input" name="Atividades_tipo"
                                        type="radio" value="Todas as Atividades" id="">
                                      <label style="display: flex" class="form-check-label" for="Todas as Atividades"> 
                                          Todas as Atividades
                                      </label>

                                        <input class="form-check-input" name="Atividades_tipo"
                                          type="radio" value="Participantes" id="participantes_input">
                                        <label style="display: flex" class="form-check-label" for="Participantes"> 
                                            Participantes 
                                        </label>
                                        

                                        <input class="form-check-input" name="Atividades_tipo"
                                            type="radio" value="Atividades Proprietario" id="">
                                        <label style="display: flex" class="form-check-label" for="Atividades Proprietario"> 
                                            Atividades Proprietario
                                        </label>

                                        <input class="form-check-input" name="Atividades_tipo"
                                        type="radio" value="Atividades Aprovadas" id="">
                                        <label style="display: flex" class="form-check-label" for="Atividades Aprovadas"> 
                                            Atividades Aprovadas
                                        </label>

                                        <input class="form-check-input" name="Atividades_tipo"
                                        type="radio" value="Atividades Reprovadas" id="">
                                        <label style="display: flex" class="form-check-label" for="Atividades Reprovadas"> 
                                            Atividades Reprovadas
                                        </label>

                                        <input class="form-check-input" name="Atividades_tipo"
                                        type="radio" value="Atividades Esperando Resposta" id="">
                                        <label style="display: flex" class="form-check-label" for="Atividades Esperando Resposta"> 
                                            Atividades Esperando Resposta
                                        </label>

                                        <div class="mt-3">
                                            <button name="filter_button" id="filter_button" class="btn_1" class="btn btn-lg btn-primary"> Mostrar </button>
                                        </div>
                                    </div>

                                </form>
                               
                                <form  id="_participantes" method="POST" action="{{route('filtrar.Atv')}}">
                                    @csrf
                                    <div style="display: none;text-align: initial;margin-bottom: 20px;;margin-top: 20px;width: 50%;" id="input_user">
                                        
                                        <label for="">Digite o nome dos participnates separados por ','</label>
                                        <div class="tags_participante" data-name="tags_participante"></div>
                                        <input class="form-check-input" name="Atividades_tipo" type="hidden" value="Participantes" id="participantes_input">
                                        <button style="margin-top: 10px" name="filter_button_participantes" id="filter_button_participantes" class="btn_1" class="btn btn-lg btn-primary"> Procurar Participantes </button>
                                    </div>
                                </form>
                                
                                <h3 >{{$request->Atividades_tipo}}</h3>

                                <div class="card">
                                    <table id="locais" class="table display" >
                                        <thead>
                                            <tr>
                                                <td style="width: 50px">Id</td>
                                                <td style="width: 70px">Data Inicio</td>
                                                <td style="width: 70px">Data Final</td>
                                                <td>Locais</td>
                                                <td>Criado por</td>
                                                <td style="width: 130px">Status</td>
                                                <td style="width: 130px"></td>
                                                @if (auth()->user()->Aprovador == 1)
                                                    <td style="width: 100px">Aprovar/Reprovar</td>
                                                @else
                                                    <td style="width: 10px"></td>
                                                @endif

                                                @if (count($atividades_) != 0)
                                                    <td style="text-align: center" >Mais informaçoẽs</td>
                                                @endif
                                               

                                            </tr>
                                        </thead>
                                        <tbody style="text-align: initial">
                                            
                                            @foreach ($atividades_ as $atividade)
                                                <tr >
                                                    
                                                    <td style="font-size: 14px">{{$atividade->id}}</td>
                                                    <td style="font-size: 14px">{{$atividade->data_inicio}}</td>
                                                    <td style="font-size: 14px">{{$atividade->data_final}}</td>
                                                    <td style="width: 200px;font-size: 14px">{{$atividade->tags_locais}}</td>
                                                    <td style="font-size: 14px;width: 220px;">{{$atividade->nome_proprietario}}</td>
                                                    @php
                                                        $status = '';
                                                        if ($atividade->situacao_aprv == 1) {
                                                            $status = "Aprovado";
                                                        }elseif ($atividade->situacao_rprv == 1) {
                                                            $status = "Reprovado";
                                                        }elseif (($atividade->situacao_aprv == 0) && ($atividade->situacao_rprv == 0)) {
                                                            $status = "Aguardando";
                                                        }
                                                    @endphp
                                                    @if ($status == "Aprovado")
                                                        <td style="color:green" >{{$status}}</td> 
                                                    @endif

                                                    @if ($status == "Reprovado")
                                                    <td style="color:red" >{{$status}}</td> 
                                                    @endif

                                                    @if ($status == "Aguardando")
                                                    <td style="color:yellow" >{{$status}}</td> 
                                                    @endif

                                                    @if ($status == "Aprovado")
                                                    <td> </td>
                                                    @endif
                                                    
                                                    @if ($status == "Reprovado")
                                                        <td><a href="{{url("/Editar_atividade/{$atividade->id}")}}"><button type="button" class="btn btn-primary">Editar</button></a> </td>
                                                    @endif
                                                    
                                                    @if ($status == "Aguardando")
                                                        <td><a href="{{url("/reenviar_mail/{$atividade->id}")}}"><button type="button" class="btn btn-primary">Reenviar</button></a> </td>
                                                     @endif
                                                    
                                                    @if (auth()->user()->id == $atividade->id_user_aprovacao )
                                                        <td style="text-align: center"><a href="{{url("/validar_atv/{$atividade->id}")}}"><button type="button" class="btn btn-success">A</button></a> <a href="{{url("/reprovar_atv/{$atividade->id}")}}"><button type="button" class="btn btn-danger">R</button></a></td>
                                                        
                                                    @else
                                                        <td></td>
                                                    @endif

                                                    @if (count($atividades_) != 0)

                                                    <td style="width:80px;text-align:center" class="more_info_pai">
                                                        
                                                        <!--<button style="border-radius: 20px"  type="button" class="btn btn-info">+</button>
                                                        <div style="width: 250px; text-align: initial;" id="infos" class="more_info">
                                                            <p>Participantes:{{$atividade->tags_participantes}} </p>
                                                            <p>Supervisor: {{$atividade->gerente}} </p>
                                                            @if ($atividade->situacao_aprv == 1)
                                                                <p>Aprovado por: {{$atividade->user_aprovacao}}</p>   
                                                            @endif
                                                            @if ($atividade->situacao_rprv == 1)
                                                            <p>Reprovado por: {{$atividade->user_aprovacao}}</p>
                                                            @endif
                                                            <p>descriçao: {{$atividade->descricao}}</p>
                                                        </div>-->

                                                        <!-- Button trigger modal -->
                                                        <button type="button" id="botao_modal" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $atividade->id}}"
                                                         >
                                                            info
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="exampleModal-{{ $atividade->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div style="max-width: 1120px;" class="modal-dialog">
                                                            <div style="width: auto" class="modal-content">
                                                                <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Mais informações</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div style="text-align: start" class="modal-body">
                                                                    <table>
                                                                        <thead>
                                                                            <tr>
                                                                                <td style="width: 250px;font-size: 14px">Participantes</td>
                                                                                <td style="font-size: 14px">Supervisor</td>
                                                                                @if ($atividade->situacao_aprv == 1)
                                                                                    <td style="font-size: 14px">Aprovado por</td>
                                                                                @endif
                                                                                @if ($atividade->situacao_rprv == 1)
                                                                                    <td style="font-size: 14px">Reprovado por</td>
                                                                                @endif
                                                                                <td style="font-size: 14px">Descrição</td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="font-size: 14px">{{$atividade->tags_participantes}}</td>
                                                                                <td style="font-size: 14px">{{$atividade->gerente}}</td>
                                                                                @if ($atividade->situacao_aprv == 1)
                                                                                    <td style="font-size: 14px">{{$atividade->user_aprovacao}}</td>   
                                                                                @endif
                                                                                @if ($atividade->situacao_rprv == 1)
                                                                                    <td style="font-size: 14px">{{$atividade->user_aprovacao}}</td>
                                                                                @endif
                                                                                <td style="font-size: 14px;width:290px">{{$atividade->descricao}}</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                      
                                </div>    

                        </div>
                
                    </div>      
        
                </div>
            
        </div>


        <script>
            $(document).ready(function(){
                
                
                $("#input_participantes").autocomplete({
                    select: function (event, ui) {
                                // Set selection
                                //$('#input_participantes').val(ui.item.label); // display the selected text
                                //$('input_participantes_hiden').val(ui.item.label); // save selected id to input
                                $('#input_participantes').val("");
                            //return false;
                    },
                    //source: js_array
                    source: function(request,response){
                        $.ajax({
                            url: "{{route('users.names')}}",
                            dataType: 'json',
                            data: {
                                term: request.term
                            },
                            success:function(data){
                                response(data)
                               
                                
                                //console.log(data)
                            }
                        });
                    }
                })
         
            });
            
        </script>
        <script>
            document.getElementById("_participantes").onkeypress = function(e) {
                var key = e.charCode || e.keyCode || 0;     
                if (key == 13) {
                    e.preventDefault();
                }
            }

        </script>
        <script>
            $(document).ready( function () {
                $(function() {

                    $('input:radio[name="Atividades_tipo"]').change(function() {
                        if ($(this).val() == 'Participantes') {
                            $('#input_user').show();
                            $('#filter_button').hide();
                        }
                        else {
                                $('#filter_button').show();
                                $('#input_user').hide();
                        }
                    });
                });
            });


        </script>
        <script>
            var btn2 = document.getElementById("atv_btn");
            
            btn2.addEventListener("click",function(){
                var col_local = document.getElementById('atvs_form');
                if (col_local.style.display === "none") {
                    col_local.style.display = "block";
                }else{

                    col_local.style.display = "none";
                }
            });

        </script>
        <script>
            jQuery(document).ready(function($) {
                $('.btn-info').on('click',function(){
                    
                    $(this).parents('.more_info_pai').find('.more_info').slideToggle('slow');
                        if ($(this).parents('.more_info_pai').find('.more_info').style.display === "none") {
                            $(this).parents('.more_info_pai').find('.more_info').style.display = "block";
                        }else{
                            $(this).parents('.more_info_pai').find('.more_info').style.display = "none";
                        }      
                });
            });

        </script>
        <script>
            $(document).ready( function () {
                $('#locais').DataTable({
                    processing: true,
                    order: [[1, 'desc']],
                });
            } );
        </script>
        <script src="{{ asset('js/prime.js')}}"></script>
        <script type="text/javascript" src="{{asset('bootstrap/bootstrap.min.js')}}"></script>


        
    </body>
</html>
