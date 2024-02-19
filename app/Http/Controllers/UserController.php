<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;
use App\Models\Job;
use GuzzleHttp\Client;
use App\SUtils\SPghUtils;
use App\User;
use App\Role;
use Validator;
use Redirect;

class UserController extends Controller
{
    private $attributeNames = array(
        'name' => 'Nombre',
        'apellidos' => 'Apellidos',
        'numEmpl' => 'Numero de empleado',
        'dept' => 'Departamento',
        'job' => 'Puesto',
        'email' => 'Email',
        'password' => 'Contraseña',

    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::where('is_delete',0)->get();
        $jobs = Job::where('is_delete',0)->get();
        $year = DB::table('config_years')->where('id_year',session()->get('id_year'))->get();
        return view('auth/register', ['departments' => $departments, 'jobs' => $jobs])->with('year',$year[0]->year);
    }

    public function createGlobal()
    {
        $json = '[{"id_global_user": 1,"username": "CARMONA FIGUEROA, EDWIN OMAR","employee_num": 990,"external_id": 3338, "email": "cesar.i@swaplicado.com.mx", "password": 1234}]';
        $departments = Department::where('is_delete',0)->get();
        $jobs = Job::where('is_delete',0)->get();
        $year = DB::table('config_years')->where('id_year',session()->get('id_year'))->get();
        $uGlobales = json_decode($json);
        $data = SPghUtils::loginToPGH();
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $data->token_type.' '.$data->access_token
        ];
        
        $client = new Client([
            'base_uri' => '127.0.0.1/GHPort/public/api/',
            'timeout' => 30.0,
            'headers' => $headers
        ]);   
        $body = '{"company":"8"}';
        $request = new \GuzzleHttp\Psr7\Request('GET', 'getPendingUser', $headers,$body);
        $response = $client->sendAsync($request)->wait();
        
        $jsonString = $response->getBody()->getContents();

