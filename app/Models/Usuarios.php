<?php
namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

class Usuarios extends AbstractDBConnection implements Model, JsonSerializable
{
    /* Tipos de Datos => bool, int, float,  */
    private ?int $id;
    private string $nombres;
    private string $apellidos;
    private string $tipo_documento;
    private int $documento;
    private int $telefono;
    private ?string $user;
    private ?string $password;
    private ?string $foto;
    private string $rol;
    private string $estado;

    /* Relaciones */
    private ?array $ventasCliente;
    private ?array $ventasEmpleado;

    /**
     * Usuarios constructor. Recibe un array asociativo
     * @param array $usuario
     */
    public function __construct(array $usuario = [])
    {
        parent::__construct();
        $this->setId($usuario['id'] ?? NULL);
        $this->setNombres($usuario['nombres'] ?? '');
        $this->setApellidos($usuario['apellidos'] ?? '');
        $this->setTipoDocumento($usuario['tipo_documento'] ?? '');
        $this->setDocumento($usuario['documento'] ?? 0);
        $this->setTelefono($usuario['telefono'] ?? 0);
        $this->setUser($usuario['user'] ?? null);
        $this->setPassword($usuario['password'] ?? null);
        $this->setFoto($usuario['foto'] ?? null);
        $this->setRol($usuario['rol'] ?? '');
        $this->setEstado($usuario['estado'] ?? '');
    }

    function __destruct()
    {
        if($this->isConnected){
            $this->Disconnect();
        }
    }

    /**
     * @return int|mixed
     */
    public function getId() : ?int
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
     * @return mixed|string
     */
    public function getNombres() : string
    {
        return ucwords($this->nombres);
    }

    /**
     * @param mixed|string $nombres
     */
    public function setNombres(string $nombres): void
    {
        $this->nombres = trim(mb_strtolower($nombres, 'UTF-8'));
    }

    /**
     * @return mixed|string
     */
    public function getApellidos() : string
    {
        return ucwords($this->apellidos);
    }

