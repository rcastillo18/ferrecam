<?php
include 'conexion.php';
include 'security.php';
//include 'header.php';

$conexion = conectar();//en conexion.php

$id = NULL;

$accion = NULL;

if(isset($_GET['id'])){
    $id = $_GET['id'];

}
   # echo $id;
if(isset($_GET['accion_ingreso'])){
    $accion = $_GET['accion_ingreso'];
}

if(isset($_GET['accion'])){
    $accion = $_GET['accion'];
}

if(isset($_POST['accion_ingreso'])){
    $accion = $_POST['accion_ingreso'];
}

switch($accion){

    case 'actualizar_Configuracion':
        $idConfiguracion = ($_POST['idConfiguracion']);
        $tasaDolarCosto = ($_POST['tasaDolarCosto']);
        $tasaDolarVenta = ($_POST['tasaDolarVenta']);
        actualizarConfig($idConfiguracion, $tasaDolarCosto, $tasaDolarVenta); 
        break;

    case 'actualizar_Empresa':
        $idEmpresa = ($_POST['idEmpresa']);
        $nombre = strtoupper($_POST['nombre']);
        $rif = ($_POST['rif']);
        $telefono = ($_POST['telefono']);
        $correo = strtoupper($_POST['correo']);
        $direccion = strtoupper($_POST['direccion']);
        $ciudad = strtoupper($_POST['ciudad']);
        $estado = strtoupper($_POST['estado']);
        $codigoPostal = ($_POST['codigoPostal']);
        $mensaje = strtoupper($_POST['mensaje']);
        actualizarE($idEmpresa, $nombre, $rif, $telefono, $correo, $direccion, $ciudad, $estado, $codigoPostal, $mensaje); 
        break;

    case 'actualizar_Producto':
        $idProducto = ($_POST['idProducto']);
        $codigo = ($_POST['codigo']);
        $descripcion = strtoupper($_POST['descripcion']);
        $costoUSD = ($_POST['costoUSD']);
        $porcentajeG = ($_POST['porcentajeG']);
        $categoria = strtoupper($_POST['categoria']);
        $precioGanUSD = ((($_POST['costoUSD']*($_POST['porcentajeG']))/100)+($_POST['costoUSD']));
        $cantidadIngresar = ($_POST['cantidadIngresar']);
        $cantidadAlerta = ($_POST['cantidadAlerta']);
        $existencia = ($_POST['existencia'] + $_POST['cantidadIngresar']);
        actualizar($codigo, $descripcion, $costoUSD, $porcentajeG, $categoria, $precioGanUSD, $cantidadIngresar, $cantidadAlerta, $existencia, $idProducto); 
        break;

    case 'agregar_Clientes':
        $idCedula = ($_POST['idCedula']);
        $nombre = strtoupper($_POST['nombre']);
        $comentarios = strtoupper($_POST['comentarios']);
        $telefono = ($_POST['telefono']);
        agregarC($idCedula ,$nombre, $comentarios, $telefono); 
        break;

    case 'actualizar_Clientes':
        $idCedula = ($_POST['idCedula']);
        $nombre = strtoupper($_POST['nombre']);
        $comentarios = strtoupper($_POST['comentarios']);
        $telefono = ($_POST['telefono']);
        actualizarC($idCedula ,$nombre, $comentarios, $telefono);  
        break;

    case 'nuevo_Producto':
    	$idProducto = ($_POST['idProducto']);
    	$codigo = ($_POST['codigo']);
		$descripcion = strtoupper($_POST['descripcion']);
		$costoUSD = ($_POST['costoUSD']);
		$porcentajeG = ($_POST['porcentajeG']);
		$categoria = strtoupper($_POST['categoria']);
        $proovedor = strtoupper($_POST['proovedor']);
		$precioGanUSD = ((($_POST['costoUSD']*($_POST['porcentajeG']))/100)+($_POST['costoUSD']));
		$cantidadIngresar = ($_POST['cantidadIngresar']);
		$cantidadAlerta = ($_POST['cantidadAlerta']);
		$existencia = ($_POST['cantidadIngresar']);
        productos($idProducto ,$codigo, $descripcion, $costoUSD, $porcentajeG, $categoria, $proovedor, $precioGanUSD, $cantidadIngresar, $cantidadAlerta, $existencia); 
        break;

    case 'ingreso':
        $usuario = validar($_POST['usuario']);
        $password = validar($_POST['password']);
        verificarIngreso($usuario, $password);
        break;

}

function consultarProducto($id){   
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];
    global $conexion;

    try{
       
        $sql = "SELECT * FROM producto WHERE idProducto = ? ";
            $st = $conexion->prepare($sql);
            $st->bindParam(1, $id);
            $st->execute();
            $consultarP = $st->fetch(PDO::FETCH_ASSOC); 
 
    }catch(PDOException $e){
        $resultado['error'] = true;
        $resultado['mensaje'] = $e->getMessage();
        //echo $e;
    }
    return $consultarP;
}

