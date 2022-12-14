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
use App\Models\User;
use App\Models\Modulo_padre;
use App\Models\Modulo;
use App\Models\MOVSGCMov_estado;
use App\Models\Accesos;
use App\Models\COMCargo;
use App\Models\COMTipo_entidad;
use App\Models\Funcion;
use App\Models\Funcion_modulo;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\SGCEntidad;
use App\Models\SGCEstado;
use App\Models\SGCPeriodicidad;
use App\Models\SGCResolucion;
use App\Models\SGCTipo_accion;
use App\Models\SGCTipo_archivo;
use App\Models\SGCTipo_documento;
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
        $data->idescuela                    = 1;
        $data->idestadopersona              = 1;
        $data->idtipopersona                = 1;
        $data->ubigeo_origen                = 1;
        $data->ubigeo_actual                = 1;
        $data->idtipo_documento_identidad   = 1;
        $data->numero_documento_identidad   = 71104111;
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
        $data->idescuela                    = 1;
        $data->idestadopersona              = 1;
        $data->idtipopersona                = 1;
        $data->ubigeo_origen                = 1;
        $data->ubigeo_actual                = 1;
        $data->idtipo_documento_identidad   = 1;
        $data->numero_documento_identidad   = 11111111;
        $data->idestado_civil               = 1;
        $data->idsexo                       = 1;
        $data->nombres                      = "Juan Carlos";
        $data->apellido_paterno             = "Nose";
        $data->apellido_materno             = "Tampoco";
        $data->correo_institucional         = "arroba@alumno.unsm.edu.pe";
        $data->correo_personal              = "arroba@gmail.com";
        $data->direccion                    = "nose";
        $data->telefono                     = "917779907";
        $data->fecha_nacimiento             = "10-05-2000";
        $data->nacionalidad                 = "Peruano";
        $data->save();

        //------------------------------------------------------- Role
        $rol = Role::create(['name' => 'Super administrador', 'abreviatura' => 'Sadm','editable' => false]);

        //------------------------------------------------------- Usuario
        $user = new User();
        $user->idpersona    = 1;
        $user->idrol        = 1;
        $user->usuario      = "ADMIN";
        $user->password     = Hash::make("12tres");
        $user->save();
        
        //------------------------------------------------------- Mod Padre
        $data = new Modulo_padre();
        $data->descripcion  = "Seguridad";
        $data->abreviatura  = "Seg.";
        $data->url          = "#";
        $data->icono        = "ti-lock";
        $data->orden        = 1;
        $data->editable     = true;
        $data->save();

        $data = new Modulo_padre();
        $data->descripcion  = "Gestion de calidad";
        $data->abreviatura  = "SGC.";
        $data->url          = "#";
        $data->icono        = "fe fe-file-text";
        $data->orden        = 2;
        $data->save();

        $data = new Modulo_padre();
        $data->descripcion  = "Comisiones";
        $data->abreviatura  = "Com.";
        $data->url          = "#";
        $data->icono        = "mdi mdi-apple-finder";
        $data->orden        = 3;
        $data->save();

        $data = new Modulo_padre();
        $data->descripcion  = "Resoluciones";
        $data->abreviatura  = "Res.";
        $data->url          = "#";
        $data->icono        = "fe fe-file-text";
        $data->orden        = 4;
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
        $data->modulo           = "Tipos de Proceso";
        $data->abreviatura      = "SGC_TPR";
        $data->url              = "tipo_proceso";
        $data->icono            = null;
        $data->orden            = 1;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Procesos Nivel 0";
        $data->abreviatura      = "SGC_PR0";
        $data->url              = "proceso_cero";
        $data->icono            = null;
        $data->orden            = 2;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Procesos Nivel 1";
        $data->abreviatura      = "SGC_PR1";
        $data->url              = "proceso_uno";
        $data->icono            = null;
        $data->orden            = 3;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Procedimientos";
        $data->abreviatura      = "SGC_PRC";
        $data->url              = "procedimiento";
        $data->icono            = null;
        $data->orden            = 4;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Indicadores Nivel 1";
        $data->abreviatura      = "SGC_IND1";
        $data->url              = "ficha_indicador_uno";
        $data->icono            = null;
        $data->orden            = 5;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Indicadores de Procedimientos";
        $data->abreviatura      = "SGC_INDPR";
        $data->url              = "ficha_indicador_procedimiento";
        $data->icono            = null;
        $data->orden            = 6;
        $data->save();


        $data = new Modulo();
        $data->idmodulo_padre   = 2;
        $data->idpadre          = null;
        $data->modulo           = "Documentos";
        $data->abreviatura      = "SGC_DOC";
        $data->url              = "documentos";
        $data->icono            = null;
        $data->orden            = 7;
        $data->save();


        $data = new Modulo();
        $data->idmodulo_padre   = 3;
        $data->idpadre          = null;
        $data->modulo           = "Comision";
        $data->abreviatura      = "Com";
        $data->url              = "comision";
        $data->icono            = null;
        $data->orden            = 1;
        $data->save();

        $data = new Modulo();
        $data->idmodulo_padre   = 4;
        $data->idpadre          = null;
        $data->modulo           = "Resoluciones";
        $data->abreviatura      = "res";
        $data->url              = "resoluciones";
        $data->icono            = null;
        $data->orden            = 1;
        $data->save();

        //}

        //------------------------------------------------------- Accesos
        $data = new Accesos();
        $data->idmodulo   = 1;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 2;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 3;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 4;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 5;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 6;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 7;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 8;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 9;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 10;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 11;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 12;
        $data->idrol      = 1;
        $data->save();

        $data = new Accesos();
        $data->idmodulo   = 13;
        $data->idrol      = 1;
        $data->save();


        //------------------------------------------------------- Funcion
        $data = new Funcion();
        $data->nombre   = 'Listar';
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
        $data->nombre   = 'Aprobar';
        $data->funcion  = 'aprobar';
        $data->clase    = 'btn btn-outline-warning';
        $data->icono    = 'fe fe-check';
        $data->orden    = 3;
        $data->mostrar  = "S";
        $data->boton    = "S";
        $data->editable = true;
        $data->save();

        $data = new Funcion();
        $data->nombre   = 'Ver';
        $data->funcion  = 'ver';
        $data->clase    = 'btn btn-outline-secondary';
        $data->icono    = 'fe fe-eye';
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

        //--------------------------------------------------- Permisos
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




        //----------------PERIODICIDAD
        $data = new SGCPeriodicidad();
        $data->idpersona_solicita = '1';
        $data->descripcion = 'Mensual';
        $data->save();

        $data = new SGCPeriodicidad();
        $data->idpersona_solicita = '1';
        $data->descripcion = 'Bimensual';
        $data->save();

        $data = new SGCPeriodicidad();
        $data->idpersona_solicita = '1';
        $data->descripcion = 'Trimestral';
        $data->save();

        $data = new SGCPeriodicidad();
        $data->idpersona_solicita = '1';
        $data->descripcion = 'Cuatrimestral';
        $data->save();

        $data = new SGCPeriodicidad();
        $data->idpersona_solicita = '1';
        $data->descripcion = 'Semenstrarl';
        $data->save();

        $data = new SGCPeriodicidad();
        $data->idpersona_solicita = '1';
        $data->descripcion = 'Anual';
        $data->save();

        $data = new SGCPeriodicidad();
        $data->idpersona_solicita = '1';
        $data->descripcion = 'Bianual';
        $data->save();

        $data = new SGCPeriodicidad();
        $data->idpersona_solicita = '1';
        $data->descripcion = 'Trianual';
        $data->save();
    }
}