<script type="text/javascript">

    $(document).ready(function() {

        $('#formulario').bootstrapValidator({
            message: 'Los valores no son válidos',
            feedbackIcons: {
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                sector:{
                    validators: {
                        notEmpty: {
                            message: 'Seleccione una opción'
                        }
                    }
                },


                siembra:{
                    validators: {
                        notEmpty: {
                            message: 'Seleccione una opción'
                        }
                    }
                },

                fuente:{
                    validators: {
                        stringLength: {
                            max: 255,
                            message: 'Debe ser menor de 255 caracteres'
                        }
                    }
                },



                cantidad:{
                    validators: {

                        numeric: {
                            message: 'No es un número válido',
                            // The default separators

                            decimalSeparator: '.'


                        },
                        greaterThan: {
                            value: 0,
                            message: 'El número tiene que ser positivo'
                        }

                    }
                },

                programaNPK:{
                    validators: {

                        stringLength: {
                            max: 255,
                            message: 'Debe ser menor de 255 caracteres'
                        }

                    }
                },

                fecha:{
                    validators: {
                        notEmpty: {
                            message: 'Seleccione una opción'
                        },

                        date: {
                            format: 'DD/MM/YYYY',
                            message: 'Ingrese fecha en formato dd/mm/aaaa'
                        }
                    }
                }
            }
        });

        $('#fecha')
                .on('dp.change dp.show', function(e) {
                    $('#formulario').data('bootstrapValidator').revalidateField('fecha');
                });




    });
</script>

<script type="text/javascript">
    $(function () {
        $('#fecha').datetimepicker({
            format:'DD/MM/YYYY'

        });

    });

    $('#fecha').keypress(function(event) {event.preventDefault();});



</script>