function consultarInventario($id){   
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];
    global $conexion;

    try{
       
        $sql = "SELECT * FROM producto WHERE idProducto = ? ";
            $st = $conexion->prepare($sql);
            $st->bindParam(1, $id);
            $st->execute();
            $consultarI = $st->fetch(PDO::FETCH_ASSOC); 
 
    }catch(PDOException $e){
        $resultado['error'] = true;
        $resultado['mensaje'] = $e->getMessage();
        //echo $e;
    }
    return $consultarI;
}


function agregarV($idVenta, $numeroVenta ,$idCedula ,$idProducto, $cantidadPedido ,$totalPagar, $totalVenta, $fecha, $comentario, $vendedor){
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];
        global $conexion;

        try{
             $sql = 'INSERT INTO venta (idVenta, numeroVenta, idCedula ,idProducto, cantidadPedido, totalPagar, totalVenta, fecha, comentario, vendedor) VALUES (?,?,?,?,?,?,?,?,?,?)';
            
            $st = $conexion->prepare($sql);
            $st->bindParam(1, $idVenta);
            $st->bindParam(2, $numeroVenta);
            $st->bindParam(3, $idCedula);
            $st->bindParam(4, $idProducto);
            $st->bindParam(5, $cantidadPedido);
            $st->bindParam(6, $totalPagar);
            $st->bindParam(7, $totalVenta);
            $st->bindParam(8, $fecha);
            $st->bindParam(9, $comentario);
            $st->bindParam(10, $vendedor);
            $st->execute();
          //  header('location:login.php');
         //   echo '<script>
            //   Recarga todos los frames de la página
            //   parent.location.reload();
            //   </script>';

        }catch(PDOException $e){
            $resultado['error'] = true;
            $resultado['mensaje'] = $e->getMessage();
            echo $e;
        }
}


function agregarC($idCedula ,$nombre, $comentarios, $telefono){
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];
        global $conexion;

        try{
             $sql = 'INSERT INTO cliente (idCedula ,nombre, comentarios, telefono) VALUES (?,?,?,?)';
            
            $st = $conexion->prepare($sql);
            $st->bindParam(1, $idCedula);
            $st->bindParam(2, $nombre);
            $st->bindParam(3, $comentarios);
            $st->bindParam(4, $telefono);
            $st->execute(); 
            header('location:ventas.php');
         //   echo '<script>
			//	 Recarga todos los frames de la página
			//	 parent.location.reload();
			//	 </script>';

        }catch(PDOException $e){
            $resultado['error'] = true;
            $resultado['mensaje'] = $e->getMessage();
            echo $e;
        }
}

function mostrarClientes(){   
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];

    global $conexion;

    try{
        
        $sql = 'SELECT idCedula ,nombre, comentarios, telefono FROM cliente ORDER BY idCedula';
        $st = $conexion->prepare($sql);
        $st->execute();
        $clientes = $st->fetchAll();        
    }catch(PDOException $e){
        $resultado['error'] = true;
        $resultado['mensaje'] = $e->getMessage();
        echo $e;
    }
    return $clientes;	
}

function consultarCliente($id){   
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];
    global $conexion;

    try{
       
        $sql = "SELECT * FROM cliente WHERE idCedula = ? ";
            $st = $conexion->prepare($sql);
            $st->bindParam(1, $id);
            $st->execute();
            $consultarC = $st->fetch(PDO::FETCH_ASSOC); 
 
    }catch(PDOException $e){
        $resultado['error'] = true;
        $resultado['mensaje'] = $e->getMessage();
        //echo $e;
    }
    return $consultarC;
}

function actualizarC($idCedula ,$nombre, $comentarios, $telefono){
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];
        global $conexion;

        try{
             $sql = 'UPDATE cliente SET nombre = ?, comentarios = ?, telefono = ? WHERE idCedula = ? ';
            
            $st = $conexion->prepare($sql);
            
            $st->bindParam(1, $nombre);
            $st->bindParam(2, $comentarios);
            $st->bindParam(3, $telefono);
            $st->bindParam(4, $idCedula);
            $st->execute();

       //     echo '<script>
                 // Recarga todos los frames de la página
       //          parent.location.reload();
       //          </script>';
            header('location:clientes.php');
        }catch(PDOException $e){
            $resultado['error'] = true;
            $resultado['mensaje'] = $e->getMessage();
            echo $e;
        }
}

