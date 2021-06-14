<?php

namespace App\Controllers;

require (__DIR__.'/../../vendor/autoload.php');
use App\Models\GeneralFunctions;
use App\Models\Colors;
use Carbon\Carbon;

class ColorsController{

    private array $dataColor;

    public function __construct(array $_FORM)
    {
        $this->dataColor = array();
        $this->dataColor['id'] = $_FORM['id'] ?? NULL;
        $this->dataColor['nombre'] = $_FORM['nombre'] ?? '';
        $this->dataColor['descripcion'] = $_FORM['descripcion'] ?? '';
        $this->dataColor['estado'] = $_FORM['estado'] ?? 'Activo';
    }

    public function create() {
        try {
            if (!empty($this->dataColor['nombre']) && !Colors::colorRegistrada($this->dataColor['nombre'])) {
                $Color = new Colors($this->dataColor);
                if ($Color->insert()) {
                    unset($_SESSION['frmColors']);
                    header("Location: ../../views/modules/colors/index.php?respuesta=success&mensaje=Color Registrado!");
                }
            } else {
                header("Location: ../../views/modules/colors/create.php?respuesta=error&mensaje=Color ya registrado!");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    public function edit()
    {
        try {
            $Color = new Colors($this->dataColor);
            if($Color->update()){
                unset($_SESSION['frmColors']);
            }

            header("Location: ../../views/modules/colors/show.php?id=" . $Color->getId() . "&respuesta=success&mensaje=Color Actualizado!");
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function searchForID (array $data){
        try {
            $result = Colors::searchForId($data['id']);
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
            $result = Colors::getAll();
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
            $ObjColor = Colors::searchForId($id);
            $ObjColor->setEstado("Activo");
            if($ObjColor->update()){
                header("Location: ../../views/modules/colors/index.php");
            }else{
                header("Location: ../../views/modules/colors/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function inactivate (int $id){
        try {
            $ObjColor = Colors::searchForId($id);
            $ObjColor->setEstado("Inactivo");
            if($ObjColor->update()){
                header("Location: ../../views/modules/colors/index.php");
            }else{
                header("Location: ../../views/modules/colors/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
    }

    static public function selectColor (array $params = []){

        $params['isMultiple'] = $params['isMultiple'] ?? false;
        $params['isRequired'] = $params['isRequired'] ?? true;
        $params['id'] = $params['id'] ?? "color_id";
        $params['name'] = $params['name'] ?? "color_id";
        $params['defaultValue'] = $params['defaultValue'] ?? "";
        $params['class'] = $params['class'] ?? "form-control";
        $params['where'] = $params['where'] ?? "";
        $params['arrExcluir'] = $params['arrExcluir'] ?? array();
        $params['request'] = $params['request'] ?? 'html';

        $arrColor = array();
        if($params['where'] != ""){
            $base = "SELECT * FROM colors WHERE ";
            $arrColor = Colors::search($base.$params['where']);
        }else{
            $arrColor = Colors::getAll();
        }

        $htmlSelect = "<select ".(($params['isMultiple']) ? "multiple" : "")." ".(($params['isRequired']) ? "required" : "")." id= '".$params['id']."' name='".$params['name']."' class='".$params['class']."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrColor) > 0){
            /* @var $arrColor Colors[] */
            foreach ($arrColor as $color)
                if (!ColorsController::colorIsInArray($color->getId(),$params['arrExcluir']))
                    $htmlSelect .= "<option ".(($color != "") ? (($params['defaultValue'] == $color->getId()) ? "selected" : "" ) : "")." value='".$color->getId()."'>".$color->getNombre()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    public static function colorIsInArray($idColor, $ArrColor){
        if(count($ArrColor) > 0){
            foreach ($ArrColor as $Color){
                if($Color->getId() == $idColor){
                    return true;
                }
            }
        }
        return false;
    }

}