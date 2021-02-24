<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BaseDataUpdateRequest;

use App\Http\Requests\UpdateVideoCardRequest;
use App\Http\Requests\StoreVideoCardRequest;

use App\Rules\NaturalNumber;
use App\Rules\BinaryValue;
use App\Rules\PositiveIntegerOrZero;

use \App\Models\User\VideoCard;
use \App\Traits\BaseDataUpdatable;
use \App\Traits\RecordDeletable;
use App\Traits\MainImageUpdatable;
use App\Traits\MainImageUploadable;
use App\Traits\CarouselImageUploadable;
use App\Traits\Searchable;

class VideoCardController extends Controller
{
    public function index(Request $request) // Display a listing of the resource
    {
      $parameters = $request -> only([ 'manufacturer-id', 'list-page' ]);
      $rules = [ 'manufacturer-id' => ['required', new PositiveIntegerOrZero ],
                 'list-page' => ['required', new NaturalNumber ] ];

      $searchQueryRule = ['search-query' => 'required|string|min:1|max:200'];
      $searchQueryValidator = \Validator::make($request -> only('search-query'), $searchQueryRule);

      $searchQuery = null;
      $listCurrentPage = 1;
      $selectedManufacturerId = 0;

      $validator = \Validator::make($parameters, $rules);

      if (!$validator -> fails())
      {
        $selectedManufacturerId = (int) $parameters['manufacturer-id'];
        $listCurrentPage = (int) $parameters['list-page'];
      }

      $queryBuilder = \DB::table('video_cards');

      if (!$searchQueryValidator -> fails())
      {
        $searchQuery = $_POST['search-query'];

        $trimmedSearchQuery = $request -> input('search-query');

        $columns = ['id', 'mainImage', 'title', 'price', 'discount', 'conditionId', 'stockTypeId', 'visibility', 'configuratorPart', 'uuid', 'warrantyDuration', 'warrantyId'];

        $indexedColumns = ['title', 'description'];

        $queryBuilder = Searchable::booleanSearch($queryBuilder, $columns, $trimmedSearchQuery, $indexedColumns);
      }

      if ($selectedManufacturerId != 0) $queryBuilder = $queryBuilder -> where('videoCardManufacturerId', $selectedManufacturerId);

      $numOfItemsToView = 9;
      $numOfItems = $queryBuilder -> count();

      $paginator = \Paginator::build($numOfItems, 2, $numOfItemsToView, $listCurrentPage, 2, 2);
      $itemsToSkip = ($paginator -> currentPage - 1) * $numOfItemsToView;

      $items = $queryBuilder -> orderBy('id', 'desc') -> skip($itemsToSkip) -> take($numOfItemsToView) -> get();
      $manufacturers = \DB::table('video_cards_manufacturers') -> get();

      $conditions = \DB::table('conditions') -> get();
      $stockTypes = \DB::table('stock_types') -> get();
      $warranties = \DB::table('warranties') -> get();

      $priceRanges = \DB::table('price_configurations') -> select(['videoCardMinPrice', 'videoCardMaxPrice']) -> first();
      $productMinPrice = $priceRanges -> videoCardMinPrice;
      $productMaxPrice = $priceRanges -> videoCardMaxPrice;

      $types = \DB::table('video_cards_memory_types') -> get();
      $manufacturers = \DB::table('video_cards_manufacturers') -> get();
      $graphicalProcessors = \DB::table('gpu_manufacturers') -> get();

      $warranties = \DB::table('warranties') -> get();

      $items -> each(function($item) use ($warranties){

                $title = $warranties -> where('id', $item -> warrantyId) -> first() -> warrantyPageTitle;

                $item -> warranty = $item -> warrantyDuration . " " . $title;
      });

      return \View::make('contents.user.videoCards.index') -> with([

            'items' => $items,
            'paginationKey' => 'list-page',
            'paginator' => $paginator,
            'conditions' => $conditions,
            'stockTypes' => $stockTypes,
            'warranties' => $warranties,
            'minPrice' => $productMinPrice,
            'maxPrice' => $productMaxPrice,
            'searchQuery' => $searchQuery,
            'manufacturersKey' => 'manufacturer-id',
            'manufacturers' => $manufacturers,
            'selectedManufacturerId' => $selectedManufacturerId,
            'types' => $types,
            'manufacturers' => $manufacturers,
            'graphicalProcessors' => $graphicalProcessors
      ]);
    }

