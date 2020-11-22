<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class ProductController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $model = new \App\Models\Site\Product();

      $responseData = $model -> getListData($request);

      return view('contents/site/products/getSearchResults', ['data' => $responseData]);
    }

    public function getLiveSearchResults(Request $request)
    {
      $model = new \App\Models\Site\Product();

      $products = $model -> getLiveSearchResultsData($request);

      return view('contents/site/products/liveSearchResults', ['data' => $products]);
    }

    public function search(Request $request)
    {
      $model = new \App\Models\Site\Product();

      $products = $model -> getProductsSearchData($request);

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      return view('contents/site/products/search', ['contentData' => $products, 'generalData' => $generalData]);
    }
}
