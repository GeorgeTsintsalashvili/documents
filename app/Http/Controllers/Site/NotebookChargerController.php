<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class NotebookChargerController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\NotebookCharger();

      $responseData = $model -> getListData($request);

      return view('contents/site/notebookChargers/getNotebookChargers', ['data' => $responseData]);
    }

    public function index()
    {
      $model = new \App\Models\Site\NotebookCharger();

      $productsPageData = $model -> getNotebookChargersData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/notebookChargers/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\NotebookCharger();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getNotebookChargerData($id, $generalData['seoFields']);

      if($viewPageData['notebookChargerExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/notebookChargers/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else abort(404);
    }
}
