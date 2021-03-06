<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class siembraPlantulaTest extends TestCase
{
    //////////////////////////////BUSCAR//////////////////////////////////
    //para llamar a solo un grupo phpunit --group siembraBuscarPlantula

    /*Unidad*/
    /**
     * @group siembraBuscarPlantula
     */
    public function testRutaBuscar(){
        $user=User::find(1);
        $response = $this->call('GET', 'plantula/siembra');
        $this->assertEquals(200, $response->status());
    }
    /*Integración*/

    /**
     * @group siembraBuscarPlantula
     */
    public function testBuscarNoParametros(){
        $user=User::find(1);
        $this->visit('plantula/siembra')
            ->press('Buscar')
            ->see("Se encontraron");
    }

    /**
     * @group siembraBuscarPlantula
     */
    public function testBuscarPlantulaCorrecto(){
        $user=User::find(1);
        $this->visit('plantula/siembra')
            ->select(1,"plantula")
            ->press('Buscar')
            ->see("Se encontraron");
    }

    /**
     * @group siembraBuscarPlantula
     */
    public function testBuscarCultivoCorrecto(){
        $user=User::find(1);
        $this->visit('plantula/siembra')
            ->select(1,"cultivo")
            ->press('Buscar')
            ->see("Se encontraron");
    }

    /**
     * @group siembraBuscarPlantula
     */
    public function testBuscarFechaCorrecto(){
        $user=User::find(1);
        $this->visit('plantula/siembra')
            ->type("29/02/2015","fechaInicio")
            ->type("29/02/2016","fechaFin")
            ->press('Buscar')
            ->see("Se encontraron");
    }

    /**
     * @group siembraBuscar
     */
    public function testBuscarPlantulaFechaCorrecto(){
        $user=User::find(1);
        $this->visit('plantula/siembra')
            ->type("29/02/2015","fechaInicio")
            ->type("29/02/2016","fechaFin")
            ->select(1,"plantula")
            ->press('Buscar')
            ->see("Se encontraron");
    }
    /**
     * @group siembraBuscarPlantula
     */
    public function testBuscarCultivoFechaCorrecto(){
        $user=User::find(1);
        $this->visit('plantula/siembra')
            ->type("29/02/2015","fechaInicio")
            ->type("29/02/2016","fechaFin")
            ->select(1,"cultivo")
            ->press('Buscar')
            ->see("Se encontraron");
    }
    /**
     * @group siembraBuscarPlantula
     */
    public function testBuscarPlantulaCultivoFechaCorrecto(){
        $user=User::find(1);
        $this->visit('plantula/siembra')
            ->type("29/02/2015","fechaInicio")
            ->type("29/02/2016","fechaFin")
            ->select(1,"plantula")
            ->select(1,"cultivo")
            ->press('Buscar')
            ->see("Se encontraron");
    }

    /**
     * @group siembraBuscarPlantula
     */
    public function testBuscarUnaFecha(){
        $user=User::find(1);
        $this->visit('plantula/siembra/lista?plantula=&cultivo=&fechaInicio=&fechaFin=29%2F02%2F2016')
            ->see("No se encontraron resultados");
    }

    /**
     * @group siembraBuscarPlantula
     */
    public function testBuscarUnaFechaTexto(){
        $user=User::find(1);
        $this->visit('plantula/siembra/lista?plantula=&cultivo=&fechaInicio=sdfsdfsd&fechaFin=')
            ->see("No se encontraron resultados");
    }
    /**
     * @group siembraBuscarPlantula
     */
    public function testBuscarFechasTexto(){
        $user=User::find(1);
        $this->visit('plantula/siembra/lista?plantula=&cultivo=&fechaInicio=sdfsdfsd&fechaFin=sdsdfd')
            ->see("No se encontraron resultados");
    }
    /**
     * @group siembraBuscarPlantula
     */
    public function testBuscarPlantulaTexto(){
        $user=User::find(1);
        $this->visit('plantula/siembra/lista?plantula=asdasd&cultivo=&fechaInicio=&fechaFin=')
            ->see("No se encontraron resultados");
    }
    /**
     * @group siembraBuscarPlantula
     */
    public function testBuscarCultivoTexto(){
        $user=User::find(1);
        $this->visit('plantula/siembra/lista?plantula=&cultivo=zfzfdf&fechaInicio=&fechaFin=')
            ->see("No se encontraron resultados");
    }
    /**
     * @group siembraBuscarPlantula
     */
    public function testBuscarPlantulaInexistente(){
        $user=User::find(1);
        $this->visit('plantula/siembra/lista?plantula=1000&cultivo=&fechaInicio=&fechaFin=')
            ->see("No se encontraron resultados");
    }
    /**
     * @group siembraBuscarPlantula
     */
    public function testBuscarCultivoInexistente(){
        $user=User::find(1);
        $this->visit('plantula/siembra/lista?plantula=&cultivo=1000&fechaInicio=&fechaFin=')
            ->see("No se encontraron resultados");
    }

    ////////////////////////////////////////////////CONSULTAR/////////////////////////////////////////////////////////

    //para llamar a solo un grupo "phpunit --group siembraConsultarPlantula"

    /*Unidad*/
    /**
     * @group siembraConsultarPlantula
     */
    public function testRutaConsultar(){
        $user=User::find(1);
        $response = $this->call('GET', 'plantula/siembra/consultar/12');
        $this->assertEquals(200, $response->status());
    }

    /**
     * @group siembraConsultarPlantula
     */
    public function testConsultarIdIncorrecto(){
        $user=User::find(1);
        $response = $this->call('GET', 'plantula/siembra/consultar/120');
        $this->assertEquals(404, $response->status());
    }

    ////////////////////////////////////////////////MODIFICAR/////////////////////////////////////////////////////////////////

    //para llamar a solo un grupo "phpunit --group siembraModificarPlantula"

    /*Unidad*/
    /**
     * @group siembraModificarPlantula
     */
    public function testRutaModificar(){
        $user=User::find(1);
        $response = $this->call('GET', 'plantula/siembra/modificar/12');
        $this->assertEquals(200, $response->status());
    }
    /**
     * @group siembraModificarPlantula
     */
    public function testModificarIdIncorrecto(){
        $user=User::find(1);
        $response = $this->call('GET', 'plantula/siembra/modificar/120');
        $this->assertEquals(404, $response->status());
    }

    /**
     * @group siembraModificarPlantula
     */
    public function testModificarCorrecto(){
        $user=User::find(1);
        $this->visit('plantula/siembra/modificar/12')
            ->select(1,"plantula")
            ->select(1,"cultivo")
            ->type("18/02/2016","fecha")
            ->type("Activo","status")
            ->type("lalala", "variedad")
            ->type("hola", "comentario")
            ->press('Modificar')
            ->see("ha sido modificada");
    }
    /**
     * @group siembraModificarPlantula
     */

    public function testModificarNoPlantula(){
        $user=User::find(1);
        $this->visit('plantula/siembra/modificar/12')
            ->select("","plantula")
            ->select(1,"cultivo")
            ->type("18/02/2016","fecha")
            ->type("Activo","status")
            ->type("lalala", "variedad")
            ->type("hola", "comentario")
            ->press('Modificar')
            ->see("El campo plantula es obligatorio");
    }
    /**
     * @group siembraModificarPlantula
     */
    public function testModificarNoCultivo(){
        $user=User::find(1);
        $this->visit('plantula/siembra/modificar/12')
            ->select(1,"plantula")
            ->select("","cultivo")
            ->type("18/02/2016","fecha")
            ->type("Activo","status")
            ->type("lalala", "variedad")
            ->type("hola", "comentario")
            ->press('Modificar')
            ->see("El campo cultivo es obligatorio");
    }

    /**
     * @group siembraModificarPlantula
     */

    public function testModificarNoFecha(){
        $user=User::find(1);
        $this->visit('plantula/siembra/modificar/12')
            ->select(1,"plantula")
            ->select(1,"cultivo")
            ->type("","fecha")
            ->type("Activo","status")
            ->type("lalala", "variedad")
            ->type("hola", "comentario")
            ->press('Modificar')
            ->see("El campo fecha es obligatorio");
    }

    /**
     * @group siembraModificarPlantula
     */
    public function testModificarFechaIncorrecta(){
        $user=User::find(1);
        $this->visit('plantula/siembra/modificar/12')
            ->select(1,"plantula")
            ->select(1,"cultivo")
            ->type("asdas","fecha")
            ->type("Activo","status")
            ->type("lalala", "variedad")
            ->type("hola", "comentario")
            ->press('Modificar')
            ->see("fecha no corresponde al formato d/m/Y");
    }

    ///////////////////////////////////////CREAR//////////////////////////////////////////////////////

    //para llamar a solo un grupo phpunit --group siembraCrearPlantula

    /*Unidad*/
    /**
     * @group siembraCrearPlantula
     */
    public function testRutaCrear(){
        $user=User::find(1);
        $response = $this->call('GET', 'plantula/siembra/crear');
        $this->assertEquals(200, $response->status());
    }


    /*Integración*/

    /**
     * @group siembraCrearPlantula
     */
    public function testCrearCorrecto(){
        $user=User::find(1);
        $this->visit('plantula/siembra/crear')
            ->select(1,"plantula")
            ->select(1,"cultivo")
            ->type("18/02/2016","fecha")
            ->type("Activo","status")
            ->type("lalala", "variedad")
            ->type("hola", "comentario")
            ->press('Crear')
            ->see("La siembra ha sido agregada");
    }

    /**
     * @group siembraCrearPlantula
     */
    public function testCrearNoPlantula(){
        $user=User::find(1);
        $this->visit('plantula/siembra/crear')
            ->select(1,"cultivo")
            ->type("18/02/2016","fecha")
            ->type("Activo","status")
            ->type("lalala", "variedad")
            ->type("hola", "comentario")
            ->press('Crear')
            ->see("El campo plantula es obligatorio");
    }


    /**
     * @group siembraCrearPlantula
     */
    public function testCrearNoCultivo(){
        $user=User::find(1);
        $this->visit('plantula/siembra/crear')
            ->select(1,"plantula")
            ->type("18/02/2016","fecha")
            ->type("Activo","status")
            ->type("lalala", "variedad")
            ->type("hola", "comentario")
            ->press('Crear')
            ->see("El campo cultivo es obligatorio");
    }

    /**
     * @group siembraCrearPlantula
     */
    public function testCrearNoFecha(){
        $user=User::find(1);
        $this->visit('plantula/siembra/crear')
            ->select(1,"plantula")
            ->select(1,"cultivo")
            ->type("Activo","status")
            ->type("lalala", "variedad")
            ->type("hola", "comentario")
            ->press('Crear')
            ->see("El campo fecha es obligatorio");
    }

    /**
     * @group siembraCrearPlantula
     */
    public function testCrearFechaIncorrecta(){
        $user=User::find(1);
        $this->visit('plantula/siembra/crear')
            ->select(1,"plantula")
            ->select(1,"cultivo")
            ->type("asdas","fecha")
            ->type("Activo","status")
            ->type("lalala", "variedad")
            ->type("hola", "comentario")
            ->press('Crear')
            ->see("fecha no corresponde al formato d/m/Y");
    }

}



