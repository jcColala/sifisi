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
use App\Models\Accesos;
use App\Models\Funcion;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        $data->nombres                      = "Anonimos";
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
        $data->editable     = false;
        $data->save();

        //------------------------------------------------------- Usuario
        $user = new User();
        $user->idpersona    = 1;
        $user->idperfil     = 1;
        $user->usuario      = "ADMIN";
        $user->password     = Hash::make("12tres");
        $user->save();
        
        //------------------------------------------------------- Mod Padre
        $data = new Modulo_padre();
        $data->descripcion  = "Seguridad";
        $data->abreviatura  = "Seg";
        $data->url          = "#";
        $data->icono        = "ti-lock";
        $data->orden        = 1;
        $data->editable     = false;
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
        $data->modulo           = "Accesos";
        $data->abreviatura      = "Acc";
        $data->url              = "accesos";
        $data->icono            = null;
        $data->orden            = 1;
        $data->editable         = false;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 1;
        $data->idpadre          = null;
        $data->modulo           = "Modulo padre";
        $data->abreviatura      = "Mdp";
        $data->url              = "modulo_padre";
        $data->icono            = null;
        $data->orden            = 2;
        $data->editable         = false;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 1;
        $data->idpadre          = null;
        $data->modulo           = "Modulo";
        $data->abreviatura      = "Md";
        $data->url              = "modulo";
        $data->icono            = null;
        $data->orden            = 3;
        $data->editable         = false; 
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Preceso nivel cero";
        $data->abreviatura      = "";
        $data->url              = "proceso_cero";
        $data->icono            = null;
        $data->orden            = 1;
        $data->save();

        //}

        //------------------------------------------------------- Accesos
        $data = new Accesos();
        $data->idmodulo   = 1;
        $data->idperfil   = 1;
        $data->editable   = false;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 2;
        $data->idperfil   = 1;
        $data->editable   = false;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 3;
        $data->idperfil   = 1;
        $data->editable   = false;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 4;
        $data->idperfil   = 1;
        $data->save();

        //------------------------------------------------------- Funcion
        $data = new Funcion();
        $data->nombre   = 'Ver';
        $data->funcion  = 'index';
        $data->orden    = 1;
        $data->editable = false;
        $data->save();

        $data = new Funcion();
        $data->nombre   = 'Crear';
        $data->funcion  = 'create';
        $data->orden    = 2;
        $data->editable = false;
        $data->save();

        $data = new Funcion();
        $data->nombre   = 'Editar';
        $data->funcion  = 'edit';
        $data->orden    = 3;
        $data->editable = false;
        $data->save();

        $data = new Funcion();
        $data->nombre   = 'Guardar';
        $data->funcion  = 'store';
        $data->orden    = 4;
        $data->editable = false;
        $data->save();

        $data = new Funcion();
        $data->nombre   = 'Eliminar';
        $data->funcion  = 'destroy';
        $data->orden    = 5;
        $data->editable = false;
        $data->save();

        //------------------------------------------------------- Permisos
        $permisos = [
            //Operaciones sobre tabla roles
            'index-modulo',
            'create-modulo',
            'edit-modulo',
            'store-modulo',
            'destroy-modulo',
        ];

        foreach($permisos as $permiso) {
            Permission::create(['name'=>$permiso]);
        }

        //------------------------------------------------------- Roles
        $rol = Role::create(['name' => 'Admin']);
        $permisos = Permission::pluck('id', 'id')->all();
        $rol->syncPermissions($permisos);        
        $user->assignRole($rol->id);
    }
}
