<?php

namespace App\Models;

use App\Interfaces\Model;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Exception;
use JsonSerializable;

class Productos extends AbstractDBConnection implements Model, JsonSerializable
{
    private ?int $id;
    private string $nombre;
    private float $precio;
    private float $porcentaje_ganancia;
    private int $stock;
    private int $categoria_id;
    private int $marca_id;
    private int $color_id;
    private string $estado;
    private Carbon $created_at;
    private Carbon $updated_at;

    /* Relaciones */
    private ?Categorias $categoria;
    private ?Marcas $marca;
    private ?Colors $color;
    private ?array $fotosProducto;

    /**
     * Producto constructor. Recibe un array asociativo
     * @param array $categoria
     */
    public function __construct(array $categoria = [])
    {
        parent::__construct();
        $this->setId($categoria['id'] ?? NULL);
        $this->setNombre($categoria['nombre'] ?? '');
        $this->setPrecio($categoria['precio'] ?? 0.0);
        $this->setPorcentajeGanancia($categoria['porcentaje_ganancia'] ?? 0.0);
        $this->setStock($categoria['stock'] ?? 0);
        $this->setCategoriaId($categoria['categoria_id'] ?? 0);
        $this->setMarcaId($categoria['marca_id'] ?? 0);
        $this->setColorId($categoria['color_id'] ?? 0);
        $this->setEstado($categoria['estado'] ?? '');
        $this->setCreatedAt(!empty($categoria['created_at']) ? Carbon::parse($categoria['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($categoria['updated_at']) ? Carbon::parse($categoria['updated_at']) : new Carbon());
    }

    /**
     * Producto constructor. Recibe un array asociativo
     * @param array $marca
     */
    public function __construct2(array $marca = [])
    {
        parent::__construct2();
        $this->setId($marca['id'] ?? NULL);
        $this->setNombre($marca['nombre'] ?? '');
        $this->setPrecio($marca['precio'] ?? 0.0);
        $this->setPorcentajeGanancia($marca['porcentaje_ganancia'] ?? 0.0);
        $this->setStock($marca['stock'] ?? 0);
        $this->setCategoriaId($marca['categoria_id'] ?? 0);
        $this->setMarcaId($marca['marca_id'] ?? 0);
        $this->setColorId($marca['color_id'] ?? 0);
        $this->setEstado($marca['estado'] ?? '');
        $this->setCreatedAt(!empty($marca['created_at']) ? Carbon::parse($marca['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($marca['updated_at']) ? Carbon::parse($marca['updated_at']) : new Carbon());
    }

     /**
     * Producto constructor. Recibe un array asociativo
     * @param array $color
     */
    public function __construct1 (array $color = [])
    {
        parent::__construct1();
        $this->setId($color['id'] ?? NULL);
        $this->setNombre($color['nombre'] ?? '');
        $this->setPrecio($color['precio'] ?? 0.0);
        $this->setPorcentajeGanancia($color['porcentaje_ganancia'] ?? 0.0);
        $this->setStock($color['stock'] ?? 0);
        $this->setCategoriaId($color['categoria_id'] ?? 0);
        $this->setMarcaId($color['marca_id'] ?? 0);
        $this->setColorId($color['color_id'] ?? 0);
        $this->setEstado($color['estado'] ?? '');
        $this->setCreatedAt(!empty($color['created_at']) ? Carbon::parse($color['created_at']) : new Carbon());
        $this->setUpdatedAt(!empty($color['updated_at']) ? Carbon::parse($color['updated_at']) : new Carbon());
    }

    function __destruct()
    {
        if($this->isConnected){
            $this->Disconnect();
        }
    }

    /**
     * @return int|null
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
    public function getNombre() : string
    {
        return ucwords($this->nombre);
    }

    /**
     * @param mixed|string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = trim(mb_strtolower($nombre, 'UTF-8'));
    }
     /**
     * @return mixed|string
     */

    /**
     * @return float|mixed
     */
    public function getPrecio() : float
    {
        return $this->precio;
    }

    /**
     * @param float|mixed $precio
     */
    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    /**
     * @return float|mixed
     */
    public function getPorcentajeGanancia() : float
    {
        return $this->porcentaje_ganancia;
    }

    /**
     * @param float|mixed $porcentaje_ganancia
     */
    public function setPorcentajeGanancia(float $porcentaje_ganancia): void
    {
        $this->porcentaje_ganancia = $porcentaje_ganancia;
    }

    /**
     * @return int|mixed
     */
    public function getStock() : int
    {
        return $this->stock;
    }

    /**
     * @param int|mixed $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return int
     */
    public function getCategoriaId(): int
    {
        return $this->categoria_id;
    }

    /**
     * @param int $categoria_id
     */
    public function setCategoriaId(int $categoria_id): void
    {
        $this->categoria_id = $categoria_id;
    }
     /**
     * @return int
     */
    public function getMarcaId(): int
    {
        return $this->marca_id;
    }

    /**
     * @param int $marca_id
     */
    public function setMarcaId(int $marca_id): void
    {
        $this->marca_id = $marca_id;
    }
     /**
     * @return int
     */
    public function getColorId(): int
    {
        return $this->color_id;
    }

    /**
     * @param int $color_id
     */
    public function setColorId(int $color_id): void
    {
        $this->color_id = $color_id;
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

    /* Relaciones */
    /**
     * @return Categorias
     */
    public function getCategoria(): ?Categorias
    {
        if(!empty($this->categoria_id)){
            $this->categoria = Categorias::searchForId($this->categoria_id) ?? new Categorias();
            return $this->categoria;
        }
        return NULL;
    }
     /* Relaciones */
    /**
     * @return Marcas
     */
    public function getMarca(): ?Marcas
    {
        if(!empty($this->marca_id)){
            $this->marca = Marcas::searchForId($this->marca_id) ?? new Marcas();
            return $this->marca;
        }
        return NULL;
    }
     /* Relaciones */
    /**
     * @return Colors
     */
    public function getColor(): ?Colors
    {
        if(!empty($this->color_id)){
            $this->color = Colors::searchForId($this->color_id) ?? new Colors();
            return $this->color;
        }
        return NULL;
    }

    /**
     * retorna un array de fotos que pertenecen al producto
     * @return array
     */
    public function getFotosProducto(): ?array
    {
        $this->fotosProducto = Fotos::search("SELECT * FROM accesoriossimple.fotos WHERE producto_id = ".$this->id." and estado = 'Activo'");
        return $this->fotosProducto;
    }

    protected function save(string $query): ?bool
    {
        $arrData = [
            ':id' =>    $this->getId(),
            ':nombre' =>   $this->getNombre(),
            ':precio' =>   $this->getPrecio(),
            ':porcentaje_ganancia' =>  $this->getPorcentajeGanancia(),
            ':stock' =>   $this->getStock(),
            ':categoria_id' =>   $this->getCategoriaId(),
            ':marca_id' =>   $this->getMarcaId(),
            ':color_id' =>   $this->getColorId(),
            ':estado' =>   $this->getEstado(),
            ':created_at' =>  $this->getCreatedAt()->toDateTimeString(), //YYYY-MM-DD HH:MM:SS
            ':updated_at' =>  $this->getUpdatedAt()->toDateTimeString() //YYYY-MM-DD HH:MM:SS
        ];
        $this->Connect();
        $result = $this->insertRow($query, $arrData);
        $this->Disconnect();
        return $result;
    }


    /**
     * @return bool|null
     */
    function insert(): ?bool
    {
        $query = "INSERT INTO accesoriossimple.productos VALUES (:id,:nombre,:precio,:porcentaje_ganancia,:stock,:categoria_id,:marca_id,:color_id,:estado,:created_at,:updated_at)";
        return $this->save($query);
    }

    /**
     * @return bool|null
     */
    public function update(): ?bool
    {
        $query = "UPDATE accesoriossimple.productos SET 
            nombre = :nombre, precio = :precio, porcentaje_ganancia = :porcentaje_ganancia, 
            stock = :stock, categoria_id = :categoria_id, marca_id = :marca_id, color_id = :color_id, estado = :estado, created_at = :created_at, 
            updated_at = :updated_at WHERE id = :id";
        return $this->save($query);
    }

    /**
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
     * @return Productos|array
     * @throws Exception
     */
    public static function search($query) : ?array
    {
        try {
            $arrProductos = array();
            $tmp = new Productos();
            $tmp->Connect();
            $getrows = $tmp->getRows($query);
            $tmp->Disconnect();

            foreach ($getrows as $valor) {
                $Producto = new Productos($valor);
                array_push($arrProductos, $Producto);
                unset($Producto);
            }
            return $arrProductos;
        } catch (Exception $e) {
            GeneralFunctions::logFile('Exception',$e, 'error');
        }
        return null;
    }

    /**
     * @param $id
     * @return Productos
     * @throws Exception
     */
    public static function searchForId($id) : ?Productos
    {
        try {
            if ($id > 0) {
                $Producto = new Productos();
                $Producto->Connect();
                $getrow = $Producto->getRow("SELECT * FROM accesoriossimple.productos WHERE id =?", array($id));
                $Producto->Disconnect();
                return ($getrow) ? new Productos($getrow) : null;
            }else{
                throw new Exception('Id de producto Invalido');
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
    public static function getAll() : ?array
    {
        return Productos::search("SELECT * FROM accesoriossimple.productos");
    }

    /**
     * @param $nombre
     * @return bool
     * @throws Exception
     */
    public static function productoRegistrado($nombre): bool
    {
        $nombre = trim(strtolower($nombre));
        $result = Productos::search("SELECT id FROM accesoriossimple.productos where nombre = '" . $nombre. "'");
        if ( !empty($result) && count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return float|mixed
     */
    public function getPrecioVenta() : float
    {
        return $this->precio + ($this->precio * ($this->porcentaje_ganancia / 100));
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return "Nombre: $this->nombre, Precio: $this->precio, Porcentaje: $this->porcentaje_ganancia, Stock: $this->stock, Estado: $this->estado";
    }

    public function substractStock(int $quantity)
    {
        $this->setStock( $this->getStock() - $quantity);
        $result = $this->update();
        if($result == false){
            GeneralFunctions::console('Stock no actualizado!');
        }
        return $result;
    }

    public function addStock(int $quantity)
    {
        $this->setStock( $this->getStock() + $quantity);
        $result = $this->update();
        if($result == false){
            GeneralFunctions::console('Stock no actualizado!');
        }
        return $result;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4
     */
    public function jsonSerialize()
    {
        return [
            'nombre' => $this->getNombre(),
            'precio' => $this->getPrecio(),
            'porcentaje_ganancias' => $this->getPorcentajeGanancia(),
            'precio_venta' => $this->getPrecioVenta(),
            'stock' => $this->getStock(),
            'categoria' => $this->getCategoria()->jsonSerialize(),
            'marca' => $this->getMarca()->jsonSerialize(),
            'color' => $this->getColor()->jsonSerialize(),
            'estado' => $this->getEstado(),
        ];
    }
}