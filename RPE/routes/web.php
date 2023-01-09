<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Usercontroller;
use App\Http\Controllers\DashboardController;




//login
Route::get('/', [Usercontroller::class, 'index'])->name('login');
Route::post('Auth',[Usercontroller::class, 'login'])->name('auth.user');
Route::get('/logout', [Usercontroller::class, 'logout'])->name('logout.user');

//Dashboard
route::get('/dashboard',[DashboardController::class,'index']);

//usuario
route::get('/registro',[DashboardController::class,'registro_usuario']);
route::post('/registro/registrar',[DashboardController::class,'registrar_usuario'])->name('registro.user');

//local
route::get('/registro_local',[DashboardController::class,'registro_local']);
route::post('/registro_local/registrar',[DashboardController::class,'registrar_local'])->name('registro.local');

//natureza
route::get('/registro_Natureza_atividade',[DashboardController::class,'registro_natureza']);
route::post('/registro_Natureza_atividade/registrar',[DashboardController::class,'registrar_natureza'])->name('registro.natureza');

//area
route::get('/registro_area',[DashboardController::class,'registro_Area']);
route::post('/registro_area/registrar',[DashboardController::class,'registrar_Area'])->name('registro.area');

//atividade
route::get('/registro_atividade',[DashboardController::class,'registro_atividade']);
route::post('/registro_atividade/registrar',[DashboardController::class,'registrar_atividade'])->name('registro.atividade');

//listar
route::get('/Areas',[DashboardController::class,'Listar_areas']);
route::get('/Locais',[DashboardController::class,'Listar_locais']);
route::get('/Naturezas',[DashboardController::class,'Listar_naturezas']);
route::get('/Atividades_Participante',[DashboardController::class,'Listar_atividade_participante']);
route::get('/Atividades_Proprietario',[DashboardController::class,'Listar_atividade_proprietario']);
route::get('/Usuarios',[DashboardController::class,'Listar_usuarios']);
route::get('/Atividades_aprv',[DashboardController::class,'Listar_aprovadas']);
route::get('/Atividades_rprv',[DashboardController::class,'Listar_reprovadas']);
route::get('/Logs',[DashboardController::class,'Listar_logs']);
route::get('/Atividades_pendentes',[DashboardController::class,'Listar_Atividades_pendentes']);


//rota de aprovaçao
route::get('/validacao/{flag}/{id}',[DashboardController::class,'Validar_Atividade']);
route::get('/reprovar/{flag}/{id}',[DashboardController::class,'Reprovar_Atividade']);
route::any('/motivo_reprovacao/{id}',[DashboardController::class,'Motivo_reprovacao'])->name('registro.motivo');
route::get('validacao_resultado', function(){
    return view('validacao');
});

//reenviar mail
route::get('/reenviar_mail/{id}',[DashboardController::class,'Reenviar_mail']);

//editar
route::get('/Editar_atividades',[DashboardController::class,'Listar_atividade_edit']);
route::get('/Editar_atividade/{id}',[DashboardController::class,'Editar_atividade']);
route::put('/Editar_atividade/editar',[DashboardController::class, 'atualizar_atividade'])->name('editar.atividade');

//editar usuario
route::get('/Editar_usuarios',[DashboardController::class,'Listar_usuarios_edit']);
route::get('/Editar_usuario/{id}',[DashboardController::class,'Editar_usuario']);
route::put('/Editar_usuarios/editar',[DashboardController::class, 'atualizar_usuario'])->name('editar.usuario');

//pdfs
route::get('/pdf_minhas_atividades',[DashboardController::class,'pdf_atividades_view']);
route::post('/pdf_atividades',[DashboardController::class,'gerar_pdf_atividades'])->name('gerar.pdf');

route::post('/pdf_atividades_usuarios',[DashboardController::class,'gerar_pdf_atividades_usuarios'])->name('gerar.pdf.users');


//route::get('/pdf_minhas_atividades_download',[DashboardController::class,'gerar_pdf_atividades_down']);
//route::any('/pdf_ativdades_aprovadas',[DashboardController::class,'gerar_pdf_aprovadas']);
//route::get('/pdf_atividades_reprovadas',[DashboardController::class,'gerar_pdf_reprovadas']);

//relatorios
route::any('/relatorios',[DashboardController::class,'relatorios_view'])->name('mostrar.relatorios');

//route::get('/Atividades',[DashboardController::class,'Atividades']);

//Route::get('fetch_atvs/{tipo}', [DashboardController::class, 'Atividades_list']);

Route::any('/Atividades', [DashboardController::class, 'Atividades'])->name('filtrar.Atv');


//ajax
Route::get('users_names', [DashboardController::class, 'ajaxRequestPost'])->name('users.names');
Route::get('locais_names', [DashboardController::class, 'ajaxLocais'])->name('locais.names');
Route::get('areas_names', [DashboardController::class, 'ajaxAreas'])->name('areas.names');
Route::get('naturezas_names', [DashboardController::class, 'ajaxNaturezas'])->name('naturezas.names');



Route::get('validar_atv/{id}',[DashboardController::class, 'validar_atvs']);

Route::get('reprovar_atv/{id}',[DashboardController::class, 'reprovar_atvs']);


route::get('/teste',function(){
    return view("teste");
});