<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;
use PDF as DOMPDF;

class ConfiguratorController extends Controllers\Controller
{
    public function index()
    {
      $model = new \App\Models\Site\Configurator();

      \App\Models\Site\BaseModel::collectStatisticalData($model);

      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      return view('contents/site/configurator/index', ['generalData' => $generalData]);
    }

    public function generateDocument(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $documentData = $model -> getDocumentData($request);

      $pdf = DOMPDF::loadHTML($documentData['documentHtmlText']) -> setPaper('a4', 'landscape');

      return $pdf -> stream($documentData['documentName']);
    }

    // get computer parts logic

    public function getProcessors(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getProcessorsData($request);

      return view('contents/site/configurator/getProcessors', ['data' => $resultData]);
    }

    public function getMotherboards(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getMotherboardsData($request);

      return view('contents/site/configurator/getMotherboards', ['data' => $resultData]);
    }

    public function getMemories(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getMemoriesData($request);

      return view('contents/site/configurator/getMemories', ['data' => $resultData]);
    }

    public function getProcessorCoolers(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getProcessorCoolersData($request);

      return view('contents/site/configurator/getProcessorCoolers', ['data' => $resultData]);
    }

    public function getCases(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getCasesData($request);

      return view('contents/site/configurator/getCases', ['data' => $resultData]);
    }

    public function getPowerSupplies(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getPowerSuppliesData($request);

      return view('contents/site/configurator/getPowerSupplies', ['data' => $resultData]);
    }

    public function getVideoCards(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getVideoCardsData($request);

      return view('contents/site/configurator/getVideoCards', ['data' => $resultData]);
    }

    public function getHardDiskDrives(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getHardDiskDrivesData($request);

      return view('contents/site/configurator/getHardDiskDrives', ['data' => $resultData]);
    }

    public function getSolidStateDrives(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getSolidStateDrivesData($request);

      return view('contents/site/configurator/getSolidStateDrives', ['data' => $resultData]);
    }

    // select computer part logic

    public function selectProcessor(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getSelectProcessorData($request);

      return response(json_encode($resultData)) -> header('Content-Type', 'application/json');
    }

    public function selectMotherboard(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getSelectMotherboardData($request);

      return response(json_encode($resultData)) -> header('Content-Type', 'application/json');
    }

    public function selectMemory(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getSelectMemoryData($request);

      return response(json_encode($resultData)) -> header('Content-Type', 'application/json');
    }

    public function selectProcessorCooler(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getSelectProcessorCoolerData($request);

      return response(json_encode($resultData)) -> header('Content-Type', 'application/json');
    }

    public function selectCase(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getSelectCaseData($request);

      return response(json_encode($resultData)) -> header('Content-Type', 'application/json');
    }

    public function selectPowerSupply(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getSelectPowerSupplyData($request);

      return response(json_encode($resultData)) -> header('Content-Type', 'application/json');
    }

    public function selectVideoCard(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getSelectVideoCardData($request);

      return response(json_encode($resultData)) -> header('Content-Type', 'application/json');
    }

    public function selectHardDiskDrive(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getSelectHardDiskDriveData($request);

      return response(json_encode($resultData)) -> header('Content-Type', 'application/json');
    }

    public function selectSolidStateDrive(Request $request)
    {
      $model = new \App\Models\Site\Configurator();

      $resultData = $model -> getSelectSolidStateDriveData($request);

      return response(json_encode($resultData)) -> header('Content-Type', 'application/json');
    }
}
