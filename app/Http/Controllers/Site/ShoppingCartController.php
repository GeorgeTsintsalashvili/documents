<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;
use \App\Helpers\Paginator;

use \App\Models\Site\BaseModel;
use \App\Models\Site\ShoppingCart;

class ShoppingCartController extends Controllers\Controller
{
    public function index()
    {
      $generalData = BaseModel::getGeneralData();

      $data['shoppingCartIsNotEmpty'] = false;
      $data['shoppingCartHasBeenModified'] = false;
      $data['totalDiscount'] = 0;
      $data['totalPrice'] = 0;
      $data['numberOfProducts'] = 0;

      $tablesData = \DB::table('tables') -> get();
      $shoppingCartCookieName = 'u0s69b7ek1de';
      $productCookieLifeTime = time() + 31536000;
      $shoppingCartCookieValue = \Cookie::get($shoppingCartCookieName);

      if(is_string($shoppingCartCookieValue))
      {
        $shoppingCartCookieValue = trim($shoppingCartCookieValue);
        $cookieDataParts = explode(':', $shoppingCartCookieValue);

        if(count($cookieDataParts) != 0)
        {
          $cookieDataParts = array_unique($cookieDataParts);
          $primaryQuery = null;

          foreach($cookieDataParts as $value)
          {
            $productParts = explode('-', $value);

            if(count($productParts) == 3)
            {
              $productId = abs((int) $productParts[0]);
              $categoryId = trim($productParts[1]);
              $numOfUnits = abs((int) $productParts[2]);
              $tableData = $tablesData -> where('alias', $categoryId) -> first();

              if(!is_null($tableData) && $numOfUnits && $productId)
              {
                $tableName = $tableData -> name;
                $pathPart = \Str::camel($tableName);

                $columns = "`code`,`price`,`discount`,`quantity`,`id`,`title`,`mainImage`,'{$pathPart}' as `pathPart`,'{$categoryId}' as `categoryId`,$numOfUnits as `numOfUnits`";
                $tempQuery = \DB::table($tableName) -> selectRaw($columns) -> where('visibility', 1) -> where('id', '=', $productId) -> where('quantity', '>=', $numOfUnits);

                if(is_null($primaryQuery)) $primaryQuery = $tempQuery;

                else $primaryQuery -> union($tempQuery);
              }
            }
          }

          if(!is_null($primaryQuery))
          {
            $data['numberOfProducts'] = $primaryQuery -> count();

            if($data['numberOfProducts'] != 0)
            {
              $data['shoppingCartIsNotEmpty'] = true;
              $data['products'] = $primaryQuery -> get();

              foreach($data['products'] as $key => $value)
              {
                $productTotalPrice = $value -> numOfUnits * $value -> price;
                $productTotalDiscount = $value -> numOfUnits * $value -> discount;

                $data['totalPrice'] += $productTotalPrice - $productTotalDiscount;
                $data['totalDiscount'] += $productTotalDiscount;
                $data['products'][$key] -> totalPrice = $productTotalPrice - $productTotalDiscount;
                $data['products'][$key] -> originalPrice = $productTotalPrice;

                if(mb_strlen($value -> title) > 40)
                {
                  $value -> title = mb_substr($value -> title, 0, 30);
                  $data['products'][$key] -> title = $value -> title . ' . . . ';
                }
              }
            }
          }
        }
      }

      return View::make('contents.site.shoppingCart.index', ['contentData' => $data,
                                                             'generalData' => $generalData]);
    }