    public function store(StoreVideoCardRequest $request) // Store a newly created resource in storage
    {
      $data = $request -> validated();

      $response['stored'] = false;

      if ($request -> file('mainImage') -> isValid())
      {
        $file = $request -> file('mainImage');

        $fileName = MainImageUploadable::uploadMainImage(VideoCard::class, $file);

        if ($fileName)
        {
          $data['mainImage'] = $fileName;
          $data['description'] = preg_replace('/(\<script(.|\s)*\>(.|\s)*<\/script\>)/si', '', $data['description']);
          $data['configuratorPart'] = $request -> filled('configuratorPart') ? 1 : 0;

          $hash = md5(uniqid(mt_rand(), true));
          $data['uuid'] = substr($hash, 0, 8) . substr($hash, 8, 4) . substr($hash, 12, 4) . substr($hash, 16, 4) . substr($hash, 20, 12);

          $data['code'] = substr(md5(time()), 0, 12);
          $codeExists = \DB::table('video_cards') -> where('code', $data['code']) -> count();

          while($codeExists)
          {
            $data['code'] = substr(md5(time()), 0, 12);
            $codeExists = \DB::table('video_cards') -> where('code', $data['code']) -> count();
          }

          $object = new VideoCard();

          $data = \Arr::except($data, ['images']);

          foreach ($data as $key => $value)
          {
            $object -> $key = $data[$key];
          }

          $object -> save();

          if ($request -> has('images'))
          {
            $carouselImages = $request -> file('images');

            foreach ($carouselImages as $carouselImage)
            {
              if ($carouselImage -> isValid())
              {
                CarouselImageUploadable::uploadImage(VideoCard::class, $object -> id, $carouselImage);
              }
            }
          }

          return ['stored' => true];
        }
      }

      return $response;
    }

    public function edit($id) // Show the form for editing the specified resource
    {
      try{

        $product = VideoCard::findOrFail($id);

        $warranties = \DB::table('warranties') -> get();
        $images = \DB::table('video_cards_images') -> where('videoCardId', $id) -> get();

        $gpuManufacturers = \DB::table('gpu_manufacturers') -> get();
        $videoCardsManufacturers = \DB::table('video_cards_manufacturers') -> get();
        $memoryTypes = \DB::table('video_cards_memory_types') -> get();

        return \View::make('contents.user.videoCards.edit') -> with([

            'product' => $product,
            'warranties' => $warranties,
            'images' => $images,
            'productid' => $id,
            'memoryTypes' => $memoryTypes,
            'videoCardsManufacturers' => $videoCardsManufacturers,
            'gpuManufacturers' => $gpuManufacturers
        ]);
      }

      catch(\Exception $e){

        return "404 Product Not Found";
      }
    }

    public function update(UpdateVideoCardRequest $request) // Update the specified resource in storage
    {
      $data = $request -> validated();

      try{
            $recordId = $data['record-id'];
            $data = \Arr::except($data, ['record-id']);

            $record = VideoCard::findOrFail($recordId);

            $data['description'] = preg_replace('/(\<script(.|\s)*\>(.|\s)*<\/script\>)/si', '', $data['description']);

            foreach ($data as $key => $value)
            {
              $record -> $key = $data[$key];
            }

            $record -> save();

            return ['updated' => true];
      }

      catch(\Exception $e){

        return ['updated' => false];
      }
    }

    public function destroy($id) // Remove the specified resource from storage
    {
      try{

        RecordDeletable::deleteRecord(VideoCard::class, $id);

        return ['deleted' => true];
      }

      catch(\Exception $e){

        return ['deleted' => false];
      }
    }

    public function updateBaseData(BaseDataUpdateRequest $request)
    {
      $data = $request -> validated();

      try{

        BaseDataUpdatable::updateBaseData(VideoCard::class, $data);

        return ['updated'  => true];
      }

      catch(\Exception $e){

        return ['updated'  => false];
      }
    }

    // images control

    public function updateImage(Request $request)
    {
      $response = [ 'uploaded' => false ];

      if ($request -> hasFile('image')) // if file is moved into temporary location by web server
      {
        $response['uploaded'] = true;
        $response['updated'] = false;

        try{
              $rules = [ 'image' => ['required', 'mimes:jpg,jpeg,png', 'max:1024'],
                         'record-id' => ['required', new NaturalNumber] ];

              $validator = \Validator::make($request -> all(), $rules);

              if (!$validator -> fails())
              {
                $file = $request -> file('image');
                $recordId = $request -> input('record-id');

                $imagesSources = MainImageUpdatable::updateImage(VideoCard::class, $recordId, $file);

                if ($imagesSources)
                {
                  $response['updated'] = true;

                  $response = array_merge($response, $imagesSources);
                }
              }

              else throw new \Exception;
        }

        catch(\Exception $e){

          $response['updated'] = false;
        }
      }

      return $response;
    }

