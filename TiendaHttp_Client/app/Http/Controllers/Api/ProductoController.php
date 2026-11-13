<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Client\ConnectionException;

class ProductoController extends Controller
{
    /**
     * Listar todos los productos.
     */
    private string $endpoint = 'http://127.0.0.1:8001/api/productos/';

    public function index()
    {
        $http = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('admin_token'),
        ]);
        try {
            $response = $http->timeout(10)->get($this->endpoint);
        } catch (ConnectionException $exception) {
            Log::warning('No fue posible conectar con el servicio de productos.', [
                'exception' => $exception->getMessage(),
            ]);

            return $this->errorResponse(
                'No fue posible conectar con el servicio de productos.',
                502
            );
        }

        if (!$response->successful()) {
            Log::warning('El servicio de productos respondió con un error.', [
                'upstream_status' => $response->status(),
            ]);

            return $this->errorResponse(
                'No fue posible obtener los productos.',
                502,
                ['upstream_status' => $response->status()]
            );
        }

        $productos = $response->json();
        if (!is_array($productos)) {
            Log::warning('El servicio de productos devolvió una respuesta inválida.');

            return $this->errorResponse(
                'El servicio de productos devolvió una respuesta inválida.',
                502
            );
        }

        return response()->json([
            'status' => 'success',
            'data'   => $productos,
        ]);
    }

    /**
     * Crear producto con gestión de imagen.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'categoria'   => 'nullable|string|max:100',
            'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $validated = $validator->validated();

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $validated['imagen'] = $path;
        }

        $producto = Producto::create($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Producto creado con imagen exitosamente.',
            'data'    => $producto,
        ], 201);
    }

    /**
     * Consultar un producto por ID.
     */
    public function show($id)
    {
        $producto = $this->findProduct($id);

        if (!$producto) {
            return $this->errorResponse('Producto no encontrado.', 404);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $producto,
        ]);
    }

    /**
     * Editar / Actualizar un producto (y su imagen).
     */
    public function update(Request $request, $id)
    {
        $producto = $this->findProduct($id);

        if (!$producto) {
            return $this->errorResponse('Producto no encontrado.', 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'      => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|nullable|string',
            'precio'      => 'sometimes|required|numeric|min:0',
            'stock'       => 'sometimes|required|integer|min:0',
            'categoria'   => 'sometimes|nullable|string|max:100',
            'imagen'      => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $validated = $validator->validated();

        // Si se subió una nueva imagen, eliminar la anterior del almacenamiento
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('productos', 'public');
            $validated['imagen'] = $path;

            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }
        }

        $producto->update($validated);

        return response()->json([
            'status'  => 'success',
            'message' => 'Producto actualizado correctamente.',
            'data'    => $producto,
        ]);
    }

    /**
     * Eliminar producto y su imagen asociada.
     */
    public function destroy($id)
    {
        $producto = $this->findProduct($id);

        if (!$producto) {
            return $this->errorResponse('Producto no encontrado.', 404);
        }

        // Eliminar imagen del disco si existe
        if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
            Storage::disk('public')->delete($producto->imagen);
        }

        $producto->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Producto e imagen eliminados correctamente.',
        ]);
    }

    private function findProduct($id): ?Producto
    {
        if (!is_scalar($id) || filter_var($id, FILTER_VALIDATE_INT) === false || (int) $id < 1) {
            return null;
        }

        return Producto::find($id);
    }

    private function validationErrorResponse(ValidatorContract $validator)
    {
        return $this->errorResponse(
            'Los datos enviados no son válidos.',
            422,
            $validator->errors()->toArray()
        );
    }

    private function errorResponse(string $message, int $status, array $errors = [])
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if ($errors !== []) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }
}
