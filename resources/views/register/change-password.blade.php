@extends('dashboard.layouts.main')

@section('container')
    <div class="row" style="margin-top:1rem">

        <div class="col-md-10 offset-2">
            <div class="panel panel-default">
                <h2 class="mb-5">Change password</h2>

                <div class="panel-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors)
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <form class="form-horizontal" autocomplete="off" method="POST" action="/register/showChangePasswordGet">
                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('current-password') ? ' has-error' : '' }} mb-3">
                            <label for="current-password" class="col-md-4 form-label">Current Password</label>

                            <div class="col-md-6">
                                <input id="current-password" type="password" class="form-control" name="current-password" required autofocus>

                                @if ($errors->has('current-password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }} mb-3">
                            <label for="new-password" class="col-md-4 form-label">New Password</label>

                            <div class="col-md-6">
                                <input id="new-password" type="password" class="form-control" name="new-password" required aria-describedby="passwordHelpBlock">
                                <div id="passwordHelpBlock" class="form-text">
                                    Minimal 8 Karakter yang berisi kombinasi huruf besar, huruf kecil, angka dan simbol.
                                </div>

                                @if ($errors->has('new-password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new-password-confirm" class="col-md-4 form-label">Confirm New Password</label>

                            <div class="col-md-6 mb-1">
                                <input id="confirm-password" type="password" class="form-control" name="new-password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="checkPassword">
                            <label class="form-check-label" for="flexCheckDefault">
                              Show Password
                            </label>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Change Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script nonce="{{ csp_nonce() }}" type="text/javascript">
        const y = document.getElementById("checkPassword");
          y.addEventListener("click", myFunction);
        
          function myFunction() {
            const collection = document.getElementsByClassName("form-control");
            for (let i = 0; i < collection.length; i++) {
                if (collection[i].type === "password") {
                  collection[i].type = "text";
                } else {
                  collection[i].type = "password";
                }
            }
          }
    </script>
@endsection