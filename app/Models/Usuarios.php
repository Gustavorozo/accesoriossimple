<?php


namespace App\Models;

use Carbon\Carbon;

class Usuarios extends AbstractDBConnection
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
        return $this->fecha_nacimiento;
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
        return $this->save($query);
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

}