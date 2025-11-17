<?php
require_once __DIR__ . '/../services/OrderItemService.php';

Flight::route('GET /order-items', function () {
    $service = new OrderItemService();
    json_response($service->getAll());
});

Flight::route('GET /order-items/@id', function ($id) {
    $service = new OrderItemService();
    $row = $service->getById((int)$id);
    if (!$row) {
        json_response(['error' => 'Order item not found'], 404);
        return;
    }
    json_response($row);
});

Flight::route('POST /order-items', function () {
    $payload = json_decode(Flight::request()->getBody(), true) ?? [];
    $service = new OrderItemService();
    try {
        $id = $service->create($payload);
        json_response(['id' => $id], 201);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 422);
    }
});

Flight::route('PUT /order-items/@id', function ($id) {
    $payload = json_decode(Flight::request()->getBody(), true) ?? [];
    $service = new OrderItemService();
    try {
        $ok = $service->update((int)$id, $payload);
        json_response(['updated' => (bool)$ok]);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 422);
    }
});

Flight::route('DELETE /order-items/@id', function ($id) {
    $service = new OrderItemService();
    try {
        $ok = $service->delete((int)$id);
        json_response(['deleted' => (bool)$ok]);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 400);
    }
});
