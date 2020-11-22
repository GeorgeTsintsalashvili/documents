<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class CaseCoolerController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\CaseCooler();

      $responseData = $model -> getListData($request);

      return view('contents/site/caseCoolers/getCaseCoolers', ['data' => $responseData]);
    }

    public function index()
    {
      $model = new \App\Models\Site\CaseCooler();

      $productsPageData = $model -> getCaseCoolersData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/caseCoolers/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\CaseCooler();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getCaseCoolerData($id, $generalData['seoFields']);

      if($viewPageData['caseCoolerExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/caseCoolers/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else abort(404);
    }
}
