<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class siembraTransplanteInvernadero extends Model
{
    //

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'siembra_invernadero';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fecha','variedad','status','fechaTerminacion','comentario','id_cultivo','id_invernadero'];


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


    public function preparaciones(){
        return $this->hasMany('App\preparacionInvernadero', 'id_stInvernadero', 'id')->orderBy('fecha','asc');
    }

    public function fertilizacionesRiegos(){
        return $this->hasMany('App\fertilizacionRiego', 'id_stInvernadero', 'id');
    }


    public function mantenimientos(){
        return $this->hasMany('App\aplicacionesMantenimiento', 'id_stInvernadero', 'id');
    }
    public function laboresCulturales(){
        return $this->hasMany('App\laboresCulturales', 'id_stInvernadero', 'id');
    }

    public function cosechas(){
        return $this->hasMany('App\cosechaInvernadero', 'id_stInvernadero', 'id');
    }

    public  function invernadero(){
        return $this->belongsTo('App\invernadero','id_invernadero');
    }

    public  function cultivo(){
        return $this->belongsTo('App\cultivo','id_cultivo');
    }


}
