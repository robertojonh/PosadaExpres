<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReportesModel;

class Reportes extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new ReportesModel();
    }

    //Funciones para usar un Excel como plantilla y colocar la info en ellas usando php/spreedsheet
}
