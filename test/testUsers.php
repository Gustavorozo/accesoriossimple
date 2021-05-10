<?php

require ("..\app\Models\Usuarios.php");
use App\Models\Usuarios;

$arrUser = [
    'nombres' => 'Diego',
    'apellidos' => 'Ojeda',
    'direccion' =>  'Sogamoso',
    'fecha_nacimiento' => '1900-01-01',
    'telefono' => '3118864151',
    'estado' => 'Activo'
];

$arrUser2 = [
    'nombres' => 'Carlos',
    'apellidos' => 'Caro',
    'direccion' =>  'Sogamoso',
    'fecha_nacimiento' => '1990-01-01',
    'telefono' => '3164182345',
    'estado' => 'Activo'
];

$objUser = new Usuarios($arrUser); // Creamos un usuario... Pero no echo nada con el.
$objUser->insert(); //Registramos el objeto en la base de datos

$objUser->setNombres("Diego"); //Cambio Valores
$objUser->setApellidos("Ojeda"); //Cambio Valores
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

$objUserCarlos = Usuarios::searchForId(3);
if(!empty($objUserCarlos)){
    $objUserCarlos->setDireccion('Manizales');
    $objUserCarlos->update();
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
echo json_encode($objUserCarlos);
