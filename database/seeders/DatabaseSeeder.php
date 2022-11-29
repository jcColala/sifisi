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
use App\Models\Funcion;
use App\Models\Funcion_modulo;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\SGCEntidad;
use App\Models\SGCEstado;
use App\Models\SGCTipo_accion;
use App\Models\SGCTipo_proceso;
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

        $data = new Persona();
        $data->dni                          = 71885613;    
        $data->idescuela                    = 1;
        $data->idestadopersona              = 1;
        $data->idtipopersona                = 1;
        $data->ubigeo_origen                = 1;
        $data->ubigeo_actual                = 1;
        $data->idtipo_documento_identidad   = 1;
        $data->idestado_civil               = 1;
        $data->idsexo                       = 1;
        $data->nombres                      = "Juan carlos";
        $data->apellido_paterno             = "Nose";
        $data->apellido_materno             = "Tampoco";
        $data->correo_institucional         = "arroba@alumno.unsm.edu.pe";
        $data->correo_personal              = "arroba@gmail.com";
        $data->direccion                    = "nose";
        $data->telefono                     = "917779907";
        $data->fecha_nacimiento             = "10-05-2000";
        $data->nacionalidad                 = "Peruano";
        $data->save();

        //------------------------------------------------------- Perfil
        $data = new Perfil();
        $data->perfil       = 'Administrador';
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
        $data->editable     = true;
        $data->save();

        $data = new Modulo_padre();
        $data->descripcion  = "Gestion de calidad";
        $data->abreviatura  = "SGC";
        $data->url          = "#";
        $data->icono        = "fe fe-file-text";
        $data->orden        = 2;
        $data->save();

        
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
        $data->editable         = true;
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
        $data->idmodulo_padre   = 1;
        $data->idpadre          = null;
        $data->modulo           = "Funcion";
        $data->abreviatura      = "Md";
        $data->url              = "funcion";
        $data->icono            = null;
        $data->orden            = 4;
        $data->editable         = true; 
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Entidades";
        $data->abreviatura      = "SGC_E";
        $data->url              = "entidad";
        $data->icono            = null;
        $data->orden            = 1;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Tipos de Proceso";
        $data->abreviatura      = "SGC_TP";
        $data->url              = "tipo_proceso";
        $data->icono            = null;
        $data->orden            = 2;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Procesos Nivel 0";
        $data->abreviatura      = "SGC_P0";
        $data->url              = "proceso_cero";
        $data->icono            = null;
        $data->orden            = 3;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Procesos Nivel 1";
        $data->abreviatura      = "SGC_P1";
        $data->url              = "proceso_uno";
        $data->icono            = null;
        $data->orden            = 4;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Indicadores";
        $data->abreviatura      = "SGC_I";
        $data->url              = "indicador";
        $data->icono            = null;
        $data->orden            = 5;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Movimientos";
        $data->abreviatura      = "SGC_MOV";
        $data->url              = "movimientos";
        $data->icono            = null;
        $data->orden            = 6;
        $data->save();

        //}

        //------------------------------------------------------- Role
        $rol = Role::create(['name' => 'SuperAdmin','editable' => false]);

        //------------------------------------------------------- Accesos
        $data = new Accesos();
        $data->idmodulo   = 1;
        $data->idperfil   = 1;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 2;
        $data->idperfil   = 1;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 3;
        $data->idperfil   = 1;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 5;
        $data->idperfil   = 1;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 6;
        $data->idperfil   = 1;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 7;
        $data->idperfil   = 1;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 8;
        $data->idperfil   = 1;
        $data->idrol      = 1;
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
        $data->clase    = 'btn btn-outline-primary';
        $data->icono    = 'fe fe-plus-circle';
        $data->orden    = 2;
        $data->mostrar  = "S";
        $data->boton    = "S";
        $data->editable = true;
        $data->save();

        $data = new Funcion();
        $data->nombre   = 'Editar';
        $data->funcion  = 'edit';
        $data->clase    = 'btn btn-outline-info';
        $data->icono    = 'fe fe-edit';
        $data->orden    = 3;
        $data->mostrar  = "S";
        $data->boton    = "S";
        $data->editable = true;
        $data->save();

        $data = new Funcion();
        $data->nombre   = 'Guardar';
        $data->funcion  = 'store';
        $data->orden    = 4;
        $data->editable = false;
        $data->save();

        $data = new Funcion();
        $data->nombre   = 'Elim/Rest';
        $data->funcion  = 'destroy';
        $data->clase    = 'btn btn-outline-default';
        $data->icono    = 'fe fe-circle';
        $data->orden    = 5;
        $data->mostrar  = "S";
        $data->boton    = "S";
        $data->editable = true;
        $data->save();

        $data = new Funcion();
        $data->nombre   = 'Accesos';
        $data->funcion  = 'acceso';
        $data->orden    = 6;
        $data->mostrar  = "S";
        $data->editable = true;
        $data->save();

        //------------------------------------------------------- Funcion_modulo

        $data = new Funcion_modulo();
        $data->idmodulo   = 1;
        $data->idfuncion  = 2;
        $data->save();

        $data = new Funcion_modulo();
        $data->idmodulo   = 1;
        $data->idfuncion  = 6;
        $data->save();

        $data = new Funcion_modulo();
        $data->idmodulo   = 3;
        $data->idfuncion  = 2;
        $data->save();

        $data = new Funcion_modulo();
        $data->idmodulo   = 3;
        $data->idfuncion  = 3;
        $data->save();

        $data = new Funcion_modulo();
        $data->idmodulo   = 3;
        $data->idfuncion  = 5;
        $data->save();

        //------------------------------------------------------- Permisos
        $permisos = [
            'index-accesos',
            'create-accesos',
            'acceso-accesos',
            'store-accesos',

            //modulo
            'index-modulo',
            'create-modulo',
            'edit-modulo',
            'store-modulo',
            'destroy-modulo',
        ];

        foreach($permisos as $permiso) {
            Permission::create(['name'=>$permiso]);
        }

        $permisos = Permission::pluck('id', 'id')->all();
        $rol->syncPermissions($permisos);        
        $user->assignRole($rol->id);
        $data->save();

        //--------------------------------------------------MOVSGC
        $data = new SGCEstado();
        $data->descripcion= 'Pendiente';
        $data->save();

        $data = new SGCEstado();
        $data->descripcion= 'Aceptado';
        $data->save();

        $data = new SGCEstado();
        $data->descripcion= 'Rechazado';
        $data->save();
        
        $data = new SGCTipo_accion();
        $data->descripcion = 'Registro';
        $data->save();

        $data = new SGCTipo_accion();
        $data->descripcion = 'Edición';
        $data->save();

        $data = new SGCTipo_accion();
        $data->descripcion = 'Eliminación';
        $data->save();

        $data = new SGCTipo_accion();
        $data->descripcion = 'Restauración';
        $data->save();

        //ENTIDADES
        $data = new SGCEntidad();
        $data->idpersona_solicita = '1';
        $data->descripcion = 'Decano';
        $data->cant_integrantes = 1;
        $data->editable = false;
        $data->save();

        $data = new SGCEntidad();
        $data->idpersona_solicita = '1';
        $data->descripcion = 'Director de escuela';
        $data->cant_integrantes = 1;
        $data->editable = false;
        $data->save();

        //TIPOS DE PROCESO
        $data = new SGCTipo_proceso();
        $data->idpersona_solicita = '1';
        $data->descripcion = 'Procesos Estratégicos';
        $data->codigo = 'PE';
        $data->editable = false;
        $data->save();

        $data = new SGCTipo_proceso();
        $data->idpersona_solicita = '1';
        $data->descripcion = 'Procesos Misionales';
        $data->codigo = 'PM';
        $data->editable = false;
        $data->save();
    }
}
