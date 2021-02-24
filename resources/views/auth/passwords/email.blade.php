
@extends('layouts.auth')

@section('title', 'პაროლის აღდგენა')

@section('content')

<div class="content-wrapper">

 <section id="form-section">
  <div class="form-wrapper">
     <form id="login-form" method="POST" action="{{ route('password.email') }}" autocomplete="off">
       @csrf
       <div class="company-logo">
         <a href="/" target="_blank">
          <img src="/images/general/logo.png">
         </a>
        </div>

       <div class="input-wrapper">
         <i class="fa fa-envelope" aria-hidden="true"></i>
         <input type="text" class="form-input font-3" name="email" placeholder="შეიყვანეთ ელ. ფოსტა" value="{{ old('email') }}"/>
       </div>

       <div class="input-wrapper">
        <a id="auth-back" href="{{ route('login') }}">
           <i class="fas fa-sign-in-alt"></i>
           <span class="font-3"> ავტორიზაციის გვერდი </span>
        </a>
       </div>

       <div class="submit-button-wrapper">
         <input class="submit-button font-3" type="submit" value="აღდგენის ბმულის გაგზავნა">
       </div>

     </form>
  </div>
 </section>

</div>

@endsection
