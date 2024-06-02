<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TempAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\accountController;
use App\Models\Account;
use Illuminate\Support\Facades\Validator;


class TempAccountController extends Controller
{
    //funcion para obtener todo
    public function index(){
        $accounts = TempAccount::All();

        if(!$accounts->isEmpty()){
            $data = [
                'results' => $accounts,
                'status' => 200
           ];
           
        }else{
            $data = [
                'message' => 'No se encontraron cuentas',
                'status' => '200'
           ];
        }

        return response()->json($data, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'account_email' => 'required|email',
            'account_password' => 'required',
            'account_type' => 'required|in:iheart,tidal'
        ]);

        if(!$validator->fails()){
            $account = TempAccount::create([
                'account_email' => $request->account_email,
                'account_password' => $request->account_password,
                'account_type' => $request->account_type
            ]);

            if($account){
                $data = [
                    'message' => 'Se agrego la cuenta',
                    'status' => 'success'
                ];
            }
        }else{
            $data = [
                'message' => 'No se puede agregar la cuenta',
                'errors' => $validator->errors(),
                'status' => 'fail'
            ];
        }
        return response()->json($data, 200);
    }

    public function show($id){                                                                                                                                                                                                                                    
        $account = TempAccount::find($id);

        
        if($account){
            $accountController = new accountController();

            $data = [
                'message' => $account,
                'status' => 'Success'
            ];
            
            $request = new Request([
                'account_email' => $account->account_email,
                'account_password' => $account->account_password,
                'account_type' => $account->account_type
            ]);

            $response = $accountController->store($request);

            $account->delete();

            $data = [
                'result' => $response,
                'status' => 'Success'
            ];
        }else{
            $data = [
                'message' => 'No se encontro una cuenta con ese id',
                'status' => 'Error'
            ];
        }
        return response()->json($data, 200);
    }
}
