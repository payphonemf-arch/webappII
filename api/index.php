<?php
declare(strict_types=1);
require __DIR__ . '/src/Database.php';
require __DIR__ . '/src/Models/Entity.php';
require __DIR__ . '/src/Api.php';
(new Northwind\Api())->run();
