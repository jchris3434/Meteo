<?php

echo "Test Jean-Christophe Fontaine";

if (!is_file(__DIR__ . '/vendor/autoload.php')) {
    exit('/!\ Please run composer install /!\\');
}

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/pages/FormMeteo.php';

// TODO: show weather

echo getFormMeteo();




