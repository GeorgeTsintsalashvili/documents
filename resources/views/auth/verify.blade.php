
@extends('layouts.auth')

@section('title', 'ელექტრონული ფოსტის დადასტურება')

@section('content')

<div class="content-wrapper-wide">

 <section id="form-section">
  <div class="form-wrapper">
     <form id="login-form" method="POST" action="{{ route('verification.resend') }}" autocomplete="off">
       @csrf
       <div class="company-logo">
         <a href="/" target="_blank">
          <img src="/images/general/logo.png">
         </a>
        </div>

        <div class="input-wrapper">
         <a class="notification" href="{{ route('login') }}">
            <i class="fas fa-info-circle"></i>
            <span class="font-4"> დაადასტურეთ თქვენი {{ Auth::user() -> email }} მისამართის სინამდვილე </span>
         </a>
       </div>

       <div class="submit-button-wrapper">
         <input class="submit-button font-3" type="submit" value="ბმულის გაგზავნა" name="resend">
       </div>

     </form>
  </div>
 </section>

</div>

@endsection