    public function add(Request $request)
    {
      $data['productAdded'] = false;
      $data['productExistsInShoppingCart'] = false;
      $data['productId'] = null;
      $data['productExists'] = false;

      $tablesData = \DB::table('tables') -> get();

      if(!$tablesData -> isEmpty())
      {
        // request data validation logic

        $parameters = $request -> all();

        $validator = \Validator::make($parameters, ['quantity' => 'required|string',
                                                    'product-id' => 'required|string',
                                                    'category-id' => 'required|string']);

        if(!$validator -> fails())
        {
          $productId = abs((int) $parameters['product-id']);
          $quantity = abs((int) $parameters['quantity']);
          $categoryId = trim($parameters['category-id']);
          $tableData = \DB::table('tables') -> select(['name']) -> where('alias', $categoryId) -> first();

          if($productId && $quantity && $tableData)
          {
            $product = \DB::table($tableData -> name) -> select(['quantity', 'id'])
                                                      -> where('id', '=', $productId)
                                                      -> where('visibility', 1)
                                                      -> where('quantity', '!=', 0)
                                                      -> first();

            if(!is_null($product))
            {
              $productQuantityIsAllowed = $quantity <= $product -> quantity;

              $data['productId'] = $product -> id;
              $data['productExists'] = true;

              if($productQuantityIsAllowed)
              {
                $shoppingCartCookieName = 'u0s69b7ek1de'; // set cookie name
                $productCookieLifeTime = time() + 31536000; // set cookie lifetime equal to one year (31536000 for native function and 525600 for framework)

                $productDataParts = [$productId, $categoryId, $quantity];
                $serializedProductData = implode($productDataParts, '-');
                $shoppingCartCookieValue = \Cookie::get($shoppingCartCookieName);

                if(is_null($shoppingCartCookieValue))
                {
                  setcookie($shoppingCartCookieName, $serializedProductData, $productCookieLifeTime);

                  $data['productAdded'] = true;
                }

                else if(is_string($shoppingCartCookieValue))
                {
                  $shoppingCartCookieValue = trim($shoppingCartCookieValue);

                  if(strlen($shoppingCartCookieValue) != 0)
                  {
                    $shoppingCartCookieValueParts = explode(':', $shoppingCartCookieValue);
                    $shoppingCartIsNotEmpty = count($shoppingCartCookieValueParts) != 0;

                    if($shoppingCartIsNotEmpty)
                    {
                       $shoppingCartCookieValueParts = array_unique($shoppingCartCookieValueParts);

                       foreach($shoppingCartCookieValueParts as $key => $value)
                       {
                         $productParts = explode('-', $value);

                         if(count($productParts) == 3)
                         {
                           $productIdPart = abs((int) $productParts[0]);
                           $categoryIdPart = $productParts[1];

                           if($productIdPart != 0)
                           {
                             if(strcmp($categoryIdPart, $categoryId) == 0 && $productIdPart === $productId)
                             {
                               $data['productExistsInShoppingCart'] = true;

                               break;
                             }
                           }
                         }
                       }

                       if(!$data['productExistsInShoppingCart'])
                       {
                         $updatedShoppingCartCookieValue = implode(':', [$shoppingCartCookieValue, $serializedProductData]);

                         setcookie($shoppingCartCookieName, $updatedShoppingCartCookieValue, $productCookieLifeTime);

                         $data['productAdded'] = true;
                       }
                    }

                    else
                    {
                      setcookie($shoppingCartCookieName, $serializedProductData, $productCookieLifeTime);

                      $data['productAdded'] = true;
                    }
                  }
                }
              }
            }
          }
        }
      }

      return response(json_encode($data)) -> header('Content-Type', 'application/json');
    }

