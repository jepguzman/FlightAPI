<?php
require 'flight/Flight.php';
require 'flight/rb.php';

header('Access-Control-Allow-Origin: *');
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

R::setup( 'mysql:host=147.135.39.236;dbname=cbtisnet_secundaria', 'cbtisnet_secundaria', '07DES0005E' );


Flight::route('/', function () {
    require 'app/header.php';
    SESSION_START();        
    $_SESSION['server']="https://cbtis169.net/Secundaria/";
    ?>
    <div class="container mt-3">
    <h1 class="text text-center">Accesso al Sistema</h1>
    <form action="<?php echo $_SESSION['server'] ?>login" method="POST">
        <div class="input-group row align-items-center">
            <div class="col-3 mt-3">
            </div>
            <div class="col-3 mt-3">
                <span class="input-group-text">Usuario y Contraseña</span>
                <input type="text" class="mt-3" name="usuario" class="form-control">
                <input type="password" class="mt-3" name="clave" class="form-control">
            </div>
            <div class="col-3 mt-3">
                <input type="submit" class="btn btn-primary">
            </div>
            <div class="col-3">                
            </div>
        </div>        
    </div>
    </form>
    <?php
    require 'app/footer.php';
});

Flight::route('/login', function () {
    $usuario=Flight::request()->data->usuario;
    $clave=Flight::request()->data->clave;
    $query = "usuario = '". $usuario."' AND clave = '".$clave."'  ";
    $data = R::find( 'usuarios', $query);
    SESSION_START();
    if($data)
    {
        foreach ($data as $x => $y) {        
            $_SESSION['iduser']=$x;
        }
        Flight::redirect('/menu');
    }
    else
    {Flight::redirect('/');}
});

Flight::route('/menu', function () {
SESSION_START();
if ($_SESSION['iduser'] == '')
    {
        Flight::redirect('/');
    }
else
    {
        require 'app/header.php';
        ?> 
        <div class="container mt-3">
        <h1>Bienvenidos al Sistema</h1>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="navbar-nav">
                    <a class="nav-link " aria-current="page" href="#">Catálogos</a>
                    <a class="nav-link" href="<?php echo $_SESSION['server'] ?>altaAlumnos">Alta de Alumnos</a>
                    <a class="nav-link" href="<?php echo $_SESSION['server'] ?>verAlumnos">Listado de Alumnos</a>
                    <a class="nav-link" href="<?php echo $_SESSION['server'] ?>Salir">Salir</a>
                </div>
            </div>
        </nav>
        <?php
        require 'app/footer.php';
    }
});

Flight::route('/Salir', function () {
    SESSION_START();
    $_SESSION['iduser']='';
    //session_destroy();
        Flight::redirect('/');
});

