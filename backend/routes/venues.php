<?php
require_once __DIR__ . '/../services/VenueService.php';

Flight::route('GET /venues', function () {
    $service = new VenueService();
    json_response($service->getAll());
});

Flight::route('GET /venues/@id', function ($id) {
    $service = new VenueService();
    $venue = $service->getById((int)$id);
    if (!$venue) {
        json_response(['error' => 'Venue not found'], 404);
        return;
    }
    json_response($venue);
});

Flight::route('POST /venues', function () {
    $payload = json_decode(Flight::request()->getBody(), true) ?? [];
    $service = new VenueService();
    try {
        $id = $service->create($payload);
        json_response(['id' => $id], 201);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 422);
    }
});

Flight::route('PUT /venues/@id', function ($id) {
    $payload = json_decode(Flight::request()->getBody(), true) ?? [];
    $service = new VenueService();
    try {
        $ok = $service->update((int)$id, $payload);
        json_response(['updated' => (bool)$ok]);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 422);
    }
});

Flight::route('DELETE /venues/@id', function ($id) {
    $service = new VenueService();
    try {
        $ok = $service->delete((int)$id);
        json_response(['deleted' => (bool)$ok]);
    } catch (Throwable $e) {
        json_response(['error' => $e->getMessage()], 400);
    }
});
