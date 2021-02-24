
@extends('layouts.auth')

@section('title', 'ავტორიზაციის ფორმა')

@section('content')

<link href="/assets/css/snackbar.css" rel="stylesheet">

<div class="content-wrapper">

<section id="form-section">
 <div class="form-wrapper">
     <form id="login-form" method="POST" action="{{ route('login') }}" autocomplete="off">
       @csrf
       <div class="company-logo">
         <a href="/" target="_blank">
          <img src="/images/general/logo.png">
         </a>
        </div>

       <div class="input-wrapper">
         <i class="fa fa-envelope" aria-hidden="true"></i>
         <input type="text" class="form-input font-3" name="email" placeholder="ელ. ფოსტა"/>
       </div>

        <div class="input-wrapper">
          <i class="fa fa-lock" aria-hidden="true"></i>
          <input type="password" class="form-input font-3" name="password" placeholder="პაროლი"/>
        </div>

       <div class="input-wrapper">
          <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}/>
          <label class="font-3"> დამახსოვრება </label>
       </div>

       <div class="input-wrapper">
        <a id="password-reset" href="{{ route('password.request') }}">
           <i class="fas fa-undo"></i>
           <span class="font-3"> პაროლის აღდგენა </span>
        </a>
       </div>

       <div class="submit-button-wrapper">
         <input class="submit-button font-3" type="submit" value="სისტემაში შესვლა" name="login">
       </div>

     </form>
 </div>
</section>

</div>

<!--- snackbar element to display request response --->

<div id="snackbar">
 <i class="fa fa-info-circle"></i>
 <span class="message font-4"></span>
</div>

@include('parts.user.general')

<!--- Form processing script --->

<script type="text/javascript">

function submitHandler(e)
{
   e.preventDefault();

   let successCallback = (data) => data["authenticated"] && (window.location.href = data["redirect"]);
   let errorCallback = (xhr, status, error) => printMessage("აუტენტიფიკაციის შეცდომა");
   let data = $(this).serialize();
   let method = $(this).attr("method");
   let address = $(this).attr("action");

   sendRequest(method, address, data, successCallback, errorCallback);
}

$("#login-form").submit(submitHandler);

</script>

@endsection
