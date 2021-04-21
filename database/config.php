<?php
require_once "../vendor/autoload.php";

//VARIABLES DE ENTORNO
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => "pgsql",
    'host'      => "queenie.db.elephantsql.com",
    'database'  => "mijcvtlh",
    'username'  => "mijcvtlh",
    'password'  => "N2_Ob5doHV5-yQweD-V2pvSB8UT9YEPW",
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();
