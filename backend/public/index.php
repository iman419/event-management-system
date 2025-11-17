<?php

require_once __DIR__ . '/../lib/autoload.php';
require_once __DIR__ . '/../config.php';


require_once __DIR__ . '/../routes/main.php';
require_once __DIR__ . '/../routes/users.php';
require_once __DIR__ . '/../routes/events.php';
require_once __DIR__ . '/../routes/venues.php';
require_once __DIR__ . '/../routes/ticket_types.php';
require_once __DIR__ . '/../routes/orders.php';
require_once __DIR__ . '/../routes/order_items.php';

Flight::start();