    public function delete(Request $request)
    {
      $data['productDeleted'] = false;
      $data['numberOfProductsLeft'] = 0;
      $data['totalPrice'] = 0;
      $data['totalDiscount'] = 0;

      $tablesData = \DB::table('tables') -> select(['alias', 'name']) -> get();

      if(!$tablesData -> isEmpty())
      {
        // request data validation logic

        $parameters = $request -> all();

        $validator = \Validator::make($parameters, ['quantity' => 'required|string',
                                                    'product-id' => 'required|string',
                                                    'category-id' => 'required|string']);

        if(!$validator -> fails())
        {
          $paramProductId = abs((int) $parameters['product-id']);
          $paramQuantity = abs((int) $parameters['quantity']);
          $paramCategoryId = trim($parameters['category-id']);
          $tableDataByCategory = $tablesData -> where('alias', $paramCategoryId) -> first();

          if(!is_null($tableDataByCategory))
          {
            $tableByCategoryName = $tableDataByCategory -> name;
            $columns = ['quantity', 'price'];

            $shoppingCartProduct = \DB::table($tableByCategoryName) -> select($columns) -> where('id', '=', $paramProductId) -> where('visibility', 1) -> where('quantity', '!=', 0) -> first();
            $shoppingCartProductIsReal = !is_null($shoppingCartProduct);

            if($shoppingCartProductIsReal && $paramQuantity <= $shoppingCartProduct -> quantity)
            {
              $shoppingCartCookieName = 'u0s69b7ek1de'; // set cookie name
              $productCookieLifeTime = time() + 31536000; // set cookie lifetime equal to one year
              $shoppingCartCookieValue = \Cookie::get($shoppingCartCookieName);

              if(is_string($shoppingCartCookieValue))
              {
                $shoppingCartCookie = trim($shoppingCartCookieValue);

                if(strlen($shoppingCartCookie) != 0)
                {
                  $shoppingCartParts = explode(':', $shoppingCartCookie);
                  $shoppingCartParts = array_unique($shoppingCartParts);
                  $shoppingCartIsNotEmpty = count($shoppingCartParts) != 0;

                  if($shoppingCartIsNotEmpty)
                  {
                    $newShoppingCartParts = [];

                    foreach($shoppingCartParts as $value)
                    {
                      $shoppingCartCookieParts = explode('-', $value);
                      $shoppingCartCookiePartToDelete = implode('-', [$paramProductId, $paramCategoryId, $paramQuantity]);

                      if(count($shoppingCartCookieParts) == 3)
                      {
                        $shoppingCartProductId = abs((int) $shoppingCartCookieParts[0]);
                        $shoppingCartQuantity = abs((int) $shoppingCartCookieParts[2]);
                        $shoppingCartCategoryId = trim($shoppingCartCookieParts[1]);

                        if(!in_array(0, [$shoppingCartProductId, $shoppingCartQuantity, strlen($shoppingCartCategoryId)]))
                        {
                          $assembledCookieSegment = implode('-', [$shoppingCartProductId, $shoppingCartCategoryId, $shoppingCartQuantity]);

                          if(strcmp($assembledCookieSegment, $shoppingCartCookiePartToDelete) != 0)

                          $newShoppingCartParts[] = $assembledCookieSegment;

                          else $data['productDeleted'] = true;
                        }
                      }
                    }

                    $newShoppingCartCookie = implode(':', $newShoppingCartParts);

                    setcookie($shoppingCartCookieName, $newShoppingCartCookie, $productCookieLifeTime);

                    $query = null;

                    foreach($newShoppingCartParts as $value)
                    {
                      $newShoppingCartCookieParts = explode('-', $value);

                      if(count($newShoppingCartCookieParts) == 3)
                      {
                        $newShoppingCartProductId = abs((int) $newShoppingCartCookieParts[0]);
                        $newShoppingCartQuantity = abs((int) $newShoppingCartCookieParts[2]);
                        $newShoppingCartCategoryId = trim($newShoppingCartCookieParts[1]);

                        if($newShoppingCartProductId && $newShoppingCartQuantity && strlen($newShoppingCartCategoryId))
                        {
                          $tableData = $tablesData -> where('alias', $newShoppingCartCategoryId) -> first();

                          if(!is_null($tableData))
                          {
                            $columns = "`price` AS `unitPrice`,`discount`,`quantity`,$newShoppingCartQuantity as `numOfUnits`";
                            $tempSqlQuery = \DB::table($tableData -> name) -> selectRaw($columns) -> where('visibility', 1) -> where('id', $newShoppingCartProductId) -> where('quantity', '>=', $newShoppingCartQuantity);

                            if(is_null($query)) $query = $tempSqlQuery;

                            else $query -> union($tempSqlQuery);
                          }
                        }
                      }
                    }

                    if(!is_null($query) && $query -> count() != 0)
                    {
                      $products = $query -> get();

                      foreach($products as $value)
                      {
                        $productTotalPrice = $value -> numOfUnits * $value -> unitPrice;
                        $productTotalDiscount = $value -> numOfUnits * $value -> discount;

                        $data['totalPrice'] += $productTotalPrice - $productTotalDiscount;
                        $data['totalDiscount'] += $productTotalDiscount;
                        $data['numberOfProductsLeft'] += 1;
                      }
                    }

                    else setcookie($shoppingCartCookieName, null, time() - 3600);
                  }

                  else setcookie($shoppingCartCookieName, null, time() - 3600);
                }

                else setcookie($shoppingCartCookieName, null, time() - 3600);
              }
            }
          }
        }
      }

      return response(json_encode($data)) -> header('Content-Type', 'application/json');
    }

