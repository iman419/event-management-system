<?php
require_once __DIR__ . '/../services/EventService.php';

Flight::route('GET /events', function () {
    $service = new EventService();
    json_response($service->getAll());
});

Flight::route('GET /events/@id', function ($id) {
    $service = new EventService();
    $event = $service->getById((int)$id);
    if (!$event) {
        json_response(['error' => 'Event not found'], 404);
        return;
    }
    json_response($event);
});

Flight::route('POST /events', function () {
    $payload = json_decode(Flight::request()->getBody(), true) ?? [];
    $service = new EventService();
    try {
        $id = $service->create($payload);
        json_response(['id' => $id], 201);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 422);
    }
});

Flight::route('PUT /events/@id', function ($id) {
    $payload = json_decode(Flight::request()->getBody(), true) ?? [];
    $service = new EventService();
    try {
        $ok = $service->update((int)$id, $payload);
        json_response(['updated' => (bool)$ok]);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 422);
    }
});

Flight::route('DELETE /events/@id', function ($id) {
    $service = new EventService();
    try {
        $ok = $service->delete((int)$id);
        json_response(['deleted' => (bool)$ok]);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 400);
    }
});