Flight::route('/altaAlumnos', function () {
    SESSION_START();
    if ($_SESSION['iduser'] == '')
        {
            Flight::redirect('/');
        }
    else
        {
            require 'app/headervistas.php';
            ?> 
            <div class="container mt-3">
            <h1>Ingresar alumnos al Sistema</h1>
            <form action="<?php echo $_SESSION['server'] ?>crearAlumno" method="POST">
                <div class="container text-center mt-3">
            
            <div class="row">
            <div class="col-6">
                <div class="input-group mb-3">
                <span class="input-group-text">CURP</span>
                <input type="text" name="curp" class="form-control">
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">NOMBRE(s)</span>
                <input type="text" name="nombres" class="form-control">
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">PATERNO</span>
                <input type="text" name="paterno" class="form-control">
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">MATERNO</span>
                <input type="text" name="materno" class="form-control">
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">FNAC</span>
                <input type="date" name="fnacimiento" value="2012-01-01" min="2000-01-01" max="2099-12-31" class="form-control">

                <label class="input-group-text">SEXO</label>
                <select class="form-select" name="sexo" >
                    <option selected>Elija...</option>
                    <option value="HOMBRE">HOMBRE</option>
                    <option value="MUJER">MUJER</option>
                </select>
                </div>
                <div class="input-group mb-3">
                <label class="input-group-text">TURNO</label>
                <select class="form-select" name="turno" >
                    <option selected>Elija...</option>
                    <option value="MATUTINO">MATUTINO</option>
                    <option value="VESPERTINO">VESPERTINO</option>
                </select>

                <label class="input-group-text">GRUPO</label>
                <select class="form-select" name="grupo" >
                    <option selected>Elija...</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                    <option value="E">E</option>
                    <option value="F">F</option>
                    <option value="G">G</option>
                    <option value="H">H</option>
                </select>
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">BECA</span>
                <input type="text" class="form-control">
                </div>
                <div class="input-group mb-3">
                <label class="input-group-text">GENERACION</label>
                <select class="form-select" name="generacion" >
                    <option selected>Elija...</option>
                    <option value="2022-2025">2022-2025</option>
                    <option value="2023-2026">2023-2026</option>
                    <option value="2024-2027">2024-2027</option>
                    <option value="2025-2028">2025-2028</option>
                </select>
                </div>
            </div>

            <div class="col-6">
                <div class="input-group mb-3">
                <span class="input-group-text">CALLE</span>
                <input type="text" name="calle" class="form-control">
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">NÚMERO</span>
                <input type="text" name="numero" class="form-control">
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">COLONIA</span>
                <input type="text" name="colonia" class="form-control">
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">LOCALIDAD</span>
                <input type="text" name="localidad" class="form-control">
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">MUNICIPIO</span>
                <input type="text" name="municipio" class="form-control">
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">ENTIDAD</span>
                <select name="entidad" class="form-select">
                    <option selected value="CHIAPAS">CHIAPAS</option>
                    <option value="CDMX">CDMX</option>
                    <option value="AGUASCALIENTES">AGUASCALIENTES</option>
                    <option value="BAJA CALIFORNIA NORTE">BAJA CALIFORNIA NORTE</option>
                    <option value="BAJA CALIFORNIA SUR">BAJA CALIFORNIA SUR</option>
                    <option value="CAMPECHE">CAMPECHE</option>
                    <option value="CHIAPAS">CHIAPAS</option>
                    <option value="CHIHUAHUA">CHIHUAHUA</option>
                    <option value="COAHUILA">COAHUILA</option>
                    <option value="COLIMA">COLIMA</option>
                    <option value="DURANGO">DURANGO</option>
                    <option value="GUANAJUATO">GUANAJUATO</option>
                    <option value="GUERRERO">GUERRERO</option>
                    <option value="HIDALGO">HIDALGO</option>
                    <option value="JALISCO">JALISCO</option>
                    <option value="EDO. DE MEXICO">EDO. DE MEXICO</option>
                    <option value="MICHOACAN">MICHOACAN</option>
                    <option value="MORELOS">MORELOS</option>
                    <option value="NAYARIT">NAYARIT</option>
                    <option value="NUEVO LEON">NUEVO LEON</option>
                    <option value="OAXACA">OAXACA</option>
                    <option value="PUEBLA">PUEBLA</option>
                    <option value="QUERETARO">QUERETARO</option>
                    <option value="QUINTANA ROO">QUINTANA ROO</option>
                    <option value="SAN LUIS POTOSI">SAN LUIS POTOSI</option>
                    <option value="SINALOA">SINALOA</option>
                    <option value="SONORA">SONORA</option>
                    <option value="TABASCO">TABASCO</option>
                    <option value="TAMAULIPAS">TAMAULIPAS</option>
                    <option value="TLAXCALA">TLAXCALA</option>
                    <option value="VERACRUZ">VERACRUZ</option>
                    <option value="YUCATAN">YUCATAN</option>
                    <option value="ZACATECAS">ZACATECAS</option>
                </select>
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">TELEFONO</span>
                <input name="telefono" class="form-control"
                    placeholder="___-___-____" data-slots="_">
                </div>
                <div class="input-group mb-3">
                <span class="input-group-text">TUTOR</span>
                <input type="text" name="tutor" class="form-control">
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col">
            <input type="submit" class="btn btn-primary" value="Grabar datos">
            </div>
            <div class="col">                
                    <a class="btn btn-success" href="<?php echo $_SESSION['server'] ?>menu">Regresar al menú</a>
                    </div>
            </div>
            </div>
        </div>        
        </div>
</form>
    <?php
    }
require 'app/footer.php';
});


