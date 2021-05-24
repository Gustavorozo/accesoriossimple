<?php

require ("..\app\Models\Usuarios.php");
use App\Models\Usuarios;

$arrUser = [
    'nombres' => 'Gustavo',
    'apellidos' => 'Rozo',
    'direccion' =>  'Sogamoso',
    'fecha_nacimiento' => '1997-01-06',
    'telefono' => '31234',
    'estado' => 'Activo'
];

$arrUser2 = [
    'nombres' => 'Andres',
    'apellidos' => 'Perez',
    'direccion' =>  'Sogamoso',
    'fecha_nacimiento' => '1990-01-01',
    'telefono' => '3134558',
    'estado' => 'Activo'
];

$objUser = new Usuarios($arrUser); // Creamos un usuario... Pero no echo nada con el.
$objUser->insert(); //Registramos el objeto en la base de datos

$objUser->setNombres("Gustavo"); //Cambio Valores
$objUser->setApellidos("Rozo"); //Cambio Valores
//$objUser->update();

//$objUser->deleted();

$objUser2 = new Usuarios($arrUser2);
$objUser2->insert();

$arrResult = Usuarios::search("SELECT * FROM usuarios WHERE direccion = 'Tunja'");
if(!empty($arrResult)){
    /* @var $arrResult Usuarios[] */
    foreach ($arrResult as $Usuario){
        echo "Nombres: ".$Usuario->getId()." - ".$Usuario->getNombres()."\n";
    }
}



$arrUsers = Usuarios::getAll();
$arrUsers = Usuarios::getAll();
if(!empty($arrUsers)){
    /* @var $arrUsers Usuarios[] */
    foreach ($arrUsers as $Usuario){
        echo "id: ".$Usuario->getId().", Nombre: ".$Usuario->getNombres().", Apellidos: ".$Usuario->getApellidos().", Estado: ".$Usuario->getEstado()."\n";
    }
}

$objUserCarlos = Usuarios::searchForId(5);
echo json_encode($objUserAndres);
