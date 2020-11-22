<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class ShoppingCartController extends Controllers\Controller
{
    public function index()
    {
      $model = new \App\Models\Site\ShoppingCart();

      $shoppingCartProductsData = $model -> getShoppingCartProductsData();

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      return view('contents/site/shoppingCart/index', ['contentData' => $shoppingCartProductsData, 'generalData' => $generalData]);
    }

    public function add(Request $request)
    {
      $model = new \App\Models\Site\ShoppingCart();

      $shoppingCartResponseData = $model -> getProductAddData($request);

      return response(json_encode($shoppingCartResponseData)) -> header('Content-Type', 'application/json');
    }

    public function delete(Request $request)
    {
      $model = new \App\Models\Site\ShoppingCart();

      $shoppingCartResponseData = $model -> getProductDeleteData($request);

      return response(json_encode($shoppingCartResponseData)) -> header('Content-Type', 'application/json');
    }

    public function changeQuantity(Request $request)
    {
      $model = new \App\Models\Site\ShoppingCart();

      $shoppingCartResponseData = $model -> getProductChangeQuantityData($request);

      return response(json_encode($shoppingCartResponseData)) -> header('Content-Type', 'application/json');
    }
}