function actualizarConfig($idConfiguracion, $tasaDolarCosto, $tasaDolarVenta){
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];
        global $conexion;

        try{
             $sql = 'UPDATE configuracion SET idConfiguracion = ?, tasaDolarCosto = ?, tasaDolarVenta = ?';
            
            $st = $conexion->prepare($sql);
            
            $st->bindParam(1, $idConfiguracion);
            $st->bindParam(2, $tasaDolarCosto);
            $st->bindParam(3, $tasaDolarVenta);
            $st->execute();

       //     echo '<script>
       //          // Recarga todos los frames de la página
       //          parent.location.reload();
       //          </script>';
            header('location:config.php');
        }catch(PDOException $e){
            $resultado['error'] = true;
            $resultado['mensaje'] = $e->getMessage();
            echo $e;
        }
}

function mostrarConfig(){   
    $resultado = [
        'error' => false,
        'mensaje' => '',
        'configuracion' => []  // Inicializar el array para los resultados de la configuración
    ];

    global $conexion;

    try{
        $sql = 'SELECT idConfiguracion, tasaDolarCosto, tasaDolarVenta FROM configuracion ORDER BY idConfiguracion';
        $st = $conexion->prepare($sql);
        $st->execute();
        $resultado['configuracion'] = $st->fetchAll(PDO::FETCH_ASSOC) ?: [];  // Devolver un array vacío si no hay resultados
    } catch(PDOException $e){
        $resultado['error'] = true;
        $resultado['mensaje'] = $e->getMessage();
        // Puedes comentar o eliminar la siguiente línea si no quieres imprimir el error aquí
        echo $e;
    }
    return $resultado;
}

function mostrarConfigu(){   
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];

    global $conexion;

    try{
        
        $sql = 'SELECT idConfiguracion ,tasaDolarCosto, tasaDolarVenta FROM configuracion ORDER BY idConfiguracion';
        $st = $conexion->prepare($sql);
        $st->execute();
        $config = $st->fetchAll();        
    }catch(PDOException $e){
        $resultado['error'] = true;
        $resultado['mensaje'] = $e->getMessage();
    }
    return $config;
}

function actualizarE($idEmpresa, $nombre, $rif, $telefono, $correo, $direccion, $ciudad, $estado, $codigoPostal, $mensaje){
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];
        global $conexion;

        try{
             $sql = 'UPDATE empresa SET nombre = ?, rif = ?, telefono = ?, correo = ?, direccion = ?, ciudad = ?, estado = ?, codigoPostal = ?, mensaje = ? WHERE idEmpresa = ? ';
            
            $st = $conexion->prepare($sql);
            
            $st->bindParam(1, $nombre);
            $st->bindParam(2, $rif);
            $st->bindParam(3, $telefono);
            $st->bindParam(4, $correo);
            $st->bindParam(5, $direccion);
            $st->bindParam(6, $ciudad);
            $st->bindParam(7, $estado);
            $st->bindParam(8, $codigoPostal);
            $st->bindParam(9, $mensaje);
            $st->bindParam(10, $idEmpresa);
            $st->execute();

            echo '<script>
                 // Recarga todos los frames de la página
                 parent.location.reload();
                 </script>';
          //  header('location:baseConfig.php');
        }catch(PDOException $e){
            $resultado['error'] = true;
            $resultado['mensaje'] = $e->getMessage();
            echo $e;
        }
}

function mostrarEmpresa(){   
    $resultado = [
        'error' => false,
        'mensaje' => '',
        'empresa' => []  // Inicializar el array para los resultados de la empresa
    ];

    global $conexion;

    try{
        $sql = 'SELECT idEmpresa, nombre, rif, telefono, correo, direccion, ciudad, estado, codigoPostal, mensaje FROM empresa ORDER BY idEmpresa';
        $st = $conexion->prepare($sql);
        $st->execute();
        $resultado['empresa'] = $st->fetchAll(PDO::FETCH_ASSOC);  // Utilizar PDO::FETCH_ASSOC para obtener un array asociativo
    } catch(PDOException $e){
        $resultado['error'] = true;
        $resultado['mensaje'] = $e->getMessage();
        // Puedes comentar o eliminar la siguiente línea si no quieres imprimir el error aquí
        echo $e;
    }
    return $resultado;
}

function actualizar($codigo, $descripcion, $costoUSD, $porcentajeG, $categoria, $precioGanUSD, $cantidadIngresar, $cantidadAlerta, $existencia, $idProducto){
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];
        global $conexion;

        try{
             $sql = 'UPDATE producto SET codigo = ?, descripcion = ?, costoUSD = ?, porcentajeG = ?, categoria = ?, precioGanUSD = ?, cantidadIngresar = ?, cantidadAlerta = ?, existencia = ? WHERE idProducto = ? ';
            
            $st = $conexion->prepare($sql);
            
            $st->bindParam(1, $codigo);
            $st->bindParam(2, $descripcion);
            $st->bindParam(3, $costoUSD);
            $st->bindParam(4, $porcentajeG);
            $st->bindParam(5, $categoria);
            $st->bindParam(6, $precioGanUSD);
            $st->bindParam(7, $cantidadIngresar);
            $st->bindParam(8, $cantidadAlerta);
            $st->bindParam(9, $existencia);
            $st->bindParam(10, $idProducto);
            $st->execute();

            echo '<script>
                 // Recarga todos los frames de la página
                 parent.location.reload();
                 </script>';
            //header('location:modificarE.php');
        }catch(PDOException $e){
            $resultado['error'] = true;
            $resultado['mensaje'] = $e->getMessage();
            echo $e;
        }
}
//FUNCIONES PARA ACTIVIDADES PLANIFICADAS

