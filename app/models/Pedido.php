<?php

class Pedido
{
    public $id; // Alfanumérico de 5 caracteres
    public $estado;

    public $id_mesa;

    public $id_producto;
    public $cantidad_producto;
    public $tiempo_finalizacion;

    public $fecha;
    public $sector;
    public $importe;

    public $cancelado; 

    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (id, estado, id_mesa, id_producto, cantidad_producto, tiempo_finalizacion, fecha, sector, importe, cancelado) VALUES (:id, :estado, :id_mesa,:id_producto,:cantidad_producto,:tiempo_finalizacion,:fecha,:sector,:importe,:cancelado)");

        // Genera un código alfanumérico de 5 caracteres para el ID de la mesa
        $this->id = generarCodigoAlfanumerico();
        
        $consulta->bindValue(':id', $this->id, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);

        $consulta->bindValue(':id_mesa', $this->id_mesa, PDO::PARAM_STR);
        $consulta->bindValue(':id_producto', $this->id_producto, PDO::PARAM_STR);

        $consulta->bindValue(':cantidad_producto', $this->cantidad_producto, PDO::PARAM_STR);
        $consulta->bindValue(':tiempo_finalizacion', $this->tiempo_finalizacion, PDO::PARAM_STR);

        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);

        $consulta->bindValue(':importe', $this->importe, PDO::PARAM_STR);
        $consulta->bindValue(':cancelado', $this->cancelado, PDO::PARAM_STR);

        $consulta->execute();
        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function obtenerPedido($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Pedido');
    }

    public static function modificarPedido($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET estado = :estado, facturacion_acum = :facturacion_acum WHERE id = :id");

        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
  

        $consulta->execute();
    }

    public static function cancelarPedido($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET cancelado = 1 WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();
    }
}

// Función para generar un código alfanumérico de 5 caracteres
function generarCodigoAlfanumerico($longitud = 5)
{
    $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codigo = '';
    for ($i = 0; $i < $longitud; $i++) {
        $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $codigo;
}