        $uGlobales = json_decode($jsonString);  
        return view('user.createGlobal')->with('uGlobales',$uGlobales->data)->with('departments', $departments)->with('jobs', $jobs)->with('year',$year);      
    }

    function normalize ($string) {
        $table = array(
            'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
            'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
            'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
            'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
            'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
        );
       
        return strtr($string, $table);
    }

    public function makeUserName($name, $last_name){
        $name = strtolower($this->normalize($name));
        $last_name = strtolower($this->normalize($last_name));
        $nombres = explode(" ", $name);
        $apellidos = explode(" ", $last_name);
        $userName = null;

        for ($i=0; $i < sizeof($nombres) ; $i++) { 
            for ($j=0; $j < sizeof($apellidos); $j++) { 
                $userName = $nombres[$i].'.'.$apellidos[$j];
                if(User::where('name', $userName)->doesntExist()){
                    return $userName;
                }
            }
        }

        return null;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'numEmpl' => ['required', 'integer', 'unique:users,num_employee'],
            'dept' => ['required'],
            'job' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $userName = $this->makeUserName($request->name, $request->apellidos);
        
        if(is_null($userName)){
            $validator->errors()->add('name', 'No existe un usuario disponible para nombre y apellidos');
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $validator->setAttributeNames($this->attributeNames);
        $validator->validate();

        $success = true;
        $error = "0";
        try {
            DB::transaction(function () use ($request, $userName) {
                $user = User::create([
                    'name' => $userName,
                    'email' => $request->email,
                    'num_employee' => $request->numEmpl,
                    'department_id' => $request->dept,
                    'job_id' => $request->job,
                    'password' => Hash::make($request->password),
                    'do_evaluation' => 1,
                    'firt_name' => $request->name,
                    'last_name' => $request->apellidos,
                    'full_name' => $request->apellidos.', '.$request->name
                ]);

                $user->roles()->attach(Role::where('id_rol', 2)->first());
            });                
        } catch (QueryException $e) {
            $success = false;
        }

        if ($success) {
            $msg = "Se guardó el registro con éxito";
            $icon = "success";
        } else {
            $msg = "Error al guardar el registro Error: " . $error;
            $icon = "error";
        }

        return redirect(route('crear_user'))->with(['message' => $msg, 'icon' => $icon]);
    }

    public function storeGlobal(Request $request){
        try {
            $success = true;
            DB::transaction(function () use ($request,$success) {
                
                $user = User::create([
                    'name' => $request->fus,
                    'email' => $request->femail,
                    'num_employee' => $request->fnumEmpl,
                    'department_id' => $request->dept,
                    'job_id' => $request->job,
                    'password' => $request->fpass,
                    'do_evaluation' => 1,
                    'firt_name' => $request->fname,
                    'last_name' => $request->fapellidos,
                    'full_name' => $request->fapellidos.', '.$request->fname
                ]);

                $user->roles()->attach(Role::where('id_rol', 2)->first());
                //enviar el id del usuario a global data
                $data = SPghUtils::loginToPGH();
                if($data->status == 'success'){
                    $headers = [
                        'Content-Type' => 'application/json',
                        'Accept' => '*/*',
                        'Authorization' => $data->token_type.' '.$data->access_token
                    ];
                
                    $client = new Client([
                        'base_uri' => '127.0.0.1/GHPort/public/api/',
                        'timeout' => 30.0,
                        'headers' => $headers,
                    ]);
                
                    $body = json_encode(['user' => $user, 'id_global' => $request->fglobal, 'id_system' => '8']);
                    
                    $request = new \GuzzleHttp\Psr7\Request('POST', 'insertUserVsSystem', $headers, $body);
                    $response = $client->sendAsync($request)->wait();
                    $jsonString = $response->getBody()->getContents();
                    $data = json_decode($jsonString);
                    
                    if($data->status == 'success'){
                        DB::commit();
                    }else{
                        DB::rollBack();
                        throw new \Exception('Fallo');
                    }
                }else{
                    DB::rollBack();
                    throw new \Exception('Fallo');
                }
            });                
        } catch (\Throwable $th) {
            $success = false;
            DB::rollBack();
            $msg = "Error al guardar el registro";
            $icon = "error";
            return redirect(route('crear_global_user'))->with(['message' => $msg, 'icon' => $icon]);
        }
        if($success == true){
            $msg = "Se guardó el registro con éxito";
            $icon = "success";
            return redirect(route('crear_global_user'))->with(['message' => $msg, 'icon' => $icon]);
        }
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function editGlobal(){
        $year = DB::table('config_years')->where('id_year',session()->get('id_year'))->get();
        $user = DB::table('users')
                    ->where('id',auth()->id())
                    ->first();
        $rol = DB::table('user_rol')
                    ->where('user_id',auth()->id())
                    ->first();
        return view('user.updateGlobal')->with('user',$user)->with('year',$year)->with('rol',$rol);      
    }
    public function updateGlobal(Request $request){
        $success = true;
        try {
            if (! (\Hash::check($request->prevpass, \Auth::user()->password))) {
                $msg = "La contraseña anterior no concuerda con nuestros registros";
                $icon = "error";
                
                return redirect(route('editar_global_user'))->with(['message' => $msg, 'icon' => $icon]); 
            }
            if($request->newpass != $request->newpass1){
                $msg = "La nueva contraseña es diferente al campo confirmar contraseña";
                $icon = "error";
                
                return redirect(route('editar_global_user'))->with(['message' => $msg, 'icon' => $icon]);    
            }
            DB::transaction(function () use ($request) {
                $user = User::findOrFail($request->id_user);
                if($request->rol == 1){
                    $user->email = $request->email;
                    $user->name = $request->us;
                    $user->password = Hash::make($request->newpass);
                }else{
                    $user->password = Hash::make($request->newpass);
                }
                $user->save();

                if(isset($request->us)){
                    $user->username = $request->us;
                }else{
                    $user->username = $user->name;
                }
                $user->pass = Hash::make($request->newpass);  
                
                
                //enviar el id del usuario a global data
                $data = SPghUtils::loginToPGH();
                if($data->status == 'success'){
                    $headers = [
                        'Content-Type' => 'application/json',
                        'Accept' => '*/*',
                        'Authorization' => $data->token_type.' '.$data->access_token
                    ];
                
                    $client = new Client([
                        'base_uri' => '127.0.0.1/GHPort/public/api/',
                        'timeout' => 30.0,
                        'headers' => $headers,
                    ]);
                
                    $body = json_encode(['user' => $user, 'fromSystem' => '8']);
                    
                    $request = new \GuzzleHttp\Psr7\Request('POST', 'updateGlobalPassword', $headers, $body);
                    $response = $client->sendAsync($request)->wait();
                    $jsonString = $response->getBody()->getContents();
                    $data = json_decode($jsonString);

                    if($data->status == 'success'){
                        DB::commit();
                    }else{
                        DB::rollBack();
                        throw new \Exception('Fallo');
                    }
                }else{
                    DB::rollBack();
                    throw new \Exception('Fallo');
                }

            });                
        } catch (\Throwable $th) {
            $success = false;
            DB::rollBack();
            $msg = "Error al guardar el registro";
            $icon = "error";
            return redirect(route('editar_global_user'))->with(['message' => $msg, 'icon' => $icon]);
        }
        if($success == true){
            $msg = "Se guardó el registro con éxito";
            $icon = "success";
            return redirect(route('editar_global_user'))->with(['message' => $msg, 'icon' => $icon]);
        }
           
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function change(){
        $id = auth()->id();
        $data = User::find($id);
        $year = DB::table('config_years')->where('id_year',session()->get('id_year'))->get();
        return view('user.changePassword', compact('data'))->with('year',$year[0]->year);   
    }

    public function updatePassword(Request $request, $id){
        $data = User::find($id);
        $data->password = bcrypt($request->password);
        $data->updated_by = session()->get('user_id');
        $data->save();
        return redirect('user/change')->with('mensaje','Contraseña fue actualizada con éxito');
    }
}
