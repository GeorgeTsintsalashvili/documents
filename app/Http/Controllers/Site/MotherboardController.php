<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class MotherboardController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\Motherboard();

      $responseData = $model -> getListData($request);

      return view('contents/site/motherboards/getMotherboards', ['data' => $responseData]);
    }

    public function index()
    {
      $model = new \App\Models\Site\Motherboard();

      $productsPageData = $model -> getMotherboardsData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/motherboards/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\Motherboard();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getMotherboardData($id, $generalData['seoFields']);

      if($viewPageData['motherboardExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/motherboards/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else abort(404);
    }
}
