<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// routes for site namespace

Route::namespace('Site') -> group(function(){

  // shopping cart routes

  Route::prefix('shoppingCart') -> group(function(){

      Route::get('/', 'ShoppingCartController@index');
      Route::post('add', 'ShoppingCartController@add');
      Route::post('delete', 'ShoppingCartController@delete');
      Route::post('changeQuantity', 'ShoppingCartController@changeQuantity');
  });

  // search routes

  Route::post('/products/getLiveSearchResults', 'ProductController@getLiveSearchResults');
  Route::get('/search', 'ProductController@search');

  // configurator routes

  Route::prefix('configurator') -> group(function(){

    Route::get('/', 'ConfiguratorController@index');
    Route::get('document', 'ConfiguratorController@generateDocument');

    Route::post('getProcessors', 'ConfiguratorController@getProcessors');
    Route::post('getMotherboards', 'ConfiguratorController@getMotherboards');
    Route::post('getMemories', 'ConfiguratorController@getMemories');
    Route::post('getProcessorCoolers', 'ConfiguratorController@getProcessorCoolers');
    Route::post('getCases', 'ConfiguratorController@getCases');
    Route::post('getPowerSupplies', 'ConfiguratorController@getPowerSupplies');
    Route::post('getVideoCards', 'ConfiguratorController@getVideoCards');
    Route::post('getHardDiskDrives', 'ConfiguratorController@getHardDiskDrives');
    Route::post('getSolidStateDrives', 'ConfiguratorController@getSolidStateDrives');

    Route::post('selectProcessor', 'ConfiguratorController@selectProcessor');
    Route::post('selectMotherboard', 'ConfiguratorController@selectMotherboard');
    Route::post('selectMemory', 'ConfiguratorController@selectMemory');
    Route::post('selectProcessorCooler', 'ConfiguratorController@selectProcessorCooler');
    Route::post('selectCase', 'ConfiguratorController@selectCase');
    Route::post('selectPowerSupply', 'ConfiguratorController@selectPowerSupply');
    Route::post('selectVideoCard', 'ConfiguratorController@selectVideoCard');
    Route::post('selectHardDiskDrive', 'ConfiguratorController@selectHardDiskDrive');
    Route::post('selectSolidStateDrive', 'ConfiguratorController@selectSolidStateDrive');

  });

  // index routes

  Route::get('/', 'HomeController@index');
  Route::get('/accessories', 'AccessoryController@index') -> name('acc');
  Route::get('/computers', 'ComputerController@index') -> name('sb');
  Route::get('/processors', 'ProcessorController@index') -> name('cpu');
  Route::get('/motherboards', 'MotherboardController@index') -> name('mb');
  Route::get('/memoryModules', 'MemoryModuleController@index') -> name('mm');
  Route::get('/monitors', 'MonitorController@index') -> name('monitors');
  Route::get('/videoCards', 'VideoCardController@index') -> name('vc');
  Route::get('/hardDiskDrives', 'HardDiskDriveController@index') -> name('hdd');
  Route::get('/solidStateDrives', 'SolidStateDriveController@index') -> name('ssd');
  Route::get('/computerCases', 'ComputerCaseController@index') -> name('cases');
  Route::get('/powerSupplies', 'PowerSupplyController@index') -> name('ps');
  Route::get('/processorCoolers', 'ProcessorCoolerController@index') -> name('pc');
  Route::get('/caseCoolers', 'CaseCoolerController@index') -> name('cc');
  Route::get('/opticalDiscDrives', 'OpticalDiscDriveController@index') -> name('odd');
  Route::get('/networkDevices', 'NetworkDeviceController@index') -> name('nd');
  Route::get('/peripherals', 'PeripheralController@index') -> name('peripherals');
  Route::get('/uninterruptiblePowerSupplies', 'UninterruptiblePowerSupplyController@index') -> name('ups');
  Route::get('/notebookChargers', 'NotebookChargerController@index') -> name('nc');

  // load routes

  Route::post('/products/loadSearchResults', 'ProductController@getList') -> name('psrLoad');
  Route::post('/accessories/load', 'AccessoryController@getList') -> name('accLoad');
  Route::post('/computers/load', 'ComputerController@getList') -> name('compLoad');
  Route::post('/processors/load', 'ProcessorController@getList') -> name('cpuLoad');
  Route::post('/motherboards/load', 'MotherboardController@getList') -> name('mbLoad');
  Route::post('/memoryModules/load', 'MemoryModuleController@getList') -> name('mmLoad');
  Route::post('/monitors/load', 'MonitorController@getList') -> name('monitorsLoad');
  Route::post('/videoCards/load', 'VideoCardController@getList') -> name('vcLoad');
  Route::post('/hardDiskDrives/load', 'HardDiskDriveController@getList') -> name('hddLoad');
  Route::post('/solidStateDrives/load', 'SolidStateDriveController@getList') -> name('ssdLoad');
  Route::post('/computerCases/load', 'ComputerCaseController@getList') -> name('casesLoad');
  Route::post('/powerSupplies/load', 'PowerSupplyController@getList') -> name('psLoad');
  Route::post('/processorCoolers/load', 'ProcessorCoolerController@getList') -> name('pcLoad');
  Route::post('/caseCoolers/load', 'CaseCoolerController@getList') -> name('ccLoad');
  Route::post('/opticalDiscDrives/load', 'OpticalDiscDriveController@getList') -> name('oddLoad');
  Route::post('/networkDevices/load', 'NetworkDeviceController@getList') -> name('ndLoad');
  Route::post('/peripherals/load', 'PeripheralController@getList') -> name('perLoad');
  Route::post('/uninterruptiblePowerSupplies/load', 'UninterruptiblePowerSupplyController@getList') -> name('upsLoad');
  Route::post('/notebookChargers/load', 'NotebookChargerController@getList') -> name('ncLoad');

  // contact routes

  Route::get('/contact', 'ContactController@index');
  Route::post('/contact/sendMessage', 'ContactController@sendMessage');

  // category routes

  Route::group(['where' => ['id' => '^[1-9]\d{0,9}$']], function(){

      Route::get('/accessories/type/{id}', 'AccessoryController@index') -> name('accByType');
      Route::get('/networkDevices/type/{id}', 'NetworkDeviceController@index') -> name('ndByType');
      Route::get('/peripherals/type/{id}', 'PeripheralController@index') -> name('perByType');
  });

  // view routes

  Route::get('/accessories/{id}', 'AccessoryController@view');
  Route::get('/computers/{id}', 'ComputerController@view');
  Route::get('/processors/{id}', 'ProcessorController@view');
  Route::get('/motherboards/{id}', 'MotherboardController@view');
  Route::get('/monitors/{id}', 'MonitorController@view');
  Route::get('/memoryModules/{id}', 'MemoryModuleController@view');
  Route::get('/videoCards/{id}', 'VideoCardController@view');
  Route::get('/hardDiskDrives/{id}', 'HardDiskDriveController@view');
  Route::get('/solidStateDrives/{id}', 'SolidStateDriveController@view');
  Route::get('/computerCases/{id}', 'ComputerCaseController@view');
  Route::get('/caseCoolers/{id}', 'CaseCoolerController@view');
  Route::get('/powerSupplies/{id}', 'PowerSupplyController@view');
  Route::get('/opticalDiscDrives/{id}', 'OpticalDiscDriveController@view');
  Route::get('/processorCoolers/{id}', 'ProcessorCoolerController@view');
  Route::get('/networkDevices/{id}', 'NetworkDeviceController@view');
  Route::get('/peripherals/{id}', 'PeripheralController@view');
  Route::get('/uninterruptiblePowerSupplies/{id}', 'UninterruptiblePowerSupplyController@view');
  Route::get('/notebookChargers/{id}', 'NotebookChargerController@view');

  // home page ajax request routes

  Route::get('/computersForHomePage/{id}', 'ComputerController@getComputersForHomePage') -> name('homePageComputers');
  Route::get('/accessoriesForHomePage/{id}', 'AccessoryController@getAccessoriesForHomePage') -> name('homePageAccessories');

});

