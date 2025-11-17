<?php
require_once __DIR__ . '/../services/OrderService.php';

Flight::route('GET /orders', function () {
    $service = new OrderService();
    json_response($service->getAll());
});

Flight::route('GET /orders/@id', function ($id) {
    $service = new OrderService();
    $row = $service->getById((int)$id);
    if (!$row) {
        json_response(['error' => 'Order not found'], 404);
        return;
    }
    json_response($row);
});

Flight::route('POST /orders', function () {
    $payload = json_decode(Flight::request()->getBody(), true) ?? [];
    $service = new OrderService();
    try {
        $id = $service->create($payload);
        json_response(['id' => $id], 201);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 422);
    }
});

Flight::route('PUT /orders/@id', function ($id) {
    $payload = json_decode(Flight::request()->getBody(), true) ?? [];
    $service = new OrderService();
    try {
        $ok = $service->update((int)$id, $payload);
        json_response(['updated' => (bool)$ok]);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 422);
    }
});

Flight::route('DELETE /orders/@id', function ($id) {
    $service = new OrderService();
    try {
        $ok = $service->delete((int)$id);
        json_response(['deleted' => (bool)$ok]);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 400);
    }
});
