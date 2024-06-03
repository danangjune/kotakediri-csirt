@extends('layouts.main')

@section('container')

<div class="d-flex justify-content-center" style="margin-top: 125px">
    <div class="col-md-4">

      @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if (session()->has('loginError'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('loginError') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      
        <main class="form-signin">
            <h1 class="h3 mb-3 fw-normal text-center">Please Login</h1>
            <form action="/login" method="post">
              @csrf
              <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control rounded @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" value="{{ old('email') }}" autofocus required>
                <label for="email">Email Address</label>
                @error('email')
                   <div class="invalid-feedback">{{ $message }}</div> 
                @enderror
              </div>
              

              <div class="form-floating mb-3" >
                <input type="password" name="password" class="form-control rounded" autocomplete="off" id="password" placeholder="Password" required>
                <label for="password">Password</label>
              </div>
              <div class="form-check m-0">
                <input class="form-check-input" type="checkbox" value="" id="checkPassword">
                <label class="form-check-label" for="flexCheckDefault">
                  Show Password
                </label>
              </div>

              <div class="form-floating mt-3 mb-3">
                <div class="captcha">
                    <span>{!! captcha_img() !!}</span>
                    <button type="button" class="btn btn-danger" class="reload" id="reload">
                        &#x21bb;
                    </button>
                </div>
              </div>

              <div class="form-floating mb-4">
                  <input id="captcha" type="text" autocomplete="off" class="form-control @error('captcha') is-invalid @enderror" placeholder="Enter Captcha" name="captcha" required>
                  <label for="captcha">Enter Captcha</label>
                  @error('captcha')
                    <div class="invalid-feedback"> Please provide a valid captcha.</div> 
                  @enderror
              </div>
          
              <button class="w-100 btn btn-lg btn-primary mb-5" type="submit">Login</button>
            </form>
        </main>
    </div>
</div>

<script nonce="{{ csp_nonce() }}" type="text/javascript">
const y = document.getElementById("checkPassword");
  y.addEventListener("click", myFunction);

  function myFunction() {
    const x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
</script>


@endsection