Flight::route('/crearAlumno', function () {
SESSION_START();
if ($_SESSION['iduser'] == '')
    {
        Flight::redirect('/');
    }
else
    {
    $alumnos = R::dispense('alumnos');
    $alumnos->curp=Flight::request()->data->curp;
        $alumnos->curp=strtoupper($alumnos->curp);
    $alumnos->generacion=Flight::request()->data->generacion;
    $alumnos->generacion=Flight::request()->data->generacion;
    $alumnos->nombres=Flight::request()->data->nombres;
        $alumnos->nombres=strtoupper($alumnos->nombres);
    $alumnos->paterno=Flight::request()->data->paterno;
        $alumnos->paterno=strtoupper($alumnos->paterno);
    $alumnos->materno=Flight::request()->data->materno;
        $alumnos->materno=strtoupper($alumnos->materno);
    $alumnos->fnacimiento=Flight::request()->data->fnacimiento;
    $alumnos->sexo=Flight::request()->data->sexo;
    $alumnos->turno=Flight::request()->data->turno;
    $alumnos->grupo=Flight::request()->data->grupo;
    $alumnos->beca=Flight::request()->data->beca;
    $alumnos->calle=Flight::request()->data->calle;
        $alumnos->calle=strtoupper($alumnos->calle);
    $alumnos->numero=Flight::request()->data->numero;
    $alumnos->colonia=Flight::request()->data->colonia;
        $alumnos->colonia=strtoupper($alumnos->colonia);
    $alumnos->localidad=Flight::request()->data->localidad;
        $alumnos->localidad=strtoupper($alumnos->localidad);
    $alumnos->municipio=Flight::request()->data->municipio;
        $alumnos->municipio=strtoupper($alumnos->municipio);
    $alumnos->entidad=Flight::request()->data->entidad;
    $alumnos->telefono=Flight::request()->data->telefono;
    $alumnos->tutor=Flight::request()->data->tutor;
        $alumnos->tutor=strtoupper($alumnos->tutor);
    $alumnos->observacion=Flight::request()->data->observacion;
    $alumnos->userid=$_SESSION['iduser'];
    $id = R::store($alumnos);

    require 'app/header.php';
    ?> 
    <div class="container mt-3 text-center">
    <h1>Alumno creado exitosamente</h1>
        <div class="input-group row align-items-center">
            <div class="col-4">
                <a class="btn btn-primary" href="<?php echo $_SESSION['server'] ?>menu">Ir al Menú de Opciones</a>    
            </div>
            <div class="col-4 mt-3">
            <a class="btn btn-success" href="<?php echo $_SESSION['server'] ?>altaAlumnos">Continuar Alta de Alumnos</a>
            </div>
            <div class="col-4 mt-3">                
            <a class="btn btn-danger" href="<?php echo $_SESSION['server'] ?>Salir">Salir del Sistema</a>
            </div>
        </div>        
    </div>
    <?php
    require 'app/footer.php';
    }
});


Flight::route('/getAlumnos', function () {
    SESSION_START();
    if ($_SESSION['iduser'] == '')
        {
            Flight::redirect('/');
        }
    else
        {
            //$alumnos = R::findAll( 'alumnos' );
            $alumnos = R::getAll( 'SELECT * FROM alumnos ORDER BY id ASC' );
            Flight::json($alumnos);     
        }
});        

Flight::route('/verAlumnos', function () {
SESSION_START();
if ($_SESSION['iduser'] == '')
    {
        Flight::redirect('/');
    }
else
    { 
    require 'app/header.php';
    ?>
    <div id="app" class="container mt-3">

        <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">CURP</th>
            <th scope="col">NOMBRE</th>
            <th scope="col">FNACIMIENTO</th>
            <th scope="col">SEXO</th>
            <th scope="col">TURNO</th>
            <th scope="col">GRUPO</th>
            <th scope="col">ACCION</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in alumnos">
            <th scope="row">{{item.id}}</th>
            <td>{{item.curp}}</td>
            <td>{{item.nombres}} {{item.paterno}} {{item.materno}}</td>
            <td>{{item.fnacimiento}}</td>
            <td>{{item.sexo}}</td>
            <td>{{item.turno}}</td>
            <td>{{item.grupo}}</td>

            <td><a v-bind:href="item.url+item.id"
                class="btn btn-warning">Editar</a></td>
            </tr>
        </tbody>
        </table>
        <div class="input-group row align-items-center">
            <div class="col-4">
                
            </div>
            <div class="col-4 mt-3">
            <a class="btn btn-primary" href="<?php echo $_SESSION['server'] ?>menu">Ir al Menú de Opciones</a>    
            </div>
            <div class="col-4 mt-3">                
            
            </div>
        </div>
    </div>
    <?php
        require 'app/footervue.php';
    }
});        

