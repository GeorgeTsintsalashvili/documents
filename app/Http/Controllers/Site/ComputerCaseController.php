<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class ComputerCaseController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\ComputerCase();

      $responseData = $model -> getListData($request);

      return view('contents/site/computerCases/getComputerCases', ['data' => $responseData]);
    }

    public function index()
    {
      $model = new \App\Models\Site\ComputerCase();

      $productsPageData = $model -> getComputerCasesData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/computerCases/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\ComputerCase();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getComputerCaseData($id, $generalData['seoFields']);

      if($viewPageData['caseExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/computerCases/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else abort(404);
    }
}
