<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/dao/UserDao.php';
require_once __DIR__ . '/dao/VenueDao.php';
require_once __DIR__ . '/dao/EventDao.php';

$pdo = Database::connect();
$u = new UserDao();
$v = new VenueDao();
$e = new EventDao();


$email = 'org@example.com';
$uid = null;
$st = $pdo->prepare("SELECT id FROM users WHERE email=:email");
$st->execute([':email'=>$email]);
$row = $st->fetch();
if ($row) {
  $uid = (int)$row['id'];
} else {
  $uid = $u->insert([
    'full_name'     => 'Demo Organizer',
    'email'         => $email,
    'password_hash' => '$2y$10$demoHash',
    'role'          => 'organizer'
  ]);
}


$venueName = 'City Arena';
$vid = null;
$st = $pdo->prepare("SELECT id FROM venues WHERE name=:n");
$st->execute([':n'=>$venueName]);
$row = $st->fetch();
if ($row) {
  $vid = (int)$row['id'];
} else {
  $vid = $v->insert([
    'name'     => $venueName,
    'city'     => 'Sarajevo',
    'capacity' => 5000,
    'address'  => 'Zmaja od Bosne 12'
  ]);
}


$title = 'Sarajevo Tech Summit';
$eid = null;
$st = $pdo->prepare("SELECT id FROM events WHERE title=:t");
$st->execute([':t'=>$title]);
$row = $st->fetch();
if ($row) {
  $eid = (int)$row['id'];
} else {
  $eid = $e->insert([
    'organizer_id' => $uid,
    'venue_id'     => $vid,
    'title'        => $title,
    'category'     => 'Tech',
    'description'  => 'Annual tech conference.',
    'starts_at'    => '2025-11-20 09:00:00',
    'ends_at'      => '2025-11-20 18:00:00',
    'status'       => 'published'
  ]);
}

echo "Seeded: user=$uid, venue=$vid, event=$eid";
