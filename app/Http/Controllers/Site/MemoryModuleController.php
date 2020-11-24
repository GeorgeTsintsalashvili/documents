<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;
use \App\Helpers\Paginator;

use \App\Models\Site\BaseModel;
use \App\Models\Site\MemoryModule;

class MemoryModuleController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $data['productsExist'] = false;

      $numOfProductsToView = 12;
      $supportedOrders = [1, 2, 3, 4, 5, 6, 7, 8];
      $priceRange = BaseModel::getPriceRange(MemoryModule::class);

      $parameters = $request -> all(); // user input

      $validator = \Validator::make($parameters, ['active-page' => 'required|integer',
                                                  'price-from' => 'required|integer',
                                                  'price-to' => 'required|integer',
                                                  'order' => 'required|integer',
                                                  'numOfProductsToShow' => 'required|integer',
                                                  'stock-type' => 'required|string',
                                                  'condition' => 'required|string',
                                                  'type-id' => 'required|string',
                                                  'destination' => 'required|string',
                                                  'frequency' => 'required|string',
                                                  'capacity' => 'required|string']);

      if(!$validator -> fails() && !is_null($priceRange))
      {
        $numOfProductsToView = abs((int) $parameters['numOfProductsToShow']);
        $productsOrder = abs((int) $parameters['order']);

        if($numOfProductsToView && $numOfProductsToView % 3 == 0 && $numOfProductsToView <= 30)
        {
          $priceFrom = abs((int) $parameters['price-from']);
          $priceTo = abs((int) $parameters['price-to']);

          $priceFromIsInRange = $priceFrom >= $priceRange -> memoryModuleMinPrice && $priceFrom <= $priceRange -> memoryModuleMaxPrice;
          $priceToIsInRange = $priceTo >= $priceRange -> memoryModuleMinPrice && $priceTo <= $priceRange -> memoryModuleMaxPrice;

          if($priceFromIsInRange && $priceToIsInRange)
          {
            $frequencies = MemoryModule::where('visibility', 1) -> distinct('frequency') -> get();
            $memories = MemoryModule::where('visibility', 1) -> distinct('capacity') -> get();
            $conditions = \DB::table('conditions') -> get();
            $stockTypes = \DB::table('stock_types') -> get();
            $types = \DB::table('memory_modules_types') -> get();

            if($memories -> count() != 0)
            {
              $memoriesParts = explode(':', $parameters['capacity']);
              $frequenciesParts = array_map('intval', explode(':', $parameters['frequency']));
              $destinationsParts = array_map('intval', explode(':', $parameters['destination']));
              $typesParts = array_map('intval', explode(':', $parameters['type-id']));
              $conditionsParts = array_map('intval', explode(':', $parameters['condition']));
              $stockTypesParts = array_map('intval', explode(':', $parameters['stock-type']));

              $columns = ['memory_modules.id', 'title', 'mainImage', 'discount', 'price', 'capacity', 'frequency', 'isCouple', 'typeTitle'];
              $memoriesNumbers = $frequenciesNumbers = $typesNumbers = $conditionNumbers = $stockTypesNumbers = [];
              $destinationsNumbers = [1, 2];

              $query = \DB::table('memory_modules') -> select($columns) -> join('memory_modules_types', 'memory_modules_types.id', '=', 'memory_modules.memoryModuleTypeId') -> where('visibility', 1);

              foreach($conditions as $value) $conditionNumbers[] = $value -> id;
              foreach($stockTypes as $value) $stockTypesNumbers[] = $value -> id;
              foreach($memories as $value) $memoriesNumbers[] = $value -> capacity;
              foreach($frequencies as $value) $frequenciesNumbers[] = $value -> frequency;
              foreach($types as $value) $typesNumbers[] = $value -> id;

              if(array_intersect($conditionsParts, $conditionNumbers) == $conditionsParts) $query = $query -> whereIn('conditionId', $conditionsParts);
              if(array_intersect($stockTypesParts, $stockTypesNumbers) == $stockTypesParts) $query = $query -> whereIn('stockTypeId', $stockTypesParts);
              if(array_intersect($frequenciesParts, $frequenciesNumbers) == $frequenciesParts) $query = $query -> whereIn('frequency', $frequenciesParts);
              if(array_intersect($typesParts, $typesNumbers) == $typesParts) $query = $query -> whereIn('memoryModuleTypeId', $typesParts);
              if(array_intersect($destinationsParts, $destinationsNumbers) == $destinationsParts) $query = $query -> whereIn('destination', $destinationsParts);

              $singlesNumber = MemoryModule::where('visibility', 1) -> where('isCouple', '=', 0) -> distinct('capacity') -> count();
              $doublesNumber = MemoryModule::where('visibility', 1) -> where('isCouple', '=', 1) -> distinct('capacity') -> count();

              $allPossibleOptions = $singlesNumber + $doublesNumber;
              $inputOptionsNum = count($memoriesParts);

              if($inputOptionsNum != 0 && $inputOptionsNum <= $allPossibleOptions)
              {
                $memoriesParts = array_unique($memoriesParts);

                $query = $query -> where(function($sqlQuery) use ($memoriesParts){

                  foreach($memoriesParts as $value)
                  {
                    $memoryData = explode('-', $value);

                    if(count($memoryData) == 2)
                    {
                      $capacity = abs((int) $memoryData[1]);
                      $isCouple = $memoryData[0];

                      $sqlQuery -> orWhere(function($nestedSqlQuery) use ($capacity, $isCouple){

                          $nestedSqlQuery -> where('capacity', $capacity) -> where('isCouple', $isCouple);
                      });
                    }
                  }

                });
              }

              $query = $query -> where('price', '>=', $priceFrom) -> where('price', '<=', $priceTo);

              if(in_array($productsOrder, $supportedOrders))
              {
                $orderNumber = !($productsOrder % 2);
                $orderColumn = 'price';

                if($productsOrder == 3 || $productsOrder == 4) $orderColumn = 'capacity';

                else if($productsOrder == 5 || $productsOrder == 6) $orderColumn = 'frequency';

                else if($productsOrder == 7 || $productsOrder == 8) $orderColumn = 'timestamp';

                $query = $query -> orderBy($orderColumn, $orderNumber == 0 ? 'desc' : 'asc');
              }

              $currentPage = abs((int) $parameters['active-page']);
              $totalNumOfProducts = $query -> count();

              if($currentPage != 0 && $totalNumOfProducts != 0)
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

      return View::make('contents.site.memoryModules.getMemoryModules', ['data' => $data]);
    }

    public function index()
    {
      $generalData = BaseModel::getGeneralData();
      $numOfProductsToView = 9;

      $data['configuration']['productPriceRange'] = BaseModel::getPriceRange(MemoryModule::class);
      $data['configuration']['productPriceRangeExists'] = !is_null($data['configuration']['productPriceRange']);
      $data['memoryModulesExist'] = false;

      if($data['configuration']['productPriceRangeExists'])
      {
        $productMinPrice = $data['configuration']['productPriceRange'] -> memoryModuleMinPrice;
        $productMaxPrice = $data['configuration']['productPriceRange'] -> memoryModuleMaxPrice;

        $columns = ['memory_modules.id', 'title', 'mainImage', 'discount', 'price', 'typeTitle', 'frequency', 'capacity', 'isCouple'];
        $query = \DB::table('memory_modules') -> select($columns)
                                              -> join('memory_modules_types', 'memory_modules_types.id', '=', 'memory_modules.memoryModuleTypeId')
                                              -> where('visibility', '1')
                                              -> where('price', '>=', $productMinPrice)
                                              -> where('price', '<=', $productMaxPrice);

        $totalNumberOfProducts = $query -> count();

        $data['memoryModulesExist'] = $totalNumberOfProducts != 0;

        if($totalNumberOfProducts != 0)
        {
          $data['memoryModules'] = $query -> take($numOfProductsToView) -> get();

          $data['configuration']['numberOfDesktopMemoryModules'] = \DB::table('memory_modules') -> where('destination', 1) -> where('visibility', 1) -> count();
          $data['configuration']['numberOfLaptopMemoryModules'] = \DB::table('memory_modules') -> where('destination', 2) -> where('visibility', 1) -> count();

          $data['configuration']['conditions'] = \DB::table('conditions') -> get();
          $data['configuration']['stockTypes'] = \DB::table('stock_types') -> get();
          $data['configuration']['frequencies'] = \DB::table('memory_modules') -> select(\DB::raw('DISTINCT(`frequency`) as `frequency`'))
                                                                               -> where('visibility', 1)
                                                                               -> where('price', '>=', $productMinPrice)
                                                                               -> where('price', '<=', $productMaxPrice)
                                                                               -> orderBy('frequency', 'asc')
                                                                               -> get();

          $data['configuration']['memoryModuleTypes'] = \DB::table('memory_modules_types') -> get();
          $data['configuration']['capacities'] = [];

          $distinctSingleMemoryModules = \DB::table('memory_modules') -> select(\DB::raw('DISTINCT(`capacity`) as `capacity`, `isCouple`'))
                                                                      -> where('visibility', 1)
                                                                      -> where('isCouple', '=', 0)
                                                                      -> where('price', '>=', $productMinPrice)
                                                                      -> where('price', '<=', $productMaxPrice)
                                                                      -> orderBy('capacity', 'asc')
                                                                      -> get();

          $distinctDoubleMemoryModules = \DB::table('memory_modules') -> select(\DB::raw('DISTINCT(`capacity`) as `capacity`, `isCouple`'))
                                                                      -> where('visibility', 1)
                                                                      -> where('isCouple', '=', 1)
                                                                      -> where('price', '>=', $productMinPrice)
                                                                      -> where('price', '<=', $productMaxPrice)
                                                                      -> orderBy('capacity', 'asc')
                                                                      -> get();

          foreach($distinctSingleMemoryModules as $value) $data['configuration']['capacities'][] = $value;

          foreach($distinctDoubleMemoryModules as $value) $data['configuration']['capacities'][] = $value;

          foreach($data['configuration']['memoryModuleTypes'] as $key => $value)

          $data['configuration']['memoryModuleTypes'][$key] -> numOfProducts = \DB::table('memory_modules') -> where('memoryModuleTypeId', $value -> id)
                                                                                                            -> where('visibility', 1)
                                                                                                            -> where('price', '>=', $productMinPrice)
                                                                                                            -> where('price', '<=', $productMaxPrice)
                                                                                                            -> count();

          foreach($data['configuration']['frequencies'] as $key => $value)

          $data['configuration']['frequencies'][$key] -> numOfProducts = \DB::table('memory_modules') -> where('frequency', $value -> frequency)
                                                                                                      -> where('visibility', 1)
                                                                                                      -> where('price', '>=', $productMinPrice)
                                                                                                      -> where('price', '<=', $productMaxPrice)
                                                                                                      -> count();

          foreach($data['configuration']['capacities'] as $key => $value)

          $data['configuration']['capacities'][$key] -> numOfProducts = \DB::table('memory_modules') -> where('capacity', $value -> capacity)
                                                                                                     -> where('visibility', 1)
                                                                                                     -> where('price', '>=', $productMinPrice)
                                                                                                     -> where('price', '<=', $productMaxPrice)
                                                                                                     -> where('isCouple', '=', $value -> isCouple)
                                                                                                     -> count();

          foreach($data['configuration']['conditions'] as $key => $value)

          $data['configuration']['conditions'][$key] -> numOfProducts = \DB::table('memory_modules') -> where('conditionId', $value -> id)
                                                                                                     -> where('visibility', 1)
                                                                                                     -> where('price', '>=', $productMinPrice)
                                                                                                     -> where('price', '<=', $productMaxPrice)
                                                                                                     -> count();

          foreach($data['configuration']['stockTypes'] as $key => $value)

          $data['configuration']['stockTypes'][$key] -> numOfProducts = \DB::table('memory_modules') -> where('stockTypeId', $value -> id)
                                                                                                     -> where('visibility', 1)
                                                                                                     -> where('price', '>=', $productMinPrice)
                                                                                                     -> where('price', '<=', $productMaxPrice)
                                                                                                     -> count();

          foreach($data['memoryModules'] as $key => $value)
          {
            $data['memoryModules'][$key] -> newPrice = $value -> price - $value -> discount;
            $data['memoryModules'][$key] -> label = $value -> isCouple ? 'წყვილ-წყვილად' : 'ცალ-ცალად';
          }

          $totalNumOfProducts = $query -> count();
          $paginator = \Paginator::build($totalNumOfProducts, 3, $numOfProductsToView, 1, 2, 0);

          $data['pages'] = $paginator -> pages;
          $data['maxPage'] = $paginator -> maxPage;
          $data['memoryModules'] = $data['memoryModules'] -> chunk(3);
        }
      }

      BaseModel::collectStatisticalData(MemoryModule::class);

      return View::make('contents.site.memoryModules.index', ['contentData' => $data,
                                                              'generalData' => $generalData]);
    }

    public function view($id)
    {
      $generalData = BaseModel::getGeneralData();
      $numOfProductsToView = 12;
      $pricePart = 0.2;

      $columns = ['memory_modules.id', 'code', 'title', 'mainImage', 'discount', 'price', 'description', 'warrantyDuration', 'warrantyId', 'stockTypeId', 'conditionId', 'quantity', 'seoDescription', 'seoKeywords'];

      $data['memoryModule'] = \DB::table('memory_modules') -> select($columns) -> where('id', $id) -> where('visibility', 1) -> get() -> first();
      $data['memoryModuleExists'] = !is_null($data['memoryModule']);

      if($data['memoryModuleExists'])
      {
        $generalData['seoFields'] -> description = $data['memoryModule'] -> seoDescription;
        $generalData['seoFields'] -> keywords = $data['memoryModule'] -> seoKeywords;
        $generalData['seoFields'] -> title = $data['memoryModule'] -> title;

        $stockData = \DB::table('stock_types') -> where('id', '=', $data['memoryModule'] -> stockTypeId) -> get() -> first();

        $data['images'] = \DB::table('memory_modules_images') -> where('memoryModuleId', '=', $data['memoryModule'] -> id) -> get();
        $data['imagesExist'] = !$data['images'] -> isEmpty();

        $data['stockTitle'] = $stockData -> stockTitle;
        $data['stockStatusColor'] = $stockData -> statusColor;
        $data['enableAddToCartButton'] = $stockData -> enableAddToCartButton;

        $data['conditionTitle'] = \DB::table('conditions') -> where('id', '=', $data['memoryModule'] -> conditionId) -> get() -> first() -> conditionTitle;
        $data['warrantyTitle'] = \DB::table('warranties') -> where('id', '=', $data['memoryModule'] -> warrantyId) -> get() -> first() -> durationUnit;

        $data['memoryModule'] -> newPrice = $data['memoryModule'] -> price - $data['memoryModule'] -> discount;
        $data['memoryModule'] -> categoryId = BaseModel::getTableAliasByModelName(MemoryModule::class);

        $percent = $data['memoryModule'] -> newPrice * $pricePart;
        $leftRange = (int) ($data['memoryModule'] -> newPrice - $percent);
        $rightRange = (int) ($data['memoryModule'] -> newPrice + $percent);

        $fields = ['memory_modules.id', 'title', 'mainImage', 'discount', 'price', 'capacity', 'frequency', 'typeTitle', 'quantity', 'isCouple'];

        $data['recommendedMemoryModules'] =  \DB::table('memory_modules') -> select($fields)
                                                                          -> join('memory_modules_types', 'memory_modules_types.id', '=', 'memoryModuleTypeId')
                                                                          -> where('visibility', 1)
                                                                          -> where('price', '<=', $rightRange)
                                                                          -> where('price', '>=', $leftRange)
                                                                          -> where('memory_modules.id', '!=', $data['memoryModule'] -> id)
                                                                          -> take($numOfProductsToView)
                                                                          -> get();

        $data['recommendedMemoryModulesExist'] = !$data['recommendedMemoryModules'] -> isEmpty();

        foreach($data['recommendedMemoryModules'] as $key => $value)
        {
          $data['recommendedMemoryModules'][$key] -> newPrice = $value -> price - $value -> discount;
          $data['recommendedMemoryModules'][$key] -> label = $value -> isCouple ? 'წყვილ-წყვილად' : 'ცალ-ცალად';
        }

        BaseModel::collectStatisticalData(MemoryModule::class);

        return View::make('contents.site.memoryModules.view', ['contentData' => $data,
                                                               'generalData' => $generalData]);
      }

      else abort(404);
    }
}
