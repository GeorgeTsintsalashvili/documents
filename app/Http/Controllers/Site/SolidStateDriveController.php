<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;
use \App\Helpers\Paginator;

use \App\Models\Site\BaseModel;
use \App\Models\Site\SolidStateDrive;

class SolidStateDriveController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      $data['productsExist'] = false;

      $numOfProductsToView = 15;
      $supportedOrders = [1, 2, 3, 4, 5, 6];
      $viewSupportedValues = [9, 12, 15, 18, 21, 24, 27, 30];
      $priceRange = BaseModel::getPriceRange(SolidStateDrive::class);

      $parameters = $request -> all(); // user input

      $validator = \Validator::make($parameters, ['active-page' => 'required|integer',
                                                  'price-from' => 'required|integer',
                                                  'price-to' => 'required|integer',
                                                  'order' => 'required|integer',
                                                  'numOfProductsToShow' => 'required|integer',
                                                  'stock-type' => 'required|string',
                                                  'condition' => 'required|string',
                                                  'capacity' => 'required|string',
                                                  'form-factor-id' => 'required|string',
                                                  'technology-id' => 'required|string']);

      if(!$validator -> fails() && !is_null($priceRange))
      {
        $numOfProductsToView = abs((int) $parameters['numOfProductsToShow']);
        $productsOrder = abs((int) $parameters['order']);

        if(in_array($numOfProductsToView, $viewSupportedValues))
        {
          $priceFrom = abs((int) $parameters['price-from']);
          $priceTo = abs((int) $parameters['price-to']);

          $priceFromIsInRange = $priceFrom >= $priceRange -> solidStateDriveMinPrice && $priceFrom <= $priceRange -> solidStateDriveMaxPrice;
          $priceToIsInRange = $priceTo >= $priceRange -> solidStateDriveMinPrice && $priceTo <= $priceRange -> solidStateDriveMaxPrice;

          if($priceFromIsInRange && $priceToIsInRange)
          {
            $conditions = \DB::table('conditions') -> get();
            $stockTypes = \DB::table('stock_types') -> get();
            $capacities = \DB::table('solid_state_drives') -> selectRaw('DISTINCT(`capacity`) AS `capacity`') -> where('visibility', 1) -> get();
            $formFactors = \DB::table('solid_state_drives_form_factors') -> get();
            $technologies = \DB::table('solid_state_drives_technologies') -> get();

            $numOfSolidStateDrives = \DB::table('solid_state_drives') -> where('visibility', 1) -> count();

            if($numOfSolidStateDrives != 0)
            {
              $capacityParts = array_map('intval', explode(':', $parameters['capacity']));
              $formFactorsParts = array_map('intval', explode(':', $parameters['form-factor-id']));
              $conditionsParts = array_map('intval', explode(':', $parameters['condition']));
              $stockTypesParts = array_map('intval', explode(':', $parameters['stock-type']));
              $technologiesParts = array_map('intval', explode(':', $parameters['technology-id']));

              $columns = ['solid_state_drives.id', 'title', 'mainImage', 'discount', 'price', 'capacity', 'formFactorTitle', 'technologyTitle'];
              $capacityNumbers = $formFactorsNumbers = $conditionNumbers = $stockTypesNumbers = $technologiesNumbers = [];

              $query = \DB::table('solid_state_drives') -> select($columns)
                                                        -> join('solid_state_drives_form_factors', 'solid_state_drives_form_factors.id', '=', 'solid_state_drives.formFactorId')
                                                        -> join('solid_state_drives_technologies', 'solid_state_drives_technologies.id', '=', 'solid_state_drives.technologyId')
                                                        -> where('visibility', 1);

              foreach($conditions as $value) $conditionNumbers[] = $value -> id;
              foreach($stockTypes as $value) $stockTypesNumbers[] = $value -> id;
              foreach($capacities as $value) $capacityNumbers[] = $value -> capacity;
              foreach($formFactors as $value) $formFactorsNumbers[] = $value -> id;
              foreach($technologies as $value) $technologiesNumbers[] = $value -> id;

              if(array_intersect($conditionsParts, $conditionNumbers) == $conditionsParts) $query = $query -> whereIn('conditionId', $conditionsParts);
              if(array_intersect($stockTypesParts, $stockTypesNumbers) == $stockTypesParts) $query = $query -> whereIn('stockTypeId', $stockTypesParts);
              if(array_intersect($capacityParts, $capacityNumbers) == $capacityParts) $query = $query -> whereIn('capacity', $capacityParts);
              if(array_intersect($formFactorsParts, $formFactorsNumbers) == $formFactorsParts) $query = $query -> whereIn('formFactorId', $formFactorsParts);
              if(array_intersect($technologiesParts, $technologiesNumbers) == $technologiesParts) $query = $query -> whereIn('technologyId', $technologiesParts);

              $query = $query -> where('price', '>=', $priceFrom) -> where('price', '<=', $priceTo);

              if(in_array($productsOrder, $supportedOrders))
              {
                $orderNumber = !($productsOrder % 2);

                if($productsOrder == 3 || $productsOrder == 4) $orderColumn = 'capacity';

                else if($productsOrder == 5 || $productsOrder == 6) $orderColumn = 'timestamp';

                else $orderColumn = 'price';

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

      return View::make('contents.site.solidStateDrives.getSolidStateDrives', ['data' => $data]);
    }

    public function index()
    {
      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      $numOfProductsToView = 9;
      $adjacent = 3;
      $currentPage = 1;
      $leftBoundary = 2;
      $rightBoundary = 0;
      $chunkSize = 3;

      $data['configuration']['productPriceRange'] = BaseModel::getPriceRange(SolidStateDrive::class);
      $data['configuration']['numOfProductsToShow'] = $numOfProductsToView;

      $data['configuration']['productPriceRangeExists'] = !is_null($data['configuration']['productPriceRange']);
      $data['solidStateDrivesExist'] = false;

      if($data['configuration']['productPriceRangeExists'])
      {
        $productMinPrice = $data['configuration']['productPriceRange'] -> solidStateDriveMinPrice;
        $productMaxPrice = $data['configuration']['productPriceRange'] -> solidStateDriveMaxPrice;

        $columns = ['solid_state_drives.id', 'title', 'mainImage', 'discount', 'price', 'formFactorId', 'capacity', 'formFactorTitle', 'technologyTitle'];

        $query = \DB::table('solid_state_drives') -> select($columns)
                                                  -> join('solid_state_drives_form_factors', 'solid_state_drives_form_factors.id', '=', 'solid_state_drives.formFactorId')
                                                  -> join('solid_state_drives_technologies', 'solid_state_drives_technologies.id', '=', 'solid_state_drives.technologyId')
                                                  -> where('visibility', 1);

        $totalNumOfProducts = $query -> count();

        $data['solidStateDrivesExist'] = $totalNumOfProducts != 0;

        if($data['solidStateDrivesExist'])
        {
          $data['configuration']['conditions'] = \DB::table('conditions') -> get();
          $data['configuration']['stockTypes'] = \DB::table('stock_types') -> get();
          $data['configuration']['technologies'] = \DB::table('solid_state_drives_technologies') -> get();

          $data['configuration']['capacity'] = \DB::table('solid_state_drives') -> select(\DB::raw('DISTINCT(`capacity`) AS `capacity`'))
                                                                                -> where('visibility', 1)
                                                                                -> where('price', '>=', $productMinPrice)
                                                                                -> where('price', '<=', $productMaxPrice)
                                                                                -> orderBy('capacity', 'asc')
                                                                                -> get();

          $data['configuration']['formFactors'] = \DB::table('solid_state_drives_form_factors') -> get();

          foreach($data['configuration']['formFactors'] as $key => $formFactor)
          {
            $data['configuration']['formFactors'][$key] -> numOfProducts = \DB::table('solid_state_drives') -> where('formFactorId', '=', $formFactor -> id)
                                                                                                            -> where('visibility', 1)
                                                                                                            -> where('price', '>=', $productMinPrice)
                                                                                                            -> where('price', '<=', $productMaxPrice)
                                                                                                            -> count();
          }

          foreach($data['configuration']['technologies'] as $key => $technology)
          {
            $data['configuration']['technologies'][$key] -> numOfProducts = \DB::table('solid_state_drives') -> where('technologyId', '=', $technology -> id)
                                                                                                             -> where('visibility', 1)
                                                                                                             -> where('price', '>=', $productMinPrice)
                                                                                                             -> where('price', '<=', $productMaxPrice)
                                                                                                             -> count();
          }

          foreach($data['configuration']['capacity'] as $key => $capacity)
          {
            $data['configuration']['capacity'][$key] -> numOfProducts = \DB::table('solid_state_drives') -> where('capacity', '=', $capacity -> capacity)
                                                                                                         -> where('visibility', 1)
                                                                                                         -> where('price', '>=', $productMinPrice)
                                                                                                         -> where('price', '<=', $productMaxPrice)
                                                                                                         -> count();
          }

          foreach($data['configuration']['conditions'] as $key => $value)
          {
            $data['configuration']['conditions'][$key] -> numOfProducts = \DB::table('solid_state_drives') -> where('conditionId', $value -> id)
                                                                                                           -> where('visibility', 1)
                                                                                                           -> where('price', '>=', $productMinPrice)
                                                                                                           -> where('price', '<=', $productMaxPrice)
                                                                                                           -> count();
          }

          foreach($data['configuration']['stockTypes'] as $key => $value)
          {
            $data['configuration']['stockTypes'][$key] -> numOfProducts = \DB::table('solid_state_drives') -> where('stockTypeId', $value -> id)
                                                                                                           -> where('visibility', 1)
                                                                                                           -> where('price', '>=', $productMinPrice)
                                                                                                           -> where('price', '<=', $productMaxPrice)
                                                                                                           -> count();
          }

          $data['solidStateDrives'] = $query -> take($numOfProductsToView) -> get();

          foreach($data['solidStateDrives'] as $key => $value) $data['solidStateDrives'][$key] -> newPrice = $value -> price - $value -> discount;

          $paginator = \Paginator::build($totalNumOfProducts, 3, $numOfProductsToView, $currentPage, 2, 0);

          $data['pages'] = $paginator -> pages;
          $data['maxPage'] = $paginator -> maxPage;
          $data['currentPage'] = $currentPage;

          $data['solidStateDrives'] = $data['solidStateDrives'] -> chunk($chunkSize);
        }
      }

      BaseModel::collectStatisticalData(SolidStateDrive::class);

      return View::make('contents.site.solidStateDrives.index', ['contentData' => $data,
                                                                 'generalData' => $generalData]);
    }

    public function view($id)
    {
      $generalData = BaseModel::getGeneralData();
      $columns = ['solid_state_drives.id', 'code', 'title', 'mainImage', 'discount', 'price', 'description', 'warrantyDuration', 'warrantyId', 'stockTypeId', 'conditionId', 'quantity', 'seoDescription', 'seoKeywords'];

      $data['solidStateDrive'] = \DB::table('solid_state_drives') -> select($columns) -> where('id', $id) -> where('visibility', 1) -> get() -> first();
      $data['solidStateDriveExists'] = !is_null($data['solidStateDrive']);

      $numOfProductsToView = 12;
      $pricePart = 0.2;

      if($data['solidStateDriveExists'])
      {
        $generalData['seoFields'] -> description = $data['solidStateDrive'] -> seoDescription;
        $generalData['seoFields'] -> keywords = $data['solidStateDrive'] -> seoKeywords;
        $generalData['seoFields'] -> title = $data['solidStateDrive'] -> title;

        $stockData = \DB::table('stock_types') -> where('id', '=', $data['solidStateDrive'] -> stockTypeId) -> get() -> first();

        $data['images'] = \DB::table('solid_state_drives_images') -> where('solidStateDriveId', '=', $data['solidStateDrive'] -> id) -> get();
        $data['imagesExist'] = !$data['images'] -> isEmpty();

        $data['stockTitle'] = $stockData -> stockTitle;
        $data['stockStatusColor'] = $stockData -> statusColor;
        $data['enableAddToCartButton'] = $stockData -> enableAddToCartButton;

        $data['conditionTitle'] = \DB::table('conditions') -> where('id', '=', $data['solidStateDrive'] -> conditionId) -> get() -> first() -> conditionTitle;
        $data['warrantyTitle'] = \DB::table('warranties') -> where('id', '=', $data['solidStateDrive'] -> warrantyId) -> get() -> first() -> durationUnit;

        $data['solidStateDrive'] -> newPrice = $data['solidStateDrive'] -> price - $data['solidStateDrive'] -> discount;
        $data['solidStateDrive'] -> categoryId = BaseModel::getTableAliasByModelName(SolidStateDrive::class);

        $percent = $data['solidStateDrive'] -> newPrice * $pricePart;
        $leftRange = (int) ($data['solidStateDrive'] -> newPrice - $percent);
        $rightRange = (int) ($data['solidStateDrive'] -> newPrice + $percent);

        $fields = ['solid_state_drives.id', 'title', 'mainImage', 'discount', 'price', 'capacity', 'formFactorTitle', 'technologyTitle'];

        $data['recommendedSolidStateDrives'] = \DB::table('solid_state_drives') -> select($fields)
                                                                                -> join('solid_state_drives_form_factors', 'solid_state_drives_form_factors.id', '=', 'solid_state_drives.formFactorId')
                                                                                -> join('solid_state_drives_technologies', 'solid_state_drives_technologies.id', '=', 'solid_state_drives.technologyId')
                                                                                -> where('visibility', 1)
                                                                                -> where('price', '<=', $rightRange)
                                                                                -> where('price', '>=', $leftRange)
                                                                                -> where('solid_state_drives.id', '!=', $data['solidStateDrive'] -> id)
                                                                                -> take($numOfProductsToView)
                                                                                -> get();

        $data['recommendedSolidStateDrivesExist'] = !$data['recommendedSolidStateDrives'] -> isEmpty();

        if($data['recommendedSolidStateDrivesExist'])
        {
          foreach($data['recommendedSolidStateDrives'] as $key => $value)

          $data['recommendedSolidStateDrives'][$key] -> newPrice = $value -> price - $value -> discount;
        }

        BaseModel::collectStatisticalData(SolidStateDrive::class);

        return View::make('contents.site.solidStateDrives.view', ['contentData' => $data,
                                                                  'generalData' => $generalData]);
      }

      else abort(404);
    }
}