// auth routes

Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm') -> name('password.reset');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset') -> name('password.update');

Route::get('/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm') -> name('password.request');
Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail') -> name('password.email');

Route::get('/password/confirm', 'Auth\ConfirmPasswordController@showConfirmForm') -> name('password.confirm');
Route::post('/password/confirm', 'Auth\ConfirmPasswordController@confirm');

Route::post('/logout', 'Auth\LoginController@logout') -> name('logout');
Route::get('/logout', 'Auth\LoginController@logout');

Route::post('/login', 'Auth\LoginController@login') -> name('login');
Route::get('/login', 'Auth\LoginController@showLoginForm');

// user routes

Route::middleware(['auth', 'verified']) -> namespace('User') -> prefix('user') -> group(function(){

      // invoice routes

      Route::prefix('invoice') -> group(function(){

          Route::post('/', 'InvoiceController@index') -> name('invoice');
          Route::post('display', 'InvoiceController@display') -> name('displayInvoice');
          Route::post('send', 'InvoiceController@send') -> name('sendInvoice');
      });

      // warranty routes

      Route::post('warranty', 'WarrantyController@index') -> name('warranty');
      Route::post('displayWarranty', 'WarrantyController@displayWarranty') -> name('displayWarranty');

      // user routes

      Route::post('changePassword', 'UserController@changePassword') -> name('passwordChange');
      Route::post('updateData', 'UserController@updateData') -> name('dataUpdate');

      // home routes

      Route::prefix('home') -> group(function(){

         // various routes

         Route::get('/', 'HomeController@index') -> name('userhome');
      });

      // analytics routes

      Route::prefix('analytics') -> group(function(){

         // various routes

         Route::post('/', 'AnalyticsController@index') -> name('useranalytics');

         Route::post('require', 'AnalyticsController@requireData') -> name('useranalyticsrequire');

         Route::post('destroy', 'AnalyticsController@destroyData') -> name('useranalyticsdestroy');
      });

      // statements routes

      Route::prefix('statements') -> group(function(){

         // index route

         Route::post('/', 'StatementController@index') -> name('userstatements');

         // store routes

         Route::post('storeStatement', 'StatementController@storeStatement') -> name('statementStore');
         Route::post('storeCategory', 'StatementController@storeCategory') -> name('categoryStore');

         // update routes

         Route::post('updateStatement', 'StatementController@updateStatement') -> name('statementUpdate');
         Route::post('updateCategory', 'StatementController@updateCategory') -> name('categoryUpdate');
         Route::post('updateSession', 'StatementController@updateSessionCookie') -> name('sessionCookieUpdate');

         // destroy routes

         Route::get('destroyStatement/{id}', 'StatementController@destroyStatement') -> name('statementDestroy');
         Route::get('destroyCategory{id}', 'StatementController@destroyCategory') -> name('categoryDestroy');
      });

      // contact routes

      Route::post('contact', 'ContactController@index') -> name('usercontact');
      Route::post('contact/update', 'ContactController@update') -> name('contactUpdate');

      // slides routes

      Route::prefix('slides') -> group(function(){

          Route::post('/', 'SlideController@index') -> name('userslides');
          Route::post('updateOrder', 'SlideController@updateOrder') -> name('updateSlideOrder');
          Route::post('store', 'SlideController@store') -> name('storeSlides');
          Route::get('destroy/{id}', 'SlideController@destroy') -> name('destroySlide');
      });

      // site parameters routes

      Route::prefix('parameters') -> group(function(){

          // general parameters routes

          Route::prefix('general') -> group(function(){

              // index route

              Route::post('/', 'HomeController@parameters') -> name('paramsgeneral');

              // destroy routes

              Route::prefix('destroy') -> group(function(){

                   Route::get('stockType/{id}', 'HomeController@destroyStockType') -> name('stockTypeDestroy');
                   Route::get('conditionType/{id}', 'HomeController@destroyConditionType') -> name('condTypeDestroy');
              });

              // update routes

              Route::prefix('update') -> group(function(){

                   Route::post('stockType', 'HomeController@updateStockType') -> name('stockTypeUpdate');
                   Route::post('conditionType', 'HomeController@updateConditionType') -> name('condTypeUpdate');
                   Route::post('priceRanges', 'HomeController@updatePriceRanges') -> name('priceRangesUpdate');
              });

              // store routes

              Route::prefix('store') -> group(function(){

                   Route::post('stockType', 'HomeController@storeStockType') -> name('stockTypeStore');
                   Route::post('conditionType', 'HomeController@storeConditionType') -> name('condTypeStore');
              });
          });

          // processors routes

          Route::prefix('processors') -> group(function(){

               Route::post('/', 'ProcessorController@parameters') -> name('paramscpu');

               // destroy routes

               Route::prefix('destroy') -> group(function(){

                    Route::get('socket/{id}', 'ProcessorController@destroySocket') -> name('socketDestroy');
                    Route::get('chipset/{id}', 'ProcessorController@destroyChipset') -> name('chipsetDestroy');
                    Route::get('system/{id}', 'ProcessorController@destroySystem') -> name('systemDestroy');
                    Route::get('technologyProcess/{id}', 'ProcessorController@destroyTechnologyProcess') -> name('tcpDestroy');
               });

               // update routes

               Route::prefix('update') -> group(function(){

                    Route::post('socket', 'ProcessorController@updateSocket') -> name('socketUpdate');
                    Route::post('chipset', 'ProcessorController@updateChipset') -> name('chipsetUpdate');
                    Route::post('system', 'ProcessorController@updateSystem') -> name('systemUpdate');
                    Route::post('technologyProcess', 'ProcessorController@updateTechnologyProcess') -> name('tcpUpdate');
               });

               // store routes

               Route::prefix('store') -> group(function(){

                    Route::post('socket', 'ProcessorController@storeSocket') -> name('socketStore');
                    Route::post('chipset', 'ProcessorController@storeChipset') -> name('chipsetStore');
                    Route::post('system', 'ProcessorController@storeSystem') -> name('systemStore');
                    Route::post('technologyProcess', 'ProcessorController@storeTechnologyProcess') -> name('tcpStore');
               });
          });

          // memory modules routes

          Route::prefix('memoryModules') -> group(function(){

              Route::post('/', 'MemoryModuleController@parameters') -> name('paramsram');
              Route::post('updateMemoryModuleType', 'MemoryModuleController@updateMemoryModuleType') -> name('mmtypeUpdate');
              Route::get('destroyMemoryModuleType/{id}', 'MemoryModuleController@destroyMemoryModuleType') -> name('mmtypeDestroy');
              Route::post('storeMemoryModuleType', 'MemoryModuleController@storeMemoryModuleType') -> name('mmtypeStore');
          });

          // motherboards routes

          Route::prefix('motherboards') -> group(function(){

            // index route

            Route::post('/', 'MotherboardController@parameters') -> name('paramsmtb');

            // destroy routes

            Route::prefix('destroy') -> group(function(){

                 Route::get('motherboardManufacturer/{id}', 'MotherboardController@destroyMotherboardManufacturer') -> name('mtbManufacturerDestroy');
                 Route::get('motherboardFormFactor/{id}', 'MotherboardController@destroyMotherboardFormFactor') -> name('mtbFormFactorDestroy');
            });

            // update routes

            Route::prefix('update') -> group(function(){

                 Route::post('motherboardManufacturer', 'MotherboardController@updateMotherboardManufacturer') -> name('mtbManufacturerUpdate');
                 Route::post('motherboardFormFactor', 'MotherboardController@updateMotherboardFormFactor') -> name('mtbFormFactorUpdate');
            });

            // store routes

            Route::prefix('store') -> group(function(){

                 Route::post('manufacturer', 'MotherboardController@storeMotherboardManufacturer') -> name('mtbManufacturerStore');
                 Route::post('formFactor', 'MotherboardController@storeMotherboardFormFactor') -> name('mtbFormFactorStore');
            });

          });

          // accessories routes

          Route::prefix('accessories') -> group(function(){

               Route::post('/', 'AccessoryController@parameters') -> name('paramsacc');
               Route::post('store', 'AccessoryController@storeAccessoryType') -> name('accTypeStore');
               Route::post('update', 'AccessoryController@updateAccessoryType') -> name('accTypeUpdate');
               Route::get('destroy/{id}', 'AccessoryController@destroyAccessoryType') -> name('accTypeDestroy');
          });

          // network devices routes

          Route::prefix('networkDevices') -> group(function(){

               Route::post('/', 'NetworkDeviceController@parameters') -> name('paramsnd');
               Route::post('store', 'NetworkDeviceController@storeNetworkDeviceType') -> name('ndTypeStore');
               Route::post('update', 'NetworkDeviceController@updateNetworkDeviceType') -> name('ndTypeUpdate');
               Route::get('destroy/{id}', 'NetworkDeviceController@destroyNetworkDeviceType') -> name('ndTypeDestroy');
          });

          // peripherals routes

          Route::prefix('peripherals') -> group(function(){

               Route::post('/', 'PeripheralController@parameters') -> name('paramsperipherals');
               Route::post('store', 'PeripheralController@storePeripheralType') -> name('peripheralTypeStore');
               Route::post('update', 'PeripheralController@updatePeripheralType') -> name('peripheralTypeUpdate');
               Route::get('destroy/{id}', 'PeripheralController@destroyPeripheralType') -> name('peripheralTypeDestroy');
          });

          // notebooks chargers manufacturers

          Route::prefix('notebookChargers') -> group(function(){

               Route::post('/', 'NotebookChargerController@parameters') -> name('paramsncm');
               Route::post('store', 'NotebookChargerController@storeNotebookChargerManufacturer') -> name('ncmStore');
               Route::post('update', 'NotebookChargerController@updateNotebookChargerManufacturer') -> name('ncmUpdate');
               Route::get('destroy/{id}', 'NotebookChargerController@destroyNotebookChargerManufacturer') -> name('ncmDestroy');
          });

          // monitors manufacturers

          Route::prefix('monitors') -> group(function(){

               Route::post('/', 'MonitorController@parameters') -> name('paramsmonitor');
               Route::post('store', 'MonitorController@storeMonitorManufacturer') -> name('monitorManufacturerStore');
               Route::post('update', 'MonitorController@updateMonitorManufacturer') -> name('monitorManufacturerUpdate');
               Route::get('destroy/{id}', 'MonitorController@destroyMonitorManufacturer') -> name('monitorManufacturerDestroy');
          });

          // optical disc drives types

          Route::prefix('opticalDiscDrives') -> group(function(){

               Route::post('/', 'OpticalDiscDriveController@parameters') -> name('paramsodd');
               Route::post('store', 'OpticalDiscDriveController@storeOpticalDiscDriveType') -> name('oddtStore');
               Route::post('update', 'OpticalDiscDriveController@updateOpticalDiscDriveType') -> name('oddtUpdate');
               Route::get('destroy/{id}', 'OpticalDiscDriveController@destroyOpticalDiscDriveType') -> name('oddtDestroy');
          });

          // hard disk drives form factors routes

          Route::prefix('hardDiskDrives') -> group(function(){

               Route::post('/', 'HardDiskDriveController@parameters') -> name('paramshdd');
               Route::post('store', 'HardDiskDriveController@storeHardDiskDriveFormFactor') -> name('hddffStore');
               Route::post('update', 'HardDiskDriveController@updateHardDiskDriveFormFactor') -> name('hddffUpdate');
               Route::get('destroy/{id}', 'HardDiskDriveController@destroyHardDiskDriveFormFactor') -> name('hddffDestroy');
          });

          // solid state drive form factors routes

          Route::prefix('solidStateDrives') -> group(function(){

               Route::post('/', 'SolidStateDriveController@parameters') -> name('paramsssd');

               Route::post('storeFormFactor', 'SolidStateDriveController@storeSolidStateDriveFormFactor') -> name('ssdffStore');
               Route::post('updateFormFactor', 'SolidStateDriveController@updateSolidStateDriveFormFactor') -> name('ssdffUpdate');
               Route::get('destroyFormFactor/{id}', 'SolidStateDriveController@destroySolidStateDriveFormFactor') -> name('ssdffDestroy');

               Route::post('storeTechnology', 'SolidStateDriveController@storeSolidStateDriveTechnology') -> name('ssdTcStore');
               Route::post('updateTechnology', 'SolidStateDriveController@updateSolidStateDriveTechnology') -> name('ssdTcUpdate');
               Route::get('destroyTechnology/{id}', 'SolidStateDriveController@destroySolidStateDriveTechnology') -> name('ssdTcDestroy');
          });

          // video card parameters routes

          Route::prefix('videoCards') -> group(function(){

               Route::post('/', 'VideoCardController@parameters') -> name('paramsvc');

               // destroy routes

               Route::prefix('destroy') -> group(function(){

                    Route::get('videoCardManufacturer/{id}', 'VideoCardController@destroyVideoCardManufacturer') -> name('vcManufacturerDestroy');
                    Route::get('videoCardMemoryType/{id}', 'VideoCardController@destroyVideoCardMemoryType') -> name('vcMemoryTypeDestroy');
                    Route::get('graphicsType/{id}', 'VideoCardController@destroyGraphicsType') -> name('graphicsTypeDestroy');
                    Route::get('graphicalProcessorManufacturer/{id}', 'VideoCardController@destroyGraphicalProcessorManufacturer') -> name('gpuManufacturerDestroy');
               });

               // update routes

               Route::prefix('update') -> group(function(){

                    Route::post('videoCardManufacturer', 'VideoCardController@updateVideoCardManufacturer') -> name('vcManufacturerUpdate');
                    Route::post('videoCardMemoryType', 'VideoCardController@updateVideoCardMemoryType') -> name('vcMemoryTypeUpdate');
                    Route::post('graphicsType', 'VideoCardController@updateGraphicsType') -> name('graphicsTypeUpdate');
                    Route::post('graphicalProcessorManufacturer', 'VideoCardController@updateGraphicalProcessorManufacturer') -> name('gpuManufacturerUpdate');
               });

               // store routes

               Route::prefix('store') -> group(function(){

                    Route::post('videoCardManufacturer', 'VideoCardController@storeVideoCardManufacturer') -> name('vcManufacturerStore');
                    Route::post('videoCardMemoryType', 'VideoCardController@storeVideoCardMemoryType') -> name('vcMemoryTypeStore');
                    Route::post('graphicsType', 'VideoCardController@storeGraphicsType') -> name('graphicsTypeStore');
                    Route::post('graphicalProcessorManufacturer', 'VideoCardController@storeGraphicalProcessorManufacturer') -> name('gpuManufacturerStore');
               });
          });
      });

      // list routes

      Route::post('accessories', 'AccessoryController@index') -> name('useracc');
      Route::post('computers', 'ComputerController@index') -> name('usersb');
      Route::post('processors', 'ProcessorController@index') -> name('usercpu');
      Route::post('motherboards', 'MotherboardController@index') -> name('usermb');
      Route::post('memoryModules', 'MemoryModuleController@index') -> name('usermm');
      Route::post('monitors', 'MonitorController@index') -> name('usermonitors');
      Route::post('videoCards', 'VideoCardController@index') -> name('uservc');
      Route::post('hardDiskDrives', 'HardDiskDriveController@index') -> name('userhdd');
      Route::post('solidStateDrives', 'SolidStateDriveController@index') -> name('userssd');
      Route::post('computerCases', 'ComputerCaseController@index') -> name('usercases');
      Route::post('powerSupplies', 'PowerSupplyController@index') -> name('userps');
      Route::post('processorCoolers', 'ProcessorCoolerController@index') -> name('userpc');
      Route::post('caseCoolers', 'CaseCoolerController@index') -> name('usercc');
      Route::post('opticalDiscDrives', 'OpticalDiscDriveController@index') -> name('userodd');
      Route::post('networkDevices', 'NetworkDeviceController@index') -> name('usernd');
      Route::post('peripherals', 'PeripheralController@index') -> name('userperipherals');
      Route::post('uninterruptiblePowerSupplies', 'UninterruptiblePowerSupplyController@index') -> name('userups');
      Route::post('notebookChargers', 'NotebookChargerController@index') -> name('usernc');

      // base data update routes

      Route::post('accessoriesBaseUpdate', 'AccessoryController@updateBaseData') -> name('accUpdateBase');
      Route::post('computersBaseUpdate', 'ComputerController@updateBaseData') -> name('sbUpdateBase');
      Route::post('processorsBaseUpdate', 'ProcessorController@updateBaseData') -> name('cpuUpdateBase');
      Route::post('motherboardsBaseUpdate', 'MotherboardController@updateBaseData') -> name('mbUpdateBase');
      Route::post('memoryModulesBaseUpdate', 'MemoryModuleController@updateBaseData') -> name('mmUpdateBase');
      Route::post('monitorsBaseUpdate', 'MonitorController@updateBaseData') -> name('monitorUpdateBase');
      Route::post('videoCardsBaseUpdate', 'VideoCardController@updateBaseData') -> name('vcUpdateBase');
      Route::post('hardDiskDrivesBaseUpdate', 'HardDiskDriveController@updateBaseData') -> name('hddUpdateBase');
      Route::post('solidStateDrivesBaseUpdate', 'SolidStateDriveController@updateBaseData') -> name('ssdUpdateBase');
      Route::post('computerCasesBaseUpdate', 'ComputerCaseController@updateBaseData') -> name('caseUpdateBase');
      Route::post('powerSuppliesBaseUpdate', 'PowerSupplyController@updateBaseData') -> name('psUpdateBase');
      Route::post('processorCoolersBaseUpdate', 'ProcessorCoolerController@updateBaseData') -> name('pcUpdateBase');
      Route::post('caseCoolersBaseUpdate', 'CaseCoolerController@updateBaseData') -> name('ccUpdateBase');
      Route::post('opticalDiscDrivesBaseUpdate', 'OpticalDiscDriveController@updateBaseData') -> name('oddUpdateBase');
      Route::post('networkDevicesBaseUpdate', 'NetworkDeviceController@updateBaseData') -> name('ndUpdateBase');
      Route::post('peripheralsBaseUpdate', 'PeripheralController@updateBaseData') -> name('peripheralUpdateBase');
      Route::post('uninterruptiblePowerSuppliesBaseUpdate', 'UninterruptiblePowerSupplyController@updateBaseData') -> name('upsUpdateBase');
      Route::post('notebookChargersBaseUpdate', 'NotebookChargerController@updateBaseData') -> name('ncUpdateBase');

      // record store routes

      Route::post('storeComputer', 'ComputerController@store') -> name('sbStore');
      Route::post('storeAccessory', 'AccessoryController@store') -> name('accStore');
      Route::post('storeProcessor', 'ProcessorController@store') -> name('cpuStore');
      Route::post('storeMotherboard', 'MotherboardController@store') -> name('mbStore');
      Route::post('storeMemoryModule', 'MemoryModuleController@store') -> name('mmStore');
      Route::post('storeMonitor', 'MonitorController@store') -> name('monitorStore');
      Route::post('storeVideoCard', 'VideoCardController@store') -> name('vcStore');
      Route::post('storeHardDiskDrive', 'HardDiskDriveController@store') -> name('hddStore');
      Route::post('storeComputerCase', 'ComputerCaseController@store') -> name('caseStore');
      Route::post('storeSolidStateDrive', 'SolidStateDriveController@store') -> name('ssdStore');
      Route::post('storePowerSupply', 'PowerSupplyController@store') -> name('psStore');
      Route::post('storeProcessorCooler', 'ProcessorCoolerController@store') -> name('pcStore');
      Route::post('storeCaseCooler', 'CaseCoolerController@store') -> name('ccStore');
      Route::post('storeOpticalDiscDrive', 'OpticalDiscDriveController@store') -> name('oddStore');
      Route::post('storeNetworkDevice', 'NetworkDeviceController@store') -> name('ndStore');
      Route::post('storePeripheral', 'PeripheralController@store') -> name('peripheralStore');
      Route::post('storeUninterruptiblePowerSupply', 'UninterruptiblePowerSupplyController@store') -> name('upsStore');
      Route::post('storeNotebookCharger', 'NotebookChargerController@store') -> name('ncStore');

      // record update routes

      Route::post('updateComputer', 'ComputerController@update') -> name('sbUpdate');
      Route::post('updateAccessory', 'AccessoryController@update') -> name('accUpdate');
      Route::post('updateProcessor', 'ProcessorController@update') -> name('cpuUpdate');
      Route::post('updateMotherboard', 'MotherboardController@update') -> name('mbUpdate');
      Route::post('updateMemoryModule', 'MemoryModuleController@update') -> name('mmUpdate');
      Route::post('updateMonitor', 'MonitorController@update') -> name('monitorUpdate');
      Route::post('updateVideoCard', 'VideoCardController@update') -> name('vcUpdate');
      Route::post('updateHardDiskDrive', 'HardDiskDriveController@update') -> name('hddUpdate');
      Route::post('updateComputerCase', 'ComputerCaseController@update') -> name('caseUpdate');
      Route::post('updateSolidStateDrive', 'SolidStateDriveController@update') -> name('ssdUpdate');
      Route::post('updatePowerSupply', 'PowerSupplyController@update') -> name('psUpdate');
      Route::post('updateProcessorCooler', 'ProcessorCoolerController@update') -> name('pcUpdate');
      Route::post('updateCaseCooler', 'CaseCoolerController@update') -> name('ccUpdate');
      Route::post('updateOpticalDiscDrive', 'OpticalDiscDriveController@update') -> name('oddUpdate');
      Route::post('updateNetworkDevice', 'NetworkDeviceController@update') -> name('ndUpdate');
      Route::post('updatePeripheral', 'PeripheralController@update') -> name('peripheralUpdate');
      Route::post('updateUninterruptiblePowerSupply', 'UninterruptiblePowerSupplyController@update') -> name('upsUpdate');
      Route::post('updateNotebookCharger', 'NotebookChargerController@update') -> name('ncUpdate');

      // edit page routes

      Route::get('accessoryEdit/{id}', 'AccessoryController@edit') -> name('accEdit');
      Route::get('computerEdit/{id}', 'ComputerController@edit') -> name('sbEdit');
      Route::get('processorEdit/{id}', 'ProcessorController@edit') -> name('cpuEdit');
      Route::get('motherboardEdit/{id}', 'MotherboardController@edit') -> name('mbEdit');
      Route::get('memoryModuleEdit/{id}', 'MemoryModuleController@edit') -> name('mmEdit');
      Route::get('monitorEdit/{id}', 'MonitorController@edit') -> name('monitorsEdit');
      Route::get('videoCardEdit/{id}', 'VideoCardController@edit') -> name('vcEdit');
      Route::get('hardDiskDriveEdit/{id}', 'HardDiskDriveController@edit') -> name('hddEdit');
      Route::get('solidStateDriveEdit/{id}', 'SolidStateDriveController@edit') -> name('ssdEdit');
      Route::get('computerCaseEdit/{id}', 'ComputerCaseController@edit') -> name('casesEdit');
      Route::get('powerSupplyEdit/{id}', 'PowerSupplyController@edit') -> name('psEdit');
      Route::get('processorCoolerEdit/{id}', 'ProcessorCoolerController@edit') -> name('pcEdit');
      Route::get('caseCoolerEdit/{id}', 'CaseCoolerController@edit') -> name('ccEdit');
      Route::get('opticalDiscDriveEdit/{id}', 'OpticalDiscDriveController@edit') -> name('oddEdit');
      Route::get('networkDeviceEdit/{id}', 'NetworkDeviceController@edit') -> name('ndEdit');
      Route::get('peripheralEdit/{id}', 'PeripheralController@edit') -> name('peripheralsEdit');
      Route::get('uninterruptiblePowerSupplyEdit/{id}', 'UninterruptiblePowerSupplyController@edit') -> name('upsEdit');
      Route::get('notebookChargerEdit/{id}', 'NotebookChargerController@edit') -> name('ncEdit');

      // record destroy routes

      Route::get('accessoryDestroy/{id}', 'AccessoryController@destroy') -> name('accDestroy');
      Route::get('computerDestroy/{id}', 'ComputerController@destroy') -> name('sbDestroy');
      Route::get('processorDestroy/{id}', 'ProcessorController@destroy') -> name('cpuDestroy');
      Route::get('motherboardDestroy/{id}', 'MotherboardController@destroy') -> name('mbDestroy');
      Route::get('memoryModuleDestroy/{id}', 'MemoryModuleController@destroy') -> name('mmDestroy');
      Route::get('monitorDestroy/{id}', 'MonitorController@destroy') -> name('monitorsDestroy');
      Route::get('videoCardDestroy/{id}', 'VideoCardController@destroy') -> name('vcDestroy');
      Route::get('hardDiskDriveDestroy/{id}', 'HardDiskDriveController@destroy') -> name('hddDestroy');
      Route::get('solidStateDriveDestroy/{id}', 'SolidStateDriveController@destroy') -> name('ssdDestroy');
      Route::get('computerCaseDestroy/{id}', 'ComputerCaseController@destroy') -> name('casesDestroy');
      Route::get('powerSupplyDestroy/{id}', 'PowerSupplyController@destroy') -> name('psDestroy');
      Route::get('processorCoolerDestroy/{id}', 'ProcessorCoolerController@destroy') -> name('pcDestroy');
      Route::get('caseCoolerDestroy/{id}', 'CaseCoolerController@destroy') -> name('ccDestroy');
      Route::get('opticalDiscDriveDestroy/{id}', 'OpticalDiscDriveController@destroy') -> name('oddDestroy');
      Route::get('networkDeviceDestroy/{id}', 'NetworkDeviceController@destroy') -> name('ndDestroy');
      Route::get('peripheralDestroy/{id}', 'PeripheralController@destroy') -> name('peripheralsDestroy');
      Route::get('uninterruptiblePowerSupplyDestroy/{id}', 'UninterruptiblePowerSupplyController@destroy') -> name('upsDestroy');
      Route::get('notebookChargerDestroy/{id}', 'NotebookChargerController@destroy') -> name('ncDestroy');

      // upload carousel image routes

      Route::post('uploadComputerImage', 'ComputerController@uploadImage') -> name('sbImageUpload');
      Route::post('uploadAccessoryImage', 'AccessoryController@uploadImage') -> name('accImageUpload');
      Route::post('uploadProcessorImage', 'ProcessorController@uploadImage') -> name('cpuImageUpload');
      Route::post('uploadMotherboardImage', 'MotherboardController@uploadImage') -> name('mbImageUpload');
      Route::post('uploadMemoryModuleImage', 'MemoryModuleController@uploadImage') -> name('mmImageUpload');
      Route::post('uploadMonitorImage', 'MonitorController@uploadImage') -> name('monitorImageUpload');
      Route::post('uploadVideoCardImage', 'VideoCardController@uploadImage') -> name('vcImageUpload');
      Route::post('uploadHardDiskDriveImage', 'HardDiskDriveController@uploadImage') -> name('hddImageUpload');
      Route::post('uploadComputerCaseImage', 'ComputerCaseController@uploadImage') -> name('caseImageUpload');
      Route::post('uploadSolidStateDriveImage', 'SolidStateDriveController@uploadImage') -> name('ssdImageUpload');
      Route::post('uploadPowerSupplyImage', 'PowerSupplyController@uploadImage') -> name('psImageUpload');
      Route::post('uploadProcessorCoolerImage', 'ProcessorCoolerController@uploadImage') -> name('pcImageUpload');
      Route::post('uploadCaseCoolerImage', 'CaseCoolerController@uploadImage') -> name('ccImageUpload');
      Route::post('uploadOpticalDiscDriveImage', 'OpticalDiscDriveController@uploadImage') -> name('oddImageUpload');
      Route::post('uploadNetworkDeviceImage', 'NetworkDeviceController@uploadImage') -> name('ndImageUpload');
      Route::post('uploadPeripheralImage', 'PeripheralController@uploadImage') -> name('peripheralImageUpload');
      Route::post('uploadUninterruptiblePowerSupplyImage', 'UninterruptiblePowerSupplyController@uploadImage') -> name('upsImageUpload');
      Route::post('uploadNotebookChargerImage', 'NotebookChargerController@uploadImage') -> name('ncImageUpload');

      // update main image routes

      Route::post('updateComputerImage', 'ComputerController@updateImage') -> name('sbImageUpdate');
      Route::post('updateAccessoryImage', 'AccessoryController@updateImage') -> name('accImageUpdate');
      Route::post('updateProcessorImage', 'ProcessorController@updateImage') -> name('cpuImageUpdate');
      Route::post('updateMotherboardImage', 'MotherboardController@updateImage') -> name('mbImageUpdate');
      Route::post('updateMemoryModuleImage', 'MemoryModuleController@updateImage') -> name('mmImageUpdate');
      Route::post('updateMonitorImage', 'MonitorController@updateImage') -> name('monitorImageUpdate');
      Route::post('updateVideoCardImage', 'VideoCardController@updateImage') -> name('vcImageUpdate');
      Route::post('updateHardDiskDriveImage', 'HardDiskDriveController@updateImage') -> name('hddImageUpdate');
      Route::post('updateComputerCaseImage', 'ComputerCaseController@updateImage') -> name('caseImageUpdate');
      Route::post('updateSolidStateDriveImage', 'SolidStateDriveController@updateImage') -> name('ssdImageUpdate');
      Route::post('updatePowerSupplyImage', 'PowerSupplyController@updateImage') -> name('psImageUpdate');
      Route::post('updateProcessorCoolerImage', 'ProcessorCoolerController@updateImage') -> name('pcImageUpdate');
      Route::post('updateCaseCoolerImage', 'CaseCoolerController@updateImage') -> name('ccImageUpdate');
      Route::post('updateOpticalDiscDriveImage', 'OpticalDiscDriveController@updateImage') -> name('oddImageUpdate');
      Route::post('updateNetworkDeviceImage', 'NetworkDeviceController@updateImage') -> name('ndImageUpdate');
      Route::post('updatePeripheralImage', 'PeripheralController@updateImage') -> name('peripheralImageUpdate');
      Route::post('updateUninterruptiblePowerSupplyImage', 'UninterruptiblePowerSupplyController@updateImage') -> name('upsImageUpdate');
      Route::post('updateNotebookChargerImage', 'NotebookChargerController@updateImage') -> name('ncImageUpdate');

      // carousel image destroy routes

      Route::get('destroyAccessoryImage/{id}', 'AccessoryController@destroyImage') -> name('accImgDestroy');
      Route::get('destroyComputerImage/{id}', 'ComputerController@destroyImage') -> name('sbImgDestroy');
      Route::get('destroyProcessorImage/{id}', 'ProcessorController@destroyImage') -> name('cpuImgDestroy');
      Route::get('destroyMotherboardImage/{id}', 'MotherboardController@destroyImage') -> name('mbImgDestroy');
      Route::get('destroyMemoryModuleImage/{id}', 'MemoryModuleController@destroyImage') -> name('mmImgDestroy');
      Route::get('destroyMonitorImage/{id}', 'MonitorController@destroyImage') -> name('monitorImgDestroy');
      Route::get('destroyVideoCardImage/{id}', 'VideoCardController@destroyImage') -> name('vcImgDestroy');
      Route::get('destroyHardDiskDriveImage/{id}', 'HardDiskDriveController@destroyImage') -> name('hddImgDestroy');
      Route::get('destroySolidStateDriveImage/{id}', 'SolidStateDriveController@destroyImage') -> name('ssdImgDestroy');
      Route::get('destroyComputerCaseImage/{id}', 'ComputerCaseController@destroyImage') -> name('casesImgDestroy');
      Route::get('destroyPowerSupplyImage/{id}', 'PowerSupplyController@destroyImage') -> name('psImgDestroy');
      Route::get('destroyProcessorCoolerImage/{id}', 'ProcessorCoolerController@destroyImage') -> name('pcImgDestroy');
      Route::get('destroyCaseCoolerImage/{id}', 'CaseCoolerController@destroyImage') -> name('ccImgDestroy');
      Route::get('destroyOpticalDiscDriveImage/{id}', 'OpticalDiscDriveController@destroyImage') -> name('oddImgDestroy');
      Route::get('destroyNetworkDeviceImage/{id}', 'NetworkDeviceController@destroyImage') -> name('ndImgDestroy');
      Route::get('destroyPeripheralImage/{id}', 'PeripheralController@destroyImage') -> name('peripheralImgDestroy');
      Route::get('destroyUninterruptiblePowerSupplyImage/{id}', 'UninterruptiblePowerSupplyController@destroyImage') -> name('upsImgDestroy');
      Route::get('destroyNotebookChargerImage/{id}', 'NotebookChargerController@destroyImage') -> name('ncImgDestroy');
});
