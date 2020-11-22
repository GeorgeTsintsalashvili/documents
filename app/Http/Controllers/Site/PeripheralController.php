<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class PeripheralController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\Peripheral();

      $responseData = $model -> getListData($request);

      return view('contents/site/peripherals/getPeripherals', ['data' => $responseData]);
    }

    public function index()
    {
      $functionArguments = func_get_args();

      $categoryId = count($functionArguments) != 0 ? $functionArguments[0] : 0;

      $model = new \App\Models\Site\Peripheral();

      $productsPageData = $model -> getPeripheralsData($categoryId);

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/peripherals/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\Peripheral();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getPeripheralData($id, $generalData['seoFields']);

      if($viewPageData['peripheralExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/peripherals/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else abort(404);
    }
}
