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
        $data->facultad     = 'FISI';
        $data->abreviatura  = 'FISI';
        $data->save();

        //------------------------------------------------------- Escuela
        $data = new Escuela();
        $data->idfacultad   = 1;
        $data->escuela      = 'FISI';
        $data->abreviatura  = 'FISI';
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
        $data->nombre   = 'Lamas';
        $data->reniec   = '1234';
        $data->save();

        //------------------------------------------------------- Tipo_documento_identidad
        $data = new Tipo_documento_identidad();
        $data->descripcion  = 'DNI';
        $data->abreviatura  = 'DNI';
        $data->save();

        //------------------------------------------------------- Estado_civil
        $data = new Estado_civil();
        $data->descripcion  = 'SOLTERO POR FEO';
        $data->save();

        //------------------------------------------------------- Sexo
        $data = new Sexo();
        $data->descripcion  = 'MACHO P';
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
        $data->nombres                      = "Admin";
        $data->apellido_paterno             = "Nose";
        $data->apellido_materno             = "Tampoco";
        $data->correo_institucional         = "colala@gmial.com";
        $data->correo_personal              = "colala@gmial.com";
        $data->direccion                    = "nose";
        $data->telefono                     = "917779907";
        $data->fecha_nacimiento             = "25-03-1998";
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
        $data->id_encrypt   = 0;
        $data->idperfil     = 1;
        $data->usuario      = "ADMIN";
        $data->password     = Hash::make("12tres");
        $data->save();

         //------------------------------------------------------- Mod Padre
        $data = new Modulo_padre();
        $data->descripcion  = "Seguridad";
        $data->abreviatura  = "Seg";
        $data->url          = "#";
        $data->icon         = "ti-lock";
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
