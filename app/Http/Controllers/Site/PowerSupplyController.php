<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class PowerSupplyController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\PowerSupply();

      $responseData = $model -> getListData($request);

      return view('contents/site/powerSupplies/getPowerSupplies', ['data' => $responseData]);
    }

    public function index()
    {
      $model = new \App\Models\Site\PowerSupply();

      $productsPageData = $model -> getPowerSuppliesData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/powerSupplies/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\PowerSupply();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getPowerSupplyData($id, $generalData['seoFields']);

      if($viewPageData['powerSupplyExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/powerSupplies/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

       else abort(404);
    }
}
