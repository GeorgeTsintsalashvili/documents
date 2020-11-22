<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

class ContactController extends Controllers\Controller
{
    public function index()
    {
      $generalData = \App\Models\Site\BaseModel::getGeneralData();

      return view('contents/site/contact/index', ['generalData' => $generalData]);
    }

    public function sendMessage(Request $request)
    {
      $model = new \App\Models\Site\Contact();

      $responseData = $model -> getSendMessageData($request);

      return response(json_encode($responseData)) -> header('Content-Type', 'application/json');
    }
}
