<?php

namespace Database\Seeders;

use App\Models\Facultad;
use App\Models\Escuela;
use App\Models\Estadopersona;
use App\Models\Tipopersona;
use App\Models\Ubigeo;
use App\Models\Tipo_documento_identidad;
use App\Models\Estado_civil;
use App\Models\Sexo;
use App\Models\Persona;
use App\Models\Perfil;
use App\Models\User;
use App\Models\Modulo_padre;
use App\Models\Modulo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
Use Faker\Factory as Facker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){

        //------------------------------------------------------- Facultad
        $data = new Facultad();
        $data->facultad     = 'Facultad de Ingeniería de Sistemas e Informática';
        $data->abreviatura  = 'FISI';
        $data->save();

        //------------------------------------------------------- Escuela
        $data = new Escuela();
        $data->idfacultad   = 1;
        $data->escuela      = 'Escuela Profesional de Ingeniería de Sistemas e Informática';
        $data->abreviatura  = 'EPISI';
        $data->save();

        //------------------------------------------------------- Estadopersona
        $data = new Estadopersona();
        $data->descripcion   = 'Activo';
        $data->save();

        //------------------------------------------------------- Tipopersona
        $data = new Tipopersona();
        $data->descripcion = 'DOCENTE';
        $data->save();

        //------------------------------------------------------- Ubigeo
        $data = new Ubigeo();
        $data->cod_dpto  = '1';
        $data->cod_prov = '2';
        $data->cod_dist = '3';
        $data->codccpp  = '4';
        $data->nombre   = 'Tarapoto';
        $data->reniec   = '1234';
        $data->save();

        //------------------------------------------------------- Tipo_documento_identidad
        $data = new Tipo_documento_identidad();
        $data->descripcion  = 'Documento Nacional de Identidad';
        $data->abreviatura  = 'DNI';
        $data->save();

        //------------------------------------------------------- Estado_civil
        $data = new Estado_civil();
        $data->descripcion  = 'Soltero';
        $data->save();

        //------------------------------------------------------- Sexo
        $data = new Sexo();
        $data->descripcion  = 'Masculino';
        $data->simbolo      = 'M';
        $data->save();

        //------------------------------------------------------- Persona
        $data = new Persona();
        $data->dni                          = 1;    
        $data->idescuela                    = 1;
        $data->idestadopersona              = 1;
        $data->idtipopersona                = 1;
        $data->ubigeo_origen                = 1;
        $data->ubigeo_actual                = 1;
        $data->idtipo_documento_identidad   = 1;
        $data->idestado_civil               = 1;
        $data->idsexo                       = 1;
        $data->nombres                      = "José Alejandro";
        $data->apellido_paterno             = "Robles";
        $data->apellido_materno             = "Delgado";
        $data->correo_institucional         = "jaroblesd@alumno.unsm.edu.pe";
        $data->correo_personal              = "dracoxxrobles1232@gmail.com";
        $data->direccion                    = "Jr. 3 de octubre #294";
        $data->telefono                     = "950904778";
        $data->fecha_nacimiento             = "10-05-2000";
        $data->nacionalidad                 = "Peruano";
        $data->save();

        //------------------------------------------------------- Perfil
        $data = new Perfil();
        $data->perfil       = 'ADMINISTRADOR';
        $data->abreviatura  = "ADMIN";
        $data->save();

        //------------------------------------------------------- Usuario
        $data = new User();
        $data->idpersona    = 1;
        $data->idperfil     = 1;
        $data->usuario      = "admin";
        $data->password     = Hash::make("fias123.123w");
        $data->save();

         //------------------------------------------------------- Mod Padre
        $data = new Modulo_padre();
        $data->descripcion  = "Seguridad";
        $data->abreviatura  = "Seg";
        $data->url          = "#";
        $data->icono        = "fa fa ti-lock";
        $data->orden        = 1;
        $data->save();

        //facker
        $faker = Facker::create();
        $int   = 1;
        foreach(range(1,500) as $value) {
        
            //------------------------------------------------------- Modulo
            $data = new Modulo();
            $data->idmodulo_padre   = 1;
            $data->idpadre          = null;
            $data->modulo           = $faker->name;
            $data->abreviatura      = "";
            $data->url              = null;
            $data->icono            = null;
            $data->orden            = $int++;
            $data->save();
        }
    }
}
