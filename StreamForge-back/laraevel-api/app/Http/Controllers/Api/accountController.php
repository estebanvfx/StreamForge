<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Validator;
use Monolog\Handler\IFTTTHandler;

class accountController extends Controller
{
    public function index(){
        
        $accounts = Account::all();

        if(!$accounts->isEmpty()){
            $data = [
                'results' => $accounts,
                'status' => 200
           ];
           
        }else{
            $data = [
                'message' => 'No se encontraron cuentas',
                'status' => 200
           ];
        }

        return response()->json($data, 200);
    }


    //funcion para agregar informacion
    public function store(Request $request){
        // Validar los datos recibidos en la solicitud
        $validator = Validator::make($request->all(), [
            'account_email' => 'required|email',
            'account_password' => 'required',
            'account_type' => 'required|in:iheart,tidal'
        ]);
    
        // Comprobar si la validación falla
        if($validator->fails()){
            // Preparar los datos para la respuesta JSON
            $data = [
                'message' => 'Error en la validacion de datos, falta informacion por enviar',
                'errors' => $validator->errors(),
                'status' => 200
            ];
            // Retornar una respuesta JSON con los errores de validación
            return response()->json($data, 200);
        }
    
        // Crear una nueva cuenta utilizando los datos recibidos
        $account = Account::create([
            'account_email' => $request->account_email,
            'account_password' => $request->account_password,
            'account_type' => $request->account_type
        ]);
    
        // Verificar si la cuenta se creó correctamente
        if($account){
            // Preparar los datos para la respuesta JSON
            $data = [
                'message' => $account,
                'status' => 201
            ];
            // Retornar una respuesta JSON con el mensaje y el código de estado 201 (creado)
            return response()->json($data, 201);
        }else{
            // Si la cuenta no se creó correctamente, preparar los datos para la respuesta JSON
            $data = [
                'message' => 'Error al almacenar la informacion',
                'status' => 500
            ];
            // Retornar una respuesta JSON con el mensaje y el código de estado 500 (error interno del servidor)
            return response()->json($data, 500);
        }        
    }

    public function show($id){
        $account_find = Account::find($id);

        if(!$account_find){
            $data = [
                'message' => 'Cuenta no encontrada',
                'status' => 200
            ];
        }else{
            $data = [
                'results' => $account_find,
                'status' => 200
            ];
        }
        
        return response()->json($data, 200);
    }


    public function destroy($id){
        $account_find = Account::find($id);

        if($account_find){
            $account_find->delete();
            $data = [
                'message' => 'Cuenta eliminada',
                'status' => 200
            ];
        }else{
            $data = [
                'message' => 'No se encontra la cuenta'
            ];
        }
        return response()->json($data, 200);
    }

    public function update(Request $request ,$id){
        $account_find = Account::find($id);
        if($account_find){
            $validatios = Validator::make($request->all(), [
                'account_email' => 'required|email',
                'account_password' => 'required',
                'account_type' => 'required|in:iheart,tidal'
            ]);

            if($validatios->passes()){
                $account_find->account_email = $request->account_email;
                $account_find->account_password = $request->account_password;
                $account_find->account_type = $request->account_type;


                $account_find->save();

                $data = [
                    'message' => 'La informaicon se actualizo',
                    'status' => 'success'
                ];
                return response()->json($data, 200);

            }else{
                $data = [
                    'erros' => $validatios->errors(),
                    'status' => 200
                ];
                return response()->json($data, 200);
            }
        }else{
            $data = [
                'message' => 'Cuenta no encontrada',
                'status' => 404
            ];
            return response()->json($data, 401);
        }
    }
} 
 