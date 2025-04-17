<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class crearVista extends BaseCommand
{
    protected $group = 'Generators';
    protected $name = 'make:view';
    protected $description = 'Command to create a new View. You can specify the folder and file name.';

    public function run(array $params)
    {
        if (empty($params)) {
            CLI::error("Debes especificar el nombre de la vista. Ejemplo: make:view entregables/view1");
            return;
        }

        $path = $params[0];
        $basePath = APPPATH . 'Views/';
        $fullPath = $basePath . $path . '.php';

        $directory = dirname($fullPath);
        $fileName = basename($fullPath);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
            CLI::write("Directorio creado: $directory", 'green');
        }

        if (file_exists($fullPath)) {
            CLI::error("El archivo $fileName ya existe en la carpeta $directory.");
            return;
        }

        $content = "<!-- Vista: $path -->\n";
        $content .= "<h1>Bienvenido a $fileName</h1>";

        if (file_put_contents($fullPath, $content) !== false) {
            CLI::write("Vista creada correctamente: $fullPath", 'green');
        } else {
            CLI::error("No se pudo crear la vista.");
        }
    }
}