<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

class MesaController extends Mesa implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $estado = $parametros['estado'];
        $facturacion_acum = 0;

        $mesa = new Mesa();
        $mesa->estado = $estado;
        $mesa->facturacion_acum = $facturacion_acum;
        $mesa->crearMesa();

        $payload = json_encode(array("mensaje" => "Mesa creada con éxito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $mesa = Mesa::obtenerMesa($id); // Ensure this method exists in Mesa model
        $payload = json_encode($mesa);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Mesa::obtenerTodos(); // Ensure obtenerTodos exists in Mesa model
        $payload = json_encode(array("listaMesas" => $lista));
        
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];
        $estado = $parametros['estado'];
        $facturacion_acum = isset($parametros['facturacion_acum']) ? $parametros['facturacion_acum'] : 0;

        Mesa::modificarMesa($id, $estado, $facturacion_acum); // Ensure modificarMesa exists in Mesa model

        $payload = json_encode(array("mensaje" => "Mesa modificada con éxito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $id = $parametros['id'];
        Mesa::borrarMesa($id); // Ensure borrarMesa exists in Mesa model

        $payload = json_encode(array("mensaje" => "Mesa borrada con éxito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
