<?php
require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $nombre = $parametros['nombre'];
        $precio = $parametros['precio'];
        $tipo = $parametros['tipo'];
        $desactivado = 0;

        $producto = new Producto();
        $producto->nombre = $nombre;
        $producto->precio = $precio;
        $producto->tipo = $tipo;
        $producto->desactivado = $desactivado;
        $producto->crearProducto();

        $payload = json_encode(array("mensaje" => "Producto creado con éxito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $producto = Producto::obtenerProducto($id); // Ensure this method exists in Producto model
        $payload = json_encode($producto);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Producto::obtenerTodos(); // Ensure obtenerTodos exists in Producto model
        $payload = json_encode(array("listaProductos" => $lista));
        
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];
        $nombre = $parametros['nombre'];
        $precio = $parametros['precio'];
        $tipo = $parametros['tipo'];
        $desactivado = isset($parametros['desactivado']) ? $parametros['desactivado'] : 0;

        Producto::modificarProducto($id, $nombre, $precio, $tipo, $desactivado); // Ensure this method exists in Producto model

        $payload = json_encode(array("mensaje" => "Producto modificado con éxito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];
        Producto::borrarProducto($id); // Ensure borrarProducto exists in Producto model

        $payload = json_encode(array("mensaje" => "Producto borrado con éxito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
