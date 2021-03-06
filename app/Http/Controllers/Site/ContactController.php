<?php

namespace App\Http\Controllers\Site;

use \App\Http\Controllers as Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\View;
use \App\Helpers\Paginator;
use \PHPMailer\PHPMailer\PHPMailer;

use \App\Models\Site\BaseModel;
use \App\Models\Site\Contact;

class ContactController extends Controllers\Controller
{
    public function index()
    {
      $generalData = BaseModel::getGeneralData();

      return View::make('contents.site.contact.index', ['generalData' => $generalData]);
    }

    public function sendMessage(Request $request)
    {
      $model = new \App\Models\Site\Contact();

      $data["messageSent"] = false;
      $data["fieldsAreNotEmpty"] = false;
      $data["emailFormatIsCorrect"] = false;
      $data["mobilePhoneFormatIsCorrect"] = false;

      $parameters = $request -> all();

      $validator = \Validator::make($parameters, ["name" => "required|string|min:2|max:50",
                                                  "email" => "required|string|email",
                                                  "phone" => "required|string|min:6|max:30|regex:/^(\+?\d{9,20})$/",
                                                  "message" => "required|string|min:10|max:1000",
                                                  "_token" => "required|string"]);
      if (!$validator -> fails())
      {
        $data["fieldsAreNotEmpty"] = true;
        $data["emailFormatIsCorrect"] = true;
        $data["mobilePhoneFormatIsCorrect"] = true;

        $parameters["message"] = preg_replace("/\s{2,}/", " ", $parameters["message"]);
        $parameters["name"] = preg_replace("/\s{2,}/", " ", $parameters["name"]);

        $parameters["message"] = htmlentities($parameters["message"], ENT_QUOTES, "UTF-8");
        $parameters["name"] = htmlentities($parameters["name"], ENT_QUOTES, "UTF-8");

        $sessionToken = $request -> session() -> token();

        if (hash_equals($sessionToken, $parameters["_token"]))
        {
          $templateFullName = base_path() . "/resources/views/contents/site/contact/message.blade.php";

          if (file_exists($templateFullName))
          {
            $htmlText = file_get_contents($templateFullName);

            $placeholders = ["{name}", "{email}", "{phone}", "{message}"];
            $valuesToPlace = [$parameters["name"], $parameters["email"], $parameters["phone"], $parameters["message"]];

            $recipientAddress = "itworksg@itworks.ge";
            $subject = "Contact page message";
            $senderName = "ITWorks";
            $senderAddress = "info@itw.ge";
            $messageToSend = str_replace($placeholders, $valuesToPlace, $htmlText);
            $headers = ["MIME-Version: 1.0", "Content-Type: text/html;charset=utf-8"];

            $mailer = new PHPMailer();

            $mailer -> CharSet = "UTF-8";
            $mailer -> Host = "localhost"; // mail.itw.ge

      //    $mailer -> SMTPAuth = true;
     //     $mailer -> Username = "info@itw.ge";
    //      $mailer -> Password = "Unicef1993$";
   //       $mailer -> SMTPSecure = "ssl";
            $mailer -> Port = 465;

            $mailer -> isHTML(true);
            $mailer -> FromName = $senderName;
            $mailer -> From = $senderAddress;
            $mailer -> addAddress($recipientAddress);
            $mailer -> Subject = $subject;
            $mailer -> Body = $messageToSend;
            $mailer -> addReplyTo($parameters["email"], "Reply");

            if ($mailer -> send())
            {
              $data["messageSent"] = true;

              \Session::regenerateToken();
            }
          }
        }
      }

      return response(json_encode($data)) -> header('Content-Type', 'application/json');
    }
}