    public function changeQuantity(Request $request)
    {
      $data['quantityChanged'] = false;
      $data['totalPrice'] = 0;
      $data['totalDiscount'] = 0;
      $data['productNewPrice'] = 0;
      $data['productDiscount'] = 0;

      $tablesData = \DB::table('tables') -> select(['alias', 'name']) -> get();

      if(!$tablesData -> isEmpty())
      {
        // request data validation logic

        $parameters = $request -> all();

        $validator = \Validator::make($parameters, ['quantity' => 'required|string',
                                                    'product-id' => 'required|string',
                                                    'category-id' => 'required|string']);

        if(!$validator -> fails())
        {
          $paramCategoryId = trim($parameters['category-id']);
          $paramProductId = abs((int) $parameters['product-id']);
          $paramQuantity = abs((int) $parameters['quantity']);

          if($paramProductId && $paramQuantity && strlen($paramCategoryId))
          {
            $tableDataByCategory = $tablesData -> where('alias', $paramCategoryId) -> first();

            if(!is_null($tableDataByCategory))
            {
              $tableName = $tableDataByCategory -> name;
              $columns = ['quantity', 'price', 'discount'];

              $shoppingCartProduct = \DB::table($tableName) -> select($columns) -> where('id', '=', $paramProductId) -> where('visibility', 1) -> where('quantity', '!=', 0) -> first();
              $shoppingCartProductIsReal = !is_null($shoppingCartProduct);

              if($shoppingCartProductIsReal && $paramQuantity <= $shoppingCartProduct -> quantity)
              {
                $data['productNewPrice'] = $paramQuantity * ($shoppingCartProduct -> price - $shoppingCartProduct -> discount);
                $data['productDiscount'] = $paramQuantity * $shoppingCartProduct -> discount;

                $shoppingCartCookieName = 'u0s69b7ek1de'; // set cookie name
                $productCookieLifeTime = time() + 31536000; // set cookie lifetime equal to one year
                $shoppingCartCookieValue = \Cookie::get($shoppingCartCookieName);

                if(is_string($shoppingCartCookieValue))
                {
                  $shoppingCartCookieValue = trim($shoppingCartCookieValue);

                  if(strlen($shoppingCartCookieValue) != 0)
                  {
                    $shoppingCartParts = explode(':', $shoppingCartCookieValue);
                    $shoppingCartIsNotEmpty = count($shoppingCartParts);
                    $productExistsInShoppingCart = false;

                    $cookieStringSegmentToFind = null;
                    $cookieStringSegmentToReplaceWith = null;
                    $newShoppingCartCookie = null;

                    if($shoppingCartIsNotEmpty)
                    {
                       $shoppingCartParts = array_unique($shoppingCartParts);
                       $newShoppingCartParts = [];

                       foreach($shoppingCartParts as $key => $value)
                       {
                         $productParts = explode('-', $value);

                         if(count($productParts) == 3)
                         {
                           $productIdPart = abs((int) $productParts[0]);
                           $categoryIdPart = trim($productParts[1]);
                           $quantityPart = $productParts[2];

                           if(!in_array(0, [$quantityPart, $productIdPart, strlen($categoryIdPart)]))
                           {
                              if(strcmp($categoryIdPart, $paramCategoryId) == 0 && $productIdPart == $paramProductId)
                              {
                                $productExistsInShoppingCart = true;

                                $cookieStringSegmentToFind = implode('-', [$productIdPart, $categoryIdPart, $quantityPart]);
                                $cookieStringSegmentToReplaceWith = implode('-', [$paramProductId, $paramCategoryId, $paramQuantity]);

                                $newShoppingCartCookie = str_replace($cookieStringSegmentToFind, $cookieStringSegmentToReplaceWith, $shoppingCartCookieValue);
                                $newShoppingCartParts[] = $cookieStringSegmentToReplaceWith;
                              }

                              else $newShoppingCartParts[] = implode('-', [$productIdPart, $categoryIdPart, $quantityPart]);
                           }
                         }
                       }

                       if($productExistsInShoppingCart)
                       {
                         setcookie($shoppingCartCookieName, $newShoppingCartCookie, $productCookieLifeTime);

                         $query = null;

                         foreach($newShoppingCartParts as $value)
                         {
                           $productParts = explode("-", $value);

                           $productId = (int) $productParts[0];
                           $categoryId = $productParts[1];
                           $numOfUnits = (int) $productParts[2];

                           $tableData = $tablesData -> where('alias', $categoryId) -> first();

                           if(!is_null($tableData))
                           {
                             $tableName = $tableData -> name;
                             $columns = "`price` AS `unitPrice`,`discount`,`quantity`,{$numOfUnits} as `numOfUnits`";

                             $tempSqlQuery = \DB::table($tableName) -> selectRaw($columns) -> where('visibility', 1) -> where('id', $productId) -> where('quantity', '>=', $numOfUnits);

                             if(is_null($query)) $query = $tempSqlQuery;

                             else $query -> union($tempSqlQuery);
                           }
                         }

                         if($query -> count() != 0)
                         {
                           $data['quantityChanged'] = true;

                           $products = $query -> get();

                           foreach($products as $key => $value)
                           {
                             $productTotalPrice = $value -> numOfUnits * $value -> unitPrice;
                             $productTotalDiscount = $value -> numOfUnits * $value -> discount;

                             $data['totalPrice'] += $productTotalPrice - $productTotalDiscount;
                             $data['totalDiscount'] += $productTotalDiscount;
                           }
                         }
                       }
                     }
                  }
                }
              }
            }
          }
        }
      }

      return response(json_encode($data)) -> header('Content-Type', 'application/json');
    }
}
