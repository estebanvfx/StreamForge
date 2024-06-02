<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MusicUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Empty_;
use PHPUnit\Framework\Constraint\IsEmpty;

class MusicUrlController extends Controller
{
    public function index(){

        $music_url = MusicUrl::all();

        if(!$music_url->isEmpty()){
            $data = [
                'results' => $music_url,
                'status' => 'success'
            ];
            return response()->json($data, 200);
        }else{
            return response()->json('No hay datos', 200);
        }
    }


    public function store(Request $request){
        $validation =  Validator::make($request->all(), [
            'url' => 'required',
            'url_type' => 'required'
        ]);

        if($validation->passes()){
            $url_create = MusicUrl::create([
                'url' => $request->url,
                'url_type' => $request->url_type
            ]);

            if($url_create){
                $data = [
                    'message' => 'Url creada con exito',
                    'status' => 'success'
                ];
            }else{
                $data = [
                    'message' => 'Algo fallo al crear la URL',
                ];
                return response()->json($data, 404);
            }
        }else{
            $data = [
                'message' => 'Falta informacion, llenala :)',
                'errors' => $validation->errors(),
                'status' => 'fail'
            ];
        }
        return response()->json($data, 200);
    }



    public function update(Request $request, $id){
        $account_find = MusicUrl::find($id);

        #return $account_find;

        if($account_find){
            $validation = Validator::make($request->all(), [
                'url' => 'required',
                'url_type' => 'required'
            ]);

            if($validation->passes()){
                $account_find->url = $request->url;
                $account_find->url_type = $request->url_type;
                

                if($account_find->save()){
                    $data = [
                        'message' => 'La informacion se actualizo',
                        'status' => 'success'
                    ];
                }else{
                    $data = [
                        'message' => 'Error al actualizar la informacion',
                        'status' => 'fail'
                    ];
                }
            }else{
                $data = [
                    'message' => 'Falta informacion por llenar',
                    'errors' => $validation->errors(),
                    'status' => 'success'
                ];
            }
        }else{
            $data = [
                'message' => 'No se encontro una url',
                'status'=> 'fail'
            ];
        }
        return response()->json($data, 200);
    }



    public function indexType($type_music){
        if(!($type_music == "iheart" || $type_music == "tidal")){
            $data = [
                'message' => 'Ingresa un type-music valido',
                'status' => 'fail'
            ];
       }else{
           $type_url = MusicUrl::where('url_type', $type_music)->get();
            $data = [
                'results' => $type_url,
                'status' => 'success'
            ];
       }
        return response()->json($data, 200);
    }
}
