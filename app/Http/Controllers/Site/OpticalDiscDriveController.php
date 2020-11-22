<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class OpticalDiscDriveController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\OpticalDiscDrive();

      $responseData = $model -> getListData($request);

      return view('contents/site/opticalDiscDrives/getOpticalDiscDrives', ['data' => $responseData]);
    }

    public function index()
    {
      $model = new \App\Models\Site\OpticalDiscDrive();

      $productsPageData = $model -> getOpticalDiscDrivesData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/opticalDiscDrives/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\OpticalDiscDrive();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getOpticalDiscDriveData($id, $generalData['seoFields']);

      if($viewPageData['opticalDiscDriveExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/opticalDiscDrives/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else abort(404);
    }
}
