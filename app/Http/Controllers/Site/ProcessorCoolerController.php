<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class ProcessorCoolerController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\ProcessorCooler();

      $responseData = $model -> getListData($request);

      return view('contents/site/processorCoolers/getProcessorCoolers', ['data' => $responseData]);
    }

    public function index()
    {
      $model = new \App\Models\Site\ProcessorCooler();

      $productsPageData = $model -> getProcessorCoolersData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/processorCoolers/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\ProcessorCooler();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getProcessorCoolerData($id, $generalData['seoFields']);

      if($viewPageData['processorCoolerExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/processorCoolers/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else abort(404);
    }
}
