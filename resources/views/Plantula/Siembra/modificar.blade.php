@include('Partials.ScriptsGenerales.scriptsPartials')

<body>

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
    @include('Plantula.Siembra.aside')
    <!--sidebar end-->

    <section id="container">
        <section id="main-content">
            <section class="wrapper site-min-height">
                <h3>
                    <a href="{{ route('plantula/siembra') }}">
                        <button type="button" class="btn btn-primary">
                            <i class="glyphicon glyphicon-arrow-left"></i> Búsqueda
                        </button>
                    </a>
                </h3>
                <div class="row mt">

                    <!-- INICIO CONSULTAR FUNCIONES -->
                    <div class="col-lg-12">
                        <div class="form-panel">
                            @include('Partials.Mensajes.mensajes')
                            <h4 style="color:#078006"><i class="fa fa-angle-right"></i>Modificar siembra</h4><br>
                            @if( isset($siembra))

                                <table align="right">
                                    <tr>
                                        <td>
                                            <a href="{{ route('plantula/siembra/consultar/item',$siembra->id) }}">
                                                <button  class="btn btn-success btn-xs tooltips" data-placement="top" data-original-title="Consultar">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                            </a> &nbsp
                                        </td>

                                        <td>
                                            {!! Form::open(['action'=>['siembraPlantulaController@eliminar'],'role'=>'form'] )  !!}
                                            <button class="btn btn-danger btn-xs tooltips" data-placement="top" data-original-title="Eliminar" onclick='return confirm("¿Seguro que desea eliminar la siembra?")'>
                                                <i class="fa fa-trash-o "></i>
                                            </button>
                                            <input type="hidden" name="id" value={{$siembra->id}}>
                                            {!! Form::close() !!}

                                        </td>
                                    </tr>
                                </table>
                                <br><br>

                            @endif

                            {!! Form::open(['action'=>['siembraPlantulaController@modificar'],'class'=>'form-horizontal','role'=>'form', 'id' =>'formulario'] )  !!}

                            @include('Plantula.Siembra.Partials.form')
                            <input type="hidden" name="id" value="{{$siembra->id}}">
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <!-- FIN CONSULTAR FUNCIONES -->
                </div>
            </section>
        </section>
    </section>
</section>
    @include('Plantula.Siembra.Partials.validator')

    @include('Plantula.Siembra.Partials.Script')

    @include('Partials.ScriptsGenerales.scriptsPartialsAbajo')