function productos($idProducto, $codigo, $descripcion, $costoUSD, $porcentajeG, $categoria, $proovedor, $precioGanUSD, $cantidadIngresar, $cantidadAlerta, $existencia){
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];
        global $conexion;

        try{
             $sql = 'INSERT INTO producto (idProducto ,codigo, descripcion, costoUSD, porcentajeG, categoria, proovedor, precioGanUSD, cantidadIngresar, cantidadAlerta, existencia) VALUES (?,?,?,?,?,?,?,?,?,?,?)';
            
            $st = $conexion->prepare($sql);
            $st->bindParam(1, $idProducto);
            $st->bindParam(2, $codigo);
            $st->bindParam(3, $descripcion);
            $st->bindParam(4, $costoUSD);
            $st->bindParam(5, $porcentajeG);
            $st->bindParam(6, $categoria);
            $st->bindParam(7, $proovedor);
            $st->bindParam(8, $precioGanUSD);
            $st->bindParam(9, $cantidadIngresar);
            $st->bindParam(10, $cantidadAlerta);
            $st->bindParam(11, $existencia);
            $st->execute(); 
            //header('location:pru.php');
            echo '<script>
				 // Recarga todos los frames de la página
				 parent.location.reload();
				 </script>';

        }catch(PDOException $e){
            $resultado['error'] = true;
            $resultado['mensaje'] = $e->getMessage();
            echo $e;
        }
}

function mostrarProductos(){   
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];

    global $conexion;

    try{
        
        $sql = 'SELECT idProducto ,codigo, descripcion, costoUSD, porcentajeG, categoria, proovedor, precioGanUSD, cantidadIngresar, cantidadAlerta, existencia FROM producto ORDER BY idProducto';
        $st = $conexion->prepare($sql);
        $st->execute();
        $productos = $st->fetchAll();        
    }catch(PDOException $e){
        $resultado['error'] = true;
        $resultado['mensaje'] = $e->getMessage();
        echo $e;
    }
    return $productos;	
}

function mostrarVentas(){   
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];

    global $conexion;

    try{
        
        $sql = 'SELECT idVenta , numeroVenta, idCedula ,idProducto, totalPagar, fecha, comentario, vendedor FROM venta ORDER BY idVenta';
        $st = $conexion->prepare($sql);
        $st->execute();
        $productos = $st->fetchAll();        
    }catch(PDOException $e){
        $resultado['error'] = true;
        $resultado['mensaje'] = $e->getMessage();
        echo $e;
    }
    return $productos;  
}

//FUNCION PARA VERIFICAR EL INGRESO AL SISTEMA

function verificarIngreso($usuario, $password){
    global $conexion;
    try{
        $sql = 'SELECT usuario, password, nivel_Acceso, id_Usuario FROM usuarios WHERE usuario = ? AND password = ?';
        $st = $conexion->prepare($sql);
        $st->bindParam(1, $usuario);
        $st->bindParam(2, $password);
        $st->execute();
        $datos = $st->fetch(PDO::FETCH_ASSOC);
        if(isset($datos['usuario'])){
            session_start();
            $_SESSION["usuario"] = $usuario;
            $_SESSION['nivel_Acceso'] = $datos['nivel_Acceso'];
            $_SESSION['id_Usuario'] = $datos['id_Usuario'];
            header('location:ventas.php');
        }else{
            header('location:index.php?ingreso=' . "error"); 
        }
    }catch(PDOException $e){
        $resultado['error'] = true;
        $resultado['mensaje'] = $e->getMessage();
        echo  $e->getMessage();
    }
}
//CUIDADO
function consultarIngreso($id_Usuario){   
    $resultado = [
        'error' =>false,
        'mensaje' => ''
    ];

    global $conexion;
    $id = $_SESSION['id_Usuario'];
    echo $id;

    try{
        $sql = "SELECT * FROM usuario WHERE usuario = ? ";
        $st = $conexion->prepare($sql);
        $st->bindParam(1, $id);
        $st->execute();
        $ingreso = $st->fetch(PDO::FETCH_ASSOC);        
    }catch(PDOException $e){
        $resultado['error'] = true;
        $resultado['mensaje'] = $e->getMessage();
    }
    return $ingreso;
}