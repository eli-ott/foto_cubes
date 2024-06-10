<?php

require 'vendor/autoload.php';

use League\Glide\ServerFactory;

$sourcePath = __DIR__ . '/Public/assets/uploads'; // Chemin vers les images source
$cachePath = __DIR__ . '/Public/assets/cache';   // Chemin vers le dossier de cache

$server = ServerFactory::create([
    'source' => $sourcePath,
    'cache' => $cachePath,
    'cache_with_file_extensions' => true,
    'group_cache_in_folders' => false,
]);

return $server;