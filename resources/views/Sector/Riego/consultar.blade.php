@include('Partials.ScriptsGenerales.scriptsPartials')



<section id="container" >
    <!-- **********************************************************************************************************************************************************
    TOP BAR CONTENT & NOTIFICATIONS
    *********************************************************************************************************************************************************** -->
    <!--header start-->
    @include('Partials.ScriptsGenerales.headerPartials')
    <!--header end-->

    <!-- **********************************************************************************************************************************************************
    MAIN SIDEBAR MENU
    *********************************************************************************************************************************************************** -->
    <!--sidebar start-->
    @include('Sector.Riego.aside')
    <!--sidebar end-->

    <section id="container">
        <section id="main-content">
            <section class="wrapper site-min-height">
                <h3><a href="{{ route('sector/riego') }}"><button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-arrow-left"></i> Búsqueda</button></a></h3>
                <div class="row mt">

                    <!-- INICIO CONSULTAR FUNCIONES -->
                    <div class="col-lg-12">
                        <div class="form-panel">

                            <h4 style="color:#078006"><i class="fa fa-angle-right"></i>Consultar riego</h4><br>

                            @if( isset($riego))


                                <table align="right">
                                    <tr>
                                        <td>
                                            <a href="{{ route('sector/riego/modificar/item',$riego->id) }}"><button class="btn btn-primary btn-xs tooltips" data-placement="top" data-original-title="Modificar"><i class="fa fa-pencil"></i></button></a>
                                            &nbsp
                                        </td>

                                        <td>
                                            {!! Form::open(['action'=>['riegoSectorController@eliminar'],'role'=>'form'] )  !!}
                                            <button class="btn btn-danger btn-xs tooltips" data-placement="top" data-original-title="Eliminar" onclick='return confirm("¿Seguro que desea eliminar el riego?")'><i class="fa fa-trash-o "></i></button>
                                            <input type="hidden" name="id" value={{$riego->id}}>
                                            {!! Form::close() !!}

                                        </td>
                                    </tr>
                                </table>
                                <br><br>

                            @endif
                            <div class="row">
                                <br>
                                <div class="col-md-4">

                                </div>


                                <div class="col-md-7">

                                    <dl class="dl-horizontal">
                                        <dt>Sector</dt><dd>{{ $riego->sector->nombre }}</dd>
                                        <dt>Siembra</dt><dd>{{ $siembras['nombre'] . ' '. $siembras['variedad']  }}</dd>
                                        <dt>Tiempo de riego</dt><dd>{{ $riego->tiempo }} horas</dd>
                                        <dt>Distancia entre líneas</dt><dd>{{ $riego->distanciaLineas }} metros</dd>
                                        <dt>Litros por hectárea</dt><dd>{{ $riego->litrosHectarea }} litros</dd>
                                        <dt>Lámina de riego</dt><dd>{{ $riego->lamina }} mm de agua</dd>
                                        <dt>Fecha</dt><dd>{{ $riego->fecha }}</dd>
                                    </dl>
                                </div>

                            </div>


                            <br>

                        </div>
                    </div>
                    <!-- FIN CONSULTAR FUNCIONES -->
                </div>
            </section>
        </section>
    </section>
</section>




@include('Partials.ScriptsGenerales.scriptsPartialsAbajo')