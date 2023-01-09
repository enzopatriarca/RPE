<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>PDF Atividades</title>
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
    </head>
    <body>
    <div class="text-center">

    <img class="mt-4 mb-4" src="/imgs/logo.png" height="80px" alt="Logo_Itaipu">
        <h1 class="titulo_1">RPE</h1>
        <h3 class="log">PDF</h3>

    <form style="width: 500px; margin:auto;" method="POST" action="{{route('gerar.pdf')}}">



        @if(session('danger'))

            <div class="alert alert-danger">
                {{session('danger')}}
            </div>

        @endif    
     
        @csrf
        <div id="div_mes" class="mt-4">
            <label class="titulo_2" for="Username"> Escolha o mes:</label><br>
            <label for="">Mes</label>
            <div style="display: flex" class="div">
                <details>
                    <summary>Como preencher em firefox</summary>
                    <p>Em Firefox escrever o ano seguido pelo mes, Ex: 2022-07</p>
                </details>
            </div>
            <input style="border-color: black;border-left: none;border-right: none;border-top:none" value="{{old('data1')}}" type="month" class="form-control" size="10px" id="data1" placeholder="data1" name="data1">
        </div>
        @if ($errors->first('data1'))
        <div style="margin-top: 10px" class="alert-danger">{{$errors->first('data1')}}</div>
        @endif
        <div style="margin-left: 10px;margin-top: 10px"  class="form-check">
            <input class="form-check-input" name="Atividades_tipo"
            type="radio" value="Todas as Atividades" id="">
          <label style="display: flex" class="form-check-label" for="Todas as Atividades"> 
              Minhas Atividades
          </label>

            <input style="margin-top: 14px" class="form-check-input" name="Atividades_tipo"
              type="radio" value="Participantes" id="participantes_input">
            <label style="display: flex;margin-top:10px" class="form-check-label" for="Participantes"> 
                Participantes 
            </label>
        </div>
        <div class=" mt-3">
            <button id="pdf_individual" style="padding: 6px; margin:0px;" class="btn_1" class="btn btn-lg btn-primary" formtarget="_blank">Gerar PDF</button>
            <a href="{{url('/dashboard')}}"><button id="voltar_minhas_atv" style="border: none;border-radius:10px" class="btn btn-warning" type="button">Voltar</button></a>
        </div>

    </form>

    <form style="justify-content: center;display:flex" id="_participantes" method="POST" action="{{route('gerar.pdf.users')}}">
        @csrf

        <div style="display: none;margin-bottom: 20px;;margin-top: 20px;width: 25%;" id="input_user">
            <label class="titulo_2" for="Username"> Escolha o mes:</label><br>
            <label for="">Mes</label>
            <input style="border-color: black;border-left: none;border-right: none;border-top:none" value="{{old('data1')}}" type="month" class="form-control" size="10px" id="data1" placeholder="data1" name="data1">
            <br>
            <label for="">Digite o nome dos participnates separados por 'enter'</label>
            <div class="tags_participante" data-name="tags_participante"></div>
            <input class="form-check-input" name="Atividades_tipo" type="hidden" value="Participantes" id="participantes_input">
            <button style="margin-top: 10px;padding:6px" name="filter_button_participantes" id="filter_button_participantes" class="btn_1" class="btn btn-lg btn-primary" formtarget="_blank"> Gerar PDF </button>
            <a href="{{url('/dashboard')}}"><button style="border: none;border-radius:10px" class="btn btn-warning" type="button">Voltar</button></a>
        </div>
    </form>

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
                        $('#pdf_individual').hide();
                        $('#div_mes').hide();
                        $('#voltar_minhas_atv').hide();
                    }
                    else {
                            $('#pdf_individual').show();
                            $('#input_user').hide();
                            $('#div_mes').show();
                            $('#voltar_minhas_atv').show();
                    }
                });
            });
        });


    </script>
    <script src="{{ asset('js/prime.js')}}"></script>
     <script type="text/javascript" src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    </body>
</html>
