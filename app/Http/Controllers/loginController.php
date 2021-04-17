<?php

namespace App\Http\Controllers;
Use App\Models\Usuario;
Use App\Models\Finca;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
class loginController extends Controller
{
    public function me()
    {
        return response()->json(auth()->user());
    }
    
    public function iniciarSesionConEmail(Request $request)
    {

        $usuario = Usuario::where([
            'email'     => $request->email,
            'eliminado' => null,
            'uid'       => $request->uid
        ])->first();

        if( empty($usuario)) {
            return response()->json([
                'errors' => [
                    'email' => [
                        'El usuario no ha sido localizado'
                    ]
                ]
            ], 422);
        }

        if (! $token = auth('api')->login( $usuario ) ) {
            return response()->json([
                'codigo'  => 423,
                'mensaje' => 'El usuario o contraseña es incorrecto',
                'errors'  => [
                    'No autorizado'
                ]
            ], 422);
        }

        $tipo = 'Correo electronico y Contraseña';
        if($request->google==1){
            $tipo = 'Google';
        }
//        $this->registrarInicioSesion($usuario->id,$tipo);
        return $this->respondWithToken($token);

    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token'      => $token,
            'usuario'           => $this->guard()->user(),
            'nombre_usuario'    => $this->guard()->user()->nombreCompleto(),
            'token_type'        => 'bearer',
            'expires_in'        => auth('api')->factory()->getTTL() * 4440,
            'cambio_clave'      => $this->guard()->user()->cambio_password,
            'permisos'          => $this->guard()->user()->rol->permisos()->pluck('nombre_permiso')->toArray(),
            'registro_completo' => $this->guard()->user()->registro_completo,
           'estado_verificacion' => $this->guard()->user()->verificacion->estados_verificaciones_id,
         'numero_paleta'       => $this->guard()->user()->accesoSubasta->numero_paleta
        ]);
    }
    public function guard()
    {
        return Auth::guard('api');
    }
    public function index(Request $request)
    {
     
        return Finca::where('user_id', Auth::guard('api')->user()->id)->get();

        
    }
}
