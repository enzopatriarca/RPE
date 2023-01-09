<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Notification;
use App\Notifications\emails;
use App\Mail\mailprime;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;

use App\Jobs\EnviarEmailAprovacao;
use App\Jobs\EnviarEmailUsers;
use App\Jobs\EnviarEmailReprovacao;
use App\Jobs\EnviarEmailReenvio;

use App\Local;
use App\Local_atividade;

use App\Natureza_atividade;
use App\Natureza_de_atividade;

use App\Area_Risco;
use App\Area_atividade;

use App\User;
use App\Usuario_atividade;

use App\Atividade_de_Risco;
use Redirect;
use App\Logs;
use App\Hashes;

use PDF;

class DashboardController extends Controller{
    //Pagina Inicial de dashboard;
    public function index(){
    	return view('dashboard');
    }

    //Pagina de registro de Usuarios Novos, manda informação para essa view;
    public function registro_usuario(){
        $status = Auth()->user()->status;

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido');
        }

        return view('registro', ['roles' => Role::all()]);
    }

    //Faz a logica para adicionar um novo registro de usuario 
    public function registrar_usuario(Request $request){

        //dd($request->aprovador);

        $status = Auth()->user()->status;

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido');
        }
        //dd($request->all());
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'username' => 'required',
            'password' => 'required|min:7',
            'cargo' => 'required',
            'matricula' => 'required|unique:users',
            'lotacao' => 'required',
            'autorizacao' => 'required',
            'email' => 'required|unique:users',
 
        ],[
            'name.required' => 'Nome é obrigatorio!',
            'username.required' => 'Username é obrigatorio!',
            'password.required' => 'Senha é obrigatoria!',
            'cargo.required' => 'Cargo é obrigatorio!',
            'matricula.required' => 'Matricula é obrigatoria!',
            'lotacao.required' => 'Lotação é obrigatorio!',
            'autorizacao.required' => 'Autorização é obrigatorio!',
            'email.required' => 'E-mail é obrigatorio!',

        ]);

        if ($validator->fails()) {
            return redirect('/registro')->withErrors($validator)->withInput($request->input());  
        }

        $users = User::all();

        foreach ($users as $user) {
            if ($user->name == $request->username) {
                return redirect('/registro')->withInput($request->input())->with('message','Username ja existe!'); 
            }
        }


        
        $pass = hash::make($request->password);
        $user = new User;
        $user->nome = $request->name;
        $user->name = $request->username;
        $user->password = $pass;
        $user->cargo = $request->cargo;
        $user->matricula = $request->matricula;
        $user->Lotacao = strtoupper($request->lotacao);
        $user->autorizacao = $request->autorizacao;
        $user->email = $request->email;

        if ($request->aprovador == null) {
            $user->Aprovador = 0;
        }else{
            $user->Aprovador = $request->aprovador;
        }
        //$user->Aprovador = $request->aprovador;
        $user->save();

        $user = User::find($user->id);
        $roles = Role::find($request->Roles);

        $user->roles()->attach($roles);

        $log = new Logs;
        $log->id_user =  Auth()->user()->id;
        $log->nome_operacao = "Registro Usuario";
        $log->save();


        return redirect('/dashboard')->with('msg1', 'Usuario criado com sucesso!');

    }

    //Renderiza a pagina para registro de um novo local
    public function registro_local(){
        $status = Auth()->user()->status;

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido');
        }
        return view('registro_local');
    }
    
    //Faz a logica para o registro de um novo local
    public function registrar_local(Request $request){

        $status = Auth()->user()->status;

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido');
        }
        $validator = Validator::make($request->all(),[
            'local' => 'required',
 
        ],[
            'local.required' => 'Nome do local é obrigatorio!',

        ]);

        if ($validator->fails()) {
            return redirect('/registro_local')->withErrors($validator)->withInput($request->input());  
        }

        $locais = Local::all();

        foreach ($locais as $local) {
            if ($local->nome_local == $request->local) {
                return redirect('/registro_local')->withInput($request->all())->with('message','Local ja existe!'); 
            }
        }

        $local = new Local;

        $local->nome_local = $request->local;

        $local->save();

        $log = new Logs;
        $log->id_user =  Auth()->user()->id;
        $log->nome_operacao = "Registro Local";
        $log->save();


        return redirect('/dashboard')->with('msg1', 'Local criado com sucesso!');

    }

    //Mostra a view de registro de natureza para o usuario
    public function registro_natureza(){
        $status = Auth()->user()->status;

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido');
        }
        return view('registro_Natureza_atv');
    }

    //Faz a logica para o registro de uma nova natureza
    public function registrar_natureza(Request $request){

        $status = Auth()->user()->status;

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido');
        }

        $validator = Validator::make($request->all(),[
            'natureza' => 'required',
 
        ],[
            'natureza.required' => 'Nome da Natureza é obrigatorio!',

        ]);

        if ($validator->fails()) {
            return redirect('/registro_Natureza_atividade')->withErrors($validator)->withInput($request->input());  
        }

        $naturezas = Natureza_atividade::all();

        foreach ($naturezas as $natureza) {
            if ($natureza->nome_natureza == $request->natureza) {
                return redirect('/registro_Natureza_atividade')->withInput($request->all())->with('message','Natureza de Atividade ja existe!'); 
            }
        }

        $natureza = new Natureza_atividade;

        $natureza->nome_natureza = $request->natureza;

        $natureza->save();

        $log = new Logs;
        $log->id_user =  Auth()->user()->id;
        $log->nome_operacao = "Registro Natureza";
        $log->save();


        return redirect('/dashboard')->with('msg1', 'Natureza Atividada criado com sucesso!');
    }

    //Mostra a view do registro de Area para o usuario
    public function registro_Area(){
        $status = Auth()->user()->status;

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido');
        }
        return view('registro_Area');
    }

    //Faz a logica para o registro de uma nova Area
    public function registrar_Area(Request $request){

        $status = Auth()->user()->status;

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido');
        }

        $validator = Validator::make($request->all(),[
            'area' => 'required',
 
        ],[
            'area.required' => 'Nome da Area é obrigatorio!',

        ]);

        if ($validator->fails()) {
            return redirect('/registro_area')->withErrors($validator)->withInput($request->input());  
        }

        $areas = Area_Risco::all();

        foreach ($areas as $area) {
            if ($area->nome_area == $request->area) {
                return redirect('/registro_area')->withInput($request->all())->with('message','Area ja existe!'); 
            }
        }


        $area = new Area_Risco;

        $area->nome_area = $request->area;

        $area->save();

        $log = new Logs;
        $log->id_user =  Auth()->user()->id;
        $log->nome_operacao = "Registro Area";
        $log->save();


        return redirect('/dashboard')->with('msg1', 'Area criada com sucesso!');

    }

    //Mostra para o usuatio a view do formulario para o registro de um atividade de risco
    public function registro_atividade(){
        $status = Auth()->user()->status;

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido');
        }

        //dd($atividades);

        $atividades_[] = new Atividade_de_Risco;
        $users = \App\User::with('roles')->get();
        $naturezas = Natureza_atividade::all();
        $areas = Area_Risco::all();
        $locais = Local::all();
        $users_ = User::all();
        $users_names []= '';
        $i = 0;
        foreach ($users_ as $u){
            $users_names[$i] = $u->name;
            $i++;
        }


        $l_o = array();
        $u_sers = array();
        $a_r = array();
        $n_t = array();

        foreach ($locais as $local) {
            array_push($l_o,$local->nome_local);
        }

        //$data_l['chart_info'] = json_encode($l_o);

        foreach ($naturezas as $n) {
            array_push($n_t, $n->id);
        }

        //$data_n['chart_info'] = json_encode($n_t);

        foreach ($users as $u) {
            array_push($u_sers, $u->name);
        }

        //$data_u['chart_info'] = json_encode($u_sers);

        foreach ($areas as $a) {
            array_push($a_r,$a->id);
        }

       // $data_a['chart_info'] = json_encode($a_r);
        //dd($l_o);
        Storage::disk('public')->put('natureza.json', json_encode($n_t));
        Storage::disk('public')->put('area.json', json_encode($a_r));
        Storage::disk('public')->put('locais.json', json_encode($l_o,JSON_UNESCAPED_UNICODE));
        Storage::disk('public')->put('users.json', json_encode($u_sers));

        //$url = Storage::url('natureza.json');

        
        //$path = Storage::disk('public')->path('natureza.json');

        //dd($url);

        //dd($users);   
        return view('registro_atividades', ['users_' => $users_ ,
        'users' =>$users, 'naturezas' => $naturezas,
        'areas' =>$areas, 'locais' =>$locais,'users_names' => $users_names,
        'l_o' => $l_o, 'u_sers' => $u_sers, 'a_r' => $a_r, 'n_t' => $n_t,
        ]);
    
    }

    //Faz o registro de uma nova atividade e gera um processo de envio de email de aprovação
    public function registrar_atividade(Request $request){
        //dd(($request->all()));

        $status = Auth()->user()->status;

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido');
        }


        $validator = Validator::make($request->all(),[
            'data_inicio' => 'required|date',
            'data_final' => 'required|date|after_or_equal:data_inicio',

            'tags_input' => 'required|',
            'tags_area' => 'required|',
            'tags_local' => 'required|',
            'tags_participante' => 'required',

            'descricao' => 'required|min:3',
            'gerente' => 'required',
            'aprovador' => 'required',
 
        ],[
            'data_inicio.required' => 'Data de inicio é obrigatoria!',
            'data_final.required' => 'Data final é obrigatoria!',

            'tags_input.required' => 'IDs de Natureza é obrigatorio!',
            'tags_area.required' => 'IDs de Area é obrigatoria!',
            'tags_local.required' => 'IDs de Local é obrigatorio!',
            'tags_participante.required' => 'E-mails de Participantes é obrigatoria!',


            'descricao.required' => 'Descrição é obrigatoria!',
            'gerente.required' => 'Nome do Gerente é obrigatorio!',
            'aprovador.required' => 'Nome do Aprovador é obrigatorio!'

        ]);

        if ($validator->fails()) {
            
            return redirect('/registro_atividade')->withErrors($validator)->withInput($request->input());
            
        }

        $currentDate = date('Y-m-d');
        $currentDate = date('Y-m-d', strtotime($currentDate));
        
        if (($request->data_inicio < $currentDate)){   
            return redirect('/registro_atividade')->withInput($request->input())->with('message','Data Inicio não pode ser menor que a data atual!');
        }

        $natureza_array [] = '';
        //$k = 0;
        $natureza_array= explode(",",$request->tags_input);
       /* for ($i=0; $i < strlen($request->tags_input) ; $i++) { 
            if($request->tags_input[$i] != ","){
                $natureza_array[$k] = $request->tags_input[$i];
                $k++;
            }
        }*/

        $area_array [] = '';
        //$k = 0;
        $area_array = explode(",",$request->tags_area);
        /*for ($i=0; $i < strlen($request->tags_area) ; $i++) { 
            if($request->tags_area[$i] != ","){
                $area_array[$k] = $request->tags_area[$i];
                $k++;
            }
        }*/
        //dd($area_array);

        $local_array = array();
        $local_array_nomes [] = '';
        $l_  = Local::all();
        //$k = 0;
        //dd($request->tags_local);
        $local_array_nomes = explode(",",$request->tags_local);
        /*for ($i=0; $i < strlen($request->tags_local) ; $i++) { 
            if($request->tags_local[$i] != ","){
                $local_array[$k] = $request->tags_local[$i];
                $k++;
            }
        }*/
        //dd($local_array_nomes);

        foreach ($local_array_nomes as $local){
            foreach ($l_ as $l){
                if ($local == $l->nome_local) {
                    //dd("aqui");
                    array_push($local_array,$l->id);
                }
            }
        }
        //dd($local_array);
        $participantes_array [] = '';
        $aux='';
        $k = 0;
        $j = 0;
        //dd($participantes_array);
        for ($i=0; $i < strlen($request->tags_participante) ;$i++ ) { 
            if($request->tags_participante[$i] == ","){      
                $aux = '';
                $j++;
            }else{
                $aux.=($request->tags_participante[$i]);
                $k++;
                $participantes_array[$j] = $aux;
            }

        }

        $nome_pro = Auth()->user()->name;
        $nome_apro = $request->aprovador;
        $nome_ger = $request->gerente;

        for ($i=0; $i < count($participantes_array); $i++) { 
            if ($nome_pro == $participantes_array[$i]) {
                return redirect('/registro_atividade')->withInput($request->input())->with('message','Criador da atividade não pode ser parte dos participantes!'); 
            }

            if ($nome_apro == $participantes_array[$i]) {
                return redirect('/registro_atividade')->withInput($request->input())->with('message','Nome do aprovador não pode estar na lista de participantes!');  
            }

            if ($nome_ger == $participantes_array[$i]) {
                return redirect('/registro_atividade')->withInput($request->input())->with('message','Nome do gerente ou Supervisor não pode estar na lista de participantes!');  
            }
        }

        array_push($participantes_array,$nome_pro);
        //dd($participantes_array);

        $users = User::all();
        $supervisor_mail;
        $supervisor_id;

        $aprovador_mail;
        $aprovador_id;
        $teste_aprovador = new User;
        foreach ($users as $user) {
            if (strtoupper($request->gerente) == strtoupper($user->name)){
                $supervisor_mail = $user->email;
                $supervisor_id = $user->id;
            }
            if (strtoupper($request->aprovador) == strtoupper($user->name) ) {
                $aprovador_mail = $user->email;
                $teste_aprovador = $user;
                $aprovador_id = $user->id;
            }
        }
        //dd($aprovador_id);

        $aux1 = 0;
        $participante_id [] = '';
        if (count($participantes_array ) == 1) {
            foreach ($users as $user) {
                if ( (strtoupper($participantes_array[0])) == (strtoupper($user->name)) ) {
                    //dd(count($participantes_array ));
                    $aux1 +=1;
                    $participante_id[0] = $user->id;
                    break;
                }else{
                }
            }
            if($aux1 != count($participantes_array)){
                return redirect('/registro_atividade')->withInput($request->input())->with('message','Username introduzido incorreto!'); 
            }

        }else{
            $j = 0;
            $aux1 = 0;
            foreach ($users as $user ) {
                for ($i=0; $i < count($participantes_array);$i++) { 

                    if ( (strtoupper($participantes_array[$i])) == (strtoupper($user->name)) ) {

                        $aux1 +=1; 
                        $participante_id[$i] = $user->id;
                    }else{

                        $j+=1;
                    }
                }
            }
            if ($aux1 == count($participantes_array) ) {
                
            }else{
                return redirect('/registro_atividade')->withInput($request->input())->with('message','Username(s) introduzido(s) incorreto(s)!');
            }
        }


        $naturezas = Natureza_atividade::all();
        $aux1 = 0;
        if (count($natureza_array ) == 1) {
            foreach ($naturezas as $natureza) {
                if ($natureza_array[0] == $natureza->id) {
                    //dd(count($participantes_array ));
                    $aux1 +=1;
                    break;
                }else{
                }
            }
            if($aux1 != count($natureza_array)){
                return redirect('/registro_atividade')->withInput($request->input())->with('message','ID de Natureza introduzida incorreta!'); 
            }

        }else{
            $j = 0;
            $aux1 = 0;
            foreach ($naturezas as $natureza ) {
                for ($i=0; $i < count($natureza_array);$i++) { 
                    //dd($natureza_array[$i]);
                    if ($natureza_array[$i] == $natureza->id) {
                        //dd($natureza->id);
                        $aux1 +=1; 
                    }else{
                        //dd(count($naturezas));
                        $j+=1;
                    }
                }
            }
            if ($aux1 == count($natureza_array) ) {
                
            }else{
                return redirect('/registro_atividade')->withInput($request->input())->with('message','ID(s) de Natureza(s) introduzida(s) incorreta(s)!');
            }
        }
        

        $areas = Area_Risco::all();
        $aux1 = 0;
        if (count($area_array ) == 1) {
            foreach ($areas as $area) {
                
                if ( !preg_match('/^[1-9][0-9]*$/', $area_array[0]) ) {
                    return redirect('/registro_atividade')->withInput($request->input())->with('message','ID so pode ser um numero!'); 
                }

                if ($area_array[0] == $area->id) {
                    //dd(count($participantes_array ));
                    $aux1 +=1;
                    break;
                }else{
                }

            }
            if($aux1 != count($area_array)){
                return redirect('/registro_atividade')->withInput($request->input())->with('message','ID de Area introduzida incorreta!'); 
            }

        }else{
            $j = 0;
            $aux1 = 0;
            foreach ($areas as $area ) {
                for ($i=0; $i < count($area_array);$i++) { 
                    //dd($natureza_array[$i]);
                    if ($area_array[$i] == $area->id) {
                        //dd($natureza->id);
                        $aux1 +=1; 
                    }else{
                        //dd(count($naturezas));
                        $j+=1;
                    }
                }
            }
            if ($aux1 == count($area_array) ) {
                
            }else{
                return redirect('/registro_atividade')->withInput($request->input())->with('message','ID(s) de Area(s) introduzida(s) incorreta(s)!');
            }
        }

        $locais = Local::all();
        $aux1 = 0;
        $locais_='';
        if (count($local_array ) == 1) {
            foreach ($locais as $local) {
                if ($local_array[0] == $local->id) {
                    //dd(count($participantes_array ));
                    $aux1 +=1;
                    $locais_ .= $local->nome_local;
                    break;
                }else{
                }
            }
            if($aux1 != count($local_array)){
                return redirect('/registro_atividade')->withInput($request->input())->with('message','ID de Local introduzida incorreta!'); 
            }

        }else{
            $j = 0;
            $aux1 = 0;
            foreach ($locais as $local ) {
                for ($i=0; $i < count($local_array);$i++) { 
                    //dd($natureza_array[$i]);
                    if ($local_array[$i] == $local->id) {
                        //dd($natureza->id);
                        $aux1 +=1;
                        $locais_ .= $local->nome_local;
                        $locais_ .= ','; 
                    }else{
                        //dd(count($naturezas));
                        $j+=1;
                    }
                }
                
            }
            if ($aux1 == count($local_array) ) {
                
            }else{
                return redirect('/registro_atividade')->withInput($request->input())->with('message','ID(s) de Local(s) introduzida(s) incorreta(s)!');
            }
            

        }
        //dd($locais_);
        $date1 = Carbon::createFromFormat('Y-m-d',$request->data_inicio);
        $date2 = Carbon::createFromFormat('Y-m-d',$request->data_final);
        $dias = $date2->diffInDays($date1);

        $primeiro_dia = $date1->format("d");
        //$ultimo_dia = $date2->format("d");
        //dd($ultimo_dia);

        //$dias_array = array();
        $dias_ = '';
        //dd($primeiro_dia);
        if($dias == 0){
            $dias_ .= $primeiro_dia;
            //dd($dias);
        }else{
            //dd($dias+1);
            for ($i=0; $i < ($dias+1); $i++) { 
                $dias_ .= $primeiro_dia+$i;
                $dias_ .= ',';  
            }
            //array_push($dias_array,$dias_);
        }

        //dd($dias_);

        $atividade = new Atividade_de_Risco;

        $id = Auth()->user()->id;
        $nome_proprietario = Auth()->user()->nome;
        $username_pro = Auth()->user()->name;
        //dd($username_pro);
        $request->tags_participante .= ',';
        $request->tags_participante .= $username_pro;
        //dd($request->tags_participante);
        $atividade->data_inicio = $request->data_inicio;
        $atividade->data_final = $request->data_final;
        $atividade->descricao = $request->descricao;
        $atividade->proprietario_id = $id;
        $atividade->nome_proprietario = $nome_proprietario;
        $atividade->gerente = $request->gerente;
        $atividade->tags_natureza = $request->tags_input;
        $atividade->tags_area =  $request->tags_area;
        $atividade->tags_locais = $locais_;
        $atividade->dias = $dias_;
        $atividade->tags_participantes =  $request->tags_participante;
        $atividade->user_aprovacao = $request->aprovador;
        $atividade->id_user_aprovacao = $aprovador_id;
        $atividade->save();

        $atividade = Atividade_de_Risco::find($atividade->id);

        //dd($atividade);
        //dd($atividade->dias);

        for ($i=0; $i < count($natureza_array); $i++){ 
            $natureza_atv = new Natureza_de_atividade;
            $natureza_atv->natureza_de_atividade_id = $natureza_array[$i];
            $natureza_atv->atividade_de__risco_id = $atividade->id;
            $natureza_atv->save();
        }

        for ($i=0; $i < count($local_array) ; $i++){ 
            $local_atv = new Local_atividade;
            $local_atv->local_de_atividade_id = $local_array[$i];
            $local_atv->atividade_de__risco_id = $atividade->id;
            $local_atv->save();
        }

        for ($i=0; $i < count($area_array) ; $i++){ 
            $area_atv = new Area_atividade;
            $area_atv->area__risco_id = $area_array[$i];
            $area_atv->atividade_de__risco_id = $atividade->id;
            $area_atv->save();
        }

         
        for ($i=0; $i < count($participante_id); $i++){ 
            $user_atv = new Usuario_atividade;
            $user_atv->user_id = $participante_id[$i];
            $user_atv->atividade_de__risco_id = $atividade->id;
            $user_atv->save();
        }
        

        //adiciona o super como participante
        $atividade_id = $atividade->id;
        $super_atv = new Usuario_atividade;
        $super_atv->user_id = $supervisor_id;
        $super_atv->atividade_de__risco_id = $atividade_id;
        $super_atv->save();

        //adiciona o aprovador como participante
        /*$apro_atv = new Usuario_atividade;
        $apro_atv->user_id = $aprovador_id;
        $apro_atv->atividade_de__risco_id = $atividade_id;
        $apro_atv->save();*/

        $atividade = Atividade_de_Risco::find($atividade_id);
        //$user_id = User::find(Auth()->user());
        $naturezas_ = $request->tags_input;
        $areas_ = $request->tags_area;
        $supervisor = $request->gerente;

        $var_rprv = $atividade_id;
        $var_rprv .= 'a';

        $hash_aprv = sha1($atividade_id);
        $hash_rprv = sha1($var_rprv);


        //tabela de hashes para poder validar e comparar;
        $hash_t = new Hashes;
        $hash_t->hash_aprv = $hash_aprv;
        $hash_t->atividade_de__risco_id = $atividade_id;
        $hash_t->hash_rprv = $hash_rprv;
        $hash_t->save();

        $user_atvs = Usuario_atividade::all();
        $user_participantes = array(); 
        //dd($user_participantes);
        foreach ($user_atvs as $user_atv) {
            foreach ($users as $user) {
                if ( ($user->id == $user_atv->user_id) && ($atividade_id == $user_atv->atividade_de__risco_id)) {
                    $user_participantes[$i] = $user;
                    $i++;
                }
            }
        }

        //dd($user_participantes);
        
        //manda email queue

        $ip = request()->server('SERVER_ADDR');
        //dd($ip);

        $details['email'] = $aprovador_mail;
        dispatch(new EnviarEmailAprovacao($details,$atividade,$hash_aprv,$hash_rprv,$user_participantes,$ip));

        $log = new Logs;
        $log->id_user =  Auth()->user()->id;
        $log->nome_operacao = "Registro Atividade";
        $log->save();



        return redirect('/dashboard')->with('msg1', 'Atividade registrada com sucesso!');

    }

    //Faz a logica para a validaçao de uma atividade e manda email para os participantes da mesma
    public function Validar_Atividade($flag,$atividade_id){
        
        $atv = Atividade_de_Risco::find($atividade_id);
        //dd($atividade_id);

        /*$status = Auth()->user()->status;
        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido!');
        }

        $nome = Auth()->user()->name;

        if ($nome != $atv->user_aprovacao) {
            return redirect('/dashboard')->with('msg1','Voce não tem autorização para aprovar essa atividade!');
        }*/


        $atividades = Atividade_de_Risco::all();
        $users = User::all();
        $hashes = Hashes::all();

        $locais_atv = Local_atividade::all();
        $areas = Area_atividade::all();
        $naturezas = Natureza_de_atividade::all();
        $user_atvs = Usuario_atividade::all();

        $locais = Local::all();

        
        $aux = 0;
        $atividade_ = new Atividade_de_Risco;

        /*$users_roles = \App\User::with('roles')->get();
        $id = Auth()->user()->id;
        $aprovador_id;
        foreach ($users as $user) {
            if ($atv->user_aprovacao == $user->name){
                $aprovador_id = $user->id;
            }
        }*/

        $aux1=0;

        $aux2 = 0; $aux3= 0; $aux4 = 0; 
        foreach ($atividades as $atividade) {

            if ($atividade->id == $atividade_id) {

                if ($atividade->situacao_aprv == 1) {
                    return redirect('/validacao_resultado')->with('msg','A Atividade ja foi aprovada!');
                }

                if ($atividade->situacao_rprv == 1) {
                    return redirect('/validacao_resultado')->with('msg','A Atividade foi Reprovada!');
                }
                
                
                foreach ($hashes as $hash) {

                    if ($hash->atividade_de__risco_id == $atividade_id) {
                        if ($hash->hash_aprv == $flag) {
                            $atividade->situacao_aprv = 1;
                            $atividade->situacao_rprv = 0;
                            $date = Carbon::now();
                            $atividade->data_situacao = $date;
                            //$atividade->id_user_aprovacao = $aprovador_id;
                            $atividade->save();
                            if ($atividade->situacao_aprv == 1) {
                               $aux = 1;
                               $atividade_ = $atividade; 
                            }
                        }else{
                            $aux4 = 1;
                        }
                    }else{
                        $aux3 = 1;
                    }
                }
            }else{
                $aux2 = 1;
            }
        }

        //dd($aux);

        if ( ($aux == 0) && ($aux2 == 1) ) {
            return redirect('/validacao_resultado')->with('msg','ID de Atividade invalida!');
        }

        if ( ($aux == 0) && ($aux3 == 1)) {
            return redirect('/validacao_resultado')->with('msg','ID de Atividade não Registrado!');
        }

        if ( ($aux == 0) && ($aux4 == 1)) {
            return redirect('/validacao_resultado')->with('msg','Codigo de  Ativação esta errado!');
        }

        $naturezas_ = '';
        $areas_  = '';
        $locais_ [] = '';
        $i = 0;
        foreach ($naturezas as $natureza) {
            if ($atividade_->id == $natureza->atividade_de__risco_id) {
                $naturezas_.= $natureza->natureza_de_atividade_id;
                $naturezas_ .= ',';
                $i++;
            }
        }
        $i = 0;
        foreach ($areas as $area) {
            if ($atividade_->id == $area->atividade_de__risco_id) {
                $areas_ .= $area->area__risco_id;
                $areas_ .= ',';
                $i++;
            }
        }
        $i = 0;
        foreach ($locais_atv as $local) {
            if ($atividade_->id == $local->atividade_de__risco_id) {
                $locais_[$i] = $local->local_de_atividade_id;
                $i++;
            }
        }

        $locais = Local::all();
        $locais_nome = '';

        if (count($locais_ ) == 1) {
            foreach ($locais as $local) {
                if ($locais_[0] == $local->id) {
                    $locais_nome .= $local->nome_local;
                    break;
                }else{
                }
            }

        }else{
            foreach ($locais as $local ) {
                for ($i=0; $i < count($locais_);$i++) { 
        
                    if ($locais_[$i] == $local->id) {
                        $locais_nome .= $local->nome_local;
                        $locais_nome .= ','; 
                    }
                }
                
            }       

        }

        $date1 = Carbon::createFromFormat('Y-m-d',$atividade_->data_inicio);
        $date2 = Carbon::createFromFormat('Y-m-d',$atividade_->data_final);
        $dias = $date2->diffInDays($date1);

        $user_participantes [] = new User;;
        $users_mails [] ='';
        $i = 0;
        foreach ($user_atvs as $user_atv) {
            foreach ($users as $user) {
                if ( ($user->id == $user_atv->user_id) && ($atividade_->id == $user_atv->atividade_de__risco_id)) {
                    $user_participantes[$i] = $user;
                    $users_mails[$i] = $user->email; 
                    $i++;
                }
            }
        }
        $details  = $users_mails;

        dispatch(new EnviarEmailUsers($details,$atividade_,$user_participantes));

        

        $log = new Logs;
        $log->id_user =  $atividade->id_user_aprovacao;
        $log->nome_operacao = "Validar Atividade";
        $log->save();

        return redirect('validacao_resultado')->with('msg1','Atividade aprovada com sucesso!!');
    }

    //Faz a logica para a reprovação de uma atividade e redireciona para aprovador explicar o motivo e mandar email
    public function Reprovar_Atividade($flag,$atividade_id){
        $atv = Atividade_de_Risco::find($atividade_id);
        /*$status = Auth()->user()->status;

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido');
        }

        $nome = Auth()->user()->name;

        if ($nome != $atv->user_aprovacao) {
            return redirect('/dashboard')->with('msg1','Voce não tem autorização para aprovar essa atividade!');
        }*/


        $atividades = Atividade_de_Risco::all();
        $users = User::all();
        $atividade_[] = new Atividade_de_Risco;
        $hashes = Hashes::all();
        //$id = Auth()->user()->id;

        /*$aprovador_id;
        foreach ($users as $user) {
            if ($atv->user_aprovacao == $user->name){
                $aprovador_id = $user->id;
            }
        }*/

        foreach ($atividades as $atividade) {

            if ($atividade->id == $atividade_id) {
                if ($atividade->situacao_aprv == 1) {
                    return redirect('/validacao_resultado')->with('msg','A Atividade ja foi Aprovada!');
                }
                
                foreach ($hashes as $hash) {

                    if ($hash->atividade_de__risco_id == $atividade_id) {
                        if ($hash->hash_rprv == $flag) {
                            $atividade_[0]= $atividade;
                            $atividade->situacao_rprv = 1;
                            $atividade->situacao_aprv = 0;
                            $date = Carbon::now();
                            $atividade->data_situacao = $date;
                           // $atividade->id_user_aprovacao = $aprovador_id;
                            $atividade->save();
                            

                        }
                    }
                }
            }
        }


        //dd($atividade_);

        $log = new Logs;
        $log->id_user =  $atividade->id_user_aprovacao;
        $log->nome_operacao = "Reprovar Atividade";
        $log->save();

        //return redirect('validacao_resultado')->with('msg','Reprovado!');
        return view('motivo_rprv', ['atividade_' => $atividade_]);

    }

    //Registra o motivo da reprovação e manda o email de reporvação para os participantes da atividade
    public function Motivo_reprovacao(Request $request,$id){
        //dd($request->id);
        $atividade = Atividade_de_Risco::find($request->id);
        //dd($atividade);
        $validator = Validator::make($request->all(),[
            'motivo' => 'required|date',
        ],[
            'motivo' => 'Motivo da reprovação é obrigatoria!',

        ]);


        $participantes_array [] = '';
        $aux='';
        $k = 0;
        $j = 0;
        $users = User::all();
        $user_gerente = new User;
        $gerente_email;
        foreach ($users as $user) {
            if (strtoupper($user->name) == strtoupper($atividade->gerente)){
                $user_gerente = $user;
                $gerente_email = $user->email;

            }
        }

        for ($i=0; $i < strlen($atividade->tags_participantes) ;$i++ ) { 
            if($atividade->tags_participantes[$i] == ","){      
                $aux = '';
                $j++;
            }else{
                $aux.=($atividade->tags_participantes[$i]);
                $k++;
                $participantes_array[$j] = $aux;
            }

        }

        //dd($participantes_array);
        $k = 0;
        $j = 0;
        $participantes_[] = new User;
        //$users = User::all();
        $users_mails [] = '';
        foreach ($users as $user) {
            for ($i=0; $i < count($participantes_array) ; $i++) { 
                if (strtoupper($participantes_array[$i]) == strtoupper($user->name)) {
                    $participantes_ [$i]= $user;
                    $users_mails[$i] = $user->email;
                }
            }
        }

        array_push($participantes_, $user_gerente);
        array_push($users_mails, $gerente_email);

        $date1 = Carbon::createFromFormat('Y-m-d',$atividade->data_inicio);
        $date2 = Carbon::createFromFormat('Y-m-d',$atividade->data_final);
        $dias = $date2->diffInDays($date1);

        if($dias == 0){
            $dias = 1;
        }

        $details  = $users_mails;
        $motivo = $request->motivo;

        dispatch(new EnviarEmailReprovacao($details,$atividade,$participantes_,$motivo));

        //dd();


        return redirect('validacao_resultado')->with('msg','Atividade Reprovada!!');
    }

    //Mostra para o usuario uma lista com as areas cadastradas
    public function Listar_areas(){
        $areas = Area_Risco::all();

        return view('Listar_areas', compact('areas'));
    }

    //Mostra para o usuario uma lista com os locais cadastrados
    public function Listar_locais(){

        $locais = Local::all();

        return view('Listar_locais', compact('locais'));
    }

    //Mostra para o usuario uma lista com as naturezas cadastradas
    public function Listar_naturezas(){

        $naturezas = Natureza_atividade::all();

        return view('Listar_naturezas', compact('naturezas'));

    }

    //Mostra para o usuario uma lista com os usuarios e suas informações
    public function Listar_usuarios(){
        $users_roles = \App\User::with('roles')->get();


        $users = User::all();
        return view('Listar_usuarios', compact('users','users_roles'));
    }

    //Mostra para o usuario com a devida permissão um registro de logs do sistema
    public function Listar_logs(){
        $logs = Logs::all();
        $users = User::all();

        return view('Listar_logs', compact('logs','users'));
    }

    //Uma lista de usuarios e suas informações com a possibilidade de editar
    public function Listar_usuarios_edit(){
        $users_roles = \App\User::with('roles')->get();

        $users = User::all();
        return view('Listar_usuarios_edit', compact('users','users_roles'));
    }

    //Mostra uma view carregada com as informações daquele id de usuario
    public function Editar_usuario($id){
        $roles = Role::all();
        $users_roles = \App\User::with('roles')->get();
        $users = User::all();
        $user_id = $id;
        $usuario = User::find($user_id);
        
        //dd($usuario);
        //$usuario = User::find($user_id);
        $rol = '';
        //dd($id);
       
        foreach ($users_roles as $user_role) {
            foreach ($user_role->roles as $role) {
                if ( ($role->pivot->model_id ==  $id)){
                    $rol = $role->name;
                }
            }
        }

        return view('editar_usuario', compact('users','roles','rol','usuario','user_id'));
    }

    //Faz a logica para a atualização dos dados de um usuario
    public function atualizar_usuario(Request $request){
        //dd($request->all());

        $aux = $request->id;
        //$user =User::all();
        $usuario = User::find($aux);

        //dd($usuario);

        $status = Auth()->user()->status;

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido');
        }

        $validator = Validator::make($request->all(),[
            //'username' => 'required',
            'cargo' => 'required',
            'matricula' => 'required|',
            'lotacao' => 'required',
            //'email' => 'required|',
            'status' => 'required',
 
        ],[
            //'username.required' => 'Username é obrigatorio!',
            'cargo.required' => 'Cargo é obrigatorio!',
            'matricula.required' => 'Matricula é obrigatoria!',
            'lotacao.required' => 'Lotação é obrigatorio!',
            //'email.required' => 'E-mail é obrigatorio!',
            'status' => 'status é obrigatorio',

        ]);

        if ($validator->fails()) {
            return redirect('/Editar_usuario/'.$request->id)->withErrors($validator)->withInput($request->input());  
        }

        $users = User::all();

        foreach ($users as $user_) {
            if ($user_->name == $request->username) {
                return redirect('/Editar_usuario/'.$request->id)->withInput($request->input())->with('message','Username ja existe!'); 
            }
        }

        $aux_aprv;
        if ($request->aprovador == 0) {
            $aux_aprv = 0;
        }else{
            $aux_aprv = 1;
        }

        
        //$pass = hash::make($request->password);
        //$user = new User;

        //$user->name = $request->username;
        $usuario->cargo = $request->cargo;
        $usuario->matricula = $request->matricula;
        $usuario->Lotacao = strtoupper($request->lotacao);
        $usuario->status = $request->status;
        $usuario->Aprovador = $aux_aprv;
        
        //$usuario->email = $request->email;
        $usuario->save();
        //dd($usuario);
        $users_roles = \App\User::with('roles')->get();
        $rols = Role::all();
        //dd($rols);
        foreach ($users_roles as $user_role) {
            foreach ($user_role->roles as $role) {
                if ( ($usuario->id == $role->pivot->model_id) ) {
                    //dd($request->Roles[0]);
                    foreach ($rols as $rol) {
                        if ($request->Roles[0] == $rol->id) {
                            //dd('aqui');
                            $role->pivot->model_id = $usuario->id;
                            $role->pivot->role_id = $rol->id;
                            $role->pivot->save();
                        } 
                    }

                    
                }
            }
        }
        $log = new Logs;
        $log->id_user =  Auth()->user()->id;
        $log->nome_operacao = "Edição de Usuario";
        $log->save();


        return redirect('/dashboard')->with('msg1', 'Usuario editado com sucesso!');

    }

    //Mostra para o usuario uma view carregada com as informações de uma atividade reprovada
    public function Editar_atividade($id){
        $atividade = Atividade_de_Risco::find($id);

        $locais_ = Local_atividade::all();
        $areas_ = Area_atividade::all();
        $naturezas_ = Natureza_de_atividade::all();
        $participantes = Usuario_atividade::all();

        $locais = Local::all();
        $areas= Area_Risco::all();
        $naturezas= Natureza_atividade::all();
        $users = User::all();
        $users = \App\User::with('roles')->get();
        $id = Auth()->user()->id;

        if (($id != $atividade->proprietario_id)) {
            return redirect('/Atividades')->with('msg1','Não é possivel editar atividades de outros usuarios!');
        }
        $l = ''; $n = ''; $a = ''; $p = '';

    
           
        foreach ($locais_ as $local) {
            if ( ($locais_->count() == 1) && ($local->atividade_de__risco_id == $atividade->id)) {
                $l .= $local->local_de_atividade_id;
            }else{
                if ($local->atividade_de__risco_id == $atividade->id) {
                    $l .= $local->local_de_atividade_id;
                    $l .= ',';
                }
            }

        }

        //dd($l);
        $l_1 = '';
        $local_array = array();
        $local_array_nomes [] = '';
        $l_  = Local::all();
        //$k = 0;
        //dd($request->tags_local);
        $local_array_nomes = explode(",",$l);

        //dd($l);
        foreach ($locais as $local) {
            foreach ($local_array_nomes as $n) {
                if ($local->id == $n) {
                    $l_1 .= $local->nome_local;
                    $l_1 .= ',';
                }
            }
        }
        $l_1 =  substr($l_1, 0, -1);
        $local_array = explode(",",$l_1);
        //dd($local_array);
        //dd($l_1);
        

        foreach ($areas_ as $area) {
            if (($areas_->count() == 1) && ($area->atividade_de__risco_id == $atividade->id) ) {
                $a .= $area->area__risco_id;
            }else{
                if (($area->atividade_de__risco_id == $atividade->id)) {
                    $a .= $area->area__risco_id;
                    $a .= ',';
                }

            }

        }
        $area_array = array();
        $a =  substr($a, 0, -1);
        $area_array = explode(",",$a);
        //dd($area_array);

        foreach ($naturezas_ as $natureza) {
            if ( ($naturezas_->count() == 1) && ($natureza->atividade_de__risco_id == $atividade->id) ) {
                $n .= $natureza->natureza_de_atividade_id;
            }else{
                if (($natureza->atividade_de__risco_id == $atividade->id)) {
                    $n .= $natureza->natureza_de_atividade_id;
                    $n .= ',';
                }

            }

        }
        $natureza_array = array();
        $n =  substr($n, 0, -1);
        $natureza_array = explode(",",$n);

        foreach ($participantes as $participante) {
            foreach ($users as $user) {
                if ( ($participante->user_id == $user->id) && ($participante->atividade_de__risco_id == $atividade->id)) {
                    if ( ($participantes->count() == 1) && ($participante->atividade_de__risco_id == $atividade->id) ) {
                        $p .= $user->name;
                    }else{
                        if (($participante->atividade_de__risco_id == $atividade->id)) {
                            $p .= $user->name;
                            $p .= ',';
                        }

                    }
                }
            }
        }
        //dd($atividade->gerente);
        $participantes_array = array();
        $p =  substr($p, 0, -1);
        $participantes_array = explode(",",$p);

        $tam = count($participantes_array);
        unset($participantes_array[$tam-2]);
        unset($participantes_array[$tam-1]);
        //dd($participantes_array);
       $p = implode(",",$participantes_array);
        return view('editar_atividade',['atividade' => $atividade,
                                        'naturezas' => $naturezas, 
                                        'areas' =>$areas, 
                                        'locais'=> $locais,
                                        'users' =>$users, 'users_' =>$users,
                                        'l' =>$l_1, 'a' => $a, 'n' => $n, 'p' => $p,
                                    'local_array' => $local_array, 'area_array' => $area_array,
                                    'natureza_array' => $natureza_array, 'participantes_array' => $participantes_array]);

    }

    //Faz a logica para a atualização de uma atividade e manda um email para aprovação
    public function atualizar_atividade(Request $request){
        //dd($request);
        $atividade = Atividade_de_Risco::find($request->id);
        //logica de atualizaçao

        $status = Auth()->user()->status;

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido');
        }

        $validator = Validator::make($request->all(),[
            'data_inicio' => 'required|date',
            'data_final' => 'required|date|after_or_equal:data_inicio',

            'tags_input' => 'required|',
            'tags_area' => 'required|',
            'tags_local' => 'required|',
            'tags_participante' => 'required',

            'descricao' => 'required|min:3',
            'gerente' => 'required',
            'aprovador' => 'required',
 
        ],[
            'data_inicio.required' => 'Data de inicio é obrigatoria!',
            'data_final.required' => 'Data final é obrigatoria!',

            'tags_input.required' => 'IDs de Natureza é obrigatorio!',
            'tags_area.required' => 'IDs de Area é obrigatoria!',
            'tags_local.required' => 'IDs de Local é obrigatorio!',
            'tags_participante.required' => 'E-mails de Participantes é obrigatoria!',


            'descricao.required' => 'Descrição é obrigatoria!',
            'gerente.required' => 'Nome do Gerente é obrigatorio!',

        ]);

        if ($validator->fails()) {
            
            return redirect('/Editar_atividade/'.$request->id)->withErrors($validator)->withInput($request->input());
            
        }

        $currentDate = date('Y-m-d');
        $currentDate = date('Y-m-d', strtotime($currentDate));


        if (($request->data_inicio < $currentDate)){   
            return redirect('/Editar_atividade/'.$request->id)->withInput($request->input())->with('message','Data Inicio não pode ser menor que a data atual!');
        }

        $natureza_array [] = '';

        $k = 0;
        $natureza_array= explode(",",$request->tags_input);
        /*for ($i=0; $i < strlen($request->tags_input) ; $i++) { 
            if($request->tags_input[$i] != ","){
                $natureza_array[$k] = $request->tags_input[$i];
                $k++;
            }
        }*/

        $area_array [] = '';

        $k = 0;
        $area_array = explode(",",$request->tags_area);
        /*for ($i=0; $i < strlen($request->tags_area) ; $i++) { 
            if($request->tags_area[$i] != ","){
                $area_array[$k] = $request->tags_area[$i];
                $k++;
            }
        }*/

        $local_array = array();
        $local_array_nomes [] = '';
        $l_  = Local::all();
        //$k = 0;
        //dd($request->tags_local);
        $local_array_nomes = explode(",",$request->tags_local);
        /*for ($i=0; $i < strlen($request->tags_local) ; $i++) { 
            if($request->tags_local[$i] != ","){
                $local_array[$k] = $request->tags_local[$i];
                $k++;
            }
        }*/
        //dd($local_array_nomes);

        foreach ($local_array_nomes as $local){
            foreach ($l_ as $l){
                if ($local == $l->nome_local) {
                    //dd("aqui");
                    array_push($local_array,$l->id);
                }
            }
        }

        //dd($local_array);

        $participantes_array [] = '';
        $aux='';
        $k = 0;
        $j = 0;

        for ($i=0; $i < strlen($request->tags_participante) ;$i++ ) { 
            if($request->tags_participante[$i] == ","){      
                $aux = '';
                $j++;
            }else{
                $aux.=($request->tags_participante[$i]);
                $k++;
                $participantes_array[$j] = $aux;
            }

        }

        $nome_pro = Auth()->user()->name;
        $nome_apro = $request->aprovador;
        $nome_ger = $request->gerente;

        for ($i=0; $i < count($participantes_array); $i++) { 
            if ($nome_pro == $participantes_array[$i]) {
                return redirect('/registro_atividade')->withInput($request->input())->with('message','Criador da atividade não pode ser parte dos participantes!'); 
            }

            if ($nome_apro == $participantes_array[$i]) {
                return redirect('/registro_atividade')->withInput($request->input())->with('message','Nome do aprovador não pode estar na lista de participantes!');  
            }

            if ($nome_ger == $participantes_array[$i]) {
                return redirect('/registro_atividade')->withInput($request->input())->with('message','Nome do gerente ou Supervisor não pode estar na lista de participantes!');  
            }
        }

        array_push($participantes_array,$nome_pro);

        $users = User::all();
        $supervisor_mail;
        $aprovador_mail;
        $gerente_id;
        $aprovador_id;
        $user_gerente = new User;
        foreach ($users as $user) {
            if ($request->gerente == $user->name){
                $supervisor_mail = $user->email;
                $gerente_id = $user->id;
                $user_gerente = $user;
            }
            if (strtoupper($request->aprovador) == strtoupper($user->name) ) {
                $aprovador_mail = $user->email;
                $aprovador_id = $user->id;
                
            }
        }

        $aux1 = 0;
        $participante_id [] = '';
        if (count($participantes_array ) == 1) {
            foreach ($users as $user) {
                if ( (strtoupper($participantes_array[0])) == (strtoupper($user->name)) ) {
                    //dd(count($participantes_array ));
                    $aux1 +=1;
                    $participante_id[0] = $user->id;
                    break;
                }else{
                }
            }
            if($aux1 != count($participantes_array)){
                return redirect('/Editar_atividade/'.$request->id)->withInput($request->input())->with('message','Username introduzido incorreto!'); 
            }

        }else{
            $j = 0;
            $aux1 = 0;
            foreach ($users as $user ) {
                for ($i=0; $i < count($participantes_array);$i++) { 

                    if ( (strtoupper($participantes_array[$i])) == (strtoupper($user->name)) ) {

                        $aux1 +=1; 
                        $participante_id[$i] = $user->id;
                    }else{

                        $j+=1;
                    }
                }
            }
            if ($aux1 == count($participantes_array) ) {
                
            }else{
                return redirect('/Editar_atividade/'.$request->id)->withInput($request->input())->with('message','Username(s) introduzido(s) incorreto(s)!');
            }
        }
        //array_push($participante_id, $gerente_id);
        //$participante_id = push($aprovador_id);
        //dd($participante_id);
        array_push($participante_id, $gerente_id);
        //dd($participante_id);
        $naturezas = Natureza_atividade::all();
        $aux1 = 0;
        if (count($natureza_array ) == 1) {
            foreach ($naturezas as $natureza) {
                if ($natureza_array[0] == $natureza->id) {
                    //dd(count($participantes_array ));
                    $aux1 +=1;
                    break;
                }else{
                }
            }
            if($aux1 != count($natureza_array)){
                return redirect('/Editar_atividade/'.$request->id)->withInput($request->input())->with('message','ID de Natureza introduzida incorreta!'); 
            }

        }else{
            $j = 0;
            $aux1 = 0;
            foreach ($naturezas as $natureza ) {
                for ($i=0; $i < count($natureza_array);$i++) { 
                    //dd($natureza_array[$i]);
                    if ($natureza_array[$i] == $natureza->id) {
                        //dd($natureza->id);
                        $aux1 +=1; 
                    }else{
                        //dd(count($naturezas));
                        $j+=1;
                    }
                }
            }
            if ($aux1 == count($natureza_array) ) {
                
            }else{
                return redirect('/Editar_atividade/'.$request->id)->withInput($request->input())->with('message','ID(s) de Natureza(s) introduzida(s) incorreta(s)!');
            }
        }
        

        $areas = Area_Risco::all();
        $aux1 = 0;
        if (count($area_array ) == 1) {
            foreach ($areas as $area) {
                
                if ( !preg_match('/^[1-9][0-9]*$/', $area_array[0]) ) {
                    return redirect('/Editar_atividade/'.$request->id)->withInput($request->input())->with('message','ID so pode ser um numero!'); 
                }

                if ($area_array[0] == $area->id) {
                    //dd(count($participantes_array ));
                    $aux1 +=1;
                    break;
                }else{
                }

            }
            if($aux1 != count($area_array)){
                return redirect('/Editar_atividade/'.$request->id)->withInput($request->input())->with('message','ID de Area introduzida incorreta!'); 
            }

        }else{
            $j = 0;
            $aux1 = 0;
            foreach ($areas as $area ) {
                for ($i=0; $i < count($area_array);$i++) { 
                    //dd($natureza_array[$i]);
                    if ($area_array[$i] == $area->id) {
                        //dd($natureza->id);
                        $aux1 +=1; 
                    }else{
                        //dd(count($naturezas));
                        $j+=1;
                    }
                }
            }
            if ($aux1 == count($area_array) ) {
                
            }else{
                return redirect('/Editar_atividade/'.$request->id)->withInput($request->input())->with('message','ID(s) de Area(s) introduzida(s) incorreta(s)!');
            }
        }

        $locais = Local::all();
        $aux1 = 0;
        $locais_='';
        if (count($local_array ) == 1) {
            foreach ($locais as $local) {
                if ($local_array[0] == $local->id) {
                    //dd(count($participantes_array ));
                    $aux1 +=1;
                    $locais_ .= $local->nome_local;
                    break;
                }else{
                }
            }
            if($aux1 != count($local_array)){
                return redirect('/Editar_atividade/'.$request->id)->withInput($request->input())->with('message','ID de Local introduzida incorreta!'); 
            }

        }else{
            $j = 0;
            $aux1 = 0;
            foreach ($locais as $local ) {
                for ($i=0; $i < count($local_array);$i++) { 
                    //dd($natureza_array[$i]);
                    if ($local_array[$i] == $local->id) {
                        //dd($natureza->id);
                        $aux1 +=1;
                        $locais_ .= $local->nome_local;
                        $locais_ .= ','; 
                    }else{
                        //dd(count($naturezas));
                        $j+=1;
                    }
                }
                
            }
            if ($aux1 == count($local_array) ) {
                
            }else{
                return redirect('/Editar_atividade/'.$request->id)->withInput($request->input())->with('message','ID(s) de Local(s) introduzida(s) incorreta(s)!');
            }
            

        }

        //$atividade = new Atividade_de_Risco;

        $id = Auth()->user()->id;
        $date1 = Carbon::createFromFormat('Y-m-d',$request->data_inicio);
        $date2 = Carbon::createFromFormat('Y-m-d',$request->data_final);
        $dias = $date2->diffInDays($date1);

        $primeiro_dia = $date1->format("d");
        //$ultimo_dia = $date2->format("d");
        //dd($ultimo_dia);

        //$dias_array = array();
        $dias_ = '';
        //dd($primeiro_dia);
        if($dias == 0){
            $dias_ = $primeiro_dia;
        }else{
            //dd($dias+1);
            for ($i=0; $i < ($dias+1); $i++) { 
                $dias_ .= $primeiro_dia+$i;
                $dias_ .= ',';  
            }
            //array_push($dias_array,$dias_);
        }

        $nome_proprietario = Auth()->user()->nome;
        $username_pro = Auth()->user()->name;
        //dd($username_pro);
        $request->tags_participante .= ',';
        $request->tags_participante .= $username_pro;

        $atividade->data_inicio = $request->data_inicio;
        $atividade->data_final = $request->data_final;
        $atividade->descricao = $request->descricao;
        $atividade->proprietario_id = $id;
        $atividade->nome_proprietario = $nome_proprietario;
        $atividade->gerente = $request->gerente;
        $atividade->situacao_rprv = 0;
        $atividade->tags_natureza = $request->tags_input;
        $atividade->tags_area =  $request->tags_area;
        $atividade->tags_locais = $locais_;
        $atividade->tags_participantes =  $request->tags_participante;
        $atividade->user_aprovacao = $request->aprovador;
        $atividade->dias = $dias;

        $atividade->save();

        $atividade = Atividade_de_Risco::find($atividade->id);

        //dd($atividade);


        $users_participantes = Usuario_atividade::where('atividade_de__risco_id', '=',$atividade->id)->delete();
        $naturezas_atvs = Natureza_de_atividade::where('atividade_de__risco_id', '=',$atividade->id)->delete();
        $locais_atvs = Local_atividade::where('atividade_de__risco_id', '=',$atividade->id)->delete();
        $areas_atvs = Area_atividade::where('atividade_de__risco_id', '=',$atividade->id)->delete();


        //dd($users_participantes);
        //DB::table('usuario_atividades')->delete($atividade->id);


        $natureza_atv = Natureza_de_atividade::all();
        for ($i=0; $i < count($natureza_array); $i++){ 
            $natureza_atv = new Natureza_de_atividade;
            $natureza_atv->natureza_de_atividade_id = $natureza_array[$i];
            $natureza_atv->atividade_de__risco_id = $atividade->id;
            $natureza_atv->save();
        }

        $local_atv = Local_atividade::all();
        for ($i=0; $i < count($local_array) ; $i++){ 
            $local_atv = new Local_atividade;
            $local_atv->local_de_atividade_id = $local_array[$i];
            $local_atv->atividade_de__risco_id = $atividade->id;
            $local_atv->save();
        }


        $area_atv = Area_atividade::all();
        for ($i=0; $i < count($area_array) ; $i++){ 
            $area_atv = new Area_atividade;
            $area_atv->area__risco_id = $area_array[$i];
            $area_atv->atividade_de__risco_id = $atividade->id;
            $area_atv->save();
        }

        $participante_atv = Usuario_atividade::all();

        for ($i=0; $i < count($participante_id); $i++){ 
            $user_atv = new Usuario_atividade;
            $user_atv->user_id = $participante_id[$i];
            $user_atv->atividade_de__risco_id = $atividade->id;
            $user_atv->save();
        }



        
        $atividade_id = $atividade->id;
        $atividade = Atividade_de_Risco::find($atividade_id);
        $naturezas_ = $request->tags_input;
        $areas_ = $request->tags_area;
        $supervisor = $request->gerente;

        $var_rprv = $atividade_id;
        $var_rprv .= 'a';

        $hash_aprv = sha1($atividade_id);
        $hash_rprv = sha1($var_rprv);


        //tabela de hashes para poder validar e comparar;
        $hashes = Hashes::all();

        //$hash_t = new Hashes;
        foreach ($hashes as $hash) {
            if ($atividade->id == $hash->atividade_de__risco_id) {
                $hash->hash_aprv = $hash_aprv;
                $hash->atividade_de__risco_id = $atividade->id;
                $hash->hash_rprv = $hash_rprv;
                $hash->save();
            }
        }

        
        $user_participantes[] = new User;
        $supervisor_mail;
        foreach ($users as $user) {
            for ($i=0; $i < count($participantes_array) ; $i++) { 
                if (strtoupper($participantes_array[$i]) == strtoupper($user->name)) {
                    $user_participantes [$i]= $user;
                }
            }
        } 
        array_push($user_participantes, $user_gerente);
        //dd($user_participantes);

        $details['email'] = $aprovador_mail;
        dispatch(new EnviarEmailAprovacao($details,$atividade,$hash_aprv,$hash_rprv,$user_participantes));

        //registrar nos logs
        $log = new Logs;
        $log->id_user =  Auth()->user()->id;
        $log->nome_operacao = "Edição de Atividade";
        $log->save();


        return redirect('/dashboard')->with('msg1', 'Atividade editada com sucesso!');
    }

    //Uma view para a geração de PDF
    public function pdf_atividades_view(){

        return view('pdf_atividades');
    }

    //Logica para gerar um pdf do usuario que esta logado
    public function gerar_pdf_atividades(Request $request){
       // dd($request);

        $validator = Validator::make($request->all(),[
            'data1' => 'required',
        ],[
            'data1.required' => 'O mes de referencia é obrigatoria!',

        ]);

        if ($validator->fails()) {
            return redirect('/pdf_minhas_atividades')->withErrors($validator)->withInput($request->input());  
        }


        $user = Auth()->user();
        $atividades = Atividade_de_Risco::all();
        $atividades_[] = new Atividade_de_Risco;
        $user_atvs = Usuario_atividade::all();
        $i=0;

        foreach ($atividades as $atividade){
            foreach ($user_atvs as $user_atv) {
                if ( ($atividade->gerente == $user->id) && ($atividade->situacao_aprv == 1) ) {
                    $atividades_[$i] = $atividade;
                    $i++;
                }
                if (($user->id == $user_atv->user_id) && ($user_atv->atividade_de__risco_id == $atividade->id) && ($atividade->situacao_aprv == 1)) {
                    $atividades_[$i] = $atividade;
                    $i++;
                }
            }
        }

        //dd($atividades_);
        $naturezas_ = Natureza_atividade::all();
        $areas_ = Area_Risco::all();
        $locais = Local::all();

        $atvs[] = new Atividade_de_Risco;
        $tam = count($atvs);
        $dias =array();
        $j=0;
        //
        $num_date = '';
        for ($i=0; $i < strlen($request->data1) ; $i++) { 
            if ($request->data1[$i] == '-') {
                $num_date .= $request->data1[$i+1];
                $num_date .= $request->data1[$i+2];
                break;
            }
        }

        $ano='';
        for ($i=0; $i < strlen($request->data1) ; $i++) { 
            if ($request->data1[$i] != '-') {
                $ano .= $request->data1[$i];
                //$num_date .= $request->data1[$i+2];
                
            }else{
                break;
            }
        }

        $dateObj   = Carbon::createFromFormat('!m', $num_date);
        $monthName = $dateObj->format('F');

        switch($monthName)
        {
            case "January": $monthName = "Janeiro"; break;
            case "February": $monthName = "Fevereiro"; break;
            case "March": $monthName = "Março"; break;
            case "April": $monthName = "Abril"; break;
            case "May": $monthName = "Maio"; break;
            case "June": $monthName = "Junho"; break;
            case "July": $monthName = "Julho"; break;
            case "August": $monthName = "Agosto"; break;
            case "September": $monthName = "Setembro"; break;
            case "October": $monthName = "Outubro"; break;
            case "November": $monthName = "Novembro"; break;
            case "December": $monthName = "Dezembro"; break;
            default: $monthName = "Unknown"; break;
        }

        //dd($monthName);

        $date =  (new Carbon($request->data1))->format("m-y");
        //dd($date);
        //$date =  Carbon::createFromFormat('Y-m-d',$request->data1)->format('F');
        //$monthName = $request->date1->format('F');

        for ($i=0; $i < count($atividades_) ; $i++) {

            $d1 = (new Carbon($atividades_[$i]->data_inicio))->format("m-y");
            $d2 = (new Carbon($atividades_[$i]->data_final))->format("m-y");
            //dd($atividades_[$i+1]->data_final);
           
            if (($date == $d1 ) || ($date == $d2)) {
                
                $atvs[$j] = $atividades_[$i];
                $j++;
                
            }
        }


        $pdf = PDF::loadView('pdfs',compact('atvs','user','request','naturezas_','areas_','monthName','ano'));


        return $pdf->setPaper('a3', 'landscape')->stream('todas_minhas_atividades');



    }

    //Logica para gerar N PDF de usuarios que são passados pelo usuario
    public function gerar_pdf_atividades_usuarios(Request $request){
        //dd($request);
        $validator = Validator::make($request->all(),[
            'data1' => 'required',
            'tags_participante' => 'required'
        ],[
            'data1.required' => 'O mes de referencia é obrigatoria!',
            'tags_participante.required' => 'Os nomes de usuarios são obrigatorios!'

        ]);

        if ($validator->fails()) {
            return redirect('/pdf_minhas_atividades')->withErrors($validator)->withInput($request->input());  
        }

        $user = Auth()->user();
        $users = User::all();
        $atividades = Atividade_de_Risco::where('situacao_aprv', '=',1)->get();
        $atvs  = array();
        $atividades_[] = new Atividade_de_Risco;
        $user_atvs = Usuario_atividade::all();
        $users_ = array();

        




        $num_date = '';
        for ($i=0; $i < strlen($request->data1) ; $i++) { 
            if ($request->data1[$i] == '-') {
                $num_date .= $request->data1[$i+1];
                $num_date .= $request->data1[$i+2];
                break;
            }
        }
        $ano='';
        for ($i=0; $i < strlen($request->data1) ; $i++) { 
            if ($request->data1[$i] != '-') {
                $ano .= $request->data1[$i];
                //$num_date .= $request->data1[$i+2];
                
            }else{
                break;
            }
        }

        $dateObj   = Carbon::createFromFormat('!m', $num_date);
        $monthName = $dateObj->format('F');

        switch($monthName)
        {
            case "January": $monthName = "Janeiro"; break;
            case "February": $monthName = "Fevereiro"; break;
            case "March": $monthName = "Março"; break;
            case "April": $monthName = "Abril"; break;
            case "May": $monthName = "Maio"; break;
            case "June": $monthName = "Junho"; break;
            case "July": $monthName = "Julho"; break;
            case "August": $monthName = "Agosto"; break;
            case "September": $monthName = "Setembro"; break;
            case "October": $monthName = "Outubro"; break;
            case "November": $monthName = "Novembro"; break;
            case "December": $monthName = "Dezembro"; break;
            default: $monthName = "Unknown"; break;
        }
        //dd($monthName);

        $date =  (new Carbon($request->data1))->format("m-y");

        foreach ($atividades as $atividade){
            $d1 = (new Carbon($atividade->data_inicio))->format("m-y");
            $d2 = (new Carbon($atividade->data_final))->format("m-y"); 
            if (($date == $d1 ) || ($date == $d2)) {
                array_push($atvs,$atividade);
            }
        }

        //dd($atvs);
        $participantes_array [] = '';

        //dd($atividades);
        $participantes_array = explode(",",$request->tags_participante);
        $l = 0;
        foreach ($participantes_array as $p) {
            foreach ($users as $u) {
                if ($u->name == $p) {
                    array_push($users_,$u);
                }
    
            }
        }
        
        
        $k = 0;

        $atividades_ = array();
        $array  = array();
        //dd($participantes_array);
        $teste [] = ''; 
        //$array = array_shift($array);
        for ($i=0; $i < count($participantes_array) ; $i++) {
            
            $array  = array();
            foreach ($atvs as $atividade){
                //echo($atividade->user_aprovacao);
                //dd($atividade);
                if (str_contains(strtoupper($atividade->tags_participantes), strtoupper($participantes_array[$i]))) {
                    array_push($array,$atividade);
              
                }elseif (str_contains(strtoupper($atividade->gerente), strtoupper($participantes_array[$i]))) {
                    array_push($array,$atividade);
                }
                //$array = array_shift($array);    
            }
            
            array_push($atividades_,$array); 
            unset($array);
            $array [] = new Atividade_de_Risco;   
        }
        //dd($users_);
        //dd($atividades_);
        //dd(count($array));
        //dd($array[2]);

        /*foreach ($atividades_ as $value) {
            //dd($value);
            foreach ($value as $key) {
                //dd($key->id);
            }
        }*/
        //dd($date);
        $naturezas_ = Natureza_atividade::all();
        $areas_ = Area_Risco::all();
        $pdf = PDF::loadView('pdfs_usuarios',compact('atividades_','users_','monthName','naturezas_','areas_','ano'));

        return $pdf->setPaper('a3', 'landscape')->stream('Atividades');

    }

    //Mostra para os usuarios uma lista com as informações de todas as atividades
    public function Atividades(Request $request){
        //dd($request->all());
        $atividades = Atividade_de_Risco::all();
        $atividades_[]= new Atividade_de_Risco;
        $user_atvs = Usuario_atividade::all();
        $users = User::all();
        $participantes [] = '';
        $id = Auth()->user()->id;
        $i = 0;
        $j = 0;
        

        //Reprovadas
        if ($request->Atividades_tipo == "Atividades Reprovadas") {
            foreach ($atividades as $atividade) {
                    if ( ($atividade->situacao_aprv == false) && ($atividade->situacao_rprv == true)) {
                        $atividades_[$i] = $atividade;
                        $i++;
                    }
            }
            //dd($atividades_);
            if ($atividades_[0]->id == null) {
                return redirect('/Atividades')->with('msg1','Não há atividades reprovadas!');
            }
            return view ('Atividades',compact('atividades_','request'))->withInput($request->all());
        }

        //aprovadas
        if ($request->Atividades_tipo == "Atividades Aprovadas") {
            foreach ($atividades as $atividade){
                if ( ($atividade->situacao_aprv == true)) {
                    $atividades_[$i] = $atividade;
                    $i++;
                }
            }
            //dd($atividades_[0]->id == null);
            if ($atividades_[0]->id == null) {
                return redirect('/Atividades')->with('msg1','Não há atividades aprovadas!');
            }
            return view ('Atividades',compact('atividades_','request'))->withInput($request->all());
        }

        //proprietario
        if ($request->Atividades_tipo == "Atividades Proprietario") {
            foreach ($atividades as $atividade) {
                if (  ($atividade->proprietario_id == $id) ) {
                    $atividades_[$i] = $atividade;
                    $i++;
                }
            }
            //dd($atividades_[0]->id == null);
            if ($atividades_[0]->id == null) {
                //dd("aqui");
                return redirect('/Atividades')->with('msg1','Não há atividades criadas!');
            }
            return view('Atividades', compact('atividades_','request'))->withInput($request->all());
        }

        //Esperando Resposta
        if ($request->Atividades_tipo == "Atividades Esperando Resposta") {
            foreach ($atividades as $atividade) {
                    if ( ($atividade->situacao_aprv == false) && ($atividade->situacao_rprv == false)) {
                        $atividades_[$i] = $atividade;
                        $i++;
                    }
            }
            if ($atividades_[0]->id == null) {
                return redirect('/Atividades')->with('msg1','Não há atividades esperando por resposta!');
            }
            return view ('Atividades',compact('atividades_','request'))->withInput($request->all());
        }

        //Participantes

        if ($request->Atividades_tipo == "Participantes") {
            //dd($request->all());
            $participantes_array [] = '';
            $aux='';
            $k = 0;
            $j = 0;
    
            for ($i=0; $i < strlen($request->tags_participante) ;$i++ ) { 
                if($request->tags_participante[$i] == ","){      
                    $aux = '';
                    $j++;
                }else{
                    $aux.=($request->tags_participante[$i]);
                    $k++;
                    $participantes_array[$j] = $aux;
                }
    
            }

            //dd($participantes_array);
            $j=0;
            $k=0;
            foreach ($atividades as $atividade) {
                foreach ($participantes_array as $p) {
                    if (str_contains(strtoupper($atividade->tags_participantes), strtoupper($p)) || ($p) == $atividade->gerente) {
                        $atividades_[$k] = $atividade;
                        $k++;
                    }
                }
            }
            //dd($atividades_);
            return view ('Atividades',compact('atividades_','request'))->withInput($request->all());
        }
        




        //dd($atividades_);
        $atividades_ = $atividades;
        return view('Atividades', compact('atividades_','request'));
    }

    //Faz a logica de reenvio de email caso seja necessario
    public function Reenviar_mail($id){
        //dd($id);
        $atividade = Atividade_de_Risco::find($id);
        //dd($atividade);
        $hashes = Hashes::all();
        $users = User::all();
        //$hash_t = new Hashes;
        $id = Auth()->user()->id;
        $hash_aprv;
        $hash_rprv;
        $dias;
        if (($id != $atividade->proprietario_id)) {
            //dd("aqui");
            return redirect('/Atividades')->with('msg1','Não é possivel REENVIAR email de atividades de outros usuarios!');
        }


        foreach ($hashes as $hash) {
            if ($atividade->id == $hash->atividade_de__risco_id) {
                $hash_aprv = $hash->hash_aprv;
                $hash_rprv = $hash->hash_rprv;
            }
        }

        $date1 = Carbon::createFromFormat('Y-m-d',$atividade->data_inicio);
        $date2 = Carbon::createFromFormat('Y-m-d',$atividade->data_final);
        $dias = $date2->diffInDays($date1);

        if($dias == 0){
            $dias = 1;
        }

        $participantes_array [] = '';
        $aux='';
        $k = 0;
        $j = 0;

        for ($i=0; $i < strlen($atividade->tags_participantes) ;$i++ ) { 
            if($atividade->tags_participantes[$i] == ","){      
                $aux = '';
                $j++;
            }else{
                $aux.=($atividade->tags_participantes[$i]);
                $k++;
                $participantes_array[$j] = $aux;
            }

        }

        //dd($participantes_array);
        $k = 0;
        $j = 0;
        $participantes_[] = new User;
        $supervisor_mail;
        $aprovador_mail ;

        $Superv;

        foreach ($users as $user) {
            for ($i=0; $i < count($participantes_array) ; $i++) { 
                if (strtoupper($participantes_array[$i]) == strtoupper($user->name)) {
                    $participantes_ [$i]= $user;
                }
            }
            if ($atividade->gerente == $user->name){
                $supervisor_mail = $user->email;
                $superv = $user;
            }

            if ($atividade->user_aprovacao == $user->name){
                $aprovador_mail = $user->email;
                //$aprvd = $user;
            }
        }

        //dd($superv);
        //dd($participantes_);
        array_push($participantes_,$superv);
        $ip = request()->server('SERVER_ADDR');

        //dd($participantes_);

        $details['email'] = $aprovador_mail;
        dispatch(new EnviarEmailReenvio($details,$atividade,$hash_aprv, $hash_rprv,$participantes_,$ip));


        return redirect('/Atividades')->with('msg2','Reenvio com sucesso!');

    }

    //Mostra uma view com o relatorio de dados de determinado mes 
    public function relatorios_view(Request $request){

        $atividades = Atividade_de_Risco::where('situacao_aprv', '=',1)->get();
        $atividades_[] = new Atividade_de_Risco;
        $user_atv = Usuario_atividade::all();
        $users = User::all();
        $users_array[] = '';
        $data_atual = Carbon::now()->format('d-m-Y');
        
        $date =  (new Carbon($request->mes_relatorio))->format("m-y");
        $date_atual = (new Carbon($data_atual))->format("m-y");
        $i = 0;
        if ($date == $date_atual) {
            foreach ($atividades as $atividade) {
                $d1 = (new Carbon($atividade->data_inicio))->format("m-y");
                $d2 = (new Carbon($atividade->data_final))->format("m-y");
                if ( ($date == $d1) || ($date == $d2) ) {
                    $atividades_[$i] = $atividade;
                    $i++;
                }
            }
        }else{
            foreach ($atividades as $atividade){
                $d1 = (new Carbon($atividade->data_inicio))->format("m-y");
                $d2 = (new Carbon($atividade->data_final))->format("m-y");
                if ( ($date == $d1) || ($date == $d2) ) {
                    $atividades_[$i] = $atividade;
                    $i++;
                }
            }
        }

        //dd($atividades_);
        $users_names [] = '';
        
        $atividade_id = 0;
        $aux = 0;
        $k = 0;
       
        foreach ($atividades_ as $atividade) {
            foreach ($users as $user) {
                foreach ($user_atv as $atv) {
                    
                    if ($atv->atividade_de__risco_id == $atividade->id){
                       if ($user->id == $atv->user_id ) {
                            $users_names[$k] = $user->name;  
                       }else{
                        $atv++;
                        $k++;
                       } 
                    }else{
                        $atividade++;
                    }
                }
            }
        }
        $i = 0;
        foreach ($users as $user){
            $users_array[$i] = $user->name;
            $i++;
            
        }
        $array_COUNT [] = '';
        $array_COUNT = (array_count_values($users_names));
        //dd($array_COUNT);
        //dd($users_names);
        //array_shift($users_names);
        //dd($users_names);
        //dd($array_COUNT);
        //array_shift($array_COUNT);
        //dd($array_COUNT);
        $array_keys [] = '';
        $array_keys = array_keys($array_COUNT);
        //dd($array_keys);
        sort($array_keys);
        //dd($users_array);
        $user_count [] = '';
        $i = 0;
        $k = 0;
        $l= 0;
        $posiçoes [] = '';
        if (!(empty($array_keys))) {
            foreach ($users_array as $user){
                if(in_array($user,$array_keys)){
                    //echo($array_COUNT[$user]);
                    $user_count[$k] = $array_COUNT[$user];
                    $k++;
                }else{
                    $user_count[$k] = 0;
                    $k++;
                }
            }
        }else{
            for ($i=0; $i < count($users_array) ; $i++) { 
                $user_count[$i] = 0;
            }

        }
        
        //dd($array_keys);

        $dados_atv [] = '';
        $atividades_ap[] = new Atividade_de_Risco;
        $atividades_rp[] = new Atividade_de_Risco;
        $atividades_ag[] = new Atividade_de_Risco;

        $atividades_aprv = Atividade_de_Risco::where('situacao_aprv', '=',1)
        ->get();
        foreach ($atividades_aprv as $ap) {
            $d1 = (new Carbon($ap->data_inicio))->format("m-y");
            $d2 = (new Carbon($ap->data_final))->format("m-y");
            if ( ($date == $d1) || ($date == $d2) ) {
                $atividades_ap[$i] = $ap;
                $i++;
            }
        }
        //dd($atividades_ap);
        if (count($atividades_ap) >= 1) {
            //dd("aqui");
            //array_shift($atividades_ap);
            if ($atividades_ap[0]->id == null) {
                $dados_atv[0] = 0;
                //dd($atividades_ap);
            }else{
                
                $dados_atv[0] = count($atividades_ap);
            }
    
        }else{
            
            $dados_atv[0] = 0;
        }

        //dd($dados_atv[0]);
        //array_shift($atividades_ap);
        
        
        
        $atividades_rprv = Atividade_de_Risco::where('situacao_rprv', '=',1)
        ->get();
        $i = 0;
        foreach ($atividades_rprv as $rp) {
            $d1 = (new Carbon($rp->data_inicio))->format("m-y");
            $d2 = (new Carbon($rp->data_final))->format("m-y");
            if ( ($date == $d1) || ($date == $d2) ) {
                $atividades_rp[$i] = $rp;
                $i++;
            }
        }
        if (count($atividades_rp) >= 1) {
            //array_shift($atividades_rp);
            if ($atividades_rp[0]->id == null) {
                $dados_atv[1] = 0;
            }else{
                $dados_atv[1] = count($atividades_rp);
            }
        }else{
            $dados_atv[1] = 0;
        }
        //]
        //dd($dados_atv[1]);
       

        $atividades_agurdando = Atividade_de_Risco::where('situacao_aprv', '=',0)
        ->where('situacao_rprv' ,'=',0)
        ->get();
        $i = 0;
        foreach ($atividades_agurdando as $ag) {
            $d1 = (new Carbon($ag->data_inicio))->format("m-y");
            $d2 = (new Carbon($ag->data_final))->format("m-y");
            if ( ($date == $d1) || ($date == $d2) ) {
                $atividades_ag[$i] = $ag;
                $i++;
            }
        }
        if (count($atividades_ag) >= 1) {
            
            //array_shift($atividades_ag);
            //dd($atividades_ag);
            if ($atividades_ag[0]->id == null) {
                //dd($atividades_ag);
                $dados_atv[2] = 0;
            }else{
                $dados_atv[2] = count($atividades_ag);
            }
        }else{
            $dados_atv[2] = 0;
        }
       
        //dd($dados_atv[2]);

        $locais = Local::all();
        $locais_atv = Local_atividade::all();
        $locais_ []= '';
        $i=0;
        foreach ($locais_atv as $lo) {
            foreach ($atividades_ as $atv) {
                if ($atv->id == $lo->atividade_de__risco_id) {
                    $locais_[$i] = $lo->local_de_atividade_id;
                    $i++;
                }
            }
        }

        //dd($locais_); //id de locais com com atividades

        $array_COUNT_l [] = '';
        $array_COUNT_l = (array_count_values($locais_));
        
        $array_keys_l [] = '';
        $array_keys_l = array_keys($array_COUNT_l);
        sort($array_keys_l);
        //dd($array_COUNT_l); 
        //dd($array_keys_l);

        $i=0;
        $l_locais = array();
        $l_count = array();

        $nome_locais []='';
        $teste_locais = '';
        $id_locais [] = '';
        foreach ($locais as $l) {
            foreach ($array_keys_l as $l_key) {
                if ($l_key == $l->id) {
                    array_push($l_locais,$l->nome_local);
                    array_push($l_count,$array_COUNT_l[$l_key] );
                    //dd("aqui");
                }
            }
            $teste_locais .= $l->nome_local;
            $teste_locais .= ',';
            //$nome_locais[$i] .= $teste_locais;

            $id_locais[$i] = $l->id;
            $i++;
         
        }
        //dd($l_count);
        //dd($l_locais);
        //dd($teste_locais);

        /*$j = 0;
        $aux='';
        $searchString = " ";
        $replaceString = "";
        for ($i=0; $i < strlen($teste_locais); $i++) { 
            if ( ($teste_locais[$i]== ",")) {
                $aux = '';
                $j++;
            }else{
                $aux .= ($teste_locais[$i]);
                $k++;
                $nome_locais[$j] = $outputString = str_replace($searchString, $replaceString, $aux); 
            }
        }*/

        //dd($array_keys_l);

       /* $l_count []='';
        $i = 0;
        $k = 0;
        if (!(empty($array_keys_l))) {
            foreach ($id_locais as $id) {
                if(in_array($id,$array_keys_l)){
                    $l_count[$k] = $array_COUNT_l[$id];
                    $k++;
                }else{
                    $l_count[$k] = 0;
                    $k++;
                }
            }
        }else{
            for ($i=0; $i < count($id_locais) ; $i++) { 
                $l_count[$i] = 0;
            }
        }*/


        //dd($array_keys_l);

        return view('Relatorios', ['dados_atv' => $dados_atv,
         'user_count' => $user_count, 'users_array' => $users_array,
         /*'l_count' => $l_count,*/ 'nome_locais' => $nome_locais,'request' =>$request,
          'l_count' => $l_count, 'l_locais' => $l_locais]);
    }

    //Logica para o aprovador validar a atividade atraves do dashboard
    public function validar_atvs($id){
        $status = Auth()->user()->status;

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido!');
        }

        $atividade = Atividade_de_Risco::find($id);

        if ($atividade->situacao_aprv == 1) {
            return redirect('/Atividades')->with('msg1','Atividade ja foi Aprovada!');
        }

        if ($atividade->situacao_rprv == 1) {
            return redirect('/Atividades')->with('msg1','Essa Atividade foi reprovada não é possivel aprovar!');
        }

        $hashes = Hashes::all();
        $hash_aprv;
        $hash_rprv;

        $atividade->situacao_aprv = 1;
        $atividade->situacao_rprv = 0;
        $date = Carbon::now();
        $user_atvs = Usuario_atividade::all();
        $users = User::all();
        $atividade->data_situacao = $date;
        //$atividade->id_user_aprovacao = $aprovador_id;
        $atividade->save();

        $user_participantes [] = new User;;
        $users_mails [] ='';
        $i = 0;
        foreach ($user_atvs as $user_atv) {
            foreach ($users as $user) {
                if ( ($user->id == $user_atv->user_id) && ($atividade->id == $user_atv->atividade_de__risco_id)) {
                    $user_participantes[$i] = $user;
                    $users_mails[$i] = $user->email; 
                    $i++;
                }
            }
        }
        $details  = $users_mails;

        dispatch(new EnviarEmailUsers($details,$atividade,$user_participantes));

        return redirect('/Atividades')->with('msg2','Atividade APROVADA com Sucesso!');
    }

    //Logica para o aprovador reprovar a atividade atravea do dashboard
    public function reprovar_atvs($id){
        $status = Auth()->user()->status;
        $atividade = Atividade_de_Risco::find($id);

        if ($status != 1) {
            return redirect('/dashboard')->with('msg1','Status do Usuario não é valido!');
        }

        if ($atividade->situacao_aprv == 1) {
            return redirect('/Atividades')->with('msg1','Atividade ja foi Aprovada não é possivel reprovar!');
        }

        if ($atividade->situacao_rprv == 1) {
            return redirect('/Atividades')->with('msg1','Essa Atividade foi reprovada!');
        }


        $atividade->situacao_aprv = 0;
        $atividade->situacao_rprv = 1;
        $date = Carbon::now();
        $atividade->data_situacao = $date;
        //$atividade->id_user_aprovacao = $aprovador_id;
        $atividade->save();

        return view('motivo_rpv_dash', ['atividade' => $atividade]);
    }

    //As proximas 4 funções são para recuperar e mandar dados atraves de um pedido ajax
    public function ajaxRequestPost(Request $request){
        $term = $request->get('term');

        $users = User::where('name','LIKE', '%'. $term . '%')->get();

        $data = [];

        foreach ($users as $user){
            $data [] = [
                'label' => $user->name
            ];
        }

        return $data;
    }

    public function ajaxLocais(Request $request){
        $term = $request->get('term');

        $locais = Local::where('nome_local','LIKE','%'.$term .'%')->get();
        
        $data = [];

        foreach ($locais as $l){
            $data [] = [
                //'value' => $l->id,
                'label' => $l->nome_local, 
            ];
        }

        return $data;
    }

    public function ajaxAreas(Request $request){
        $term = $request->get('term');

        $areas = Area_Risco::where('nome_area','LIKE','%'.$term .'%')->get();
        
        $data = [];

        foreach ($areas as $a){
            $data [] = [
                'value' => $a->id,
                'label' => $a->nome_area, 
            ];
        }

        return $data;
    }

    public function ajaxNaturezas(Request $request){
        $term = $request->get('term');

        $naturezas = Natureza_atividade::where('nome_natureza','LIKE','%'.$term .'%')->get();
        
        $data = [];

        foreach ($naturezas as $n){
            $data [] = [
                'value' => $n->id,
                'label' => $n->nome_natureza, 
            ];
        }

      
        return $data;
    }
    // Fin dos pedidos ajax


   /* public function Listar_atividade_participante(){
        $atividades = Atividade_de_Risco::all();
        $atividades_ [] = new Atividade_de_Risco;
        $user_atvs = Usuario_atividade::all();
        $id = Auth()->user()->id;
        $i = 0;

        foreach ($atividades as $atividade) {
            foreach ($user_atvs as $user_atv) {
                if ( ($atividade->situacao_aprv == true) && ($user_atv->user_id == $id)) {
                    //dd('aqui');
                    if (($atividade->id == $user_atv->atividade_de__risco_id)) {
                        $atividades_[$i] = $atividade;
                        $i++;
                    }

                }
            }
        }
        //dd($atividades_);

        return view('Listar_Atv_participantes', compact('atividades_'));
    }

    public function Listar_atividade_proprietario(){
        $atividades = Atividade_de_Risco::all();
        //$users = User::all();
        $atividades_ [] = new Atividade_de_Risco;
        $id = Auth()->user()->id;
        $i = 0;

        foreach ($atividades as $atividade) {
            if ( ($atividade->situacao_aprv == true) && ($atividade->proprietario_id == $id) ) {
                $atividades_[$i] = $atividade;
                $i++;
            }
        }

        return view('Listar_Atv_proprietario', compact('atividades_'));
    }

    public function Listar_aprovadas(){
        $atividades = Atividade_de_Risco::all();
        $atividades_[] = new Atividade_de_Risco;
        $i = 0;
        $id = Auth()->user()->id;
        foreach ($atividades as $atividade){
            if ( ($atividade->situacao_aprv == 1) && ($atividade->id_user_aprovacao == $id)) {
                $atividades_[$i] = $atividade;
                $i++;
            }
        }

        return view('Listar_Atv_aprovadas', compact('atividades_'));
    }

    public function Listar_reprovadas(){
        $atividades = Atividade_de_Risco::all();
        $atividades_[] = new Atividade_de_Risco;
        $i = 0;
        $id = Auth()->user()->id;
        foreach ($atividades as $atividade){
            if ( ($atividade->situacao_rprv == 1) && ($atividade->id_user_aprovacao == $id)) {
                $atividades_[$i] = $atividade;
                $i++;
            }
        }

        return view('Listar_Atv_reprovadas', compact('atividades_'));
    }

    public function Listar_Atividades_pendentes(){
        $atividades = Atividade_de_Risco::all();
        $atividades_[] = new  Atividade_de_Risco;
        $user_atvs = Usuario_atividade::all();
        $id = Auth()->user()->id;
        $i = 0;
        foreach ($atividades as $atividade){
                if ( ($atividade->situacao_aprv == false) && ($atividade->situacao_rprv == false) ) {   
                    //dd($id); 
                    if (($atividade->proprietario_id == $id)) {
                        //dd($id);
                        $atividades_[$i] = $atividade;
                        $i++;
                    }

                }
    
        }

        //dd($atividades_);

        return view('Listar_Atv_pendentes', compact('atividades_'));
    }
        public function Listar_atividade_edit(){
        $atividades = Atividade_de_Risco::all();
        $atividades_ [] = new Atividade_de_Risco;
        $user_atvs = Usuario_atividade::all();
        $id = Auth()->user()->id;
        $i = 0;

        $locais = Local_atividade::all();
        $areas = Area_atividade::all();
        $naturezas = Natureza_de_atividade::all();


        foreach ($atividades as $atividade) {
            foreach ($user_atvs as $user_atv) {
                if ( ($atividade->situacao_aprv == false) && ($user_atv->user_id == $id) && ($atividade->id == $user_atv->atividade_de__risco_id) && ($atividade->situacao_rprv == true)) {
                    $atividades_[$i] = $atividade;
                    $i++;
                }
            }
        }
        $tam = count($atividades_) - 1;
 

        return view('Listar_atividade_edit', compact('atividades_','locais','areas', 'naturezas'));
    }
        public function Atividades_list($tipo){
        //$atividades = Atividade_de_Risco::all();
        //dd($tipo);
        $atividades = Atividade_de_Risco::all();
        $atividades_ = new Atividade_de_Risco;
        $user_atvs = Usuario_atividade::all();
        $id = Auth()->user()->id;
        $i = 0;

        

        if ($tipo == "Participantes") {
            
            foreach ($atividades as $atividade) {
                foreach ($user_atvs as $user_atv) {
                    if ( ($atividade->situacao_aprv == true) && ($user_atv->user_id == $id)) {
                        if (($atividade->id != $user_atv->atividade_de__risco_id)) {
                            //dd('aqui');
                            $atividades->forget($atividade->id);
                        }
    
                    }
                }
            }
            
            $atividades_ = $atividades;
            return  Datatables::of($atividades_)->make(true);
        }


        if ($tipo == "Atividades Reprovadas") {
                foreach ($atividades as $atividade) {
                        if ( ($atividade->situacao_aprv == 0)) {
                            $atividades->forget($atividade->id);
                            //$i++;
                        }
                    
                }
                $atividades_ = $atividades;
                //dd($atividades_);
                return  Datatables::of($atividades_)->make(true);

        }
        //return  Datatables::of($atividades)->make(true);
        //dd($atividades_);
        
        
        //return  Datatables::of($atividades_)->make(true);

    }
    */


}
