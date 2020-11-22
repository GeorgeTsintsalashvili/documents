<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class NetworkDeviceController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\NetworkDevice();

      $responseData = $model -> getListData($request);

      return view('contents/site/networkDevices/getNetworkDevices', ['data' => $responseData]);
    }

    public function index()
    {
      $functionArguments = func_get_args();

      $categoryId = count($functionArguments) != 0 ? $functionArguments[0] : 0;

      $model = new \App\Models\Site\NetworkDevice();

      $productsPageData = $model -> getNetworkDevicesData($categoryId);

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/networkDevices/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\NetworkDevice();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getNetworkDeviceData($id, $generalData['seoFields']);

      if($viewPageData['networkDeviceExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/networkDevices/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else abort(404);
    }
}