Flight::route('/getAlumno/@id', function ($id) {
    SESSION_START();
    if ($_SESSION['iduser'] == '')
        {
            Flight::redirect('/');
        }
    else
        {
            require 'app/headervistas.php';
            ?> 
            
            <div class="container mt-3 text-center">
            <h1>Datos del Alumno</h1>
                    
            <?php
                $alumno  = R::findAll( 'alumnos' , ' id = ? ', [ $id ]);
                $actualiza="actualizarAlumno/";
                $url=$_SESSION['server'].$actualiza.$id;
                //echo $url;
            ?>
                <form action="<?php echo $url ?>" method="POST">
                    
                <div class="row">
                <div class="col-6">
                    <div class="input-group mb-3">
                    <span class="input-group-text">ID</span>
                    <input disabled type="text" name="id" value="<?php echo $alumno[$id]->id; ?>" class="form-control" >
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text">CURP</span>
                    <input type="text" name="curp" value="<?php echo $alumno[$id]->curp; ?>" class="form-control" >
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text">NOMBRE(s)</span>
                    <input type="text" name="nombres" value="<?php echo $alumno[$id]->nombres; ?>" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text">PATERNO</span>
                    <input type="text" name="paterno" value="<?php echo $alumno[$id]->paterno; ?>" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text">MATERNO</span>
                    <input type="text" name="materno" value="<?php echo $alumno[$id]->materno; ?>" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text">FNAC</span>
                    <input type="date" name="fnacimiento" value="<?php echo $alumno[$id]->fnacimiento; ?>"
                    value="2012-01-01" min="2000-01-01" max="2099-12-31" class="form-control">
    
                    <label class="input-group-text">SEXO</label>
                    <select class="form-select" name="sexo" >
                        <option selected><?php echo $alumno[$id]->sexo; ?></option>
                        <option value="HOMBRE">HOMBRE</option>
                        <option value="MUJER">MUJER</option>
                    </select>
                    </div>
                    <div class="input-group mb-3">
                    <label class="input-group-text">TURNO</label>
                    <select class="form-select" name="turno" >
                        <option selected><?php echo $alumno[$id]->turno; ?></option>
                        <option value="MATUTINO">MATUTINO</option>
                        <option value="VESPERTINO">VESPERTINO</option>
                    </select>
    
                    <label class="input-group-text">GRUPO</label>
                    <select class="form-select" name="grupo" >
                        <option selected><?php echo $alumno[$id]->grupo; ?></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <option value="F">F</option>
                        <option value="G">G</option>
                        <option value="H">H</option>
                    </select>
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text">BECA</span>
                    <input type="text" value="<?php echo $alumno[$id]->beca; ?>" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                    <label class="input-group-text">GENERACION</label>
                    <select class="form-select" name="generacion" >
                        <option selected><?php echo $alumno[$id]->generacion; ?></option>
                        <option value="2022-2024">2022-2024</option>
                        <option value="2023-2025">2023-2025</option>
                        <option value="2024-2026">2024-2026</option>
                        <option value="2025-2027">2025-2027</option>
                    </select>
                    </div>
                </div>
    
                <div class="col-6">
                    <div class="input-group mb-3">
                    <span class="input-group-text">CALLE</span>
                    <input type="text" name="calle" value="<?php echo $alumno[$id]->calle; ?>" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text">NÚMERO</span>
                    <input type="text" name="numero" value="<?php echo $alumno[$id]->numero; ?>" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text">COLONIA</span>
                    <input type="text" name="colonia" value="<?php echo $alumno[$id]->colonia; ?>" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text">LOCALIDAD</span>
                    <input type="text" name="localidad" value="<?php echo $alumno[$id]->localidad; ?>" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text">MUNICIPIO</span>
                    <input type="text" name="municipio" value="<?php echo $alumno[$id]->municipio; ?>" class="form-control">
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text">ENTIDAD</span>
                    <select name="entidad" class="form-select">
                        <option selected><?php echo $alumno[$id]->entidad; ?></option>
                        <option value="CDMX">CDMX</option>
                        <option value="AGUASCALIENTES">AGUASCALIENTES</option>
                        <option value="BAJA CALIFORNIA NORTE">BAJA CALIFORNIA NORTE</option>
                        <option value="BAJA CALIFORNIA SUR">BAJA CALIFORNIA SUR</option>
                        <option value="CAMPECHE">CAMPECHE</option>
                        <option value="CHIAPAS">CHIAPAS</option>
                        <option value="CHIHUAHUA">CHIHUAHUA</option>
                        <option value="COAHUILA">COAHUILA</option>
                        <option value="COLIMA">COLIMA</option>
                        <option value="DURANGO">DURANGO</option>
                        <option value="GUANAJUATO">GUANAJUATO</option>
                        <option value="GUERRERO">GUERRERO</option>
                        <option value="HIDALGO">HIDALGO</option>
                        <option value="JALISCO">JALISCO</option>
                        <option value="EDO. DE MEXICO">EDO. DE MEXICO</option>
                        <option value="MICHOACAN">MICHOACAN</option>
                        <option value="MORELOS">MORELOS</option>
                        <option value="NAYARIT">NAYARIT</option>
                        <option value="NUEVO LEON">NUEVO LEON</option>
                        <option value="OAXACA">OAXACA</option>
                        <option value="PUEBLA">PUEBLA</option>
                        <option value="QUERETARO">QUERETARO</option>
                        <option value="QUINTANA ROO">QUINTANA ROO</option>
                        <option value="SAN LUIS POTOSI">SAN LUIS POTOSI</option>
                        <option value="SINALOA">SINALOA</option>
                        <option value="SONORA">SONORA</option>
                        <option value="TABASCO">TABASCO</option>
                        <option value="TAMAULIPAS">TAMAULIPAS</option>
                        <option value="TLAXCALA">TLAXCALA</option>
                        <option value="VERACRUZ">VERACRUZ</option>
                        <option value="YUCATAN">YUCATAN</option>
                        <option value="ZACATECAS">ZACATECAS</option>
                    </select>
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text">TELEFONO</span>
                    <input name="telefono" value="<?php echo $alumno[$id]->telefono; ?>" class="form-control"
                        placeholder="___-___-____" data-slots="_">
                    </div>
                    <div class="input-group mb-3">
                    <span class="input-group-text">TUTOR</span>
                    <input type="text" name="tutor" value="<?php echo $alumno[$id]->tutor; ?>" class="form-control">
                    </div>
                </div>
                </div>
                <div class="row">
                <div class="col">
                <input type="submit" class="btn btn-primary" value="Actualizar">
                </div>
                <div class="col">                
                        <a class="btn btn-success" href="<?php echo $_SESSION['server'] ?>menu">Regresar al menú</a>
                        </div>
                </div>
                </div>
            </div>        
            </div>
    </form>
    <?php
            require 'app/footer.php';
        }
    });
    
