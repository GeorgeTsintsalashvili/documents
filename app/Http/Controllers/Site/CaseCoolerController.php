<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;
use \App\Helpers\Paginator;

use \App\Models\Site\BaseModel;
use \App\Models\Site\CaseCooler;

class CaseCoolerController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $data['productsExist'] = false;

      $numOfProductsToView = 6;
      $supportedOrders = [1, 2, 3, 4];
      $priceRange = BaseModel::getPriceRange(CaseCooler::class);

      $parameters = $request -> all(); // user input

      $validator = \Validator::make($parameters, ['active-page' => 'required|integer',
                                                  'price-from' => 'required|integer',
                                                  'price-to' => 'required|integer',
                                                  'order' => 'required|integer',
                                                  'numOfProductsToShow' => 'required|integer',
                                                  'stock-type' => 'required|string',
                                                  'condition' => 'required|string',
                                                  'size' => 'required|string']);

      if (!$validator -> fails() && !is_null($priceRange))
      {
        $numOfProductsToView = abs((int) $parameters['numOfProductsToShow']);
        $productsOrder = abs((int) $parameters['order']);

        if ($numOfProductsToView && $numOfProductsToView % 3 == 0 && $numOfProductsToView <= 30)
        {
          $priceFrom = abs((int) $parameters['price-from']);
          $priceTo = abs((int) $parameters['price-to']);

          $priceFromIsInRange = $priceFrom >= $priceRange -> caseCoolerMinPrice && $priceFrom <= $priceRange -> caseCoolerMaxPrice;
          $priceToIsInRange = $priceTo >= $priceRange -> caseCoolerMinPrice && $priceTo <= $priceRange -> caseCoolerMaxPrice;

          if ($priceFromIsInRange && $priceToIsInRange)
          {
            $conditions = \DB::table('conditions') -> get();
            $conditionExists = $conditions -> count() != 0;

            $stockTypes = \DB::table('stock_types') -> get();
            $stockTypeExists = $stockTypes -> count() != 0;

            $coolersSizes = \DB::table('case_coolers') -> selectRaw('DISTINCT(`size`) AS `size`') -> get();
            $coolersSizesExist = $coolersSizes -> count() != 0;

            if ($coolersSizesExist && $stockTypeExists && $conditionExists)
            {
              $coolersSizesParts = array_map('intval', explode(':', $parameters['size']));
              $conditionsParts = array_map('intval', explode(':', $parameters['condition']));
              $stockTypesParts = array_map('intval', explode(':', $parameters['stock-type']));

              $columns = ['case_coolers.id', 'title', 'mainImage', 'discount', 'price'];
              $coolersSizesNumbers = $conditionNumbers = $stockTypesNumbers = [];

              $query = \DB::table('case_coolers') -> select($columns) -> where('visibility', 1);

              foreach ($conditions as $value) $conditionNumbers[] = $value -> id;
              foreach ($stockTypes as $value) $stockTypesNumbers[] = $value -> id;
              foreach ($coolersSizes as $value) $accessoryTypesNumbers[] = $value -> size;

              if (array_intersect($conditionsParts, $conditionNumbers) == $conditionsParts) $query = $query -> whereIn('conditionId', $conditionsParts);
              if (array_intersect($stockTypesParts, $stockTypesNumbers) == $stockTypesParts) $query = $query -> whereIn('stockTypeId', $stockTypesParts);
              if (array_intersect($coolersSizesParts, $coolersSizesNumbers) == $coolersSizesParts) $query = $query -> whereIn('size', $coolersSizesParts);

              $query = $query -> where('price', '>=', $priceFrom) -> where('price', '<=', $priceTo);

              if (in_array($productsOrder, $supportedOrders))
              {
                $orderNumber = !($productsOrder % 2);
                $orderColumn = $productsOrder == 1 || $productsOrder == 2 ? 'price' : 'timestamp';

                $query = $query -> orderBy($orderColumn, $orderNumber == 0 ? 'desc' : 'asc');
              }

              $currentPage = abs((int) $parameters['active-page']);
              $totalNumOfProducts = $query -> count();

              if ($currentPage != 0 && $totalNumOfProducts != 0)
              {
                $paginator = \Paginator::build($totalNumOfProducts, 3, $numOfProductsToView, $currentPage, 2, 0);

                $data['pages'] = $paginator -> pages;
                $data['maxPage'] = $paginator -> maxPage;
                $data['currentPage'] = $currentPage;

                $data['products'] = $query -> skip(($currentPage - 1) * $numOfProductsToView) -> take($numOfProductsToView) -> get();
                $data['productsExist'] = true;

                $data['products'] -> map(function($product){

                   $product -> newPrice = $product -> price - $product -> discount;
                });

                $data['products'] = $data['products'] -> chunk(3);
              }
            }
          }
        }
      }

      return View::make('contents.site.caseCoolers.getCaseCoolers', ['data' => $data]);
    }

    public function index()
    {
      $generalData = BaseModel::getGeneralData();
      $numOfProductsToView = 6;

      $data['configuration']['productPriceRange'] = BaseModel::getPriceRange(CaseCooler::class);
      $data['configuration']['productPriceRangeExists'] = !is_null($data['configuration']['productPriceRange']);
      $data['coolersExist'] = false;

      if ($data['configuration']['productPriceRangeExists'])
      {
        $productMinPrice = $data['configuration']['productPriceRange'] -> caseCoolerMinPrice;
        $productMaxPrice = $data['configuration']['productPriceRange'] -> caseCoolerMaxPrice;

        $columns = ['case_coolers.id', 'title', 'mainImage', 'discount', 'price'];
        $query = \DB::table('case_coolers') -> select($columns) -> where('visibility', 1) -> where('price', '>=', $productMinPrice) -> where('price', '<=', $productMaxPrice);

        $totalNumberOfProducts = $query -> count();
        $data['coolersExist'] = $totalNumberOfProducts != 0;

        if ($data['coolersExist'])
        {
          $data['configuration']['coolersSizes'] = \DB::table('case_coolers') -> select(\DB::raw('DISTINCT(`size`) AS `size`'))
                                                                              -> where('visibility', 1)
                                                                              -> where('price', '>=', $productMinPrice)
                                                                              -> where('price', '<=', $productMaxPrice)
                                                                              -> get();

          $data['configuration']['conditions'] = \DB::table('conditions') -> get();
          $data['configuration']['stockTypes'] = \DB::table('stock_types') -> get();

          foreach ($data['configuration']['coolersSizes'] as $key => $value)
          {
            $data['configuration']['coolersSizes'][$key] -> numOfProducts = \DB::table('case_coolers') -> where('size', $value -> size)
                                                                                                       -> where('visibility', 1)
                                                                                                       -> where('price', '>=', $productMinPrice)
                                                                                                       -> where('price', '<=', $productMaxPrice)
                                                                                                       -> count();
          }

          foreach ($data['configuration']['conditions'] as $key => $value)
          {
            $data['configuration']['conditions'][$key] -> numOfProducts = \DB::table('case_coolers') -> where('conditionId', $value -> id)
                                                                                                     -> where('visibility', 1)
                                                                                                     -> where('price', '>=', $productMinPrice)
                                                                                                     -> where('price', '<=', $productMaxPrice)
                                                                                                     -> count();
          }

          foreach ($data['configuration']['stockTypes'] as $key => $value)
          {
            $data['configuration']['stockTypes'][$key] -> numOfProducts = \DB::table('case_coolers') -> where('stockTypeId', $value -> id)
                                                                                                     -> where('visibility', 1)
                                                                                                     -> where('price', '>=', $productMinPrice)
                                                                                                     -> where('price', '<=', $productMaxPrice)
                                                                                                     -> count();
          }

          $data['coolers'] = $query -> take($numOfProductsToView) -> get();

          foreach ($data['coolers'] as $key => $value) $data['coolers'][$key] -> newPrice = $value -> price - $value -> discount;

          $totalNumOfProducts = $query -> count();
          $paginator = \Paginator::build($totalNumOfProducts, 3, $numOfProductsToView, 1, 2, 0);

          $data['pages'] = $paginator -> pages;
          $data['maxPage'] = $paginator -> maxPage;
          $data['coolers'] = $data['coolers'] -> chunk(3);
        }
      }

      BaseModel::collectStatisticalData(CaseCooler::class);

      return View::make('contents.site.caseCoolers.index', ['contentData' => $data,
                                                            'generalData' => $generalData]);
    }

    public function view($id)
    {
      $generalData = BaseModel::getGeneralData();
      $columns = ['case_coolers.id', 'code', 'title', 'mainImage', 'discount', 'price', 'description', 'warrantyDuration', 'warrantyId', 'stockTypeId', 'conditionId', 'quantity', 'seoDescription', 'seoKeywords'];

      $data['caseCooler'] = CaseCooler::find($id, $columns);
      $data['caseCoolerExists'] = !is_null($data['caseCooler']);

      $numOfProductsToView = 12;
      $pricePart = 0.2;

      if ($data['caseCoolerExists'])
      {
        $generalData['seoFields'] -> description = $data['caseCooler'] -> seoDescription;
        $generalData['seoFields'] -> keywords = $data['caseCooler'] -> seoKeywords;
        $generalData['seoFields'] -> title = $data['caseCooler'] -> title;

        $stockData = \DB::table('stock_types') -> where('id', '=', $data['caseCooler'] -> stockTypeId) -> get() -> first();

        $data['images'] = \DB::table('case_coolers_images') -> where('caseCoolerId', '=', $data['caseCooler'] -> id) -> get();
        $data['imagesExist'] = !$data['images'] -> isEmpty();

        $data['stockTitle'] = $stockData -> stockTitle;
        $data['stockStatusColor'] = $stockData -> statusColor;
        $data['enableAddToCartButton'] = $stockData -> enableAddToCartButton;

        $data['conditionTitle'] = \DB::table('conditions') -> where('id', '=', $data['caseCooler'] -> conditionId) -> get() -> first() -> conditionTitle;
        $data['warrantyTitle'] = \DB::table('warranties') -> where('id', '=', $data['caseCooler'] -> warrantyId) -> get() -> first() -> durationUnit;

        $data['caseCooler'] -> newPrice = $data['caseCooler'] -> price - $data['caseCooler'] -> discount;
        $data['caseCooler'] -> categoryId = BaseModel::getTableAliasByModelName(CaseCooler::class);

        $percent = $data['caseCooler'] -> newPrice * $pricePart;
        $leftRange = (int) ($data['caseCooler'] -> newPrice - $percent);
        $rightRange = (int) ($data['caseCooler'] -> newPrice + $percent);
        $fields = ['case_coolers.id', 'title', 'mainImage', 'discount', 'price'];

        $data['recommendedCaseCoolers'] = \DB::table('case_coolers') -> select($fields) -> where('visibility', 1) -> where('price', '<=', $rightRange) -> where('price', '>=', $leftRange) -> where('case_coolers.id', '!=', $data['caseCooler'] -> id) -> take($numOfProductsToView) -> get();
        $data['recommendedCaseCoolersExist'] = !$data['recommendedCaseCoolers'] -> isEmpty();

        if ($data['recommendedCaseCoolersExist'])
        {
          foreach ($data['recommendedCaseCoolers'] as $key => $value)

          $data['recommendedCaseCoolers'][$key] -> newPrice = $value -> price - $value -> discount;
        }

        BaseModel::collectStatisticalData(CaseCooler::class);

        return View::make('contents.site.caseCoolers.view', ['contentData' => $data,
                                                             'generalData' => $generalData]);
      }

      else abort(404);
    }
}
