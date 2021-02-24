<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;
use \App\Helpers\Paginator;

use \App\Models\Site\BaseModel;
use \App\Models\Site\Monitor;

class MonitorController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $data['productsExist'] = false;

      $numOfProductsToView = 15;
      $supportedOrders = [1, 2, 3, 4, 5, 6];

      $priceRange = BaseModel::getPriceRange(Monitor::class);
      $diagonalRange = \DB::table('monitors') -> selectRaw('MAX(`diagonal`) AS `maxDiagonal`,MIN(`diagonal`) AS `minDiagonal`') -> first();

      $parameters = $request -> all(); // user input

      $validator = \Validator::make($parameters, ['active-page' => 'required|integer',
                                                  'price-from' => 'required|integer',
                                                  'price-to' => 'required|integer',
                                                  'order' => 'required|integer',
                                                  'numOfProductsToShow' => 'required|integer',
                                                  'stock-type' => 'required|string',
                                                  'condition' => 'required|string',
                                                  'monitor-manufacturer' => 'required|string',
                                                  'diagonal-from' => 'required|string',
                                                  'diagonal-to' => 'required|string',
                                                  'refresh-rate' => 'required|string']);

      if (!$validator -> fails() && !is_null($priceRange) && !is_null($diagonalRange))
      {
        $numOfProductsToView = abs((int) $parameters['numOfProductsToShow']);
        $productsOrder = abs((int) $parameters['order']);

        if ($numOfProductsToView && $numOfProductsToView % 3 == 0 && $numOfProductsToView <= 30)
        {
          $priceFrom = abs((int) $parameters['price-from']);
          $priceTo = abs((int) $parameters['price-to']);

          $diagonalFrom = abs((int) $parameters['diagonal-from']);
          $diagonalTo = abs((int) $parameters['diagonal-to']);

          $priceFromIsInRange = $priceFrom >= $priceRange -> monitorMinPrice && $priceFrom <= $priceRange -> monitorMaxPrice;
          $priceToIsInRange = $priceTo >= $priceRange -> monitorMinPrice && $priceTo <= $priceRange -> monitorMaxPrice;

          $diagonalFromIsInRange = $diagonalFrom >= $diagonalRange -> minDiagonal && $diagonalFrom <= $diagonalRange -> maxDiagonal;
          $diagonalToIsInRange = $diagonalTo >= $diagonalRange -> minDiagonal && $diagonalTo <= $diagonalRange -> maxDiagonal;

          if ($priceFromIsInRange && $priceToIsInRange && $diagonalFromIsInRange && $diagonalToIsInRange)
          {
            $conditions = \DB::table('conditions') -> get();
            $stockTypes = \DB::table('stock_types') -> get();
            $monitorManufacturers = \DB::table('monitors_manufacturers') -> get();
            $refreshRates = \DB::table('monitors') -> select(['refreshRate']) -> distinct() -> get();

            $numOfMonitors = \DB::table('monitors') -> where('visibility', 1) -> count();

            if ($numOfMonitors != 0)
            {
              $monitorManufacturersParts = array_map('intval', explode(':', $parameters['monitor-manufacturer']));
              $conditionsParts = array_map('intval', explode(':', $parameters['condition']));
              $stockTypesParts = array_map('intval', explode(':', $parameters['stock-type']));
              $refreshRatesParts = array_map('intval', explode(':', $parameters['refresh-rate']));

              $columns = ['monitors.id', 'title', 'mainImage', 'discount', 'price', 'manufacturerTitle', 'diagonal', 'refreshRate'];
              $monitorManufacturersNumbers = $conditionNumbers = $stockTypesNumbers = $refreshRatesNumbers = [];

              $query = \DB::table('monitors') -> select($columns) -> join('monitors_manufacturers', 'monitors_manufacturers.id', '=', 'monitors.monitorManufacturerId') -> where('visibility', 1);

              foreach ($conditions as $value) $conditionNumbers[] = $value -> id;
              foreach ($stockTypes as $value) $stockTypesNumbers[] = $value -> id;
              foreach ($monitorManufacturers as $value) $monitorManufacturersNumbers[] = $value -> id;
              foreach ($refreshRates as $value) $refreshRatesNumbers[] = $value -> refreshRate;

              if (array_intersect($conditionsParts, $conditionNumbers) == $conditionsParts) $query = $query -> whereIn('conditionId', $conditionsParts);
              if (array_intersect($stockTypesParts, $stockTypesNumbers) == $stockTypesParts) $query = $query -> whereIn('stockTypeId', $stockTypesParts);
              if (array_intersect($monitorManufacturersParts, $monitorManufacturersNumbers) == $monitorManufacturersParts) $query = $query -> whereIn('monitorManufacturerId', $monitorManufacturersParts);
              if (array_intersect($refreshRatesParts, $refreshRatesNumbers) == $refreshRatesParts) $query = $query -> whereIn('refreshRate', $refreshRatesParts);

              $query = $query -> where('price', '>=', $priceFrom) -> where('price', '<=', $priceTo) -> where('diagonal', '>=', $diagonalFrom) -> where('diagonal', '<=', $diagonalTo);

              if (in_array($productsOrder, $supportedOrders))
              {
                $orderNumber = !($productsOrder % 2);
                $orderColumn = 'price';

                if ($productsOrder == 3 || $productsOrder == 4) $orderColumn = 'diagonal';

                else if ($productsOrder == 5 || $productsOrder == 6) $orderColumn = 'timestamp';

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

      return View::make('contents.site.monitors.getMonitors', ['data' => $data]);
    }

    public function index()
    {
      $generalData = BaseModel::getGeneralData();
      $numOfProductsToView = 9;

      $data['configuration']['productPriceRange'] = BaseModel::getPriceRange(Monitor::class);
      $data['configuration']['productPriceRangeExists'] = !is_null($data['configuration']['productPriceRange']);
      $data['monitorsExist'] = false;

      if ($data['configuration']['productPriceRangeExists'])
      {
        $productMinPrice = $data['configuration']['productPriceRange'] -> monitorMinPrice;
        $productMaxPrice = $data['configuration']['productPriceRange'] -> monitorMaxPrice;

        $columns = ['monitors.id', 'title', 'mainImage', 'discount', 'price', 'manufacturerTitle', 'diagonal', 'refreshRate'];
        $query = \DB::table('monitors') -> select($columns)
                                        -> join('monitors_manufacturers', 'monitors_manufacturers.id', '=', 'monitors.monitorManufacturerId')
                                        -> where('visibility', '1')
                                        -> where('price', '>=', $productMinPrice)
                                        -> where('price', '<=', $productMaxPrice);

        $totalNumberOfProducts = $query -> count();
        $data['monitorsExist'] = $totalNumberOfProducts != 0;

        if ($data['monitorsExist'])
        {
          $data['configuration']['monitorsManufacturers'] = \DB::table('monitors_manufacturers') -> get();
          $data['monitors'] = $query -> take($numOfProductsToView) -> get();

          $range = \DB::table('monitors') -> select(\DB::raw('MIN(`diagonal`) AS `minDiagonal`, MAX(`diagonal`) AS `maxDiagonal`'))
                                          -> where('visibility', 1)
                                          -> where('price', '>=', $productMinPrice)
                                          -> where('price', '<=', $productMaxPrice)
                                          -> get()
                                          -> first();

          $data['configuration']['refreshRates'] = \DB::table('monitors') -> select(['refreshRate']) -> distinct() -> get();

          $data['configuration']['minDiagonal'] = $range -> minDiagonal;
          $data['configuration']['maxDiagonal'] = $range -> maxDiagonal;

          $data['configuration']['conditions'] = \DB::table('conditions') -> get();
          $data['configuration']['stockTypes'] = \DB::table('stock_types') -> get();

          foreach ($data['configuration']['refreshRates'] as $key => $value)

          $data['configuration']['refreshRates'][$key] -> numOfProducts = \DB::table('monitors') -> where('refreshRate', $value -> refreshRate)
                                                                                                 -> where('visibility', 1)
                                                                                                 -> where('price', '>=', $productMinPrice)
                                                                                                 -> where('price', '<=', $productMaxPrice)
                                                                                                 -> count();

          foreach ($data['monitors'] as $key => $value)

          $data['monitors'][$key] -> newPrice = $value -> price - $value -> discount;

          foreach ($data['configuration']['conditions'] as $key => $value)

          $data['configuration']['conditions'][$key] -> numOfProducts = \DB::table('monitors') -> where('conditionId', $value -> id)
                                                                                               -> where('visibility', 1)
                                                                                               -> where('price', '>=', $productMinPrice)
                                                                                               -> where('price', '<=', $productMaxPrice)
                                                                                               -> count();

          foreach ($data['configuration']['stockTypes'] as $key => $value)

          $data['configuration']['stockTypes'][$key] -> numOfProducts = \DB::table('monitors') -> where('stockTypeId', $value -> id)
                                                                                               -> where('visibility', 1)
                                                                                               -> where('price', '>=', $productMinPrice)
                                                                                               -> where('price', '<=', $productMaxPrice)
                                                                                               -> count();

          foreach ($data['configuration']['monitorsManufacturers'] as $key => $value)

          $data['configuration']['monitorsManufacturers'][$key] -> numOfProducts = \DB::table('monitors') -> where('monitorManufacturerId', $value -> id)
                                                                                                          -> where('visibility', 1)
                                                                                                          -> where('price', '>=', $productMinPrice)
                                                                                                          -> where('price', '<=', $productMaxPrice)
                                                                                                          -> count();

          $totalNumOfProducts = $query -> count();
          $paginator = \Paginator::build($totalNumOfProducts, 3, $numOfProductsToView, 1, 2, 0);

          $data['pages'] = $paginator -> pages;
          $data['maxPage'] = $paginator -> maxPage;
          $data['monitors'] = $data['monitors'] -> chunk(3);
        }
      }

      BaseModel::collectStatisticalData(Monitor::class);

      return View::make('contents.site.monitors.index', ['contentData' => $data,
                                                         'generalData' => $generalData]);
    }

    public function view($id)
    {
      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $numOfProductsToView = 12;
      $pricePart = 0.2;

      $columns = ['monitors.id', 'code', 'title', 'mainImage', 'discount', 'price', 'description', 'warrantyDuration', 'warrantyId', 'stockTypeId', 'conditionId', 'quantity', 'seoDescription', 'seoKeywords'];
      $fields = ['monitors.id', 'title', 'mainImage', 'discount', 'price', 'manufacturerTitle', 'diagonal', 'refreshRate'];

      $data['monitor'] = \DB::table('monitors') -> select($columns) -> where('id', $id) -> where('visibility', 1) -> get() -> first();
      $data['monitorExists'] = !is_null($data['monitor']);

      if ($data['monitorExists'])
      {
        $generalData['seoFields'] -> description = $data['monitor'] -> seoDescription;
        $generalData['seoFields'] -> keywords = $data['monitor'] -> seoKeywords;
        $generalData['seoFields'] -> title = $data['monitor'] -> title;

        $stockData = \DB::table('stock_types') -> select() -> where('id', '=', $data['monitor'] -> stockTypeId) -> get() -> first();

        $data['images'] = \DB::table('monitors_images') -> where('monitorId', '=', $data['monitor'] -> id) -> get();
        $data['imagesExist'] = !$data['images'] -> isEmpty();

        $data['stockTitle'] = $stockData -> stockTitle;
        $data['stockStatusColor'] = $stockData -> statusColor;
        $data['enableAddToCartButton'] = $stockData -> enableAddToCartButton;

        $data['conditionTitle'] = \DB::table('conditions') -> where('id', '=', $data['monitor'] -> conditionId) -> get() -> first() -> conditionTitle;
        $data['warrantyTitle'] = \DB::table('warranties') -> where('id', '=', $data['monitor'] -> warrantyId) -> get() -> first() -> durationUnit;

        $data['monitor'] -> newPrice = $data['monitor'] -> price - $data['monitor'] -> discount;
        $data['monitor'] -> categoryId = BaseModel::getTableAliasByModelName(Monitor::class);

        $percent = $data['monitor'] -> newPrice * $pricePart;
        $leftRange = (int) ($data['monitor'] -> newPrice - $percent);
        $rightRange = (int) ($data['monitor'] -> newPrice + $percent);

        $data['recommendedMonitors'] = \DB::table('monitors') -> select($fields)
                                                              -> join('monitors_manufacturers', 'monitors_manufacturers.id', '=', 'monitors.monitorManufacturerId')
                                                              -> where('visibility', 1)
                                                              -> where('price', '<=', $rightRange)
                                                              -> where('price', '>=', $leftRange)
                                                              -> where('monitors.id', '!=', $data['monitor'] -> id)
                                                              -> take($numOfProductsToView)
                                                              -> get();

        $data['recommendedMonitorsExist'] = !$data['recommendedMonitors'] -> isEmpty();

        if ($data['recommendedMonitorsExist'])
        {
          foreach ($data['recommendedMonitors'] as $key => $value)

          $data['recommendedMonitors'][$key] -> newPrice = $value -> price - $value -> discount;
        }

        BaseModel::collectStatisticalData(Monitor::class);

        return View::make('contents.site.monitors.view', ['contentData' => $data,
                                                          'generalData' => $generalData]);
      }

      else abort(404);
    }
}
