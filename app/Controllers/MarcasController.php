<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php');
use App\Models\GeneralFunctions;
use App\Models\Marcas;
use Carbon\Carbon;

class MarcasController{

    private array $dataMarca;

    public function __construct(array $_FORM)
    {
        $this->dataMarca = array();
        $this->dataMarca['id'] = $_FORM['id'] ?? NULL;
        $this->dataMarca['nombre'] = $_FORM['nombre'] ?? '';
        $this->dataMarca['descripcion'] = $_FORM['descripcion'] ?? '';
        $this->dataMarca['estado'] = $_FORM['estado'] ?? 'Activo';
    }

    public function create() {
        try {
            if (!empty($this->dataMarca['nombre']) && !Marcas::marcaRegistrada($this->dataMarca['nombre'])) {
                $Marca = new Marcas($this->dataMarca);
                if ($Marca->insert()) {
                    unset($_SESSION['frmMarcas']);
                    header("Location: ../../views/modules/marcas/index.php?respuesta=success&mensaje=Marca Registrada!");
                }
            } else {
                header("Location: ../../views/modules/marcas/create.php?respuesta=error&mensaje=Marca ya registrada!");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit()
    {
        try {
            $Marca = new Marcas($this->dataMarca);
            if($Marca->update()){
                unset($_SESSION['frmMarcas']);
            }

            header("Location: ../../views/modules/marcas/show.php?id=" . $Marca->getId() . "&respuesta=success&mensaje=Marca Actualizada!");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Marcas::searchForId($data['id']);
            if (!empty($data['request']) and $data['request'] === 'ajax' and !empty($result)) {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result->jsonSerialize());
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static public function getAll (array $data = null){
        try {
            $result = Marcas::getAll();
            if (!empty($data['request']) and $data['request'] === 'ajax') {
                header('Content-type: application/json; charset=utf-8');
                $result = json_encode($result);
            }
            return $result;
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static public function activate (int $id){
        try {
            $ObjMarca = Marcas::searchForId($id);
            $ObjMarca->setEstado("Activo");
            if($ObjMarca->update()){
                header("Location: ../../views/modules/marcas/index.php");
            }else{
                header("Location: ../../views/modules/marcas/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate (int $id){
        try {
            $ObjMarca = Marcas::searchForId($id);
            $ObjMarca->setEstado("Inactivo");
            if($ObjMarca->update()){
                header("Location: ../../views/modules/marcas/index.php");
            }else{
                header("Location: ../../views/modules/marcas/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function selectMarca (array $params = []){

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "marca_id";
        $params['name'] = $params['name'] ?? "marca_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrMarca = array();
        if($params['where'] != ""){
            $base = "SELECT * FROM marcas WHERE ";
            $arrMarca = Marcas::search($base.$params['where']);
        }else{
            $arrMarca = Marcas::getAll();
        }

        $htmlSelect = "<select ".(($params['isMultiple']) ? "multiple" : "")." ".(($params['isRequired']) ? "required" : "")." id= '".$params['id']."' name='".$params['name']."' class='".$params['class']."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrMarca) > 0){
            /* @var $arrMarca Marcas[] */
            foreach ($arrMarca as $marca)
                if (!MarcasController::marcaIsInArray($marca->getId(),$params['arrExcluir']))
                    $htmlSelect .= "<option ".(($marca != "") ? (($params['defaultValue'] == $marca->getId()) ? "selected" : "" ) : "")." value='".$marca->getId()."'>".$marca->getNombre()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    public static function marcaIsInArray($idMarca, $ArrMarca){
        if(count($ArrMarca) > 0){
            foreach ($ArrMarca as $Marca){
                if($Marca->getId() == $idMarca){
                    return true;
                }
            }
        }
        return false;
    }

}