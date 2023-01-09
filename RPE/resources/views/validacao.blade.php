<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Validação</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>
    <div class="loader">
        <div>

        </div>
    </div>
    <div id="container_validacao" class="container">
        <div class="row">
            <div style="margin: 12px;display: flex;text-align: center;justify-content: center;" class="md-12">
                @if(session('msg'))
                    <div class="alert alert-danger">
                        {{session('msg')}}
                    </div>
                @endif 
    
                @if(session('msg1'))
                <div class="alert alert-success">
                    {{session('msg1')}}
                </div>
    
                
                @endif 
            </div>

            <div style="margin: 12px;display: flex;text-align: center;justify-content: center;" class="md-12">
                <a style="margin-left: 31px" href="{{url('/dashboard')}}"><button  class="btn btn-warning">voltar a Dashboard</button></a>
            </div>
    
        </div>
    </div>
    <script>
        $(window).on('load',function(){
            $(".loader").fadeOut(800);
            $("#container_validacao").fadeIn(1000);
        });
    </script>
    <script src="{{ asset('js/prime.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>