<?php

namespace App\Http\Controllers\Site;

use Illuminate\Support\Facades\Http; // added for making requests

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class HomeController extends Controllers\Controller
{
    public function index(Request $request)
    {
       $model = new \App\Models\Site\Home();

       $contentData = $model -> getIndexPageData();

       $generalData = \App\Models\Site\BaseModel::getGeneralData();

       \App\Models\Site\BaseModel::collectStatisticalData($model);

       return view('contents/site/home/index', ['contentData' => $contentData, 'generalData' => $generalData]);
    }
}
