<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class MonitorController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\Monitor();

      $responseData = $model -> getListData($request);

      return view('contents/site/monitors/getMonitors', ['data' => $responseData]);
    }

    public function index()
    {
      $model = new \App\Models\Site\Monitor();

      $productsPageData = $model -> getMonitorsData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/monitors/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\Monitor();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getMonitorData($id, $generalData['seoFields']);

      if($viewPageData['monitorExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/monitors/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else abort(404);
    }
}
