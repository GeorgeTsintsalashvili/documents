<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class SolidStateDriveController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\SolidStateDrive();

      $responseData = $model -> getListData($request);

      return view('contents/site/solidStateDrives/getSolidStateDrives', ['data' => $responseData]);
    }

    public function index()
    {
      $model = new \App\Models\Site\SolidStateDrive();

      $productsPageData = $model -> getSolidStateDrivesData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/solidStateDrives/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\SolidStateDrive();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getSolidStateDriveData($id, $generalData['seoFields']);

      if($viewPageData['solidStateDriveExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/solidStateDrives/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else abort(404);
    }
}
