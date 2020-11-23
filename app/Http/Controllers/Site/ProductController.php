<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;
use \App\Helpers\Paginator;

use \App\Models\Site\BaseModel;
use \App\Models\Site\Product;

class ProductController extends Controllers\Controller
{
    public function getList(Request $request)
    {
      // initialize options

      $numOfProductsToView = 9;
      $data['productsExist'] = false;

      $supportedOrders = [0, 1, 2, 3, 4];
      $viewSupportedValues = [9, 12, 15, 18, 21, 24, 27, 30];

      $searchTextMaximumLength = 100;
      $categoryIdMaxLength = 15;

      // validate user input

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['active-page' => 'required|integer',
                                                  'price-from' => 'required|integer',
                                                  'price-to' => 'required|integer',
                                                  'order' => 'required|integer',
                                                  'numOfProductsToShow' => 'required|integer',
                                                  'stock-type' => 'required|string',
                                                  'condition' => 'required|string',
                                                  'category-id' => 'required|string|min:5',
                                                  'query' => 'required|string|min:1|max:100']);

      $productPriceRanges = \DB::table('price_configurations') -> first();

      if(!$validator -> fails() && !is_null($productPriceRanges))
      {
        $priceValues = [];

        foreach($productPriceRanges as $key => $value) $priceValues[] = $value;

        $data['productMinPrice'] = min($priceValues);
        $data['productMaxPrice'] = max($priceValues);

        $tablesData = \DB::table('tables') -> get();

        $searchQuery = str_replace(['+', '-', '<', '>', '@', '(', ')', '~', '*', '`', '\'', '"'], '', $parameters['query']);
        $searchQuery = trim($searchQuery);
        $categoryId = trim($parameters['category-id']);

        $searchQueryLengthIsValid = strlen($searchQuery) != 0;
        $categoryIdLengthIsValid = strlen($categoryId) != 0;

        if($searchQueryLengthIsValid && $categoryIdLengthIsValid)
        {
          $numberOfTables = $tablesData -> count();

          if($numberOfTables != 0)
          {
            $maximumLengthOfCategoryIdParam = ($categoryIdMaxLength * $numberOfTables) + $numberOfTables - 1;

            $categoryId = substr($parameters['category-id'], 0, $maximumLengthOfCategoryIdParam);
            $categoryIdParts = explode(':', $categoryId);
            $tablesIdentifiers = [];

            $tablesData -> each(function($table) use (&$tablesIdentifiers){

                $tablesIdentifiers[] = $table -> alias;
            });

            if(array_intersect($categoryIdParts, $tablesIdentifiers) == $categoryIdParts)
            {
              $priceFrom = abs((int) $parameters['price-from']);
              $priceTo = abs((int) $parameters['price-to']);
              $currentPage = abs((int) $parameters['active-page']);

              $minPriceIsInAllowedRange = $priceFrom >= $data['productMinPrice'] && $priceFrom <= $data['productMaxPrice'];
              $maxPriceIsInAllowedRange = $priceTo <= $data['productMaxPrice'] && $priceTo >= $data['productMinPrice'];

              if($minPriceIsInAllowedRange && $maxPriceIsInAllowedRange && $currentPage != 0)
              {
                $productsOrder = abs((int) $parameters['order']);
                $numOfProductsToView = abs((int) $parameters['numOfProductsToShow']);

                if(in_array($numOfProductsToView, $viewSupportedValues))
                {
                  $numOfProductsToView = $numOfProductsToView;

                  $conditions = \DB::table('conditions') -> get();
                  $conditionExists = $conditions -> count() != 0;

                  $stockTypes = \DB::table('stock_types') -> get();
                  $stockTypeExists = $stockTypes -> count() != 0;

                  if($conditionExists && $stockTypeExists)
                  {
                    $conditionsParts = explode(':', $parameters['condition']);
                    $stockTypesParts = explode(':', $parameters['stock-type']);

                    $searchQuery = preg_replace('/\s{2,}/', ' ', $searchQuery);
                    $searchQueryParts = explode(' ', $searchQuery);
                    $validCharactersForSearch = [];

                    foreach($searchQueryParts as $searchQueryPart)
                    {
                      $searchQueryPart = trim($searchQueryPart);

                      if(strlen($searchQueryPart) != 0)

                      $validCharactersForSearch[] = "{$searchQueryPart}*";
                    }

                    $filteredSearchQuery = implode(' ', $validCharactersForSearch);
                    $searchCommand = "MATCH(`title`,`description`) AGAINST(? IN BOOLEAN MODE)";

                    $sqlQuery = null;
                    $totalNumOfProducts = 0;
                    $stockTypeIdentifiers = $conditionIdentifiers = [];

                    foreach($stockTypes as $value) $stockTypeIdentifiers[] = $value -> id;

                    foreach($conditions as $value) $conditionIdentifiers[] = $value -> id;

                    foreach($categoryIdParts as $categoryIdentifier)
                    {
                      $categoryTableData = $tablesData -> where('alias', $categoryIdentifier) -> first();

                      $tableName = $categoryTableData -> name;
                      $pathPart = \Str::camel($tableName);

                      $columns = "`price`,`discount`,`id`,`title`,`mainImage`,'{$pathPart}' AS `pathPart`,{$searchCommand} AS `relevance`";

                      $tempSqlQuery = \DB::table($tableName) -> selectRaw($columns, [$filteredSearchQuery])
                                                             -> whereRaw($searchCommand, [$filteredSearchQuery])
                                                             -> where('visibility', 1)
                                                             -> where('price', '<=', $priceTo)
                                                             -> where('price', '>=', $priceFrom);

                      if(array_intersect($conditionsParts, $conditionIdentifiers) == $conditionsParts) $tempSqlQuery = $tempSqlQuery -> whereIn('conditionId', $conditionsParts);

                      if(array_intersect($stockTypesParts, $stockTypeIdentifiers) == $stockTypesParts) $tempSqlQuery = $tempSqlQuery -> whereIn('stockTypeId', $stockTypesParts);

                      if(is_null($sqlQuery)) $sqlQuery = $tempSqlQuery;

                      else $sqlQuery -> union($tempSqlQuery);

                      $totalNumOfProducts += $tempSqlQuery -> count();
                    }

                    if(in_array($productsOrder, $supportedOrders))
                    {
                      $orderNumber = !($productsOrder % 2);
                      $orderColumn = 'relevance';

                      if($productsOrder == 1 || $productsOrder == 2) $orderColumn = 'price';

                      else if($productsOrder == 3 || $productsOrder == 4) $orderColumn = 'timestamp';

                      $sqlQuery = $sqlQuery -> orderBy($orderColumn, $orderNumber == 0 ? 'desc' : 'asc');
                    }

                    if($totalNumOfProducts != 0)
                    {
                      $paginator = \Paginator::build($totalNumOfProducts, 3, $numOfProductsToView, $currentPage, 2, 0);

                      $data['pages'] = $paginator -> pages;
                      $data['maxPage'] = $paginator -> maxPage;
                      $data['currentPage'] = $currentPage;

                      $data['products'] = $sqlQuery -> skip(($currentPage - 1) * $numOfProductsToView) -> take($numOfProductsToView) -> get();
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
          }
        }
      }

      return View::make('contents.site.products.getSearchResults', ['data' => $data]);
    }

    public function getLiveSearchResults(Request $request)
    {
      $resultsToView = 10;
      $data['products'] = null;
      $data['productsExist'] = false;

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['query' => 'required|string|min:1|max:100',
                                                  'category-id' => 'required|string|min:5|max:10']);

      if(!$validator -> fails())
      {
        $tablesData = \DB::table('tables') -> get();

        $searchQuery = trim($parameters['query']);
        $categoryId = trim($parameters['category-id']);

        $searchQuery = str_replace(['+', '-', '<', '>', '@', '(', ')', '~', '*', '`', '\'', '"'], '', $searchQuery);
        $searchQuery = trim($searchQuery);

        if(strlen($searchQuery) != 0 && !$tablesData -> isEmpty())
        {
          $tableDataByCategory = \DB::table('tables') -> where('alias', $categoryId) -> first();
          $categoryExists = !is_null($tableDataByCategory);

          $searchQuery = preg_replace('/\s{2,}/', ' ', $searchQuery);
          $searchQueryParts = explode(' ', $searchQuery);
          $validCharactersForSearch = [];

          foreach($searchQueryParts as $searchQueryPart)
          {
            $searchQueryPart = trim($searchQueryPart);

            if(strlen($searchQueryPart) != 0)

            $validCharactersForSearch[] = "{$searchQueryPart}*";
          }

          $filteredSearchQuery = implode(' ', $validCharactersForSearch);
          $searchCommand = "MATCH(`title`,`description`) AGAINST(? IN BOOLEAN MODE)";

          if($categoryExists)
          {
             $tableName = $tableDataByCategory -> name;
             $pathPart = \Str::camel($tableName);

             $columns = "`price`,`discount`,`id`,`title`,`mainImage`,'{$pathPart}' AS `pathPart`,{$searchCommand} AS `relevance`";

             $sqlQuery = \DB::table($tableName) -> selectRaw($columns, [$filteredSearchQuery])
                                                -> whereRaw($searchCommand, [$filteredSearchQuery])
                                                -> where('visibility', 1)
                                                -> orderBy('relevance', 'desc')
                                                -> take($resultsToView);

             if($sqlQuery -> count() != 0)
             {
                $data['productsExist'] = true;

                $data['products'] = $sqlQuery -> get();

                $data['products'] -> map(function($product){

                    $product -> price = $product -> price - $product -> discount;
                });
             }
          }

          else
          {
             $primarySqlQuery = null;

             foreach($tablesData as $table)
             {
                 $tableName = $table -> name;

                 $pathPart = \Str::camel($tableName);

                 $columns = "`price`,`discount`,`id`,`title`,`mainImage`,'{$pathPart}' AS `pathPart`,$searchCommand AS `relevance`";

                 $tempSqlQuery = \DB::table($tableName) -> selectRaw($columns, [$filteredSearchQuery])
                                                        -> whereRaw($searchCommand, [$filteredSearchQuery])
                                                        -> where('visibility', 1);

                 if(is_null($primarySqlQuery)) $primarySqlQuery = $tempSqlQuery;

                 else $primarySqlQuery -> union($tempSqlQuery);
              }

              if(!is_null($primarySqlQuery) && $primarySqlQuery -> count() != 0)
              {
                $data['productsExist'] = true;

                $data['products'] = $primarySqlQuery -> orderBy('relevance', 'desc') -> take($resultsToView) -> get();

                $data['products'] -> map(function($product){

                    $product -> price = $product -> price - $product -> discount;
                });
              }
           }
        }
      }

      return View::make('contents.site.products.liveSearchResults', ['data' => $data]);
    }

    public function search(Request $request)
    {
      $generalData = BaseModel::getGeneralData();

      $data['productsExist'] = false;
      $data['categoryIdentifiers'] = null;
      $data['paramsAreValid'] = false;

      $data['products'] = [];
      $data['categories'] = [];

      $data['active'] = 1;
      $data['category-id'] = 'f1u3ja5i7';

      $numOfProductsToView = 9;
      $searchTextMaximumLength = 100;
      $categoryIdMaximumLength = 15;

      $productPriceRanges = \DB::table('price_configurations') -> select() -> first();
      $priceValues = [];

      foreach($productPriceRanges as $key => $value) if($key !== 'id') $priceValues[] = $value;

      // get maximum and minimum prices

      $data['productMinPrice'] = min($priceValues);
      $data['productMaxPrice'] = max($priceValues);

      // get stock types and conditions

      $data['stockTypes'] = \DB::table('stock_types') -> get();
      $data['conditions'] = \DB::table('conditions') -> get();

      // set counters to zero

      foreach($data['stockTypes'] as $key => $value) $data['stockTypes'][$key] -> quantity = 0;
      foreach($data['conditions'] as $key => $value) $data['conditions'][$key] -> quantity = 0;

      // request data validation

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['query' => 'required|string|min:1|max:100',
                                                  'categoryId' => 'required|string|min:5:max:15']);

      if(!$validator -> fails())
      {
        $parameters['query'] = trim($parameters['query']);
        $parameters['categoryId'] = trim($parameters['categoryId']);

        if(strlen($parameters['query']) != 0 && strlen($parameters['categoryId']) != 0)
        {
          $data['paramsAreValid'] = true;

          $tablesData = \DB::table('tables') -> get();

          $searchQuery = str_replace(['+', '-', '<', '>', '@', '(', ')', '~', '*', '`', '\'', '"'], '', $parameters['query']);
          $searchQuery = trim($searchQuery);
          $searchQuery = substr($searchQuery, 0, $searchTextMaximumLength);
          $categoryId = substr($parameters['categoryId'], 0, $categoryIdMaximumLength);
          $searchQueryLengthIsValid = strlen($searchQuery) != 0;

          $data['search-query'] = htmlentities($searchQuery, ENT_QUOTES, 'UTF-8');
          $data['category-id'] = htmlentities($categoryId, ENT_QUOTES, 'UTF-8');

          if(!$tablesData -> isEmpty() != 0 && $searchQueryLengthIsValid)
          {
            $searchQuery = preg_replace('/\s{2,}/', ' ', $searchQuery);

            $searchQueryParts = explode(' ', $searchQuery);

            $validCharactersForSearch = [];

            foreach($searchQueryParts as $searchQueryPart)
            {
              $searchQueryPart = trim($searchQueryPart);

              if(strlen($searchQueryPart) != 0)

              $validCharactersForSearch[] = "{$searchQueryPart}*";
            }

            $tableDataByCategory = \DB::table('tables') -> where('alias', $categoryId) -> first();
            $categoryExists = !is_null($tableDataByCategory);

            $filteredSearchQuery = implode(' ', $validCharactersForSearch);
            $searchCommand = "MATCH(`title`,`description`) AGAINST(? IN BOOLEAN MODE)";

            if($categoryExists)
            {
              $tableName = $tableDataByCategory -> name;
              $pathPart = \Str::camel($tableName);

              $columns = "`price`,`discount`,`id`,`title`,`mainImage`,'{$pathPart}' AS `pathPart`,{$searchCommand} AS `relevance`";

              $sqlQuery = \DB::table($tableName) -> selectRaw($columns, [$filteredSearchQuery])
                                                 -> whereRaw($searchCommand, [$filteredSearchQuery])
                                                 -> where('visibility', 1)
                                                 -> orderBy('relevance', 'desc')
                                                 -> take($numOfProductsToView);

              $data['products'] = $sqlQuery -> get();

              $totalNumOfProducts = $sqlQuery -> count();
              $paginator = \Paginator::build($totalNumOfProducts, 3, $numOfProductsToView, $data['active'], 2, 0);

              $data['pages'] = $paginator -> pages;
              $data['maxPage'] = $paginator -> maxPage;
              $data['currentPage'] = $data['active'];

              $data['productsExist'] = $totalNumOfProducts != 0;

              if($data['productsExist'])
              {
                $data['categories'][] = ['categoryTitle' => $tableDataByCategory -> title,
                                         'categoryId' => $categoryId,
                                         'quantity' => $totalNumOfProducts];

                $data['categoryIdentifiers'] = $categoryId;

                foreach($data['products'] as $key => $value)
                {
                  $data['products'][$key] -> newPrice = $value -> price - $value -> discount;
                }

                foreach($data['stockTypes'] as $key => $value)
                {
                  $data['stockTypes'][$key] -> quantity = \DB::table($tableName) -> whereRaw($searchCommand, [$filteredSearchQuery])
                                                                                 -> where('visibility', 1)
                                                                                 -> where('stockTypeId', $value -> id)
                                                                                 -> count();
                }

                foreach($data['conditions'] as $key => $value)
                {
                  $data['conditions'][$key] -> quantity = \DB::table($tableName) -> whereRaw($searchCommand, [$filteredSearchQuery])
                                                                                 -> where('visibility', 1)
                                                                                 -> where('conditionId', $value -> id)
                                                                                 -> count();
                }

                $data['products'] = $data['products'] -> chunk(3);
              }
            }

            else
            {
              $sqlQuery = null;
              $totalNumOfProducts = 0;

              foreach($tablesData as $table)
              {
                $tableName = $table -> name;
                $pathPart = \Str::camel($tableName);
                $categoryId = $table -> alias;

                $columns = "`title`,`mainImage`,`price`,`id`,`discount`,'{$pathPart}' AS `pathPart`,{$searchCommand} AS `relevance`";

                $tempSqlQuery = \DB::table($tableName) -> selectRaw($columns, [$filteredSearchQuery])
                                                       -> whereRaw($searchCommand, [$filteredSearchQuery])
                                                       -> where('visibility', 1)
                                                       -> orderBy('relevance', 'desc')
                                                       -> take($numOfProductsToView);

                if(is_null($sqlQuery)) $sqlQuery = $tempSqlQuery;

                else $sqlQuery -> union($tempSqlQuery);

                foreach($data['stockTypes'] as $key => $value)
                {
                  $data['stockTypes'][$key] -> quantity += \DB::table($tableName) -> whereRaw($searchCommand, [$filteredSearchQuery])
                                                                                  -> where('visibility', 1)
                                                                                  -> where('stockTypeId', $value -> id)
                                                                                  -> count();
                }

                foreach($data['conditions'] as $key => $value)
                {
                  $data['conditions'][$key] -> quantity += \DB::table($tableName) -> whereRaw($searchCommand, [$filteredSearchQuery])
                                                                                  -> where('visibility', 1)
                                                                                  -> where('conditionId', $value -> id)
                                                                                  -> count();
                }

                $numberOfRows = $tempSqlQuery -> count();

                if($numberOfRows != 0)
                {
                  $data['categories'][] = ['categoryTitle' => $table -> title, 'categoryId' => $categoryId, 'quantity' => $numberOfRows];

                  $totalNumOfProducts += $numberOfRows;

                  $data['categoryIdentifiers'] .= "{$categoryId}:";
                }
              }

              $sqlQuery = $sqlQuery -> orderBy('relevance', 'desc') -> take($numOfProductsToView);

              $data['categoryIdentifiers'] = rtrim($data['categoryIdentifiers'], ':');
              $data['numOfProducts'] = $totalNumOfProducts;
              $data['itemsPerPage'] = $numOfProductsToView;
              $data['productsExist'] = $data['numOfProducts'] != 0;

              $paginator = \Paginator::build($data['numOfProducts'], 3, $data['itemsPerPage'], $data['active'], 2, 0);

              $data['pages'] = $paginator -> pages;
              $data['maxPage'] = $paginator -> maxPage;
              $data['currentPage'] = $data['active'];
              $data['products'] = $sqlQuery -> get();

              if($data['productsExist'])
              {
                $data['products'] -> map(function($product){

                    $product -> newPrice = $product -> price - $product -> discount;
                });

                $data['products'] = $data['products'] -> chunk(3);
              }
            }
          }
        }
      }

      return View::make('contents.site.products.search', ['contentData' => $data,
                                                          'generalData' => $generalData]);
    }
}
