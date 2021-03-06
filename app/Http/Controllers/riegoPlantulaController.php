<?php
/**
 * Created by PhpStorm.
 * User: Dannyrious
 * Date: 11-Mar-16
 * Time: 11:18 AM
 */

namespace App\Http\Controllers;

use App\invernadero;

use App\Http\Requests\riegoPlantulaRequest;
use App\invernaderoPlantula;
use App\riegoPlantula;
use App\salidaPlanta;
use App\siembraPlantula;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class riegoPlantulaController extends Controller
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

    public function index() {
        $now= Carbon::now()->format('Y/m/d');
        $now= $now. " 23:59:59";
        $now2 =Carbon::now()->subMonth(6)->format('Y/m/d');
        $riegos = riegoPlantula::whereBetween('fecha', array($now2,$now))->orderBy('fecha', 'des')->paginate(15);
        $this->adaptaFechas($riegos);

        $invernaderos= invernaderoPlantula::select('id','nombre')->orderBy('nombre', 'asc')->get();
        return view('Plantula/riego/buscar')->with([
            'invernaderos' =>$invernaderos,
            'riegos'=>$riegos
        ]);
    }

    /*
     * Devuelve la vista de crear con los valores de los combobox
     * */
    public function pagCrear() {
        $invernadero = invernaderoPlantula::select('id', 'nombre')->first();
        $invernaderos= invernaderoPlantula::select('id','nombre')->orderBy('nombre', 'asc')->get();
        $siembras= siembraPlantula::select()->orderBy('variedad', 'asc')->get();
        $this->adaptaFechas($siembras);


        return view('Plantula/riego/crear')->with([
            'invernaderos' => $invernaderos,
            'invernadero' => $invernadero,
            'siembras' => $siembras

        ]);
    }

    /*
     * Devuelve vista modificar con los valores del registro que se manda como parametro ($id)
     */
    public function pagModificar($id) {
        $riego= riegoPlantula::findOrFail($id);
        $invernadero= $riego->invernadero;
        $invernaderos= invernaderoPlantula::select('id','nombre')->orderBy('nombre', 'asc')->get();
        $fechaSiembraSeleccionada=Carbon::createFromFormat('Y-m-d H:i:s', $riego->siembra->fecha);

        $siembraSeleccionada = array(
            'id_siembra'=>$riego->id_siembraPlantula,
            'variedad'=>$riego->siembra->variedad,
            'nombre'=>$riego->siembra->cultivo->nombre,
            'fecha'=>$fechaSiembraSeleccionada->format('d/m/Y')
        );

        $siembras = siembraPlantula::where('id_invernaderoPlantula',$riego->id_invernaderoPlantula)->get();
        $siembrasTodas=array();
        foreach ($siembras as $siembra) {

            $fechaSiembraToda=Carbon::createFromFormat('Y-m-d H:i:s', $siembra->fecha);

            array_push($siembrasTodas,array(
                    'id_siembra' => $siembra->id,
                    'variedad' => $siembra->variedad,
                    'nombre' => $siembra->cultivo->nombre,
                    'fecha' => $fechaSiembraToda->format('d/m/Y'))

            );
        }

        $fecha=Carbon::createFromFormat('Y-m-d H:i:s', $riego->fecha);
        $riego->fecha=$fecha->format('d/m/Y');


        return view('Plantula/riego/modificar')->with([
            'invernadero' => $invernadero,
            'siembras' => $siembrasTodas,
            'siembraSeleccionada' => $siembraSeleccionada,
            'riego' => $riego,
        ]);
    }

    /*
     * Devuelve vista consultar con los valores del registro que se manda como parametro ($id)
     */

    public function pagConsultar($id) {
        $riego= riegoPlantula::findOrFail($id);
        $fecha=Carbon::createFromFormat('Y-m-d H:i:s', $riego->fecha);
        $riego->fecha=$fecha->format('d/m/Y');

        return view('Plantula/riego/consultar')->with([
            'riego'=>$riego
        ]);
    }



    /*
     * Recibe la informacion del formulario de crear y la almacena en la base de datos
     */

    public function crear(riegoPlantulaRequest $request){
        //dd('aqui');
        $riego=$this->adaptarRequest($request);
        $riego->save();
        Session::flash('message', 'El riego ha sido creado');
        return redirect('plantula/riego/crear');
    }


    /*
     * Recibe la informacion del formulario de modificar y la actualiza en la base de datos
     */
    public function modificar(riegoPlantulaRequest $request){
        $riego=$this->adaptarRequest($request);
        $riego->save();
        $riego->push();
        Session::flash('message', 'El riego ha sido modificado');
        return redirect('plantula/riego/modificar/'.$riego->id);
    }

    /*
     * Elimina un registro de la base de datos
     */
    public function eliminar(Request $request){
        $riego= riegoPlantula::findOrFail($request->id);
        $riego->delete();

        Session::flash('message','El riego ha sido eliminado');
        return redirect('plantula/riego');
    }

    /*
     * Realiza una busqueda de informacion con los valores enviados desde la vista de busqueda
     */

    public function buscar(Request $request){
        /*Listados de combobox*/
        //$invernaderos= invernaderoPlantula::select('id','nombre')->orderBy('nombre', 'asc')->get();
        /*Ahi se guardaran los resultados de la busqueda*/
        $riegos=null;


        $validator = Validator::make($request->all(), [
            'fechaInicio' => 'date_format:d/m/Y',
            'fechaFin' => 'date_format:d/m/Y',
            'invernadero' => 'exists:invernadero_plantula,id'
        ]);

        /*Si validador no falla se pueden realizar busquedas*/
        if ($validator->fails()) {
        }
        else{
            /*Busqueda sin parametros*/
            if ($request->fechaFin == "" && $request->fechaInicio == "" && $request->invernadero == "") {
                $riegos  = riegoPlantula::orderBy('fecha', 'desc')->paginate(15);;

            }
            /*Pregunta si se mandaron fechas, para calcular busquedas con fechas*/
            if ( $request->fechaFin != "" && $request->fechaInicio !="") {

                /*Transforma fechas en formato adecuado*/

                $fecha = $request->fechaInicio . " 00:00:00";
                $fechaInf = Carbon::createFromFormat("d/m/Y H:i:s", $fecha);
                $fecha = $request->fechaFin . " 23:59:59";
                $fechaSup = Carbon::createFromFormat("d/m/Y H:i:s", $fecha);

                /*Hay cuatro posibles casos de busqueda con fechas, cada if se basa en un caso */

                /*Solo con fechas*/

                $riegos = riegoPlantula::whereBetween('fecha', array($fechaInf, $fechaSup))->orderBy('fecha', 'desc')->paginate(15);;

            }
        }


        if($riegos!=null){
            /*Adapta el formato de fecha para poder imprimirlo en la vista adecuadamente*/
            $this->adaptaFechas($riegos);

            /*Si no es nulo puede contar los resultados*/
            $num = $riegos->total();
        }
        else{
            $num=0;
        }


        if($num<=0){
            Session::flash('error', 'No se encontraron resultados');
        }
        else{
            Session::flash('message', 'Se encontraron '.$num.' resultados');
        }
        /*Regresa la vista*/
        return view('Plantula/riego/buscar')->with([
            'riegos'=>$riegos
        ]);
    }






    /*
     * Recibe la informacion del formulario de crear y la adapta a los campos del modelo
     */
    public function adaptarRequest($request){
        $riego=new riegoPlantula($request->all());
        if(isset($request->id)) {
            $riego = riegoPlantula::findOrFail($request->id);
        }

        $riego->id_invernaderoPlantula= $request->invernadero;
        $riego->id_siembraPlantula = $request->siembraPlantula;
        $riego->fecha=Carbon::createFromFormat('d/m/Y', $request->fecha)->toDateTimeString();
        $riego->tiempoRiego = $request->tiempoRiego;
        $riego->frecuencia = $request->frecuencia;
        $riego->formulacion= $request->formulacion;


        return $riego;
    }
    /*
     * Adapta fechas de resultado de busqueda a formato adecuado para imprimir en la vista de busqueda
     */
    public function adaptaFechas($resultados){

        foreach($resultados as $resultado  ){
            $fecha=Carbon::createFromFormat('Y-m-d H:i:s', $resultado->fecha);
            $resultado->fecha=$fecha->format('d/m/Y');
        }

    }

}