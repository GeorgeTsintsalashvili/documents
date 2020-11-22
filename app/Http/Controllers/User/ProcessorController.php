<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BaseDataUpdateRequest;

use App\Http\Requests\UpdateProcessorRequest;
use App\Http\Requests\StoreProcessorRequest;

use App\Rules\NaturalNumber;
use App\Rules\BinaryValue;
use App\Rules\PositiveIntegerOrZero;

use \App\Models\User\Processor;
use \App\Traits\BaseDataUpdatable;
use \App\Traits\RecordDeletable;
use App\Traits\MainImageUpdatable;
use App\Traits\MainImageUploadable;
use App\Traits\CarouselImageUploadable;
use App\Traits\Searchable;

class ProcessorController extends Controller
{
    public function __construct()
    {
       $this -> middleware(['auth', 'verified']);
    }

    public function index(Request $request) // Display a listing of the resource
    {
      $parameters = $request -> only([ 'system-id', 'list-page' ]);
      $rules = [ 'system-id' => ['required', new PositiveIntegerOrZero ],
                 'list-page' => ['required', new NaturalNumber ] ];

      $searchQueryRule = ['search-query' => 'required|string|min:1|max:200'];
      $searchQueryValidator = \Validator::make($request -> only('search-query'), $searchQueryRule);

      $searchQuery = null;
      $listCurrentPage = 1;
      $selectedSystemId = 0;

      $validator = \Validator::make($parameters, $rules);

      if(!$validator -> fails())
      {
        $selectedSystemId = (int) $parameters['system-id'];
        $listCurrentPage = (int) $parameters['list-page'];
      }

      $queryBuilder = \DB::table('processors');

      if(!$searchQueryValidator -> fails())
      {
        $searchQuery = $_POST['search-query'];

        $trimmedSearchQuery = $request -> input('search-query');

        $columns = ['id', 'mainImage', 'title', 'price', 'discount', 'conditionId', 'stockTypeId', 'visibility', 'configuratorPart', 'uuid', 'warrantyDuration', 'warrantyId'];

        $indexedColumns = ['title', 'description'];

        $queryBuilder = Searchable::booleanSearch($queryBuilder, $columns, $trimmedSearchQuery, $indexedColumns);
      }

      if($selectedSystemId != 0) $queryBuilder = $queryBuilder -> where('seriesId', $selectedSystemId);

      $numOfItemsToView = 9;
      $numOfItems = $queryBuilder -> count();

      $paginator = \Paginator::build($numOfItems, 2, $numOfItemsToView, $listCurrentPage, 2, 2);
      $itemsToSkip = ($paginator -> currentPage - 1) * $numOfItemsToView;

      $items = $queryBuilder -> orderBy('id', 'desc') -> skip($itemsToSkip) -> take($numOfItemsToView) -> get();
      $systems = \DB::table('cpu_series') -> get();

      $conditions = \DB::table('conditions') -> get();
      $stockTypes = \DB::table('stock_types') -> get();
      $warranties = \DB::table('warranties') -> get();

      $priceRanges = \DB::table('price_configurations') -> select(['processorMinPrice', 'processorMaxPrice']) -> first();
      $productMinPrice = $priceRanges -> processorMinPrice;
      $productMaxPrice = $priceRanges -> processorMaxPrice;

      $sockets = \DB::table('cpu_sockets') -> get();
      $series = \DB::table('cpu_series') -> get();
      $manufacturers = \DB::table('cpu_manufacturers') -> get();
      $technologyProcesses = \DB::table('cpu_technology_processes') -> get();

      $sockets -> each(function($socket){

          $chipsets = \DB::table('chipsets') -> where('socketId', $socket -> id) -> get();

          $identifiers = $chipsets -> pluck('id') -> toArray();
          $titles = $chipsets -> pluck('chipsetTitle') -> toArray();

          $socket -> chipsetsTitles = implode('|', $titles);
          $socket -> chipsetsIdentifiers = implode('|', $identifiers);
      });

      $warranties = \DB::table('warranties') -> get();

      $items -> each(function($item) use ($warranties){

                $title = $warranties -> where('id', $item -> warrantyId) -> first() -> warrantyPageTitle;

                $item -> warranty = $item -> warrantyDuration . " " . $title;
      });

      return \View::make('contents.user.processors.index') -> with([

            'items' => $items,
            'paginationKey' => 'list-page',
            'paginator' => $paginator,
            'conditions' => $conditions,
            'stockTypes' => $stockTypes,
            'warranties' => $warranties,
            'minPrice' => $productMinPrice,
            'maxPrice' => $productMaxPrice,
            'searchQuery' => $searchQuery,
            'systemsKey' => 'system-id',
            'systems' => $systems,
            'selectedSystemId' => $selectedSystemId,
            'sockets' => $sockets,
            'series' => $series,
            'manufacturers' => $manufacturers,
            'technologyProcesses' => $technologyProcesses
      ]);
    }