Flight::route('/actualizarAlumno/@id', function ($id) {
    SESSION_START();
    if ($_SESSION['iduser'] == '')
        {
            Flight::redirect('/');
        }
    else
        {
        $alumnos = R::load('alumnos',$id);
        
        $alumnos->curp=Flight::request()->data->curp;
            $alumnos->curp=strtoupper($alumnos->curp);
        $alumnos->generacion=Flight::request()->data->generacion;
        $alumnos->generacion=Flight::request()->data->generacion;
        $alumnos->nombres=Flight::request()->data->nombres;
            $alumnos->nombres=strtoupper($alumnos->nombres);
        $alumnos->paterno=Flight::request()->data->paterno;
            $alumnos->paterno=strtoupper($alumnos->paterno);
        $alumnos->materno=Flight::request()->data->materno;
            $alumnos->materno=strtoupper($alumnos->materno);
        $alumnos->fnacimiento=Flight::request()->data->fnacimiento;
        $alumnos->sexo=Flight::request()->data->sexo;
        $alumnos->turno=Flight::request()->data->turno;
        $alumnos->grupo=Flight::request()->data->grupo;
        $alumnos->beca=Flight::request()->data->beca;
        $alumnos->calle=Flight::request()->data->calle;
            $alumnos->calle=strtoupper($alumnos->calle);
        $alumnos->numero=Flight::request()->data->numero;
        $alumnos->colonia=Flight::request()->data->colonia;
            $alumnos->colonia=strtoupper($alumnos->colonia);
        $alumnos->localidad=Flight::request()->data->localidad;
            $alumnos->localidad=strtoupper($alumnos->localidad);
        $alumnos->municipio=Flight::request()->data->municipio;
            $alumnos->municipio=strtoupper($alumnos->municipio);
        $alumnos->entidad=Flight::request()->data->entidad;
        $alumnos->telefono=Flight::request()->data->telefono;
        $alumnos->tutor=Flight::request()->data->tutor;
            $alumnos->tutor=strtoupper($alumnos->tutor);
        $alumnos->observacion=Flight::request()->data->observacion;
        $alumnos->userid=$_SESSION['iduser'];
        R::store($alumnos);
    
        require 'app/header.php';
        ?> 
        <div class="container mt-3 text-center">
        <h1>Alumno actualizado exitosamente</h1>
            <div class="input-group row align-items-center">
                <div class="col-4">
                    <a class="btn btn-primary" href="<?php echo $_SESSION['server'] ?>menu">Ir al Menú de Opciones</a>    
                </div>
                <div class="col-4 mt-3">
                <a class="btn btn-success" href="<?php echo $_SESSION['server'] ?>verAlumnos">Lista de Alumnos</a>
                </div>
                <div class="col-4 mt-3">                
                <a class="btn btn-danger" href="<?php echo $_SESSION['server'] ?>Salir">Salir del Sistema</a>
                </div>
            </div>        
        </div>
        <?php
        require 'app/footer.php';
        }
    });
    


//Inicializa el FrameWork
Flight::start();
?>


