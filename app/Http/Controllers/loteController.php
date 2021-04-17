<?php

namespace App\Http\Controllers;

use App\Models\LoteInfo;
use Illuminate\Http\Request;
use App\Models\Razas;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Vimeo\Laravel\Facades\Vimeo;

class loteController extends Controller
{
    public function productos(Request $request)
    {



             return  Producto::all();



    }
    public function razas(Request $request)
    {



             return  Razas::all();



    }
    public function crear(Request $request)
    {



        $validarDatos = Validator::make($request->all(), [
            'producto'    => 'required|numeric',
            'cantidad'    => 'required|numeric',
            'procedencia' => 'required',
            'raza_o_cruce' => 'required',
        ]);
        if( $validarDatos->fails() ) {
           return response()->json([
                'estado' => 456,
                'mensaje' => 'Error en formulario',
                'detalle' => $validarDatos->getMessageBag()->toArray()
            ], 422);



        }
        $user_id=Auth::guard('api')->user()->id;

        $loteInfo = LoteInfo::create([
            'productos_id'           => $request->producto,
            'cantidad'               => $request->cantidad,
            'lotes_procedencia_id'   => $request->procedencia,
            'observaciones'          => $request->observaciones,
            'video'                  => $request->video,
            'usuarios_id'            => Auth::guard('api')->user()->id,
            'edad'                   => $request->edad,
            'peso_promedio'          => $request->peso_promedio,
            'raza_o_cruce'           => $request->raza_o_cruce,

        ]);
$loteInfo->numero_oferta=$loteInfo->id.$user_id;
$loteInfo->save();
        return response()->json([
        'estado' => 200,
        'mensaje' => 'Lote creado',
        'detalle' => [
            'lote' => [
                'id' => $loteInfo->id
            ]
        ]
    ], 200);



    }
    public function subirVideo(Request $request){
    $validarVideo = Validator::make($request->all(),[
        'video'=>'required|file',
    ]);
    if($validarVideo->fails()){
        return response()->json(['error',422]);
    }
  try{
$file = $request->file('video');
$extension = $file ->getClientOriginalExtension();
$time = time();
$nombre= 'video-subasta-'. $time . '.' . $extension;

$response = Vimeo::upload($file->getRealPath(),[
    "privacy"=>[
        "view"=>"unlisted"
    ],
    "name"   => $nombre,
    "description" => "Video Subasta en vivo",
]);
$idVideo = str_replace('/videos/','',$response);
Vimeo::request('/users/116903467/projects/2143519/videos/' . $idVideo, [], 'PUT');

  }catch(\Exception $exception){
      return response()->json([
          'estado'=>456,
          'mensaje'=>'Error al subir el video',
          'detalle'=>['No se puede procesar la solicitud']
      ],422);
  }
    return $idVideo;

    }

}
