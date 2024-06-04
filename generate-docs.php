<?php

require 'vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

try {
    // Load the YAML file
    $yamlFile = __DIR__ . '/docs/openapi.yaml';
    if (!file_exists($yamlFile)) {
        throw new Exception("YAML file not found: $yamlFile");
    }
    $yamlData = Yaml::parseFile($yamlFile);

    // Convert the YAML data to JSON
    $openapiJson = json_encode($yamlData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    // Save the documentation to a file
    file_put_contents(__DIR__ . '/public/docs/openapi.json', $openapiJson);

    // Output the documentation
    header('Content-Type: application/json');
    echo $openapiJson;
} catch (Exception $e) {
    echo 'Error: ',  $e->getMessage(), "\n";
}
