<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Configurator extends Model
{
    // get computer parts

    public function getProcessorsData($request)
    {
      $data['series'] = \DB::table('cpu_series') -> get();
      $data['filter-parameter'] = 0;

      $fields = ['processors.id', 'title', 'mainImage', 'price', 'discount', 'quantity', 'conditionTitle', 'stockTitle', 'clockSpeed', 'cores', 'socketTitle', 'size'];

      $query = \DB::table('processors') -> select($fields)
                                        -> join('cpu_sockets', 'cpu_sockets.id', '=', 'processors.socketId')
                                        -> join('conditions', 'conditions.id', '=', 'processors.conditionId')
                                        -> join('stock_types', 'stock_types.id', '=', 'processors.stockTypeId')
                                        -> join('cpu_technology_processes', 'cpu_technology_processes.id', '=', 'processors.technologyProcessId')
                                        -> join('processors_and_chipsets', 'processors.id', '=', 'processors_and_chipsets.processorId')
                                        -> where('visibility', 1)
                                        -> where('processors.configuratorPart', '=', 1)
                                        -> where('cpu_sockets.configuratorPart', '=', 1)
                                        -> where('stock_types.configuratorPart', '=', 1);

      // request data validation logic

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['filter-parameter' => 'required']);

      if(!$validator -> fails())
      {
        $filterParameterValue = abs((int) $parameters['filter-parameter']);

        if($filterParameterValue != 0)
        {
          $query = $query -> where('seriesId', '=', $filterParameterValue);

          $data['filter-parameter'] = $filterParameterValue;
        }
      }

      $data['partsExist'] = $query -> count() != 0;
      $data['products'] = $query -> groupBy('processorId') -> orderBy('price', 'desc') -> get();

      return $data;
    }

    public function getMotherboardsData($request)
    {
      $solidStateDrivesFormFactors = \DB::table('solid_state_drives_form_factors') -> select(['id']) -> get();
      $memoryTypes = \DB::table('memory_modules_types') -> select(['id']) -> get();
      $formFactors = \DB::table('case_form_factors') -> select(['id']) -> get();
      $chipsets = \DB::table('chipsets') -> select(['id']) -> get();

      $data['manufacturers'] = \DB::table('motherboards_manufacturers') -> get();
      $data['filter-parameter'] = 0;

      $fields = ['motherboards.id', 'title', 'mainImage', 'price', 'discount', 'quantity', 'conditionTitle', 'stockTitle', 'socketTitle', 'manufacturerTitle', 'formFactorTitle', 'typeTitle', 'chipsetTitle', 'maxMemory', 'ramSlots'];

      $query = \DB::table('motherboards') -> select($fields)
                                          -> join('conditions', 'conditions.id', '=', 'motherboards.conditionId')
                                          -> join('stock_types', 'stock_types.id', '=', 'motherboards.stockTypeId')
                                          -> join('cpu_sockets', 'cpu_sockets.id', '=', 'motherboards.socketId')
                                          -> join('chipsets', 'chipsets.id', '=', 'motherboards.chipsetId')
                                          -> join('memory_modules_types', 'memory_modules_types.id', '=', 'motherboards.memoryTypeId')
                                          -> join('case_form_factors', 'case_form_factors.id', '=', 'motherboards.formFactorId')
                                          -> join('solid_state_drives_and_motherboards', 'motherboards.id', '=', 'solid_state_drives_and_motherboards.motherboardId')
                                          -> join('motherboards_manufacturers', 'motherboards_manufacturers.id', '=', 'motherboards.manufacturerId')
                                          -> where('visibility', 1)
                                          -> where('motherboards.configuratorPart', '=', 1)
                                          -> where('cpu_sockets.configuratorPart', '=', 1)
                                          -> where('stock_types.configuratorPart', '=', 1);

      // request data validation

      $parameters = $request -> all();

      $filterValidator = \Validator::make($parameters, ['filter-parameter' => 'required']);
      $chipsetValidator = \Validator::make($parameters, ['chipset' => 'required']);

      if(!$filterValidator -> fails())
      {
        $manufacturerId = abs((int) $parameters['filter-parameter']);

        if($manufacturerId != 0)
        {
          $query = $query -> where('manufacturerId', '=', $manufacturerId);

          $data['filter-parameter'] = $manufacturerId;
        }
      }

      if(!$chipsetValidator -> fails())
      {
        $chipset = $parameters['chipset'];

        if($parameters['chipset'] !== '0')
        {
          $chipsetParts = array_map('intval', explode(':', $parameters['chipset']));

          if(count($chipsetParts) != 0 && !in_array(0, $chipsetParts))
          {
            $realChipsets = \DB::table('chipsets') -> select(['id']) -> get();

            $realChipsetsIdentifiers = [];

            foreach($realChipsets as $chipset) $realChipsetsIdentifiers[] = $chipset -> id;

            if(count($realChipsetsIdentifiers) != 0)
            {
              $chipsetParts = array_unique($chipsetParts);

              if(array_intersect($chipsetParts, $realChipsetsIdentifiers) == $chipsetParts)

              $query = $query -> whereIn('chipsetId', $chipsetParts);
            }
          }
        }
      }

      $data['partsExist'] = $query -> count() != 0;
      $data['products'] = $query -> groupBy('motherboardId') -> orderBy('price', 'desc') -> get();

      return $data;
    }

    public function getMemoriesData($request)
    {
      $data['partsExist'] = false;
      $data['filter-parameter'] = 0;

      $maxMemory = 0;
      $memorySlots = 0;

      $field = ['function' => 'distinct', 'argument' => 'capacity', 'alias' => 'capacity'];
      $data['capacities'] = \DB::table('memory_modules') -> select(\DB::raw('DISTINCT(`capacity`) AS `capacity`'))
                                                         -> where('visibility', 1)
                                                         -> where('configuratorPart', '=', 1)
                                                         -> orderBy('capacity', 'asc')
                                                         -> get();

      $fields = '`memory_modules`.`id`,`title`,`mainImage`,`price`,`discount`,`code`,`conditionTitle`,`quantity`,`stockTitle`,`typeTitle`,`frequency`,`capacity`,`isCouple`,IF(`isCouple` != 0, 2, 1) AS `units`';

      $query = \DB::table('memory_modules') -> selectRaw($fields)
                                            -> join('conditions', 'conditions.id', '=', 'memory_modules.conditionId')
                                            -> join('stock_types', 'stock_types.id', '=', 'memory_modules.stockTypeId')
                                            -> join('memory_modules_types', 'memory_modules_types.id', '=', 'memory_modules.memoryModuleTypeId')
                                            -> where('memory_modules.configuratorPart', 1)
                                            -> where('stock_types.configuratorPart', 1)
                                            -> where('visibility', 1);

      // request data validation

      $parameters = $request -> all();

      $filterValidator = \Validator::make($parameters, ['filter-parameter' => 'required']);
      $memoryValidator = \Validator::make($parameters, ['memory-type' => 'required',
                                                        'max-memory' => 'required',
                                                        'memory-slots' => 'required']);

      if(!$filterValidator -> fails())
      {
        $capacity = abs((int) $parameters['filter-parameter']);

        if($capacity != 0)
        {
          $query = $query -> where('capacity', '=', $capacity);

          $data['filter-parameter'] = $capacity;
        }
      }

      if(!$memoryValidator -> fails())
      {
        $memoryType = abs((int) $parameters['memory-type']);
        $maxMemory = abs((int) $parameters['max-memory']);
        $memorySlots = abs((int) $parameters['memory-slots']);

        if($memoryType != 0)
        {
          $realMemoryTypes = \DB::table('memory_modules_types') -> select(['id']) -> get();

          $realMemoryTypesIdentifiers = [];

          foreach($realMemoryTypes as $type) $realMemoryTypesIdentifiers[] = $type -> id;

          if(in_array($memoryType, $realMemoryTypesIdentifiers))

          $query = $query -> where('memoryModuleTypeId', '=', $memoryType);
        }

        if($maxMemory != 0) $query = $query -> where('capacity', '<=', $maxMemory);
      }

      $data['partsExist'] = $query -> count() != 0;
      $data['products'] = $query -> orderBy('capacity', 'desc') -> get();

      if($data['partsExist'] && $memorySlots != 0)
      {
        foreach($data['products'] as $key => $product)

        $data['products'][$key] -> units = $memorySlots / $product -> units;
      }

      return $data;
    }

    public function getProcessorCoolersData($request)
    {
      $data['partsExist'] = false;

      $fields = '`processor_coolers`.`id`,`title`,`mainImage`,`price`,`discount`,`quantity`,`code`,`conditionTitle`,`stockTitle`,`size`,GROUP_CONCAT(`socketTitle` SEPARATOR ", ") AS `socketTitle`';

      $query = \DB::table('processor_coolers') -> selectRaw($fields)
                                               -> join('conditions', 'conditions.id', '=', 'processor_coolers.conditionId')
                                               -> join('stock_types', 'stock_types.id', '=', 'processor_coolers.stockTypeId')
                                               -> join('processor_coolers_and_sockets', 'processor_coolers.id', '=', 'processor_coolers_and_sockets.processorCoolerId')
                                               -> join('cpu_sockets', 'cpu_sockets.id', '=', 'processor_coolers_and_sockets.socketId')
                                               -> where('visibility', 1)
                                               -> where('processor_coolers.configuratorPart', '=', 1)
                                               -> where('cpu_sockets.configuratorPart', '=', 1);

      // request data validation

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['cpu-socket' => 'required']);

      if(!$validator -> fails())
      {
        $cpuSocketId = abs((int) $parameters['cpu-socket']);

        if($cpuSocketId != 0)
        {
          $realSockets = \DB::table('cpu_sockets') -> select(['id']) -> where('configuratorPart', '=', 1) -> get();

          $realSocketsIdentifiers = [];

          foreach($realSockets as $socket) $realSocketsIdentifiers[] = $socket -> id;

          if(in_array($cpuSocketId, $realSocketsIdentifiers)) $query = $query -> where('socketId', '=', $cpuSocketId);
        }
      }

      $data['partsExist'] = $query -> count() != 0;
      $data['products'] = $query -> groupBy('processorCoolerId') -> orderBy('price', 'desc') -> get();

      return $data;
    }

    public function getCasesData($request)
    {
      $data['partsExist'] = false;

      $fields = ['computer_cases.id', 'title', 'mainImage', 'price', 'discount', 'quantity', 'conditionTitle', 'stockTitle'];

      $query = \DB::table('computer_cases') -> select($fields)
                                            -> join('conditions', 'conditions.id', '=', 'computer_cases.conditionId')
                                            -> join('stock_types', 'stock_types.id', '=', 'computer_cases.stockTypeId')
                                            -> join('cases_and_form_factors', 'computer_cases.id', '=', 'cases_and_form_factors.caseId')
                                            -> where('visibility', 1)
                                            -> where('computer_cases.configuratorPart', '=', 1);

      // request data validation

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['form-factor' => 'required']);

      if(!$validator -> fails())
      {
        $formFactor = abs((int) $parameters['form-factor']);

        if($formFactor != 0)
        {
          $realFormFactors = \DB::table('case_form_factors') -> select(['id']) -> get();

          $realFormFactorsIdentifiers = [];

          foreach($realFormFactors as $formFactorType) $realFormFactorsIdentifiers[] = $formFactorType -> id;

          if(in_array($formFactor, $realFormFactorsIdentifiers))
          {
            $query = $query -> where('formFactorId', '=', $formFactor);
          }
        }
      }

      $data['partsExist'] = $query -> count() != 0;
      $data['products'] = $query -> groupBy('computer_cases.id') -> orderBy('price', 'desc') -> get();

      if($data['partsExist'])
      {
        foreach($data['products'] as $key => $product)
        {
          $supportedFormFactors = \DB::table('cases_and_form_factors') -> select(['formFactorTitle'])
                                                                       -> join('case_form_factors', 'case_form_factors.id', '=', 'cases_and_form_factors.formFactorId')
                                                                       -> where('caseId', '=', $product -> id)
                                                                       -> get();
          $suppportedFormFactorsFullTitle = '';
          $supportedFormFactorsTitles = [];

          foreach($supportedFormFactors as $supportedFormFactor) $supportedFormFactorsTitles[] = $supportedFormFactor -> formFactorTitle;

          if(count($supportedFormFactorsTitles) != 0) $suppportedFormFactorsFullTitle = implode(', ', $supportedFormFactorsTitles);

          $data['products'][$key] -> formFactorTitle = $suppportedFormFactorsFullTitle;
        }
      }

      return $data;
    }

    public function getPowerSuppliesData($request)
    {
      $data['partsExist'] = false;

      $fields = ['power_supplies.id', 'title', 'mainImage', 'price', 'discount', 'quantity', 'conditionTitle', 'stockTitle', 'power'];

      $query = \DB::table('power_supplies') -> select($fields)
                                            -> join('conditions', 'conditions.id', '=', 'power_supplies.conditionId')
                                            -> join('stock_types', 'stock_types.id', '=', 'power_supplies.stockTypeId')
                                            -> where('visibility', 1)
                                            -> where('power_supplies.configuratorPart', '=', 1);

      // request data validation

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['required-power' => 'required']);

      if(!$validator -> fails())
      {
        $requiredPower = abs((int) $parameters['required-power']);

        if($requiredPower != 0) $query = $query -> where('power', '>=', $requiredPower);
      }

      $data['partsExist'] = $query -> count() != 0;
      $data['products'] = $query -> orderBy('price', 'desc') -> get();

      return $data;
    }

    public function getVideoCardsData($request)
    {
      $data['partsExist'] = false;
      $data['filter-parameter'] = 0;

      $data['memories'] = \DB::table('video_cards') -> selectRaw('DISTINCT(`memory`) AS `memory`')
                                                    -> where('visibility', 1)
                                                    -> where('configuratorPart', '=', 1)
                                                    -> orderBy('memory', 'asc')
                                                    -> get();

      $fields = ['video_cards.id', 'title', 'mainImage', 'price', 'discount', 'quantity', 'conditionTitle', 'stockTitle', 'memory', 'memoryBandwidth', 'typeTitle', 'gpuTitle', 'minPower'];

      $query = \DB::table('video_cards') -> select($fields)
                                         -> join('conditions', 'conditions.id', '=', 'video_cards.conditionId')
                                         -> join('stock_types', 'stock_types.id', '=', 'video_cards.stockTypeId')
                                         -> join('video_cards_memory_types', 'video_cards_memory_types.id', '=', 'video_cards.memoryTypeId')
                                         -> join('gpu_manufacturers', 'gpu_manufacturers.id', '=', 'video_cards.gpuManufacturerId')
                                         -> where('visibility', 1)
                                         -> where('video_cards.configuratorPart', '=', 1);

      // request data validation logic

      $parameters = $request -> all();

      $filterValidator = \Validator::make($parameters, ['filter-parameter' => 'required']);
      $powerValidator = \Validator::make($parameters, ['required-power' => 'required']);

      if(!$filterValidator -> fails())
      {
        $filterParameterValue = abs((int) $parameters['filter-parameter']);

        if($filterParameterValue != 0)
        {
          $query = $query -> where('memory', '=', $filterParameterValue);

          $data['filter-parameter'] = $filterParameterValue;
        }
      }

      if(!$powerValidator -> fails())
      {
        $requiredPower = abs((int) $parameters['required-power']);

        if($requiredPower != 0) $query = $query -> where('minPower', '<=', $requiredPower);
      }

      $data['partsExist'] = $query -> count() != 0;
      $data['products'] = $query -> orderBy('price', 'desc') -> get();

      return $data;
    }

    public function getHardDiskDrivesData($request)
    {
      $data['partsExist'] = false;
      $data['filter-parameter'] = 0;

      $data['capacities'] = \DB::table('hard_disk_drives') -> selectRaw('DISTINCT(`capacity`) AS `capacity`')
                                                           -> where('visibility', 1)
                                                           -> where('configuratorPart', '=', 1)
                                                           -> orderBy('capacity', 'asc')
                                                           -> get();

      $fields = ['hard_disk_drives.id', 'title', 'mainImage', 'price', 'discount', 'quantity', 'conditionTitle', 'stockTitle', 'capacity', 'rpm', 'formFactorTitle'];

      $query = \DB::table('hard_disk_drives') -> select($fields)
                                              -> join('conditions', 'conditions.id', '=', 'hard_disk_drives.conditionId')
                                              -> join('stock_types', 'stock_types.id', '=', 'hard_disk_drives.stockTypeId')
                                              -> join('hard_disk_drives_form_factors', 'hard_disk_drives_form_factors.id', '=', 'hard_disk_drives.formFactorId')
                                              -> where('visibility', 1)
                                              -> where('hard_disk_drives.configuratorPart', '=', 1);

      // request data validation logic

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['filter-parameter' => 'required']);

      if(!$validator -> fails())
      {
        $filterParameterValue = abs((int) $parameters['filter-parameter']);

        if($filterParameterValue != 0)
        {
          $query = $query -> where('capacity', '=', $filterParameterValue);

          $data['filter-parameter'] = $filterParameterValue;
        }
      }

      $data['partsExist'] = $query -> count() != 0;
      $data['products'] = $query -> orderBy('price', 'desc') -> get();

      return $data;
    }

    public function getSolidStateDrivesData($request)
    {
      $data['partsExist'] = false;
      $data['filter-parameter'] = 0;

      $data['capacities'] = \DB::table('solid_state_drives') -> selectRaw('DISTINCT(`capacity`) AS `capacity`')
                                                             -> where('visibility', 1)
                                                             -> where('configuratorPart', '=', 1)
                                                             -> orderBy('capacity', 'asc')
                                                             -> get();

      $fields = ['solid_state_drives.id', 'title', 'mainImage', 'price', 'discount', 'quantity', 'conditionTitle', 'stockTitle', 'capacity', 'formFactorTitle'];

      $query = \DB::table('solid_state_drives') -> select($fields)
                                                -> join('conditions', 'conditions.id', '=', 'solid_state_drives.conditionId')
                                                -> join('stock_types', 'stock_types.id', '=', 'solid_state_drives.stockTypeId')
                                                -> join('solid_state_drives_form_factors', 'solid_state_drives_form_factors.id', '=', 'solid_state_drives.formFactorId')
                                                -> where('visibility', 1)
                                                -> where('solid_state_drives.configuratorPart', '=', 1);

      // request data validation logic

      $parameters = $request -> all();

      $filterValidator = \Validator::make($parameters, ['filter-parameter' => 'required']);

      $typeValidator = \Validator::make($parameters, ['ssd-type' => 'required']);

      if(!$filterValidator -> fails())
      {
        $filterParameterValue = abs((int) $parameters['filter-parameter']);

        if($filterParameterValue != 0)
        {
          $query = $query -> where('capacity', '=', $filterParameterValue);

          $data['filter-parameter'] = $filterParameterValue;
        }
      }

      if(!$typeValidator -> fails())
      {
        $ssdType = $parameters['ssd-type'];

        if($parameters['ssd-type'] !== "0")
        {
          $ssdTypesParts = array_map('intval', explode(':', $ssdType));

          if(count($ssdTypesParts) != 0 && !in_array(0, $ssdTypesParts))
          {
            $realSsdTypes = \DB::table('solid_state_drives_form_factors') -> select(['id']) -> get();

            $realSsdTypesIdentifiers = [];

            foreach($realSsdTypes as $ssdType) $realSsdTypesIdentifiers[] = $ssdType -> id;

            $ssdTypesParts = array_unique($ssdTypesParts);

            if(array_intersect($ssdTypesParts, $realSsdTypesIdentifiers) == $ssdTypesParts)

            $query = $query -> whereIn('formFactorId', $ssdTypesParts);
          }
        }
      }

      $data['partsExist'] = $query -> count() != 0;
      $data['products'] = $query -> orderBy('price', 'desc') -> get();

      return $data;
    }

    // select computer part

    public function getSelectProcessorData($request)
    {
      $data['partExists'] = false;
      $data['price'] = 0;
      $data['discount'] = 0;

      // compatibility data

      $data['chipset'] = null;
      $data['socket'] = null;

      // request data validation logic

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['part-id' => 'required']);

      if(!$validator -> fails())
      {
         $partId = abs((int) $parameters['part-id']);

         if($partId != 0)
         {
           $fieldsToSelect = ['price', 'discount', 'id', 'socketId'];

           $computerPart = \DB::table('processors') -> select($fieldsToSelect) -> where('id', '=', $partId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> first();

           if(!is_null($computerPart))
           {
             $data['partExists'] = true;
             $data['price'] = $computerPart -> price;
             $data['discount'] = $computerPart -> discount;
             $data['socket'] = $computerPart -> socketId;

             $supportedChipsets = \DB::table('processors_and_chipsets') -> select(['chipsetId']) -> where('processorId', '=', $partId) -> get();
             $chipsetsIdentifiers = [];

             foreach($supportedChipsets as $chipset) $chipsetsIdentifiers[] = $chipset -> chipsetId;

             $data['chipset'] = implode(":", $chipsetsIdentifiers);
           }
         }
      }

      return $data;
    }

    public function getSelectMotherboardData($request)
    {
      $data['partExists'] = false;
      $data['price'] = 0;
      $data['discount'] = 0;

      // compatibility data

      $data['memory-type'] = null;
      $data['max-memory'] = null;
      $data['memory-slots'] = null;
      $data['form-factor'] = null;
      $data['ssd-type'] = null;

      // request data validation logic

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['part-id' => 'required']);

      if(!$validator -> fails())
      {
         $partId = abs((int) $parameters['part-id']);

         if($partId != 0)
         {
           $fieldsToSelect = ['motherboards.id', 'price', 'discount', 'formFactorId', 'maxMemory', 'ramSlots', 'memoryTypeId'];

           $computerPart = \DB::table('motherboards') -> select($fieldsToSelect) -> where('id', '=', $partId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> first();

           if(!is_null($computerPart))
           {
             $data['partExists'] = true;
             $data['price'] = $computerPart -> price;
             $data['discount'] = $computerPart -> discount;
             $data['form-factor'] = $computerPart -> formFactorId;
             $data['memory-slots'] = $computerPart -> ramSlots;
             $data['max-memory'] = $computerPart -> maxMemory;
             $data['memory-type'] = $computerPart -> memoryTypeId;

             $supportedSolidStateDrivesTypes = \DB::table('solid_state_drives_and_motherboards') -> select(['solidStateDriveTypeId']) -> where('motherboardId', '=', $partId) -> get();
             $solidStateDrivesTypesIdentifiers = [];

             foreach($supportedSolidStateDrivesTypes as $ssdType) $solidStateDrivesTypesIdentifiers[] = $ssdType -> solidStateDriveTypeId;

             $data['ssd-type'] = implode(":", $solidStateDrivesTypesIdentifiers);
           }
         }
      }

      return $data;
    }

    public function getSelectMemoryData($request)
    {
      $data['partExists'] = false;
      $data['price'] = 0;
      $data['discount'] = 0;

      // request data validation logic

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['part-id' => 'required',
                                                  'quantity' => 'required']);

      if(!$validator -> fails())
      {
         $partId = abs((int) $parameters['part-id']);
         $quantity = abs((int) $parameters['quantity']);

         if($partId != 0 && $quantity != 0)
         {
           $fieldsToSelect = ['price', 'discount', 'id'];

           $computerPart = \DB::table('memory_modules') -> select($fieldsToSelect) -> where('id', '=', $partId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> first();

           if(!is_null($computerPart))
           {
             $data['partExists'] = true;
             $data['price'] = $computerPart -> price * $quantity;
             $data['discount'] = $computerPart -> discount * $quantity;
           }
         }
      }

      return $data;
    }

    public function getSelectProcessorCoolerData($request)
    {
      $data['partExists'] = false;
      $data['price'] = 0;
      $data['discount'] = 0;

      // request data validation logic

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['part-id' => 'required']);

      if(!$validator -> fails())
      {
         $partId = abs((int) $parameters['part-id']);

         if($partId != 0)
         {
           $fieldsToSelect = ['price', 'discount', 'id'];

           $computerPart = \DB::table('processor_coolers') -> select($fieldsToSelect) -> where('id', '=', $partId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> first();

           if(!is_null($computerPart))
           {
             $data['partExists'] = true;
             $data['price'] = $computerPart -> price;
             $data['discount'] = $computerPart -> discount;
           }
         }
      }

      return $data;
    }

    public function getSelectCaseData($request)
    {
      $data['partExists'] = false;
      $data['price'] = 0;
      $data['discount'] = 0;

      // request data validation logic

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['part-id' => 'required']);

      if(!$validator -> fails())
      {
         $partId = abs((int) $parameters['part-id']);

         if($partId != 0)
         {
           $fieldsToSelect = ['price', 'discount', 'id'];

           $computerPart = \DB::table('computer_cases') -> select($fieldsToSelect) -> where('id', '=', $partId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> first();

           if(!is_null($computerPart))
           {
             $data['partExists'] = true;
             $data['price'] = $computerPart -> price;
             $data['discount'] = $computerPart -> discount;
           }
         }
      }

      return $data;
    }

    public function getSelectPowerSupplyData($request)
    {
      $data['partExists'] = false;
      $data['price'] = 0;
      $data['discount'] = 0;

      // compatibility data

      $data['required-power'] = 0;

      // request data validation logic

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['part-id' => 'required']);

      if(!$validator -> fails())
      {
         $partId = abs((int) $parameters['part-id']);

         if($partId != 0)
         {
           $fieldsToSelect = ['price', 'discount', 'id', 'power'];

           $computerPart = \DB::table('power_supplies') -> select($fieldsToSelect) -> where('id', '=', $partId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> first();

           if(!is_null($computerPart))
           {
             $data['partExists'] = true;
             $data['price'] = $computerPart -> price;
             $data['discount'] = $computerPart -> discount;
             $data['required-power'] = $computerPart -> power;
           }
         }
      }

      return $data;
    }

    public function getSelectVideoCardData($request)
    {
      $data['partExists'] = false;
      $data['price'] = 0;
      $data['discount'] = 0;

      // compatibility data

      $data['required-power'] = 0;

      // request data validation logic

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['part-id' => 'required']);

      if(!$validator -> fails())
      {
         $partId = abs((int) $parameters['part-id']);

         if($partId != 0)
         {
           $fieldsToSelect = ['price', 'discount', 'id', 'minPower'];

           $computerPart = \DB::table('video_cards') -> select($fieldsToSelect) -> where('id', '=', $partId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> first();

           if(!is_null($computerPart))
           {
             $data['partExists'] = true;
             $data['price'] = $computerPart -> price;
             $data['discount'] = $computerPart -> discount;
             $data['required-power'] = $computerPart -> minPower;
           }
         }
      }

      return $data;
    }

    public function getSelectHardDiskDriveData($request)
    {
      $data['partExists'] = false;
      $data['price'] = 0;
      $data['discount'] = 0;

      // request data validation logic

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['part-id' => 'required']);

      if(!$validator -> fails())
      {
         $partId = abs((int) $parameters['part-id']);

         if($partId != 0)
         {
           $fieldsToSelect = ['price', 'discount', 'id'];

           $computerPart = \DB::table('hard_disk_drives') -> select($fieldsToSelect) -> where('id', '=', $partId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> first();

           if(!is_null($computerPart))
           {
             $data['partExists'] = true;
             $data['price'] = $computerPart -> price;
             $data['discount'] = $computerPart -> discount;
           }
         }
      }

      return $data;
    }

    public function getSelectSolidStateDriveData($request)
    {
      $data['partExists'] = false;
      $data['price'] = 0;
      $data['discount'] = 0;

      // request data validation logic

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ['part-id' => 'required']);

      if(!$validator -> fails())
      {
         $partId = abs((int) $parameters['part-id']);

         if($partId != 0)
         {
           $fieldsToSelect = ['price', 'discount', 'id'];

           $computerPart = \DB::table('solid_state_drives') -> select($fieldsToSelect) -> where('id', '=', $partId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> first();

           if(!is_null($computerPart))
           {
             $data['partExists'] = true;
             $data['price'] = $computerPart -> price;
             $data['discount'] = $computerPart -> discount;
           }
         }
      }

      return $data;
    }

  // document generation logic

  function getDocumentData($request)
  {
    $data['documentHtmlText'] = 'Configuration Is Empty';
    $data['documentName'] = 'itworks';

    // request data validation logic

    $parameters = $request -> all();

    $validator = \Validator::make($parameters, ['configuration' => 'required']);

    if(!$validator -> fails())
    {
      $configurationParameterValue = $parameters['configuration'];

      $templateName = base_path() . '/resources/views/contents/site/configurator/document.blade.php';

      if(file_exists($templateName))
      {
        $configurationParameterValueParts = explode(':', $configurationParameterValue);

        if(count($configurationParameterValueParts) == 9)
        {
          $memoryPart = $configurationParameterValueParts[0];

          $memoryParts = explode('-', $memoryPart);

          if(count($memoryParts) == 2)
          {
            $memories = abs((int) $memoryParts[0]);
            $memoryId = abs((int) $memoryParts[1]);

            if($memories != 0 && $memoryId != 0)
            {
              $stockTypes = \DB::table('stock_types') -> select(['id']) -> where('configuratorPart', '=', 1) -> get();
              $stockTypesIdentifiers = [];

              foreach($stockTypes as $stockType) $stockTypesIdentifiers[] = $stockType -> id;

              if(count($stockTypesIdentifiers) != 0)
              {
                $memoryFields = ['title', 'price', 'discount', 'isCouple'];
                $memory = \DB::table('memory_modules') -> select($memoryFields)
                                                       -> where('id', '=', $memoryId)
                                                       -> where('visibility', 1)
                                                       -> where('configuratorPart', '=', 1)
                                                       -> whereIn('stockTypeId', $stockTypesIdentifiers)
                                                       -> first();

                if(!is_null($memory))
                {
                  $processorId = abs((int) $configurationParameterValueParts[1]);
                  $motherboardId = abs((int) $configurationParameterValueParts[2]);

                  if($processorId != 0 && $motherboardId != 0)
                  {
                    $processorFields = ['title', 'price', 'discount'];
                    $processor = \DB::table('processors') -> select($processorFields)
                                                          -> where('id', '=', $processorId)
                                                          -> where('visibility', 1)
                                                          -> where('configuratorPart', '=', 1)
                                                          -> whereIn('stockTypeId', $stockTypesIdentifiers)
                                                          -> first();

                    $motherboardFields = ['title', 'price', 'discount', 'ramSlots'];

                    $motherboard = \DB::table('motherboards') -> select($motherboardFields)
                                                              -> where('id', '=', $motherboardId)
                                                              -> where('visibility', 1)
                                                              -> where('configuratorPart', '=', 1)
                                                              -> whereIn('stockTypeId', $stockTypesIdentifiers)
                                                              -> first();

                    if(!is_null($motherboard) && !is_null($processor))
                    {
                      $memoryUnitsProvidedByUser = ($memory -> isCouple ? 2 : 1) * $memories;

                      if($memoryUnitsProvidedByUser <=  $motherboard -> ramSlots)
                      {
                        // contact information data

                        $email = 'არ არის მითითებული';
                        $phone = 'არ არის მითითებული';
                        $address = 'არ არის მითითებული';
                        $schedule = 'არ არის მითითებული';

                        // key logic

                        $numberOfPartsSelectedByUser = 3;
                        $assemblyPrice = 0;
                        $overalPrice = 0;
                        $overalOldPrice = 0;
                        $overalOldPriceVisibility = 'none';

                        // optional parts identifiers

                        $videoCardId = abs((int) $configurationParameterValueParts[3]);
                        $powerSupplyId = abs((int) $configurationParameterValueParts[4]);
                        $processorCoolerId = abs((int) $configurationParameterValueParts[5]);
                        $caseId = abs((int) $configurationParameterValueParts[6]);
                        $hardDiskDriveId = abs((int) $configurationParameterValueParts[7]);
                        $solidStateDiskDriveId = abs((int) $configurationParameterValueParts[8]);

                        // system block parts titles

                        $processorTitle = $processor -> title;
                        $motherboardTitle = $motherboard -> title;
                        $memoryTitle = $memory -> title;
                        $videoCardTitle = 'არ არის არჩეული';
                        $powerSupplyTitle = 'არ არის არჩეული';
                        $processorCoolerTitle = 'არ არის არჩეული';
                        $caseTitle = 'არ არის არჩეული';
                        $hardDiskDriveTitle = 'არ არის არჩეული';
                        $solidStateDriveTitle = 'არ არის არჩეული';

                        // system block parts new prices

                        $processorPrice = $processor -> price - $processor -> discount;
                        $motherboardPrice = $motherboard -> price - $motherboard -> discount;
                        $memoryPrice = $memories * ($memory -> price - $memory -> discount);
                        $videoCardPrice = 0;
                        $powerSupplyPrice = 0;
                        $processorCoolerPrice = 0;
                        $casePrice = 0;
                        $hardDiskDrivePrice = 0;
                        $solidStateDrivePrice = 0;

                        // system block parts old prices

                        $processorOldPrice = $processor -> price;
                        $motherboardOldPrice = $motherboard -> price;
                        $memoryOldPrice = $memories * $memory -> price;
                        $videoCardOldPrice = 0;
                        $powerSupplyOldPrice = 0;
                        $processorCoolerOldPrice = 0;
                        $caseOldPrice = 0;
                        $hardDiskDriveOldPrice = 0;
                        $solidStateDriveOldPrice = 0;

                        // discounts visibilities

                        $processorDiscountVisibility = $processor -> discount == 0 ? 'none' : 'inline';
                        $motherboardDiscountVisibility = $motherboard -> discount == 0 ? 'none' : 'inline';
                        $memoryDiscountVisibility = $memories * $memory -> discount == 0 ? 'none' : 'inline';
                        $videoCardDiscountVisibility = 'none';
                        $powerSupplyDiscountVisibility = 'none';
                        $processorCoolerDiscountVisibility = 'none';
                        $caseDiscountVisibility = 'none';
                        $hardDiskDriveDiscountVisibility = 'none';
                        $solidStateDriveDiscountVisibility = 'none';

                        // initialize optional parts fields

                        $optionalPartsfields = ['title', 'price', 'discount'];

                        // select optional parts

                        $videoCard = \DB::table('video_cards') -> select($optionalPartsfields) -> where('id', '=', $videoCardId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> whereIn('stockTypeId', $stockTypesIdentifiers) -> first();
                        $powerSupply = \DB::table('power_supplies') -> select($optionalPartsfields) -> where('id', '=', $powerSupplyId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> whereIn('stockTypeId', $stockTypesIdentifiers) -> first();
                        $processorCooler = \DB::table('processor_coolers') -> select($optionalPartsfields) -> where('id', '=', $processorCoolerId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> whereIn('stockTypeId', $stockTypesIdentifiers) -> first();
                        $case = \DB::table('computer_cases') -> select($optionalPartsfields) -> where('id', '=', $caseId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> whereIn('stockTypeId', $stockTypesIdentifiers) -> first();
                        $hardDiskDrive = \DB::table('hard_disk_drives') -> select($optionalPartsfields) -> where('id', '=', $hardDiskDriveId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> whereIn('stockTypeId', $stockTypesIdentifiers) -> first();
                        $solidStateDrive = \DB::table('solid_state_drives') -> select($optionalPartsfields) -> where('id', '=', $solidStateDiskDriveId) -> where('visibility', 1) -> where('configuratorPart', '=', 1) -> whereIn('stockTypeId', $stockTypesIdentifiers) -> first();

                        // sum key data

                        $overalPrice = $processorPrice + $motherboardPrice + $memoryPrice;
                        $overalOldPrice = $processorOldPrice + $motherboardOldPrice + $memoryOldPrice;

                        // check optional parts

                        if(!is_null($videoCard))
                        {
                          $videoCardTitle = $videoCard -> title;
                          $videoCardPrice = $videoCard -> price - $videoCard -> discount;
                          $videoCardOldPrice = $videoCard -> price;
                          $videoCardDiscountVisibility = $videoCard -> discount == 0 ? 'none' : 'inline';

                          $numberOfPartsSelectedByUser += 1;
                          $overalPrice += $videoCardPrice;
                          $overalOldPrice += $videoCardOldPrice;
                        }

                        if(!is_null($powerSupply))
                        {
                          $powerSupplyTitle = $powerSupply -> title;
                          $powerSupplyPrice = $powerSupply -> price - $powerSupply -> discount;
                          $powerSupplyOldPrice = $powerSupply -> price;
                          $powerSupplyDiscountVisibility = $powerSupply -> discount == 0 ? 'none' : 'inline';

                          $numberOfPartsSelectedByUser += 1;
                          $overalPrice += $powerSupplyPrice;
                          $overalOldPrice += $powerSupplyOldPrice;
                        }

                        if(!is_null($processorCooler))
                        {
                          $processorCoolerTitle = $processorCooler -> title;
                          $processorCoolerPrice = $processorCooler -> price - $processorCooler -> discount;
                          $processorCoolerOldPrice = $processorCooler -> price;
                          $processorCoolerDiscountVisibility = $processorCooler -> discount == 0 ? 'none' : 'inline';

                          $numberOfPartsSelectedByUser += 1;
                          $overalPrice += $processorCoolerPrice;
                          $overalOldPrice += $processorCoolerOldPrice;
                        }

                        if(!is_null($case))
                        {
                          $caseTitle = $case -> title;
                          $casePrice = $case -> price - $case -> discount;
                          $caseOldPrice = $case -> price;
                          $caseDiscountVisibility = $case -> discount == 0 ? 'none' : 'inline';

                          $numberOfPartsSelectedByUser += 1;
                          $overalPrice += $casePrice;
                          $overalOldPrice += $caseOldPrice;
                        }

                        if(!is_null($hardDiskDrive))
                        {
                          $hardDiskDriveTitle = $hardDiskDrive -> title;
                          $hardDiskDrivePrice = $hardDiskDrive -> price - $hardDiskDrive -> discount;
                          $hardDiskDriveOldPrice = $hardDiskDrive -> price;
                          $hardDiskDriveDiscountVisibility = $hardDiskDrive -> discount == 0 ? 'none' : 'inline';

                          $numberOfPartsSelectedByUser += 1;
                          $overalPrice += $hardDiskDrivePrice;
                          $overalOldPrice += $hardDiskDriveOldPrice;
                        }

                        if(!is_null($solidStateDrive))
                        {
                          $solidStateDriveTitle = $solidStateDrive -> title;
                          $solidStateDrivePrice = $solidStateDrive -> price - $solidStateDrive -> discount;
                          $solidStateDriveOldPrice = $solidStateDrive -> price;
                          $solidStateDriveDiscountVisibility = $solidStateDrive -> discount == 0 ? 'none' : 'inline';

                          $numberOfPartsSelectedByUser += 1;
                          $overalPrice += $solidStateDrivePrice;
                          $overalOldPrice += $solidStateDriveOldPrice;
                        }

                        // determine key moments

                        $assemblyPrice = $numberOfPartsSelectedByUser == 9 ? 0 : 50;
                        $overalOldPriceVisibility = ($overalOldPrice - $overalPrice - $assemblyPrice) <= 0 ? 'none' : 'inline';

                        // pdf document generation logic

                        $htmlText = file_get_contents($templateName);

                        $htmlText = str_replace('{address}', \URL::to('/'), $htmlText);

                        // replace titles

                        $titlesPlaceholders = ['{processorTitle}', '{motherboardTitle}', '{memoryTitle}', '{videoCardTitle}', '{powerSupplyTitle}', '{hardDiskDriveTitle}', '{solidStateDriveTitle}', '{processorCoolerTitle}', '{caseTitle}', '{memories}'];
                        $titlesToInsert = [$processorTitle, $motherboardTitle, $memoryTitle, $videoCardTitle, $powerSupplyTitle, $hardDiskDriveTitle, $solidStateDriveTitle, $processorCoolerTitle, $caseTitle, $memoryUnitsProvidedByUser];

                        $htmlText = str_replace($titlesPlaceholders, $titlesToInsert, $htmlText);

                        // replace prices

                        $pricesPlaceholders = ['{processorPrice}', '{motherboardPrice}', '{memoryPrice}', '{videoCardPrice}', '{powerSupplyPrice}', '{hardDiskDrivePrice}', '{solidStateDrivePrice}', '{processorCoolerPrice}', '{casePrice}'];
                        $pricesToInsert = [$processorPrice, $motherboardPrice, $memoryPrice, $videoCardPrice, $powerSupplyPrice, $hardDiskDrivePrice, $solidStateDrivePrice, $processorCoolerPrice, $casePrice];

                        $htmlText = str_replace($pricesPlaceholders, $pricesToInsert, $htmlText);

                        // replace old prices

                        $oldPricesPlaceholders = ['{processorOldPrice}', '{motherboardOldPrice}', '{memoryOldPrice}', '{videoCardOldPrice}', '{powerSupplyOldPrice}', '{hardDiskDriveOldPrice}', '{solidStateDriveOldPrice}', '{processorCoolerOldPrice}', '{caseOldPrice}'];
                        $oldPricesToInsert = [$processorOldPrice, $motherboardOldPrice, $memoryOldPrice, $videoCardOldPrice, $powerSupplyOldPrice, $hardDiskDriveOldPrice, $solidStateDriveOldPrice, $processorCoolerOldPrice, $caseOldPrice];

                        $htmlText = str_replace($oldPricesPlaceholders, $oldPricesToInsert, $htmlText);

                        // replace key prices

                        $overalPrice = $overalPrice + $assemblyPrice;

                        $keyPricesPlaceholders = ['{configurationPrice}', '{oldPrice}', '{assemblyPrice}', '{overalOldPriceVisibility}'];
                        $keyPricesToInsert = [$overalPrice, $overalOldPrice, $assemblyPrice, $overalOldPriceVisibility];

                        $htmlText = str_replace($keyPricesPlaceholders, $keyPricesToInsert, $htmlText);

                        // replace discount visibilities

                        $discountVisibilityPlaceholders = ['{processorDiscountVisibility}', '{motherboardDiscountVisibility}', '{memoryDiscountVisibility}', '{videoCardDiscountVisibility}', '{powerSupplyDiscountVisibility}', '{processorCoolerDiscountVisibility}', '{caseDiscountVisibility}', '{hardDiskDriveDiscountVisibility}', '{solidStateDriveDiscountVisibility}'];
                        $discountVisibilitiesToInsert = [$processorDiscountVisibility, $motherboardDiscountVisibility, $memoryDiscountVisibility, $videoCardDiscountVisibility, $powerSupplyDiscountVisibility, $processorCoolerDiscountVisibility, $caseDiscountVisibility, $hardDiskDriveDiscountVisibility, $solidStateDriveDiscountVisibility];

                        $htmlText = str_replace($discountVisibilityPlaceholders, $discountVisibilitiesToInsert, $htmlText);

                        // check contact information

                        $contactInformationFieldsToSelect = ['email', 'phone', 'address', 'schedule'];
                        $contactInformation = \DB::table('contacts') -> select($contactInformationFieldsToSelect) -> first();

                        if(!is_null($contactInformation))
                        {
                          $email = $contactInformation -> email;
                          $phone = $contactInformation -> phone;
                          $companyAddress = $contactInformation -> address;
                          $schedule = $contactInformation -> schedule;
                        }

                        $contactInformationPlaceholders = ['{email}', '{phone}', '{companyAddress}', '{schedule}'];
                        $contactInformationToInsert = [$email, $phone, $companyAddress, $schedule];

                        $htmlText = str_replace($contactInformationPlaceholders, $contactInformationToInsert, $htmlText);

                        $data['documentHtmlText'] = $htmlText;
                        $data['documentName'] = "itworks-" . substr(md5(mt_rand()), 0, 8) . ".pdf";
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

    return $data;
  }
}
