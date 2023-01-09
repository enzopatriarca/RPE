<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Registro de Atividade</title>


        <!-- Fonts -->
        <script type="text/javascript" src="{{asset('jquary/jquery-3.6.0.min.js')}}"></script>
        
        <link rel="stylesheet" type="text/css" href="{{asset('DataTables/datatables.min.css')}}" rel="stylesheet" />
        <script type="text/javascript" src="{{asset('DataTables/datatables.min.js')}}"></script>

        <!--bootstrap-->
        
        <link rel="stylesheet" type="text/css" href="{{asset('/bootstrap/bootstrap.min.css')}}" rel="stylesheet" />
       
        <link href="{{asset('css/style.css')}}" rel="stylesheet" />

        <link rel="stylesheet" type="text/css" href="{{asset('jquaryUI/jquery-ui.min.css')}}" rel="stylesheet" />
        <script type="text/javascript" src="{{asset('jquaryUI/jquery-ui.min.js')}}"></script>
        <script defer src="js/scripts.js"></script>

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
                                <h1 class="titulo_1">Registro de Atividade</h1>
                        </div>

                        <div style="" class="col-md-5"> 
                            <form id="form_atv"   style="width: 450px; margin:none;" method="POST" action="{{route('registro.atividade')}}">
                                @if(session('message'))
                                <div class="alert alert-danger">
                                    {{session('message')}}
                                </div>
                                @endif
                                
                                <div id="error"></div>

                                @csrf

                                <div class="mt-4">
                                    <div style="display: flex" class="div">
                                        <details>
                                            <summary>Como preencher</summary>
                                            <p>Digite os ID(s) e Usernames(s) separando por 'enter'</p>
                                        </details>
                                    </div>
                                </div>
                                

                                <div class="mt-4">
                                    <label for="">Data Inicio</label>
                                    <input rrequired="required" style="border-color: black;width:50%;" type="date" value="{{old('data_inicio')}}"  class="form-control" size="10px" id="data_inicio" placeholder="data de inicio da atividade" name="data_inicio" >                           
                                </div>
                                @if ($errors->first('data_inicio'))
                                    <div style="margin-top: 10px" class="alert-danger">{{$errors->first('data_inicio')}}</div>
                                @endif

                                <div class="mt-4">
                                    <label for="">Data Final</label>
                                    <input required="required" style="border-color: black;width:50%;" type="date" value="{{old('data_final')}}" class="form-control" size="10px" id="data_final" placeholder="data de final da atividade" name="data_final" >                           
                                </div>

                                @if ($errors->first('data_final'))
                                <div style="margin-top: 10px" class="alert-danger">{{$errors->first('data_final')}}</div>
                                @endif
                                
                                <div class="mt-4">

                                    
                                    @if ( (old('tags_input') != null) || (old('tags_area') != null) || (old('tags_local') != null) || (old('tags_participantes') != null) )
                                    <script type="text/javascript">
                                        //var e = jQuery.Event("keypress");
                                        //e.which = 13; //choose the one you want
                                        //e.keyCode = 13;
                                        //var element = document.getElementById("input_natureza"); 
                                        var n = '{{old('tags_input')}}';
                                        var a = '{{old('tags_area')}}';
                                        var l = '{{old('tags_local')}}';
                                        var p = '{{old('tags_participante')}}'
                                        var descri = '{{old('descricao')}}'
                                        window.onload = function(){
                                            document.getElementById("input_natureza").value =  n;
                                            document.getElementById("input_area").value =  a;
                                            document.getElementById("input_locais").value =  l;
                                            document.getElementById("input_participantes").value =  p;
                                            document.getElementById("descricao").value =  descri;
                                        }
                                       
                                    </script>
                                    @endif

                                    <div class="container-tag">
                                        <label for="">Natureza</label>
                                        <div class="tags_input"  data-name="tags_input">
                                        
                                        </div>
                                    </div>
                                    <!--<a href="{{url('/Naturezas')}}"><button style="margin-top:4px" type="button" class="btn btn-info">Ver ID(s) de Natureza(s)</button></a>-->
                                    
                                </div>
                                <!-- Button trigger modal -->
                                <button style="margin-top:8px" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Ver ID(s) de Natureza(s)
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ID(s) de Natureza de Atividade</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @foreach ($naturezas as $natureza)
                                                <p>ID: {{$natureza->id}},{{$natureza->nome_natureza}}</p>
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                        <a href="{{url('/registro_Natureza_atividade')}}" target="_blank"><button type="button" class="btn btn-primary">Adicionar Natureza</button></a>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                @if ($errors->first('tags_input'))
                                    <div style="margin-top: 10px" class="alert-danger">{{$errors->first('tags_input')}}</div>
                                @endif

                                <div class="mt-4">
                                    @if (old('tags_area') != null)
                                
                                       
                                    @endif   
                                    <div class="container-tag-area">
                                        <label for="">Area de Atividade</label>
                                        <div class="tags_area" data-name="tags_area">
                                        
                                        </div>
                                    </div>                    
                                </div>

                                <!-- Button trigger modal -->
                                <button style="margin-top:8px" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">
                                    Ver ID(s) de Area(s)
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ID(s) de Area(s) de Atividade</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">          
                                            @foreach ($areas as $area)
                                                <p>ID: {{$area->id}},{{$area->nome_area}}</p>
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                        <a href="{{url('/registro_area')}}" target="_blank"><button type="button" class="btn btn-primary">Adicionar Area</button></a>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                

                                @if ($errors->first('tags_area'))
                                    <div style="margin-top: 10px" class="alert-danger">{{$errors->first('tags_area')}}</div>
                                @endif

                                <div class="mt-4">
                                    @if (old('tags_local') != null)

                                    @endif   
                                    <div class="container-tag-local">
                                        <label for="">Local</label>
                                        <div class="tags_local" data-name="tags_local">
                                        
                                        </div>
                                    </div>
                                </div>

                                <!-- Button trigger modal -->
                                <button style="margin-top:8px" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal2">
                                    Ver ID(s) de Local(s)
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ID(s) de Local(s) de Atividade</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">          
                                            @foreach ($locais as $local)
                                                <p>ID: {{$local->id}},{{$local->nome_local}}</p>
                                            @endforeach
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                        <a href="{{url('/registro_local')}}" target="_blank"><button type="button" class="btn btn-primary">Adicionar Local</button></a>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                @if ($errors->first('tags_local'))
                                    <div style="margin-top: 10px" class="alert-danger">{{$errors->first('tags_local')}}</div>
                                @endif

                                <div class="mt-4">
                                    <label for="">Descrição da Atividade</label>
                                    <!--<input style="display: flex; width:100%; border-color: black;" type="text" class="form-control" size="10px" id="descricao" placeholder="Descrição da Atividade"  value="{{old('descricao')}}" name="descricao">-->
                                    <textarea required style="border-radius: 10px" value="{{old('descricao')}}" placeholder="Descrição da Atividade" name="descricao" id="descricao" cols="75" rows="7"></textarea>
              
                                </div>
                                
                                @if ($errors->first('descricao'))
                                    <div style="margin-top: 10px" class="alert-danger">{{$errors->first('descricao')}}</div>
                                @endif

                                <div class="mt-4">
                                    @if (old('tags_participante') != null)
                                    
                                    @endif
 
                                    <div class="container-tag-participantes">
                                        <label for="">Participantes</label>
                                        <div class="tags_participante" data-name="tags_participante">
                                        
                                        </div>
                                    </div>

                                </div> 
                                @if ($errors->first('tags_participante'))
                                    <div style="margin-top: 10px" class="alert-danger">{{$errors->first('tags_participante')}}</div>
                                @endif

                                <div class="mt-4">
                                    <label for="">Gerente ou Supervisor</label> <br>
                                    <!--<input style="border-color: black;" type="text" class="form-control" size="10px" id="gerente" placeholder="Gerente ou Supervisor"  value="{{old('gerente')}}" name="gerente">-->
                                    <select style="width: 100%; height:36px;border-radius:10px;background-color: white;border-right: none;" name="gerente" id="">
                                        @foreach ($users_ as $user)
                                            @foreach ($user->roles as $user_role)
                                                @if (($user_role->pivot->model_id == $user->id) && ($user_role->pivot->role_id == 3 ))
                                                    <option  value="{{$user->name}}">{{$user->name}}</option>
                                                @endif
 
                                            @endforeach
                                        @endforeach  
                                    </select>

                                    
                                                     
                                </div>

                                @if ($errors->first('gerente'))
                                    <div style="margin-top: 10px" class="alert-danger">{{$errors->first('gerente')}}</div>
                                @endif

                                <div class="mt-4">
                                    <label for="">Aprovador</label> <br>
                                    <select style="width: 100%; height:36px;border-radius:10px;background-color: white;border-right: none;" name="aprovador" id="aprovador">
                                        @foreach ($users_ as $user)
                                                @if ($user->Aprovador == 1)
                                                    <option  value="{{$user->name}}">{{$user->name}}</option>
                                                @endif
                                        @endforeach  
                                    </select>

                                    
                                                     
                                </div>

        
                                <div style="padding-top: 8px" class=" mt-1">
                                    <button style="padding: 6px;margin:0px"  id="btn_registrar_atv" class="btn_1" class="btn btn-lg btn-primary"> Registrar </button>
                                    <a href="{{url('/dashboard')}}"><button style="border: none;border-radius:10px" class="btn btn-warning" type="button">Voltar</button></a>
                                </div>

                            </form>
                        </div>
                        
                        <script>

                        </script>

                        <div style="text-align: center;display:none" class="col-md-3">
                            <button id="scroll_btn"  onClick="scroll(0, 100);" type="button" class="btn btn-info">Verificar ID(s)</button>
                        </div>
     
                    </div>

                    <div style="margin-top: 20px;display:none" class="container">
                        <div class="row">
                          <div  class="col">
                            <button id="s_h_natureza" type="button" class="btn btn-info">mostrar/ocultar Naturezas</button>
                            <div id="naturezas_">
                                @foreach ($naturezas as $n)
                                <p>{{$n->id}}.{{$n->nome_natureza}}</p>  
                                @endforeach
                            </div>
                          </div>
                          <div  class="col">
                            <button id="s_h_area" type="button" class="btn btn-info">mostrar/ocultar Areas</button>
                            <div id="areas_">
                                @foreach ($areas as $a)
                                <p>{{$a->id}}.{{$a->nome_area}}</p>  
                                @endforeach
                            </div>
                          </div>
                          <div class="col">
                            <button id="s_h_locais" type="button" class="btn btn-info">mostrar/ocultar Locais</button>
                            <div  id="locais_">
                                @foreach ($locais as $l)
                                <p>{{$l->id}}.{{$l->nome_local}}</p>  
                                @endforeach
                            </div>
                          </div>
                        </div>
                    </div>


        
                </div>
            
        </div>
        <script>
            $(document).ready(function(){

                $('#form_atv').submit(function() {
                    if ($.trim($("#hidden_naturezas").val()) === "" || $.trim($("#hidden_area").val()) === "" || $.trim($("#input_participantes_hiden").val()) === "" || $.trim($("#hidden_locais").val()) === "" ) {
                            alert('Todos os campos prescisam ser preenchidos!');
                        return false;
                    }
                });

            });
        </script>
        <script>
            $(document).ready(function(){

                var data_i =  document.getElementById('data_inicio');
                var data_f =  document.getElementById('data_final');

                data_i.required = true;
                data_f.required = true;

                var data1;
                var data2;
                $('#data_inicio').change(function(){
                    data1 = ($(this).val());
                    var today = new Date().toISOString().slice(0, 10)

                    if (Date.parse(data1) <  Date.parse(today)) {
                        
                        alert('ERRO: Data de INICIO nao pode ser menor que a data atual!');
                        data_i.value = "";

                    }
                    //console.log(today)
                })

                $('#data_final').change(function(){
                    data2 = ($(this).val());
                    var dt_i = document.getElementById('data_inicio').value;

                    if ( (Date.parse(dt_i) >  Date.parse(data2))) {
                        alert('ERRO: Data de INICIO nao pode ser maior que a data de final!');
                        data_f.value = "";
                    }

                    if ( (Date.parse(data2) <  Date.parse(dt_i))) {
                        alert('ERRO: Data FINAL nao pode ser menor que a data de inicio!');
                        data_f.value = "";
                    }



                    //console.log(dt_i)

                })
            });
        </script>
        <script>
            $(document).ready(function(){
                
                $("#input_natureza").autocomplete({
                    //source: js_array
                    select: function (event, ui) {
                                // Set selection
                                $('#hidden_naturezas').val(ui.item.label); // display the selected text
                                //$('#hidden_naturezas').val(ui.item.value); // save selected id to input
                                $('#input_natureza').val("");
                            //return false;
                    },
                    source: function(request,response){
                        $.ajax({
                            url: "{{route('naturezas.names')}}",
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
            $(document).ready(function(){
                
                $("#input_area").autocomplete({
                    //source: js_array
                    select: function (event, ui) {
                                // Set selection
                                $('#input_area').val(ui.item.label); // display the selected text
                                //$('#hidden_area').val(ui.item.value); // save selected id to input
                                $('#input_area').val("");
                            //return false;
                    },
                    source: function(request,response){
                        $.ajax({
                            url: "{{route('areas.names')}}",
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
            $(document).ready(function(){
                
                $("#input_locais").autocomplete({
                    //source: js_array
                    select: function (event, ui) {
                                // Set selection
                                $('#input_locais').val(ui.item.label); // display the selected text
                                $('#input_locais').val("");
                            //return false;
                    },
                    source: function(request,response){
                        $.ajax({
                            url: "{{route('locais.names')}}",
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
            document.getElementById("form_atv").onkeypress = function(e) {
                var key = e.charCode || e.keyCode || 0;     
                if (key == 13) {
                    e.preventDefault();
                }
            }

        </script>
        <script>
            $(window).on('load',function(){
                $(".loader").fadeOut(800);
                $("#container_validacao").fadeIn(1000);
            });
        </script>
        <script src="js/prime.js"></script>
        <script type="text/javascript" src="{{asset('jquaryUI/jquery-ui.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('bootstrap/bootstrap.min.js')}}"></script>


        
    </body>
</html>
