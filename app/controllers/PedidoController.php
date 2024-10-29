<?php
require_once './models/Pedido.php';
require_once './interfaces/IApiUsable.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');

class PedidoController extends Pedido implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $pedido = new Pedido();
        $pedido->estado = $parametros['estado'];
        $pedido->id_mesa = $parametros['id_mesa'];
        $pedido->id_producto = $parametros['id_producto'];
        $pedido->cantidad_producto = $parametros['cantidad_producto'];
        $pedido->tiempo_finalizacion = isset($parametros['tiempo_finalizacion']) ? $parametros['tiempo_finalizacion'] : null;
        $pedido->fecha = date('Y-m-d H:i:s');
        $pedido->sector = $parametros['sector'];
        $pedido->importe = $parametros['importe'];
        $pedido->cancelado = 0;

        $pedido->crearPedido();

        $payload = json_encode(array("mensaje" => "Pedido creado con éxito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $pedido = Pedido::obtenerPedido($id);
        $payload = json_encode($pedido);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Pedido::obtenerTodos();
        $payload = json_encode(array("listaPedidos" => $lista));
        
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];
        $estado = $parametros['estado'];
        $id_mesa = $parametros['id_mesa'];
        $id_producto = $parametros['id_producto'];
        $cantidad_producto = $parametros['cantidad_producto'];
        $tiempo_finalizacion = isset($parametros['tiempo_finalizacion']) ? $parametros['tiempo_finalizacion'] : null;
        $sector = $parametros['sector'];
        $importe = $parametros['importe'];
        $cancelado = $parametros['cancelado'];

        Pedido::modificarPedido($id, $estado, $id_mesa, $id_producto, $cantidad_producto, $tiempo_finalizacion, $sector, $importe, $cancelado);

        $payload = json_encode(array("mensaje" => "Pedido modificado con éxito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $id = $args['id'];
        Pedido::cancelarPedido($id);

        $payload = json_encode(array("mensaje" => "Pedido cancelado con éxito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
