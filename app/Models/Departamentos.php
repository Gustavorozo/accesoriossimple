<?php
namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Exception;
use JsonSerializable;

final class Departamentos extends AbstractDBConnection implements Model, JsonSerializable
{

    private ?int $id;
    private string $nombre;
    private string $region;
    private string $estado;
    private Carbon $created_at;
    private Carbon $updated_at;
    private Carbon $deleted_at;

    /* Relaciones */
    private ?array $MunicipiosDepartamento;

    /**
     * Departamentos constructor. Recibe un array asociativo
     * @param array $departamento
     */
    public function __construct(array $departamento = [])
    {
        parent::__construct();
        $this->setId($departamento['id'] ?? NULL);
        $this->setNombre($departamento['nombre'] ?? '');
        $this->setRegion($departamento['region'] ?? '');
        $this->setEstado($departamento['estado'] ?? '');
        $this->setCreatedAt(!empty($departamento['created_at']) ? Carbon::parse($departamento['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($departamento['updated_at']) ? Carbon::parse($departamento['updated_at']) : new Carbon());
        $this->setDeletedAt(!empty($departamento['deleted_at']) ? Carbon::parse($departamento['deleted_at']) : new Carbon());
    }

    public function __destruct()
    {
        parent::__destruct();
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
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion(string $region): void
    {
        $this->region = $region;
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
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at->locale('es');
    }

    /**
     * @param Carbon $created_at
     */
    public function setCreatedAt(Carbon $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at->locale('es');
    }

    /**
     * @param Carbon $updated_at
     */
    public function setUpdatedAt(Carbon $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return Carbon
     */
    public function getDeletedAt(): Carbon
    {
        return $this->deleted_at->locale('es');
    }

    /**
     * @param Carbon $deleted_at
     */
    public function setDeletedAt(Carbon $deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }

    /* Relaciones */
    /**
     * retorna un array de municipios que perteneces a un departamento
     * @return array
     */
    public function getMunicipiosDepartamento(): ?array
    {
        if(!empty($this-> MunicipiosDepartamento)){
            $this-> MunicipiosDepartamento = Municipios::search("SELECT * FROM accesoriossimple.municipios WHERE departamento_id = ".$this->id);
            return $this-> MunicipiosDepartamento;
        }
        return null;
    }

    static function search($query): ?array
    {
        try {
            $arrDepartamentos = array();
            $tmp = new Departamentos();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Departamento = new Departamentos($valor);
                array_push($arrDepartamentos, $Departamento);
                unset($Departamento);
            }
            return $arrDepartamentos;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static function searchForId(int $id): ?Departamentos
    {
        try {
            if ($id > 0) {
                $tmpDepartamento = new Departamentos();
                $tmpDepartamento->Connect();
                $getrow = $tmpDepartamento->getRow("SELECT * FROM accesoriossimple.departamentos WHERE id =?", array($id));
                $tmpDepartamento->Disconnect();
                return ($getrow) ? new Departamentos($getrow) : null;
            }else{
                throw new Exception('Id de departamento Invalido');
            }
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    static function getAll(): array
    {
        return Departamentos::search("SELECT * FROM accesoriossimple.departamentos");
    }

    public function __toString() : string
    {
        return "Nombre: $this->nombre, Region: $this->region, Estado: $this->estado";
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'region' => $this->getRegion(),
            'estado' => $this->getEstado(),
            'created_at' => $this->getCreatedAt()->toDateTimeString(),
            'updated_at' => $this->getUpdatedAt()->toDateTimeString(),
            'deleted_at' => $this->getDeletedAt()->toDateTimeString(),
        ];
    }

    protected function save(string $query): ?bool { return null; }
    function insert(){ }
    function update() { }
    function deleted() { }

}