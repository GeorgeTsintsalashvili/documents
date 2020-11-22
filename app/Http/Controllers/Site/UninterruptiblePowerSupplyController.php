<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class UninterruptiblePowerSupplyController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\UninterruptiblePowerSupply();

      $responseData = $model -> getListData($request);

      return view('contents/site/uninterruptiblePowerSupplies/getUninterruptiblePowerSupplies', ['data' => $responseData]);
    }

    public function index()
    {
      $model = new \App\Models\Site\UninterruptiblePowerSupply();

      $productsPageData = $model -> getUninterruptiblePowerSuppliesData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/uninterruptiblePowerSupplies/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\UninterruptiblePowerSupply();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getUninterruptiblePowerSupplyData($id, $generalData['seoFields']);

      if($viewPageData['uninterruptiblePowerSupplyExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/uninterruptiblePowerSupplies/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else abort(404);
    }
}
