<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class MemoryModuleController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\MemoryModule();

      $responseData = $model -> getListData($request);

      return view('contents/site/memoryModules/getMemoryModules', ['data' => $responseData]);
    }

    public function index()
    {
      $model = new \App\Models\Site\MemoryModule();

      $productsPageData = $model -> getMemoryModulesData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/memoryModules/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\MemoryModule();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getMemoryModuleData($id, $generalData['seoFields']);

      if($viewPageData['memoryModuleExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/memoryModules/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else abort(404);
    }
}
