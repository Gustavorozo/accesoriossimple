<?php
namespace App\Models;

require ("AbstractDBConnection.php");
require (__DIR__ ."\..\Interfaces\Model.php");
require(__DIR__ .'/../../vendor/autoload.php');

use App\Interfaces\Model;
use App\Models\AbstractDBConnection;
use Carbon\Carbon;

class Usuarios extends AbstractDBConnection implements Model
{
    private ?int $id;
    private string $nombres;
    private string $apellidos;
    private string $direccion;
    private Carbon $fecha_nacimiento;
    private int $telefono;
    private string $estado;

    /**
     * Usuarios constructor. Recibe un array asociativo
     * @param array $usuario
     */
    public function __construct(array $usuario = [])
    {
        parent::__construct();
        $this->setId($usuario['id'] ?? null);
        $this->setNombres($usuario['nombres'] ?? '');
        $this->setApellidos($usuario['apellidos'] ?? '');
        $this->setDireccion($usuario['direccion'] ?? '');
        $this->setFechaNacimiento(!empty($usuario['fecha_nacimiento']) ?
            Carbon::parse($usuario['fecha_nacimiento']) : new Carbon());
        $this->setTelefono($usuario['telefono'] ?? 0);
        $this->setEstado($usuario['estado'] ?? '');
    }

    public static function usuarioRegistrado(string $nombres, string $apellidos) : bool
    {
        $usrTmp = Usuarios::search("SELECT * FROM usuario WHERE nombres = '$nombres' and apellidos = '$apellidos'");
        return (!empty($usrTmp)) ? true : false;
    }

    public function __destruct()
    {
        if ($this->isConnected()) {
            $this->Disconnect();
        }
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombres(): string
    {
        return $this->nombres;
    }

    /**
     * @param string $nombres
     */
    public function setNombres(string $nombres): void
    {
        $this->nombres = $nombres;
    }

    /**
     * @return string
     */
    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return string
     */
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return Carbon
     */
    public function getFechaNacimiento(): Carbon
    {
        return $this->fecha_nacimiento->locale('es');
    }

    /**
     * @param Carbon $fecha_nacimiento
     */
    public function setFechaNacimiento(Carbon $fecha_nacimiento): void
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    /**
     * @return int
     */
    public function getTelefono(): int
    {
        return $this->telefono;
    }

    /**
     * @param int $telefono
     */
    public function setTelefono(int $telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return string
     */
    public function getEstado(): string
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @param string $query
     * @return bool|null
     */
    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' =>    $this->getId(),
            ':nombres' =>   $this->getNombres(),
            ':apellidos' =>   $this->getApellidos(),
            ':direccion' =>   $this->getDireccion(),
            ':fecha_nacimiento' =>  $this->getFechaNacimiento()->toDateString(), //YYYY-MM-DD
            ':telefono' =>   $this->getTelefono(),
            ':estado' =>   $this->getEstado(),
        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;
    }

    /**
     * @return bool|null
     */
    public function insert(): ?bool
    {
        $query = "INSERT INTO usuarios VALUES (
            :id,:nombres,:apellidos,:direccion,:fecha_nacimiento,:telefono,:estado
        )";
        //return $this->save($query);
        if($this->save($query)){
            $idUsuario = $this->getLastId('usuarios');
            $this->setId($idUsuario);
            return true;
        }else{
            return false;
        }
    }

    /**
     * @return bool|null
     */
    public function update(): ?bool
    {
        $query = "UPDATE usuarios SET 
            nombres = :nombres, apellidos = :apellidos, direccion = :direccion, 
            fecha_nacimiento = :fecha_nacimiento, telefono = :telefono,  
            estado = :estado WHERE id = :id";
        return $this->save($query);
    }

    function deleted()
    {
        $this->setEstado("Inactivo"); //Cambia el estado del Usuario
        return $this->update();                    //Guarda los cambios..
    }

    //SELECT * FROM usuarios WHERE nombre = 'Diego'
    static function search($query): ?array
    {
        try {
            $arrUsuarios = array();
            $tmp = new Usuarios();

            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            if (!empty($getrows)) {
                foreach ($getrows as $valor) {
                    $Usuario = new Usuarios($valor);
                    array_push($arrUsuarios, $Usuario);
                    unset($Usuario); //Borrar el contenido del objeto
                }
                return $arrUsuarios;
            }
            return null;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }

    static function searchForId(int $id): ?Usuarios
    {
        try {
            if ($id > 0) {
                $tmpUsuario = new Usuarios();
                $tmpUsuario->Connect();
                $getrow = $tmpUsuario->getRow("SELECT * FROM usuarios WHERE id = ?", array($id) );

                $tmpUsuario->Disconnect();
                return ($getrow) ? new Usuarios($getrow) : null;
            } else {
                throw new Exception('Id de usuario Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception', $e);
        }
        return null;
    }

    static function getAll(): ?array
    {
        return Usuarios::search("SELECT * FROM usuarios");
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nombres' => $this->getNombres(),
            'apellidos' => $this->getApellidos(),
            'direccion' => $this->getDireccion(),
            'fecha_nacimiento' => $this->getFechaNacimiento()->toDateString(),
            'telefono' => $this->getTelefono(),
            'estado' => $this->getEstado(),
        ];
    }
}