<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class HardDiskDriveController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\HardDiskDrive();

      $responseData = $model -> getListData($request);

      return view('contents/site/hardDiskDrives/getHardDiskDrives', ['data' => $responseData]);
    }

    public function index()
    {
      $model = new \App\Models\Site\HardDiskDrive();

      $productsPageData = $model -> getHardDiskDrivesData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/hardDiskDrives/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\HardDiskDrive();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getHardDiskDriveData($id, $generalData['seoFields']);

      if($viewPageData['hardDiskDriveExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/hardDiskDrives/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else return abort(404);
    }
}
