<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View; // use View facade class

class AccessoryController extends Controllers\Controller
{
    public function getList(Request $request) // injecting dependency into controller (passing object of type Request)
    {
      $model = new \App\Models\Site\Accessory();

      $responseData = $model -> getListData($request); // instead of $request variable request() global helper function can be used which returns an object reference (request() and $request behave identically)

      return view('contents/site/accessories/getAccessories', ['data' => $responseData]);
    }

    public function getAccessoriesForHomePage($id)
    {
      $model = new \App\Models\Site\Accessory();

      $accessories = $model -> getAccessoriesForHomePageData($id);
      $accessoriesExist = !$accessories -> isEmpty();

      return view('contents/site/accessories/getAccessoriesForHomePage', ['accessories' => $accessories,
                                                                          'accessoriesExist' => $accessoriesExist]);
    }

    public function index()
    {
      $functionArguments = func_get_args();

      $categoryId = count($functionArguments) != 0 ? $functionArguments[0] : 0;

      $model = new \App\Models\Site\Accessory(); // get fully qualified name of the class using built-in Accessories::class property

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $productsPageData = $model -> getAccessoriesData($categoryId);

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return View::make('contents/site/accessories/index') -> with(['contentData' => $productsPageData,
                                                                    'generalData' => $generalData]); // is identical to view() global helper function
    }

    public function view($id)
    {
      $model = new \App\Models\Site\Accessory();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getAccessoryData($id, $generalData['seoFields']);

      if($viewPageData['accessoryExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/accessories/view', ['contentData' => $viewPageData,
                                                       'generalData' => $generalData]);
      }

      else abort(404);
    }
}
