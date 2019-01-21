<?php

// The autoloader takes care of automatic file loading.
// If the given class has the namespace we want, and
// the file exists we include it automatically.
spl_autoload_register(function ($class) {
    if (! strpos($class, 'Pine\\SimplePay\\') === 0) {
        return;
    }

    $file = simplepay_gateway_path(sprintf(
        'src/%s.php',
        str_replace('\\', '/', str_replace('Pine\\SimplePay\\', '', $class))
    ));

    if (file_exists($file)) {
        require_once $file;
    }
});
