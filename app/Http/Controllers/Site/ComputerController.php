<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class ComputerController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\Computer();

      $responseData = $model -> getListData($request);

      return view('contents/site/computers/getComputers', ['data' => $responseData]);
    }

    public function getComputersForHomePage($id)
    {
      $model = new \App\Models\Site\Computer();

      $computers = $model -> getComputersForHomePageData($id); // system identifier is passed
      $computersExist = !$computers -> isEmpty();

      return view('contents/site/computers/getComputersForHomePage', ['computers' => $computers,
                                                                      'computersExist' => $computersExist]);
    }

    public function index()
    {
      $model = new \App\Models\Site\Computer();

      $productsPageData = $model -> getComputersData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/computers/index', ['contentData' => $productsPageData,
                                                    'generalData' => $generalData]);
    }

    public function view($id)
    {
       $model = new \App\Models\Site\Computer();

       $generalData = \App\Models\Site\BaseModel::getGeneralData();

       $viewPageData = $model -> getComputerData($id, $generalData['seoFields']);

       if($viewPageData['computerExists'])
       {
         \App\Models\Site\BaseModel::collectStatisticalData($model);

         return view('contents/site/computers/view', ['contentData' => $viewPageData,
                                                      'generalData' => $generalData]);
       }

       else abort(404);
    }
}