    public function uploadImage(Request $request)
    {
      $response = [ 'uploaded' => false ];

      if ($request -> hasFile('image')) // if file is moved into temporary location by web server
      {
        $response['uploaded'] = true;

        try{
              $rules = [ 'image' => ['required', 'mimes:jpg,jpeg,png', 'max:1024'],
                         'record-id' => ['required', new NaturalNumber] ];

              $validator = \Validator::make($request -> all(), $rules);

              if (!$validator -> fails())
              {
                $response['testPassed'] = true;

                $file = $request -> file('image');
                $className = VideoCard::class;
                $recordId = $request -> input('record-id');

                $controlData = CarouselImageUploadable::uploadImage($className, $recordId, $file);

                $response = array_merge($response, $controlData);
              }

              else throw new \Exception;
        }

        catch(\Exception $e){

          $response['testPassed'] = false;
        }
      }

      return $response;
    }

    public function destroyImage($id)
    {
      $response['destroyed'] = false;

      $classBaseName = class_basename(VideoCard::class);
      $imagesDirectoryName = lcfirst(\Str::plural($classBaseName));
      $imagesTableName = \Str::snake($imagesDirectoryName) . '_images';

      $recordQuery = \DB::table($imagesTableName) -> where('id', $id);

      if ($recordQuery -> count() != 0)
      {
         $record = $recordQuery -> first();
         $fileName = $record -> image;

         $recordQuery -> delete();

         $slidesPath = realpath('./images/' . $imagesDirectoryName . '/slides');

         $originalImagesPath = $slidesPath . '/original/';
         $resizedImagesPath = $slidesPath . '/preview/';

         $originalImageFullName = $originalImagesPath . $fileName;
         $resizeImageFullName = $resizedImagesPath . $fileName;

         if (file_exists($originalImageFullName) && file_exists($resizeImageFullName))
         {
           \File::delete($originalImageFullName);
           \File::delete($resizeImageFullName);

           $response['destroyed'] = true;
         }
      }

      return $response;
    }

    // parameters methods

    public function parameters(Request $request)
    {
       $parameters = $request -> all();
       $vcManufacturersPageKey = 'vc-manufacturers-page';

       $validator = \Validator::make($parameters, [
         $vcManufacturersPageKey => [
            'required',
             new NaturalNumber()
           ]
       ]);

       $vcManufacturersToView = 5;
       $vcManufacturersNum = \DB::table('video_cards_manufacturers') -> count();
       $vcManufacturersPage = $validator -> fails() ? 1 : (int) $parameters[$vcManufacturersPageKey];
       $manufacturersToSkip = ($vcManufacturersPage - 1) * $vcManufacturersToView;

       return \View::make('contents.user.videoCards.parameters') -> with([
          'videoMemoryTypes' => \DB::table('video_cards_memory_types') -> orderBy('id', 'desc') -> get(),
          'gpuManufacturers' => \DB::table('gpu_manufacturers') -> orderBy('id', 'desc') -> get(),
          'videoCardsManufacturers' => \DB::table('video_cards_manufacturers') -> orderBy('id', 'desc') -> skip($manufacturersToSkip) -> take($vcManufacturersToView) -> get(),
          'systemBlockGraphics' => \DB::table('computer_graphics') -> orderBy('id', 'desc') -> get(),
          'vcManufacturersPaginator' => \Paginator::build($vcManufacturersNum, 2, $vcManufacturersToView, $vcManufacturersPage, 2, 2),
          'vcManufacturersPageKey' => $vcManufacturersPageKey
       ]);
    }

    // update methods

    public function updateVideoCardManufacturer(Request $request)
    {
      $data['updated'] = false;

      $parameters = $request -> all(); // user input

      $validator = \Validator::make($parameters, ['video-card-manufacturer-title' => 'required|string|min:1|max:100',
                                                  'record-id' => ['required', new NaturalNumber()]
                                                 ]);
      if (!$validator -> fails())
      {
         $data['updated'] = true;

         \DB::table('video_cards_manufacturers') -> where('id', $parameters['record-id']) -> update(['videoCardManufacturerTitle' => $parameters['video-card-manufacturer-title']]);
      }

      return $data;
    }

    public function updateVideoCardMemoryType(Request $request)
    {
      $data['updated'] = false;

      $parameters = $request -> all(); // user input

      $validator = \Validator::make($parameters, ['video-memory-type-title' => 'required|string|min:1|max:100',
                                                  'record-id' => ['required', new NaturalNumber()]
                                                 ]);
      if (!$validator -> fails())
      {
         $data['updated'] = true;

         \DB::table('video_cards_memory_types') -> where('id', $parameters['record-id']) -> update(['typeTitle' => $parameters['video-memory-type-title']]);
      }

      return $data;
    }

