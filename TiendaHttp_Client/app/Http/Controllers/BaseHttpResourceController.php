<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

abstract class BaseHttpResourceController extends Controller
{
    protected string $resource;
    protected string $module;
    protected string $moduleTitle;
    protected string $modelName;
    protected array $fields = [];
    protected array $optionSources = [];
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = rtrim(env('API_URL', 'http://127.0.0.1:8000/api'), '/');
    }

    protected function client()
    {
        $token = session('admin_token');
        return Http::withToken($token)
            ->acceptJson()
            ->timeout(10);
    }

    public function listar(): View|RedirectResponse
    {
        try {
            $response = $this->client()->get("{$this->apiUrl}/{$this->resource}");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => "Error de conexión con la API al listar {$this->moduleTitle}: " . $e->getMessage()]);
        }

        if (!$response->successful()) {
            return back()->withErrors(['error' => "Error al obtener {$this->moduleTitle} desde la API: " . ($response->json('message') ?? $response->status())]);
        }

        $body = $response->json();
        $registros = $body['data'] ?? $body;
        if (!is_array($registros)) {
            $registros = [];
        }

        return view("{$this->module}.mvc.listado", $this->datosVista(['registros' => $registros]));
    }

    public function vistaFormulario(): View
    {
        return view("{$this->module}.mvc.registro", $this->datosVista(['modo' => 'crear']));
    }

    public function registrar(Request $request): RedirectResponse
    {
        $datos = $request->except(['_token', '_method']);

        try {
            $client = $this->client();

            foreach ($this->fields as $campo) {
                if (($campo['type'] ?? '') === 'image' && $request->hasFile($campo['name'])) {
                    $file = $request->file($campo['name']);
                    $client = $client->attach($campo['name'], file_get_contents($file->getRealPath()), $file->getClientOriginalName());
                    unset($datos[$campo['name']]);
                }
            }

            foreach ($datos as $k => $v) {
                if ($v === null || $v === '') {
                    unset($datos[$k]);
                }
            }

            $response = $client->post("{$this->apiUrl}/{$this->resource}", $datos);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => "Error al enviar datos a la API: " . $e->getMessage()])->withInput();
        }

        if (!$response->successful()) {
            $errores = $response->json('errors') ?? ['error' => $response->json('message') ?? 'Error en la API'];
            $mensajes = [];
            foreach ($errores as $campo => $msgs) {
                $mensajes[] = is_array($msgs) ? implode(', ', $msgs) : $msgs;
            }
            return back()->withErrors(['api_error' => implode(' | ', $mensajes)])->withInput();
        }

        return redirect()->route("{$this->module}.listar")
            ->with('exito', "Registro de {$this->moduleTitle} guardado correctamente vía API (POST).");
    }

    public function vistaEdicion(int $id): View|RedirectResponse
    {
        try {
            $response = $this->client()->get("{$this->apiUrl}/{$this->resource}/{$id}");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => "Error de conexión con la API: " . $e->getMessage()]);
        }

        if (!$response->successful()) {
            return back()->withErrors(['error' => "No se encontró el registro en la API."]);
        }

        $registro = $response->json('data') ?? $response->json();

        return view("{$this->module}.mvc.edicion", $this->datosVista([
            'modo' => 'editar',
            'id' => $id,
            'registro' => $registro,
        ]));
    }

    public function actualizar(Request $request, int $id): RedirectResponse
    {
        $datos = $request->except(['_token', '_method']);

        try {
            $client = $this->client();

            $hasImage = false;
            foreach ($this->fields as $campo) {
                if (($campo['type'] ?? '') === 'image' && $request->hasFile($campo['name'])) {
                    $file = $request->file($campo['name']);
                    $client = $client->attach($campo['name'], file_get_contents($file->getRealPath()), $file->getClientOriginalName());
                    unset($datos[$campo['name']]);
                    $hasImage = true;
                }
            }

            foreach ($datos as $k => $v) {
                if ($v === null || $v === '') {
                    unset($datos[$k]);
                }
            }

            if ($hasImage) {
                $datos['_method'] = 'PUT';
                $response = $client->post("{$this->apiUrl}/{$this->resource}/{$id}", $datos);
            } else {
                $response = $client->put("{$this->apiUrl}/{$this->resource}/{$id}", $datos);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => "Error al actualizar en la API: " . $e->getMessage()])->withInput();
        }

        if (!$response->successful()) {
            $errores = $response->json('errors') ?? ['error' => $response->json('message') ?? 'Error en la API'];
            $mensajes = [];
            foreach ($errores as $campo => $msgs) {
                $mensajes[] = is_array($msgs) ? implode(', ', $msgs) : $msgs;
            }
            return back()->withErrors(['api_error' => implode(' | ', $mensajes)])->withInput();
        }

        return redirect()->route("{$this->module}.listar")
            ->with('exito', "Registro de {$this->moduleTitle} actualizado correctamente vía API (PUT).");
    }

    public function vistaMostrar(int $id): View|RedirectResponse
    {
        try {
            $response = $this->client()->get("{$this->apiUrl}/{$this->resource}/{$id}");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => "Error de conexión con la API: " . $e->getMessage()]);
        }

        if (!$response->successful()) {
            return back()->withErrors(['error' => "No se encontró el registro en la API."]);
        }

        $registro = $response->json('data') ?? $response->json();

        return view("{$this->module}.mvc.mostrar", $this->datosVista([
            'id' => $id,
            'registro' => $registro,
        ]));
    }

    public function borrar(int $id): RedirectResponse
    {
        try {
            $response = $this->client()->delete("{$this->apiUrl}/{$this->resource}/{$id}");
        } catch (\Exception $e) {
            return back()->withErrors(['error' => "Error al eliminar en la API: " . $e->getMessage()]);
        }

        if (!$response->successful()) {
            return back()->withErrors(['error' => "No fue posible eliminar el registro en la API: " . ($response->json('message') ?? '')]);
        }

        return redirect()->route("{$this->module}.listar")
            ->with('exito', "Registro de {$this->moduleTitle} eliminado correctamente vía API (DELETE).");
    }

    protected function datosVista(array $extra = []): array
    {
        $campos = $this->fields;

        foreach ($campos as &$campo) {
            $campo['options'] = $this->obtenerOpcionesCampo($campo['name'], $campo['options'] ?? []);
        }
        unset($campo);

        return array_merge([
            'modulo' => $this->module,
            'titulo' => $this->moduleTitle,
            'modelo' => $this->modelName,
            'campos' => $campos,
            'registro' => [],
            'modo' => 'crear',
        ], $extra);
    }

    protected function obtenerOpcionesCampo(string $nombre, array $opcionesDefault = []): array
    {
        if (!isset($this->optionSources[$nombre])) {
            return $opcionesDefault;
        }

        $src = $this->optionSources[$nombre];
        $resource = $src['resource'];
        $labelField = $src['label'];

        try {
            $response = $this->client()->get("{$this->apiUrl}/{$resource}");
            if ($response->successful()) {
                $body = $response->json();
                $items = $body['data'] ?? $body;
                if (is_array($items)) {
                    $opciones = [];
                    foreach ($items as $item) {
                        if (isset($item['id']) && isset($item[$labelField])) {
                            $opciones[$item['id']] = $item[$labelField];
                        }
                    }
                    return $opciones;
                }
            }
        } catch (\Exception $e) {
            Log::warning("No se pudieron cargar opciones para {$nombre} desde {$resource}: " . $e->getMessage());
        }

        return $opcionesDefault;
    }
}
