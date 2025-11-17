<?php
require_once __DIR__ . '/../services/TicketTypeService.php';

Flight::route('GET /ticket-types', function () {
    $service = new TicketTypeService();
    json_response($service->getAll());
});

Flight::route('GET /ticket-types/@id', function ($id) {
    $service = new TicketTypeService();
    $row = $service->getById((int)$id);
    if (!$row) {
        json_response(['error' => 'Ticket type not found'], 404);
        return;
    }
    json_response($row);
});

Flight::route('POST /ticket-types', function () {
    $payload = json_decode(Flight::request()->getBody(), true) ?? [];
    $service = new TicketTypeService();
    try {
        $id = $service->create($payload);
        json_response(['id' => $id], 201);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 422);
    }
});

Flight::route('PUT /ticket-types/@id', function ($id) {
    $payload = json_decode(Flight::request()->getBody(), true) ?? [];
    $service = new TicketTypeService();
    try {
        $ok = $service->update((int)$id, $payload);
        json_response(['updated' => (bool)$ok]);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 422);
    }
});

Flight::route('DELETE /ticket-types/@id', function ($id) {
    $service = new TicketTypeService();
    try {
        $ok = $service->delete((int)$id);
        json_response(['deleted' => (bool)$ok]);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 400);
    }
});