    public function updateGraphicsType(Request $request)
    {
      $data['updated'] = false;

      $parameters = $request -> all(); // user input

      $validator = \Validator::make($parameters, ['computer-graphics-type-title' => 'required|string|min:1|max:100',
                                                  'record-id' => ['required', new NaturalNumber()]
                                                 ]);
      if (!$validator -> fails())
      {
         $data['updated'] = true;

         \DB::table('computer_graphics') -> where('id', $parameters['record-id']) -> update(['graphicsTitle' => $parameters['computer-graphics-type-title']]);
      }

      return $data;
    }

    public function updateGraphicalProcessorManufacturer(Request $request)
    {
      $data['updated'] = false;

      $parameters = $request -> all(); // user input

      $validator = \Validator::make($parameters, ['gpu-manufacturer-title' => 'required|string|min:1|max:100',
                                                  'record-id' => ['required', new NaturalNumber()]
                                                 ]);
      if (!$validator -> fails())
      {
         $data['updated'] = true;

         \DB::table('gpu_manufacturers') -> where('id', $parameters['record-id']) -> update(['gpuTitle' => $parameters['gpu-manufacturer-title']]);
      }

      return $data;
    }

    // destroy methods

    public function destroyVideoCardManufacturer($id)
    {
      $data['deleted'] = false;

      $numOfVideoCards = \DB::table('video_cards') -> where('videoCardManufacturerId', $id) -> count();

      if ($numOfVideoCards == 0)
      {
        $data['deleted'] = true;

        \DB::table('video_cards_manufacturers') -> where('id', $id) -> delete();
      }

      return $data;
    }

    public function destroyVideoCardMemoryType($id)
    {
      $data['deleted'] = false;

      $numOfVideoCards = \DB::table('video_cards') -> where('memoryTypeId', $id) -> count();

      if ($numOfVideoCards == 0)
      {
        $data['deleted'] = true;

        \DB::table('video_cards_memory_types') -> where('id', $id) -> delete();
      }

      return $data;
    }

    public function destroyGraphicsType($id)
    {
      $data['deleted'] = false;

      $numOfComputers = \DB::table('computers') -> where('computerGraphicsId', $id) -> count();

      if ($numOfComputers == 0)
      {
        $data['deleted'] = true;

        \DB::table('computer_graphics') -> where('id', $id) -> delete();
      }

      return $data;
    }

    public function destroyGraphicalProcessorManufacturer($id)
    {
      $data['deleted'] = false;

      $numOfVideoCards = \DB::table('video_cards') -> where('gpuManufacturerId', $id) -> count();

      if ($numOfVideoCards == 0)
      {
        $data['deleted'] = true;

        \DB::table('gpu_manufacturers') -> where('id', $id) -> delete();
      }

      return $data;
    }

    // store methods

    public function storeVideoCardManufacturer(Request $request)
    {
        $data['success'] = false;

        $parameters = $request -> all(); // user input

        $validator = \Validator::make($parameters, ['video-card-manufacturer-title' => 'required|string|min:1|max:100']);

        if (!$validator -> fails())
        {
           $data['success'] = true;

           \DB::table('video_cards_manufacturers') -> insert(['videoCardManufacturerTitle' => $parameters['video-card-manufacturer-title']]);
        }

        return $data;
    }

    public function storeVideoCardMemoryType(Request $request)
    {
      $data['success'] = false;

      $parameters = $request -> all(); // user input

      $validator = \Validator::make($parameters, ['video-memory-type-title' => 'required|string|min:1|max:100']);

      if (!$validator -> fails())
      {
         $data['success'] = true;

         \DB::table('video_cards_memory_types') -> insert(['typeTitle' => $parameters['video-memory-type-title']]);
      }

      return $data;
    }

    public function storeGraphicsType(Request $request)
    {
      $data['success'] = true;

      $parameters = $request -> all(); // user input

      $validator = \Validator::make($parameters, ['computer-graphics-type-title' => 'required|string|min:1|max:100']);

      if (!$validator -> fails())
      {
         $data['success'] = true;

         \DB::table('computer_graphics') -> insert(['graphicsTitle' => $parameters['computer-graphics-type-title']]);
      }

      return $data;
    }

    public function storeGraphicalProcessorManufacturer(Request $request)
    {
      $data['success'] = false;

      $parameters = $request -> all(); // user input

      $validator = \Validator::make($parameters, ['gpu-manufacturer-title' => 'required|string|min:1|max:100']);

      if (!$validator -> fails())
      {
         $data['success'] = true;

         \DB::table('gpu_manufacturers') -> insert(['gpuTitle' => $parameters['gpu-manufacturer-title']]);
      }

      return $data;
    }
}
