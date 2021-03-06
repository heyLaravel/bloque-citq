<?php

namespace App\Http\Controllers;

use App\cultivo;
use App\Http\Requests\siembraPlantulaRequest;
use App\invernaderoPlantula;
use App\siembraPlantula;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class siembraPlantulaController extends Controller
{
    public function  __construct()
    {
        //se valida que no este logueado
        if(!Auth::check() ){
            $this->middleware('auth');
        }
        else {
            //Si esta logueado entonces se revisa el permiso
            if (Auth::user()->can('invernaderoplantula'))
            {
            }
            else {
                //Si no tiene el permiso entonces cierra la sesion y manda un error 404
                //Auth::logout();
                abort('404');
            }
        }
    }
    /**
     * Metodo para ver la pagina inicial de siembra invernadero de plántula
     *
     *
     */
    public function index()
    {
        //
        $now= Carbon::now()->format('Y/m/d');
        $now = $now. " 23:59:59";
        $now2 =Carbon::now()->subMonth(6)->format('Y/m/d');
        $siembras = siembraPlantula::orderBy('fecha', 'desc')->paginate(15);
        $this->adaptaFechas($siembras);
        $invernaderos= invernaderoPlantula::select('id','nombre')->orderBy('nombre', 'asc')->get();
        $cultivos= cultivo::select('id','nombre')->orderBy('nombre', 'asc')->get();

        return view('Plantula/Siembra/buscar')->with([
            'invernaderos' => $invernaderos,
            'cultivos' => $cultivos,
            'siembras'=> $siembras,
        ]);
    }

    /*Metodo de Busqueda
    *
    * */
    public function buscar(Request $request){
        $invernaderos= invernaderoPlantula::select('id','nombre')->orderBy('nombre', 'asc')->get();
        $cultivos= cultivo::select('id','nombre')->orderBy('nombre', 'asc')->get();

        /*Ahi se guardaran los resultados de la busqueda*/
        $siembras =null;

        $validator = Validator::make($request->all(), [
            'fechaInicio' => 'date_format:d/m/Y',
            'fechaFin' => 'date_format:d/m/Y',
            'invernadero' => 'exists:invernaderoPlantula,id',
            'cultivo' => 'exists:cultivo,id',
            'status'=>'in:Activo,Terminado',
        ]);

        /*Si validador no falla se pueden realizar busquedas*/
        if ($validator->fails()) {

        }
        else {

            /*Busqueda sin parametros*/
            if ($request->fechaFin == "" && $request->fechaInicio == "" && $request->invernadero == "" && $request->cultivo == "" && $request->status == "") {
                $siembras  = siembraPlantula::orderBy('fecha', 'desc')->paginate(15);;
            }

            /*Busqueda solo con invernadero*/
            if ($request->fechaFin == "" && $request->fechaInicio == "" && $request->invernadero != "" && $request->cultivo == "" && $request->status == "") {
                $siembras  = siembraPlantula::where('id_invernadero', $request->invernadero)->orderBy('fecha', 'desc')->paginate(15);;

            }

            /*Busqueda solo con cultivo*/
            if ($request->fechaFin == "" && $request->fechaInicio == "" && $request->invernadero == "" && $request->cultivo != "" && $request->status == "") {
                $siembras  = siembraPlantula::where('id_cultivo', $request->cultivo)->orderBy('fecha', 'desc')->paginate(15);;
            }

            /*Busqueda solo con status*/
            if ($request->fechaFin == "" && $request->fechaInicio == "" && $request->invernadero == "" && $request->cultivo == "" && $request->status != "") {
                $siembras  = siembraPlantula::where('status', $request->status)->orderBy('fecha', 'desc')->paginate(15);;
            }

            /*Busqueda solo con invernadero y cultivo*/
            if ($request->fechaFin == "" && $request->fechaInicio == "" && $request->invernadero != "" && $request->cultivo != "" && $request->status == "") {
                $siembras  = siembraPlantula::where('id_invernadero', $request->invernadero)->where('id_cultivo', $request->cultivo)->orderBy('fecha', 'desc')->paginate(15);
            }

            /*Busqueda solo con invernadero y status*/
            if ($request->fechaFin == "" && $request->fechaInicio == "" && $request->invernadero != "" && $request->cultivo == "" && $request->status != "") {
                $siembras  = siembraPlantula::where('id_invernadero', $request->invernadero)->where('status', $request->status)->orderBy('fecha', 'desc')->paginate(15);
            }

            /*Busqueda solo con cultivo y status*/
            if ($request->fechaFin == "" && $request->fechaInicio == "" && $request->invernadero == "" && $request->cultivo != "" && $request->status != "") {
                $siembras  = siembraPlantula::where('id_cultivo', $request->cultivo)->where('status', $request->status)->orderBy('fecha', 'desc')->paginate(15);
            }

            /*Busqueda con invernadero, cultivo y status*/
            if ($request->fechaFin == "" && $request->fechaInicio == "" && $request->invernadero != "" && $request->cultivo != "" && $request->status != "") {
                $siembras  = siembraPlantula::where('id_invernadero', $request->invernadero)->where('id_cultivo', $request->cultivo)->where('status', $request->status)->orderBy('fecha', 'desc')->paginate(15);
            }

            /*Pregunta si se mandaron fechas, en caso contrario manda error 404*/
            if ($request->fechaFin != "" && $request->fechaInicio != "") {

                /*Transforma fechas en formato adecuado*/
                $fecha = $request->fechaInicio . " 00:00:00";
                $fechaInf = Carbon::createFromFormat("d/m/Y H:i:s", $fecha);
                $fecha = $request->fechaFin . " 23:59:59";
                $fechaSup = Carbon::createFromFormat("d/m/Y H:i:s", $fecha);

                /*Hay 8 posibles casos de busqueda, cada if se basa en un caso */
                /*Busqueda sin parametros*/
                if ($request->invernadero == "" && $request->cultivo == "" && $request->status == "") {
                    $siembras  = siembraPlantula::whereBetween('fecha', array($fechaInf, $fechaSup))->orderBy('fecha', 'desc')->paginate(15);;
                }

                /*Busqueda solo con invernadero*/
                if ($request->invernadero != "" && $request->cultivo == "" && $request->status == "") {
                    $siembras  = siembraPlantula::where('id_invernadero', $request->invernadero)->whereBetween('fecha', array($fechaInf, $fechaSup))->orderBy('fecha', 'desc')->paginate(15);;

                }

                /*Busqueda solo con cultivo*/
                if ($request->invernadero == "" && $request->cultivo != "" && $request->status == "") {
                    $siembras  = siembraPlantula::where('id_cultivo', $request->cultivo)->whereBetween('fecha', array($fechaInf, $fechaSup))->orderBy('fecha', 'desc')->paginate(15);;
                }

                /*Busqueda solo con status*/
                if ($request->invernadero == "" && $request->cultivo == "" && $request->status != "") {
                    $siembras  = siembraPlantula::where('status', $request->status)->whereBetween('fecha', array($fechaInf, $fechaSup))->orderBy('fecha', 'desc')->paginate(15);;
                }

                /*Busqueda solo con invernadero y cultivo*/
                if ($request->invernadero != "" && $request->cultivo != "" && $request->status == "") {
                    $siembras  = siembraPlantula::where('id_invernadero', $request->invernadero)->where('id_cultivo', $request->cultivo)->whereBetween('fecha', array($fechaInf, $fechaSup))->orderBy('fecha', 'desc')->paginate(15);
                }

                /*Busqueda solo con invernadero y status*/
                if ($request->invernadero != "" && $request->cultivo == "" && $request->status != "") {
                    $siembras  = siembraPlantula::where('id_invernadero', $request->invernadero)->where('status', $request->status)->whereBetween('fecha', array($fechaInf, $fechaSup))->orderBy('fecha', 'desc')->paginate(15);
                }

                /*Busqueda solo con cultivo y status*/
                if ($request->invernadero == "" && $request->cultivo != "" && $request->status != "") {
                    $siembras  = siembraPlantula::where('id_cultivo', $request->cultivo)->where('status', $request->status)->whereBetween('fecha', array($fechaInf, $fechaSup))->orderBy('fecha', 'desc')->paginate(15);
                }

                /*Busqueda con invernadero, cultivo y status*/
                if ($request->invernadero != "" && $request->cultivo != "" && $request->status != "") {
                    $siembras  = siembraPlantula::where('id_invernadero', $request->invernadero)->where('id_cultivo', $request->cultivo)->where('status', $request->status)->whereBetween('fecha', array($fechaInf, $fechaSup))->orderBy('fecha', 'desc')->paginate(15);
                }
            }
        }

        if($siembras!=null){
            /*Adapta el formato de fecha para poder imprimirlo en la vista adecuadamente*/
            $this->adaptaFechas($siembras);

            /*Si no es nulo puede contar los resultados*/
            $num = $siembras->total();
        }
        else{
            $num=0;
        }

        if ($num <= 0) {
            Session::flash('error', 'No se encontraron resultados');

        } else {
            Session::flash('message', 'Se encontraron ' . $num . ' resultados');
        }

        /*Regresa la vista*/
        return view('Plantula/Siembra/buscar')->with([
            'invernaderos' => $invernaderos,
            'cultivos' => $cultivos,
            'siembras'=> $siembras,
        ]);

    }

    /*Devuelve la vista de crear con los valores de los combobox*/
    public function pagCrear()
    {
        $invernadero = invernaderoPlantula::select('id', 'nombre')->first();
        $invernaderos= invernaderoPlantula::select('id','nombre')->orderBy('nombre', 'asc')->get();
        $cultivos = cultivo::select('id','nombre')->orderBy('nombre', 'asc')->get();
        $contenedores = ['Maceta (1L)', 'Maceta (0.5L)', 'Maceta (0.25L)', 'Charola - Plástico', 'Charola - Unicel'];
        $destinos = ['Campo', 'Invernadero'];
        $tipoStatus = ['Activo', 'Terminado'];

        return view('Plantula/Siembra/crear')->with([
            'invernadero' => $invernadero,
            'invernaderos' => $invernaderos,
            'contenedores' => $contenedores,
            'cultivos' => $cultivos,
            'destinos' => $destinos,
            'tipoStatus' => $tipoStatus
        ]);
    }

    /*
     * Crear pagina de modificar
     *
     * */
    public function pagModificar($id)
    {
        $siembra= siembraPlantula::findOrFail($id);

        $invernadero = $siembra->invernadero;
        $invernaderos= invernaderoPlantula::select('id','nombre')->orderBy('nombre', 'asc')->get();
        $cultivos = cultivo::select('id','nombre')->orderBy('nombre', 'asc')->get();
        $contenedores = ['Maceta (1L)', 'Maceta (0.5L)', 'Maceta (0.25L)', 'Charola - Plástico', 'Charola - Unicel'];
        $contenedor = $siembra->contenedor;
        $destinos = ['Campo', 'Invernadero'];
        $destino = $siembra->destino;
        $numPlantas = $siembra->numPlantas;
        $sustrato = $siembra->sustrato;
        $variedad = $siembra->variedad;
        $fecha=Carbon::createFromFormat('Y-m-d H:i:s', $siembra->fecha);
        if ($siembra->fechaTerminacion == "0000-00-00 00:00:00"){

        }else{
            $fechaTerminacion=Carbon::createFromFormat('Y-m-d H:i:s', $siembra->fechaTerminacion);
            $siembra->fechaTerminacion=$fechaTerminacion->format('d/m/Y');
        }
        $siembra->fecha=$fecha->format('d/m/Y');
        $tipoStatus = ['Activo', 'Terminado'];

        return view('Plantula/Siembra/modificar')->with([
            'invernadero' => $invernadero,
            'invernaderos' => $invernaderos,
            'cultivos' => $cultivos,
            'contenedores' => $contenedores,
            'contenedor' => $contenedor,
            'numPlantas' => $numPlantas,
            'sustrato' => $sustrato,
            'variedad' => $variedad,
            'siembra' => $siembra,
            'destinos' => $destinos,
            'destino' => $destino,
            'tipoStatus' => $tipoStatus,
        ]);
    }


    /*Recibe la informacion del formulario de crear y la almacena en la base de datos*/
    public function crear(siembraPlantulaRequest $request)
    {
        $siembra=$this->adaptarRequest($request);
        $siembra->save();

        Session::flash('message', 'La siembra ha sido agregada');
        return redirect('plantula/siembra/crear');
    }



    /*Modificar registro*/
    public function modificar(siembraPlantulaRequest $request)
    {
        $siembra=$this->adaptarRequest($request);
        $siembra->save();
        $siembra->push();
        Session::flash('message', 'La siembra ha sido modificada');
        return redirect('plantula/siembra/modificar/'.$siembra->id);
    }



    /*Recibe la informacion del formulario de crear y la adapta a los campos del modelo*/
    public function adaptarRequest($request){
        $siembra = new siembraPlantula();
        if(isset($request->id)) {
            $siembra = siembraPlantula::findOrFail($request->id);
        }

        $siembra->id_invernaderoPlantula = $request->invernadero;
        $siembra->id_cultivo = $request->cultivo;
        $siembra->fecha = Carbon::createFromFormat('d/m/Y', $request->fecha)->toDateTimeString();

        if($request->fechaTerminacion != "") {
            $siembra->fechaTerminacion = Carbon::createFromFormat('d/m/Y', $request->fechaTerminacion)->toDateTimeString();
        }

        $siembra->status = $request->status;
        $siembra->contenedor = $request->contenedor;
        $siembra->sustrato = $request->sustrato;
        $siembra->variedad = $request->variedad;
        $siembra->numPlantas = $request->numPlantas;
        $siembra->destino = $request->destino;
        $siembra->comentario = $request->comentario;
        return $siembra;
    }

    /*
     * Pagina para consultar
     *
     * */
    public function pagConsultar($id)
    {
        $siembra= siembraPlantula::findOrFail($id);
        $fecha = Carbon::createFromFormat('Y-m-d H:i:s', $siembra->fecha);
        $fechaTerminacion=Carbon::createFromFormat('Y-m-d H:i:s', $siembra->fechaTerminacion);
        $siembra->fecha=$fecha->format('d/m/Y');
        $siembra->fechaTerminacion=$fecha->format('d/m/Y');

        return view('Plantula/Siembra/consultar')->with([
            'siembra'=>$siembra
        ]);
    }


    /*Eliminar registro*/
    public function eliminar(Request $request)
    {
        $siembra= siembraPlantula::findOrFail($request->id);
        try {
            $siembra->delete();
            Session::flash('message','La siembra ha sido eliminada');
        }
        catch(\Exception $ex) {
            Session::flash('error','No puedes eliminar esta siembra porque otros registros dependen de ella');
        }
        return redirect('plantula/siembra');
    }


    /*Adapta fechas a formato adecuado para imprimir en la vista*/
    public function adaptaFechas($resultados){
        foreach($resultados as $resultado  ){
            $fecha=Carbon::createFromFormat('Y-m-d H:i:s', $resultado->fecha);
            $fechaTerminacion=Carbon::createFromFormat('Y-m-d H:i:s', $resultado->fechaTerminacion);
            $resultado->fecha=$fecha->format('d/m/Y');
            $resultado->fechaTerminacion=$fechaTerminacion->format('d/m/Y');
        }

    }


}
