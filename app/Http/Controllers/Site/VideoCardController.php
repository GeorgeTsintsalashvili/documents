<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class VideoCardController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\VideoCard();

      $responseData = $model -> getListData($request);

      return view('contents/site/videoCards/getVideoCards', ['data' => $responseData]);
    }

    public function index()
    {
      $model = new \App\Models\Site\VideoCard();

      $productsPageData = $model -> getVideoCardsData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      return view('contents/site/videoCards/index', ['contentData' => $productsPageData, 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $model = new \App\Models\Site\VideoCard();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $viewPageData = $model -> getVideoCardData($id, $generalData['seoFields']);

      if($viewPageData['videoCardExists'])
      {
        \App\Models\Site\BaseModel::collectStatisticalData($model);

        return view('contents/site/videoCards/view', ['contentData' => $viewPageData, 'generalData' => $generalData]);
      }

      else abort(404);
    }
}
