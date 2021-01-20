<?php

// The autoloader takes care of automatic file loading.
// If the given class has the namespace we want, and
// the file exists we include it automatically.
spl_autoload_register(static function ($class) {
    if (strpos($class, 'Pine\\SimplePay\\') !== 0) {
        return;
    }

    $file = __DIR__.sprintf('/src/%s.php', str_replace(['Pine\\SimplePay\\', '\\'], ['', '/'], $class));

    if (is_file($file)) {
        require_once $file;
    }
});
