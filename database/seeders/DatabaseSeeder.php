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
use App\Models\MOVSGCMov_estado;
use App\Models\Accesos;
use App\Models\SGCEstado;
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
        $data->password     = Hash::make("12tres");
        $data->save();

         //------------------------------------------------------- Mod Padre
        $data = new Modulo_padre();
        $data->descripcion  = "Seguridad";
        $data->abreviatura  = "Seg";
        $data->url          = "#";
        $data->icono        = "ti-lock";
        $data->orden        = 1;
        $data->save();

        $data = new Modulo_padre();
        $data->descripcion  = "Gestion de calidad";
        $data->abreviatura  = "SGC";
        $data->url          = "#";
        $data->icono        = "fe fe-file-text";
        $data->orden        = 2;
        $data->save();

        //facker
        //$faker = Facker::create();
        //$int   = 1;
        //foreach(range(1,500) as $value) {
        
        //------------------------------------------------------- Modulo
        $data = new Modulo();
        $data->idmodulo_padre   = 1;
        $data->idpadre          = null;
        $data->modulo           = "Modulo padre";
        $data->abreviatura      = "";
        $data->url              = "modulo_padre";
        $data->icono            = null;
        $data->orden            = 1;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 1;
        $data->idpadre          = null;
        $data->modulo           = "Modulo";
        $data->abreviatura      = "";
        $data->url              = "modulo";
        $data->icono            = null;
        $data->orden            = 2;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Tipo Proceso";
        $data->abreviatura      = "SGC_TP";
        $data->url              = "tipo_proceso";
        $data->icono            = null;
        $data->orden            = 1;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Entidades";
        $data->abreviatura      = "SGC_E";
        $data->url              = "entidades";
        $data->icono            = null;
        $data->orden            = 2;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Preceso nivel cero";
        $data->abreviatura      = "SGC_P0";
        $data->url              = "proceso_cero";
        $data->icono            = null;
        $data->orden            = 3;
        $data->save();


        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Movimientos";
        $data->abreviatura      = "SGC_MOV";
        $data->url              = "movimientos";
        $data->icono            = null;
        $data->orden            = 4;
        $data->save();

        //}

        //------------------------------------------------------- Accesos
        $data = new Accesos();
        $data->idmodulo   = 1;
        $data->idperfil   = 1;
        $data->acceder    = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 2;
        $data->idperfil   = 1;
        $data->acceder    = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 3;
        $data->idperfil   = 1;
        $data->acceder    = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 4;
        $data->idperfil   = 1;
        $data->acceder    = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 5;
        $data->idperfil   = 1;
        $data->acceder    = 1;
        $data->save();

        //--------------------------------------------------MOVSGC
        $data = new MOVSGCMov_estado();
        $data->descripcion= 'Pendiente';
        $data->save();

        $data = new MOVSGCMov_estado();
        $data->descripcion= 'Aceptado';
        $data->save();

        $data = new MOVSGCMov_estado();
        $data->descripcion= 'Rechazado';
        $data->save();

        
        $data = new SGCEstado();
        $data->descripcion= 'Pendiente';
        $data->save();

        $data = new SGCEstado();
        $data->descripcion= 'Aceptado';
        $data->save();

        $data = new SGCEstado();
        $data->descripcion= 'Rechazado';
        $data->save();
    }
}