    /**
     * @param mixed|string $apellidos
     */
    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = trim(mb_strtolower($apellidos, 'UTF-8'));
    }

    /**
     * @return mixed|string
     */
    public function getTipoDocumento() : string
    {
        return $this->tipo_documento;
    }

    /**
     * @param mixed|string $tipo_documento
     */
    public function setTipoDocumento(string $tipo_documento): void
    {
        $this->tipo_documento = $tipo_documento;
    }

    /**
     * @return int|mixed
     */
    public function getDocumento() : int
    {
        return $this->documento;
    }

    /**
     * @param int|mixed $documento
     */
    public function setDocumento(int $documento): void
    {
        $this->documento = $documento;
    }

    /**
     * @return int|mixed
     */
    public function getTelefono() : int
    {
        return $this->telefono;
    }

    /**
     * @param int|mixed $telefono
     */
    public function setTelefono(int $telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return mixed|string
     */
    public function getDireccion() : string
    {
        return $this->direccion;
    }

    /**
     * @param mixed|string $direccion
     */
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed|string
     */
    public function getUser() : ?string
    {
        return $this->user;
    }

    /**
     * @param mixed|string $user
     */
    public function setUser(?string $user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed|string
     */
    public function getPassword() : ?string
    {
        return $this->password;
    }

    /**
     * @param mixed|string $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getFoto(): ?string
    {
        return $this->foto;
    }

    /**
     * @param string|null $foto
     */
    public function setFoto(?string $foto): void
    {
        $this->foto = $foto;
    }

    /**
     * @return mixed|string
     */
    public function getRol() : string
    {
        return $this->rol;
    }

    /**
     * @param mixed|string $rol
     */
    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }

    /**
     * @return mixed|string
     */
    public function getEstado() : string
    {
        return $this->estado;
    }

    /**
     * @param mixed|string $estado
     */
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }



    /**
     * @return array
     */
    public function getVentasCliente(): ?array
    {
        if(!empty($this->getId())){
            $this->ventasCliente = Ventas::search('SELECT * FROM ventas WHERE cliente_id = '.$this->getId());
            return $this->ventasCliente;
        }
        return null;
    }

    /**
     * @return array
     */
    public function getVentasEmpleado(): ?array
    {
        if(!empty($this->getId())){
            $this->ventasEmpleado = Ventas::search('SELECT * FROM ventas WHERE empleado_id = '.$this->getId());
            return $this->ventasEmpleado;
        }
        return null;
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
            ':tipo_documento' =>  $this->getTipoDocumento(),
            ':documento' =>   $this->getDocumento(),
            ':telefono' =>   $this->getTelefono(),
            ':user' =>  $this->getUser(),
            ':password' =>   $this->getPassword(),
            ':foto' =>   $this->getFoto(),
            ':rol' =>   $this->getRol(),
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
        $query = "INSERT INTO weber.usuarios VALUES (
            :id,:nombres,:apellidos,:tipo_documento,:documento,
            :telefono,:user,
            :password,:foto,:rol,:estado
        )";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update(): ?bool
    {
        $query = "UPDATE weber.usuarios SET 
            nombres = :nombres, apellidos = :apellidos, tipo_documento = :tipo_documento, 
            documento = :documento, telefono = :telefono, user = :user,  
            password = :password, foto = :foto, rol = :rol, estado = :estado WHERE id = :id";
        return $this->save($query);
    }

    /**
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function deleted(): bool
    {
        $this->setEstado("Inactivo"); //Cambia el estado del Usuario
        return $this->update();                    //Guarda los cambios..
    }

    /**
     * @param $query
     * @return Usuarios|array
     * @throws Exception
     */
    public static function search($query) : ?array
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
                    unset($Usuario);
                }
                return $arrUsuarios;
            }
            return null;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * @param $id
     * @return Usuarios
     * @throws Exception
     */
    public static function searchForId(int $id): ?Usuarios
    {
        try {
            if ($id > 0) {
                $tmpUsuario = new Usuarios();
                $tmpUsuario->Connect();
                $getrow = $tmpUsuario->getRow("SELECT * FROM accesoriossimple.usuarios WHERE id =?", array($id));
                $tmpUsuario->Disconnect();
                return ($getrow) ? new Usuarios($getrow) : null;
            }else{
                throw new Exception('Id de usuario Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * @return array
     * @throws Exception
     */
    public static function getAll(): array
    {
        return Usuarios::search("SELECT * FROM accesoriossimple.usuarios");
    }

    /**
     * @param $documento
     * @return bool
     * @throws Exception
     */
    public static function usuarioRegistrado($documento): bool
    {
        $result = Usuarios::search("SELECT * FROM accesoriossimple.usuarios where documento = " . $documento);
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function nombresCompletos() : string
    {
        return $this->nombres . " " . $this->apellidos;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return "Nombres: $this->nombres, Apellidos: $this->nombres, Tipo Documento: $this->tipo_documento, Documento: $this->documento, Telefono: $this->telefono,";
    }

    public function Login($User, $Password){
        try {
            $resultUsuarios = Usuarios::search("SELECT * FROM usuarios WHERE user = '$User'");
            if(count($resultUsuarios) >= 1){
                if($resultUsuarios[0]->password == $Password){
                    if($resultUsuarios[0]->estado == 'Activo'){
                        return $resultUsuarios[0];
                    }else{
                        return "Usuario Inactivo";
                    }
                }else{
                    return "Contraseña Incorrecta";
                }
            }else{
                return "Usuario Incorrecto";
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
            return "Error en Servidor";
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nombres' => $this->getNombres(),
            'apellidos' => $this->getApellidos(),
            'tipo_documento' => $this->getTipoDocumento(),
            'documento' => $this->getDocumento(),
            'telefono' => $this->getTelefono(),
            'user' => $this->getUser(),
            'password' => $this->getPassword(),
            'foto' => $this->getFoto(),
            'rol' => $this->getRol(),
            'estado' => $this->getEstado(),

        ];
    }
}