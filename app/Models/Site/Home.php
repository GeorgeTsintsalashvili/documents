<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    public function getIndexPageData()
    {
       $numberOfAccessoriesToView = 12;
       $numberOfSystemsToView = 15;
       $numberOfLatestProductsToView = 40;
       $numberOfDiscountedProductsToView = 50;

       $computerColumns = ['computers.id', 'title', 'mainImage', 'discount', 'price', 'cpu', 'memory', 'solidStateDriveCapacity', 'hardDiscDriveCapacity', 'gpuTitle'];
       $accessoriesColumns = ['accessories.id', 'price', 'discount', 'title', 'mainImage'];

       $specialOffers = \DB::table('computers') -> select($computerColumns) -> where('visibility', '=', 1) -> where('isOffer', '=', 1) -> get();
       $activeAccessories = null;
       $activeSystems = null;

       $discountedProductsQuery = null;
       $latestProductsQuery = null;

       $slides = \DB::table('slides') -> get();
       $cpuSeries = \DB::table('cpu_series') -> get();
       $accessoriesTypes = \DB::table('accessories_types') -> get();

       // data for raw sql statement

       $tablesData = \DB::table('tables') -> where('blacklisted', 0) -> get();

       $data['slidesExist'] = !$slides -> isEmpty();
       $data['cpuSeriesExist'] = !$cpuSeries -> isEmpty();
       $data['accessoriesTypesExist'] = !$accessoriesTypes -> isEmpty();
       $data['specialOffersExist'] = !$specialOffers -> isEmpty();
       $data['discountedProductsExist'] = false;
       $data['latestProductsExist'] = false;

       $data['activeAccessoryCategoryId'] = 0;
       $data['activeCpuSeriesId'] = 0;

       if($data['accessoriesTypesExist'])
       {
         foreach($accessoriesTypes as $value)
         {
            $activeAccessories = \DB::table('accessories') -> select($accessoriesColumns) -> where('accessoryTypeId', $value -> id) -> where('visibility', '=', 1) -> take($numberOfAccessoriesToView) -> get();

            if(!$activeAccessories -> isEmpty())
            {
              foreach($activeAccessories as $key => $accessory) $activeAccessories[$key] -> newPrice = $accessory -> price - $accessory -> discount;

              $data['activeAccessoryCategoryId'] = $value -> id;

              break;
            }
         }
       }

       if($data['cpuSeriesExist'])
       {
          $cpuSeries -> each(function($series) use ($computerColumns, $numberOfSystemsToView, &$activeSystems, &$data){

              $activeSystems = \DB::table('computers') -> select($computerColumns)
                                                       -> where('visibility', '=', 1)
                                                       -> where('seriesId', '=', $series -> id)
                                                       -> take($numberOfSystemsToView)
                                                       -> get();

              if(!$activeSystems -> isEmpty())
              {
                $activeSystems -> map(function($system){

                    $hddCapacity = $system -> hardDiscDriveCapacity;
                    $ssdCapacity = $system -> solidStateDriveCapacity;
                    $storage = null;

                    if($hddCapacity && $ssdCapacity) $storage = "HDD {$hddCapacity} GB SSD {$ssdCapacity} GB";

                    else if($hddCapacity && !$ssdCapacity) $storage = "HDD {$hddCapacity} GB";

                    else if(!$hddCapacity && $ssdCapacity) $storage = "SSD {$ssdCapacity} GB";

                    $system -> newPrice = $system -> price - $system -> discount;
                    $system -> storage = $storage;
                });

                $data['activeCpuSeriesId'] = $series -> id;

                return false;
              }
          });
       }

       if($data['specialOffersExist'])
       {
          $specialOffers -> map(function($product){

              $hddCapacity = $product -> hardDiscDriveCapacity;
              $ssdCapacity = $product -> solidStateDriveCapacity;
              $storage = null;

              if($hddCapacity && $ssdCapacity) $storage = "HDD {$hddCapacity} GB SSD {$ssdCapacity} GB";

              else if($hddCapacity && !$ssdCapacity) $storage = "HDD {$hddCapacity} GB";

              else if(!$hddCapacity && $ssdCapacity) $storage = "SSD {$ssdCapacity} GB";

              $product -> newPrice = $product -> price - $product -> discount;
              $product -> storage = $storage;
          });
       }

       $tablesData -> each(function($item) use (&$discountedProductsQuery, &$latestProductsQuery){

           $pathPartToAssign = \Str::camel($item -> name);

           $columnsToSelect = "`id`,`timestamp`,`price`,`discount`,`title`,`mainImage`,'{$pathPartToAssign}' as `pathPart`";

           $discountedProductsTempQuery = \DB::table($item -> name) -> selectRaw($columnsToSelect) -> where('visibility', 1) -> where('discount', '!=', 0);

           if(!$discountedProductsQuery) $discountedProductsQuery = $discountedProductsTempQuery;

           else $discountedProductsQuery -> union($discountedProductsTempQuery);

           $latestProductsTempQuery = \DB::table($item -> name) -> selectRaw($columnsToSelect) -> where('visibility', '=', 1);

           if(!$latestProductsQuery) $latestProductsQuery = $latestProductsTempQuery;

           else $latestProductsQuery -> union($latestProductsTempQuery);
       });

       $discountedProducts = $discountedProductsQuery -> take($numberOfDiscountedProductsToView) -> get();
       $latestProducts = $latestProductsQuery -> orderBy('timestamp', 'desc') -> take($numberOfLatestProductsToView) -> get();

       if(!$discountedProducts -> isEmpty())
       {
          $data['discountedProductsExist'] = true;

          $discountedProducts -> map(function($product){

              $product -> newPrice = $product -> price - $product -> discount;
          });

          $data['discountedProducts'] = $discountedProducts;
       }

       if(!$latestProducts -> isEmpty())
       {
           $data['latestProductsExist'] = true;

           $latestProducts -> map(function($product){

               $product -> newPrice = $product -> price - $product -> discount;
           });

           $data['latestProducts'] = $latestProducts;
       }

       $data['specialOffers'] = $specialOffers;
       $data['activeAccessories'] = $activeAccessories;
       $data['activeSystems'] = $activeSystems;

       $data['slides'] = $slides;
       $data['cpuSeries'] = $cpuSeries;
       $data['accessoriesTypes'] = $accessoriesTypes;

       return $data;
    }
}
