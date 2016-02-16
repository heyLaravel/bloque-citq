<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class invernadero extends Model
{
    //

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'invernadero';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','descripcion'];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['remember_token'];

    // Task model
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    //N a N




    // 1 a N
    public function siembrasTransplantes(){
        return $this->hasMany('App\siembraTransplanteInvernadero', 'id_invernadero', 'id')->orderBy('fecha','asc');
    }

    public function preparaciones(){
        return $this->hasMany('App\preparacionInvernadero', 'id_invernadero', 'id')->orderBy('fecha','asc');
    }

    public function fertilizacionesRiegos(){
        return $this->hasMany('App\fertilizacionRiego', 'id_invernadero', 'id')->orderBy('fecha','asc');
    }


    public function mantenimientos(){
        return $this->hasMany('App\mantenimientoInvernadero', 'id_invernadero', 'id')->orderBy('fecha','asc');
    }

    public function cosechas(){
        return $this->hasMany('App\cosechaInvernadero', 'id_invernadero', 'id')->orderBy('fecha','asc');
    }
}
