
@extends('layouts.auth')

@section('title', 'პაროლის აღდგენა')

@section('content')

<div class="content-wrapper">

 <section id="form-section">
  <div class="form-wrapper">
     <form id="login-form" method="POST" action="{{ route('password.update') }}" autocomplete="off">
       @csrf

       <input type="hidden" name="token" value="{{ $token }}">

       <div class="company-logo">
         <a href="/" target="_blank">
          <img src="/images/general/logo.png">
         </a>
        </div>

       <div class="input-wrapper">
         <i class="fa fa-envelope" aria-hidden="true"></i>
         <input type="text" class="form-input font-3" name="email" placeholder="ელ. ფოსტა" value="{{ $email ?? old('email') }}"/>
       </div>

        <div class="input-wrapper">
          <i class="fa fa-lock" aria-hidden="true"></i>
          <input type="password" class="form-input font-3" name="password" placeholder="პაროლი"/>
        </div>

        <div class="input-wrapper">
          <i class="fa fa-lock" aria-hidden="true"></i>
          <input type="password" class="form-input font-3" name="password_confirmation" placeholder="გაიმეორეთ პაროლი"/>
        </div>

       <div class="submit-button-wrapper">
         <input class="submit-button font-3" type="submit" value="შეცვლა" name="register">
       </div>

     </form>
  </div>
 </section>

</div>

@endsection
