<?php

namespace Tests\Feature;

use App\Http\Controllers\Api\ProductoController;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ProductoControllerErrorTest extends TestCase
{
    public function test_index_returns_products_when_the_upstream_service_succeeds(): void
    {
        Http::fake([
            'http://127.0.0.1:8001/api/productos/' => Http::response([
                ['id' => 1, 'nombre' => 'Teclado'],
            ]),
        ]);

        $response = app(ProductoController::class)->index();

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('success', $response->getData(true)['status']);
        $this->assertSame('Teclado', $response->getData(true)['data'][0]['nombre']);
    }

    public function test_index_returns_a_gateway_error_when_the_upstream_service_fails(): void
    {
        Http::fake([
            'http://127.0.0.1:8001/api/productos/' => Http::response([], 503),
        ]);

        $response = app(ProductoController::class)->index();

        $this->assertSame(502, $response->getStatusCode());
        $this->assertSame('error', $response->getData(true)['status']);
        $this->assertSame(503, $response->getData(true)['errors']['upstream_status']);
    }

    public function test_index_handles_a_connection_failure(): void
    {
        Http::fake(function () {
            throw new ConnectionException('Connection failed.');
        });

        $response = app(ProductoController::class)->index();

        $this->assertSame(502, $response->getStatusCode());
        $this->assertSame('error', $response->getData(true)['status']);
    }

    public function test_store_returns_field_errors_for_invalid_input(): void
    {
        $request = Request::create('/api/productos', 'POST', []);
        $response = app(ProductoController::class)->store($request);

        $this->assertSame(422, $response->getStatusCode());
        $this->assertSame('error', $response->getData(true)['status']);
        $this->assertArrayHasKey('nombre', $response->getData(true)['errors']);
        $this->assertArrayHasKey('precio', $response->getData(true)['errors']);
    }

    public function test_show_returns_not_found_for_an_invalid_product_id(): void
    {
        $response = app(ProductoController::class)->show('no-es-un-id');

        $this->assertSame(404, $response->getStatusCode());
        $this->assertSame('Producto no encontrado.', $response->getData(true)['message']);
    }
}
