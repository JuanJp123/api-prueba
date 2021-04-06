<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Usuario;
Use App\Models\DatoUsuario;
class registroController extends Controller
{
   private $rol_default =7;
    public function verificar(Request $request)
    {
        if(!is_numeric($request->telefono)) {
            return response()->json(['telefono' => 'El teléfono debe ser completamente numérico'], 422);
        }

        if( empty($request->terminos) ) {
            return response()->json(['terminos' => 'Acepta los términos y condiciones y políticas de privacidad'], 422);
        }

        if ( empty($request->nombre) || empty($request->apellidos) || empty($request->email) || empty($request->objetivo) || empty($request->departamento) || empty($request->telefono) ) {
            return response()->json( 'Error', 422);
        }
        $verificarTelefono = Usuario::where([
            ['telefono', $request->telefono],
            ['eliminado', null],
        ])->first();

        if($verificarTelefono) {
            return response()->json(['telefono' => 'El teléfono ingresado ya se encuentra en uso'], 422);
        }

        if( $request->token === 'si') {

            $token = md5(time());
            $token = substr( $token, 0, 8);

            return response()->json($token, 200);

        } else {
            return response()->json('Todo correcto', 200);
        }
    }
    public function registrarUsuario(Request $request)
    {

        try {

            $objetivos = $this->getObjetivos( $request->objetivo );

            $referido_por = ( !empty($request->referido) ) ? $request->referido : 'SEV';

            $telefono = str_replace(['+57', ' ', '-', '_'], '', $request->telefono);


            $usuario = Usuario::create([
                'email'           => $request->email,
                'roles_id'        =>  $this->rol_default,
                'tipo'            => 'Registro directo',
                'uid'             => $request->uid,
                'telefono'        => $telefono,
                'cambio_password' => 0,
                'referido'        => $referido_por
            ]);

            $fecha = $usuario->created_at; //extraemos la fecha
            $fecha = $fecha->toDateString(); //la pasamos a formato de string
            $fecha = explode("-", $fecha); //dividimos en un vector el año-mes-dia
            $fecha = $fecha[1];//guardamos solo el mes en la fecha
            $codigoReferido = $fecha . $usuario->id; //creamos el codigo de referido concatenando

            $usuario->codigo_para_referir = $codigoReferido;
            $usuario->save();

            DatoUsuario::create([
                'nombre'              => $request->nombre,
                'apellidos'           => $request->apellidos,
                'tipos_documentos_id' => $request->tipo_documento,
                'numero_documento'    => $request->documento,
                'departamento'        => $request->departamento,
                'objetivos'           => $objetivos,
                'usuarios_id'         => $usuario->id
            ]);

            $otros_datos = [
                'nombre'           => $request->nombre,
                'apellidos'        => $request->apellidos,
                'email'            => $request->email,
                'empresa'          => $request->empresa,
                'tipo_documento'   => $request->tipo_documento,
                'documento'        => $request->documento,
                'departamento'     => $request->departamento,
                'roles_id'         => $this->rol_default,
                'tipo'             => 'Registro directo',
                'uid'              => $request->uid,
                'telefono'         => $request->telefono,
                'objetivos'        => $objetivos,
                'password'         => $request->password,
                'codigo'           => $codigoReferido,
                'link'             => 'https://subastaenvivo.com/sev-registro?referido=' . $codigoReferido,
                'referido'         => $referido_por,
                'mensaje_whatsapp' => ""
            ];

            return response()->json([
                'codigo'  => 200,
                'mensaje' => 'usuario creado',
                'detalle'  => [
                    'El usuario ha sido creado correctamente'
                ]
            ]);

        }catch (\Exception $e) {
            return response()->json([
                'codigo'  => 422,
                'mensaje' => 'Error al crear el usuario: ' . $e->getMessage(),
                'errors'  => [
                    'No se pudo crear el usuario'
                ]
            ], 422);

        }

    }
    public function getObjetivos( $objetivos )
    {

        if( is_array( $objetivos ) ) {

            $texto = '';

            for($i = 0; $i < count( $objetivos); $i++ ) {
                $texto .= ( $i < (count( $objetivos) - 1 ) ) ? $objetivos[$i] . ', ' : $objetivos[$i];
            }

            return $texto;

        } else {
            return $objetivos;
        }

    }
}