    public function store(StoreProcessorRequest $request) // Store a newly created resource in storage
    {
      $data = $request -> validated();

      $response['stored'] = false;

      if($request -> file('mainImage') -> isValid())
      {
        $file = $request -> file('mainImage');

        $fileName = MainImageUploadable::uploadMainImage(Processor::class, $file);

        if($fileName)
        {
          $data['mainImage'] = $fileName;
          $data['description'] = preg_replace('/(\<script(.|\s)*\>(.|\s)*<\/script\>)/si', '', $data['description']);
          $data['configuratorPart'] = $request -> filled('configuratorPart') ? 1 : 0;

          $data['code'] = substr(md5(time()), 0, 12);
          $codeExists = \DB::table('processors') -> where('code', $data['code']) -> count();

          $hash = md5(uniqid(mt_rand(), true));
          $data['uuid'] = substr($hash, 0, 8) . substr($hash, 8, 4) . substr($hash, 12, 4) . substr($hash, 16, 4) . substr($hash, 20, 12);

          while($codeExists)
          {
            $data['code'] = substr(md5(time()), 0, 12);
            $codeExists = \DB::table('processors') -> where('code', $data['code']) -> count();
          }

          $chipsetId = $data['chipsetId'];
          $inputChipsets = explode(',', $chipsetId);

          $object = new Processor();

          $data = \Arr::except($data, ['images', 'chipsetId']);

          foreach($data as $key => $value)
          {
            $object -> $key = $data[$key];
          }

          $object -> save();

          foreach($inputChipsets as $chipset)
          {
            \DB::table('processors_and_chipsets') -> insert(['processorId' => $object -> id, 'chipsetId' => $chipset]);
          }

          if($request -> has('images'))
          {
            $carouselImages = $request -> file('images');

            foreach($carouselImages as $carouselImage)
            {
              if($carouselImage -> isValid())
              {
                CarouselImageUploadable::uploadImage(Processor::class, $object -> id, $carouselImage);
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

        $product = Processor::findOrFail($id);

        $warranties = \DB::table('warranties') -> get();
        $images = \DB::table('processors_images') -> where('processorId', $id) -> get();

        $series = \DB::table('cpu_series') -> get();
        $existentChipsets = \DB::table('processors_and_chipsets') -> join('chipsets', 'chipsetId', '=', 'chipsets.id') -> where('processorId', $product -> id) -> get();
        $restOfChipsets = \DB::table('chipsets') -> where('socketId', $product -> socketId) -> whereNotIn('id', $existentChipsets -> pluck('chipsetId')) -> get();
        $manufacturers = \DB::table('cpu_manufacturers') -> get();
        $technologyProcesses = \DB::table('cpu_technology_processes') -> get();
        $sockets = \DB::table('cpu_sockets') -> get();

        $sockets -> each(function($socket){

            $chipsets = \DB::table('chipsets') -> where('socketId', $socket -> id) -> get();

            $identifiers = $chipsets -> pluck('id') -> toArray();
            $titles = $chipsets -> pluck('chipsetTitle') -> toArray();

            $socket -> chipsetsTitles = implode('|', $titles);
            $socket -> chipsetsIdentifiers = implode('|', $identifiers);
        });

        return \View::make('contents.user.processors.edit') -> with([

            'product' => $product,
            'warranties' => $warranties,
            'images' => $images,
            'productid' => $id,
            'series' => $series,
            'chipsets' => $existentChipsets,
            'restOfChipsets' => $restOfChipsets,
            'sockets' => $sockets,
            'manufacturers' => $manufacturers,
            'technologyProcesses' => $technologyProcesses
        ]);
      }

      catch(\Exception $e){

        return "404 Product Not Found";
      }
    }

    public function update(UpdateProcessorRequest $request) // Update the specified resource in storage
    {
      $data = $request -> validated();

      try{
            $recordId = $data['record-id'];
            $record = Processor::findOrFail($recordId);

            $chipsetId = $data['chipsetId'];
            $inputChipsets = explode(',', $chipsetId);
            $existentChipsets = \DB::table('processors_and_chipsets') -> select(['chipsetId'])
                                                                      -> where('processorId', $recordId)
                                                                      -> get()
                                                                      -> pluck('chipsetId')
                                                                      -> toArray();

            $chipsetsToAdd = array_diff($inputChipsets, $existentChipsets);
            $chipsetsToDelete = array_diff($existentChipsets, $inputChipsets);

            if(count($chipsetsToAdd))
            {
              foreach($chipsetsToAdd as $chipset)

              \DB::table('processors_and_chipsets') -> insert(['processorId' => $recordId, 'chipsetId' => $chipset]);
            }

            if(count($chipsetsToDelete))
            {
              foreach($chipsetsToDelete as $chipset)

              \DB::table('processors_and_chipsets') -> where('processorId', $recordId) -> where('chipsetId', $chipset) -> delete();
            }

            $data = \Arr::except($data, ['record-id', 'chipsetId']);

            $data['description'] = preg_replace('/(\<script(.|\s)*\>(.|\s)*<\/script\>)/si', '', $data['description']);

            foreach($data as $key => $value)
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

        RecordDeletable::deleteRecord(Processor::class, $id);

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

        BaseDataUpdatable::updateBaseData(Processor::class, $data);

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

      if($request -> hasFile('image')) // if file is moved into temporary location by web server
      {
        $response['uploaded'] = true;
        $response['updated'] = false;

        try{
              $rules = [ 'image' => ['required', 'mimes:jpg,jpeg,png', 'max:1024'],
                         'record-id' => ['required', new NaturalNumber] ];

              $validator = \Validator::make($request -> all(), $rules);

              if(!$validator -> fails())
              {
                $file = $request -> file('image');
                $recordId = $request -> input('record-id');

                $imagesSources = MainImageUpdatable::updateImage(Processor::class, $recordId, $file);

                if($imagesSources)
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

      if($request -> hasFile('image')) // if file is moved into temporary location by web server
      {
        $response['uploaded'] = true;

        try{
              $rules = [ 'image' => ['required', 'mimes:jpg,jpeg,png', 'max:1024'],
                         'record-id' => ['required', new NaturalNumber] ];

              $validator = \Validator::make($request -> all(), $rules);

              if(!$validator -> fails())
              {
                $response['testPassed'] = true;

                $file = $request -> file('image');
                $className = Processor::class;
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

      $classBaseName = class_basename(Processor::class);
      $imagesDirectoryName = lcfirst(\Str::plural($classBaseName));
      $imagesTableName = \Str::snake($imagesDirectoryName) . '_images';

      $recordQuery = \DB::table($imagesTableName) -> where('id', $id);

      if($recordQuery -> count() != 0)
      {
         $record = $recordQuery -> first();
         $fileName = $record -> image;

         $recordQuery -> delete();

         $slidesPath = realpath('./images/' . $imagesDirectoryName . '/slides');

         $originalImagesPath = $slidesPath . '/original/';
         $resizedImagesPath = $slidesPath . '/preview/';

         $originalImageFullName = $originalImagesPath . $fileName;
         $resizeImageFullName = $resizedImagesPath . $fileName;

         if(file_exists($originalImageFullName) && file_exists($resizeImageFullName))
         {
           \File::delete($originalImageFullName);
           \File::delete($resizeImageFullName);

           $response['destroyed'] = true;
         }
      }

      return $response;
    }

    // parameters routes

    public function parameters(Request $request)
    {
      $parameters = $request -> only([ 'socket-id', 'chipsets-page' ]);
      $rules = [ 'socket-id' => ['required', new PositiveIntegerOrZero ],
                 'chipsets-page' => ['required', new NaturalNumber ] ];

      $chipsetsCurrentPage = 1;
      $selectedSocketId = 0;

      $validator = \Validator::make($parameters, $rules);

      if(!$validator -> fails())
      {
        $chipsetsCurrentPage = (int) $parameters['chipsets-page'];
        $selectedSocketId = (int) $parameters['socket-id'];
      }

      $sockets = \DB::table('cpu_sockets') -> orderBy('id', 'desc') -> get();
      $systems = \DB::table('cpu_series') -> orderBy('id', 'desc') -> get();
      $technologyProcesses = \DB::table('cpu_technology_processes') -> orderBy('id', 'desc') -> get();
      $chipsetsQueryBuilder = \DB::table('chipsets');

      if($selectedSocketId != 0) $chipsetsQueryBuilder = $chipsetsQueryBuilder -> where('socketId', $selectedSocketId);

      $numOfChipsetsToView = 8;
      $numOfChipsets = $chipsetsQueryBuilder -> count();
      $chipsetsPaginator = \Paginator::build($numOfChipsets, 2, $numOfChipsetsToView, $chipsetsCurrentPage, 2, 2);
      $chipsetsToSkip = ($chipsetsPaginator -> currentPage - 1) * $numOfChipsetsToView;

      $chipsets = $chipsetsQueryBuilder -> orderBy('id', 'desc') -> skip($chipsetsToSkip) -> take($numOfChipsetsToView) -> get();

      return \View::make('contents.user.processors.parameters') -> with([

            'sockets' => $sockets,
            'chipsets' => $chipsets,
            'systems' => $systems,
            'technologyProcesses' => $technologyProcesses,
            'chipsetsPageKey' => 'chipsets-page',
            'chipsetsPaginator' => $chipsetsPaginator,
            'socketsKey' => 'socket-id',
            'selectedSocketId' => $selectedSocketId
      ]);
    }

    // store routes

    public function storeSocket(Request $request)
    {
      $data['success'] = false;

      $parameters = $request -> only(['socketTitle', 'configuratorPart']);
      $rules = [ 'socketTitle' => 'required|string|min:1|max:100',
                 'configuratorPart' => [ new BinaryValue ] ];

      $validator = \Validator::make($parameters, $rules);

      if(!$validator -> fails())
      {
         $data['success'] = true;

         $parameters['configuratorPart'] = $request -> has('configuratorPart') ? 1 : 0;

         \DB::table('cpu_sockets') -> insert($parameters);
      }

      return $data;
    }

    public function storeChipset(Request $request)
    {
      $parameters = $request -> only([ 'chipsetTitle', 'socketId' ]);

      $rules = [ 'chipsetTitle' => 'required|string|min:1|max:100',
                 'socketId' => [ 'required', new NaturalNumber ] ];

      $validator = \Validator::make($parameters, $rules);

      if(!$validator -> fails())
      {
          $socket = \DB::table('cpu_sockets') -> where('id', $parameters['socketId']) -> first();

          if(!is_null($socket))
          {
            \DB::table('chipsets') -> insert($parameters);

            return [ 'success' => true ];
          }
      }

      return [ 'success' => false ];
    }

    public function storeSystem(Request $request)
    {
      $parameters = $request -> only([ 'homePageTitle', 'seriesTitle', 'visibleOnHomePage' ]);

      $rules = [ 'homePageTitle' => 'required|string|min:1|max:100',
                 'seriesTitle' => 'required|string|min:1|max:100',
                 'visibleOnHomePage' => [ new BinaryValue ] ];

      $validator = \Validator::make($parameters, $rules);

      if(!$validator -> fails())
      {
        $parameters['visibleOnHomePage'] = $request -> has('visibleOnHomePage') ? 1 : 0;

        \DB::table('cpu_series') -> insert($parameters);

        return [ 'success' => true ];
      }

      return [ 'success' => false ];
    }

    public function storeTechnologyProcess(Request $request)
    {
      $parameters = $request -> only([ 'size' ]);

      $rules = [ 'size' => 'required|string|min:1|max:100' ];

      $validator = \Validator::make($parameters, $rules);

      if(!$validator -> fails())
      {
          \DB::table('cpu_technology_processes') -> insert($parameters);

          return [ 'success' => true ];
      }

      return [ 'success' => false ];
    }

    // update routes

    public function updateSocket(Request $request)
    {
      $data['updated'] = false;

      $parameters = $request -> only([ 'socketTitle', 'configuratorPart', 'record-id' ]);

      $rules = [ 'socketTitle' => 'required|string|min:1|max:100',
                 'configuratorPart' => [ 'required', new BinaryValue ],
                 'record-id' => [ 'required', new NaturalNumber ] ];

      $validator = \Validator::make($parameters, $rules);

      if(!$validator -> fails())
      {
        $data['updated'] = true;

        \DB::table('cpu_sockets') -> where('id', $parameters['record-id']) -> update(\Arr::except($parameters, 'record-id'));
      }

      return $data;
    }

    public function updateChipset(Request $request)
    {
      $parameters = $request -> only([ 'chipsetTitle', 'socketId', 'record-id' ]);

      $rules = [ 'chipsetTitle' => 'required|string|min:1|max:100',
                 'socketId' => [ 'required', new NaturalNumber ],
                 'record-id' => [ 'required', new NaturalNumber ] ];

      $validator = \Validator::make($parameters, $rules);

      if(!$validator -> fails())
      {
          $socket = \DB::table('cpu_sockets') -> where('id', $parameters['socketId']) -> first();

          if(!is_null($socket))
          {
            \DB::table('chipsets') -> where('id', $parameters['record-id']) -> update(\Arr::except($parameters, 'record-id'));

            return ['updated' => true];
          }
      }

      return ['updated' => false];
    }

    public function updateSystem(Request $request)
    {
      $parameters = $request -> only([ 'homePageTitle', 'seriesTitle', 'visibleOnHomePage', 'record-id' ]);

      $rules = [ 'homePageTitle' => 'required|string|min:1|max:100',
                 'seriesTitle' => 'required|string|min:1|max:100',
                 'visibleOnHomePage' => [ 'required', new BinaryValue ],
                 'record-id' => [ 'required', new NaturalNumber ] ];

      $validator = \Validator::make($parameters, $rules);

      if(!$validator -> fails())
      {
        \DB::table('cpu_series') -> where('id', $parameters['record-id']) -> update(\Arr::except($parameters, 'record-id'));

        return ['updated' => true];
      }

      return ['updated' => false];
    }

    public function updateTechnologyProcess(Request $request)
    {
      $parameters = $request -> only([ 'size', 'record-id' ]);

      $rules = [ 'size' => 'required|string|min:1|max:100',
                 'record-id' => [ 'required', new NaturalNumber ] ];

      $validator = \Validator::make($parameters, $rules);

      if(!$validator -> fails())
      {
         \DB::table('cpu_technology_processes') -> where('id', $parameters['record-id']) -> update(\Arr::except($parameters, 'record-id'));

         return ['updated' => true];
      }

      return ['updated' => false];
    }

    // destroy routes

    public function destroySocket($id)
    {
      try{

          \DB::table('cpu_sockets') -> where('id', $id) -> delete();

          return ['deleted' => true];
      }

      catch(\Exception $e){

        return ['deleted' => false];
      }
    }

    public function destroyChipset($id)
    {
      try{

          \DB::table('chipsets') -> where('id', $id) -> delete();

          return ['deleted' => true];
      }

      catch(\Exception $e){

        return ['deleted' => false];
      }
    }

    public function destroySystem($id)
    {
      try{

          \DB::table('cpu_series') -> where('id', $id) -> delete();

          return ['deleted' => true];
      }

      catch(\Exception $e){

        return ['deleted' => false];
      }
    }

    public function destroyTechnologyProcess($id)
    {
      try{

          \DB::table('cpu_technology_processes') -> where('id', $id) -> delete();

          return ['deleted' => true];
      }

      catch(\Exception $e){

        return ['deleted' => false];
      }
    }
}
