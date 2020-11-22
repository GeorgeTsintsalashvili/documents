<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class ProcessorController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\Processor();

      $responseData = $model -> getListData($request);

      return view('contents/site/processors/getProcessors', ['data' => $responseData]);
    }

    public function index()
    {
      $model = new \App\Models\Site\Processor();

      $productsPageData = $model -> getProcessorsData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/processors/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\Processor();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getProcessorData($id, $generalData['seoFields']);

      if($viewPageData['processorExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/processors/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else abort(404);
    }
}
