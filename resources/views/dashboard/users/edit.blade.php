@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit User</h1>
    </div>

    <div class="col-lg-8">
        <form method="post" action="/dashboard/users/{{ $user->username }}" class="mb-5">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required autofocus value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" required value="{{ old('username', $user->username) }}">
                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="mb-3 {{  $user->is_superadmin ? 'visually-hidden' : '' }}">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="off" {{  $user->is_superadmin ? 'disabled' : 'required' }} aria-describedby="passwordHelpBlock">
                <div id="passwordHelpBlock" class="form-text mb-1">
                    Minimal 8 Karakter yang berisi kombinasi huruf besar, huruf kecil, angka dan simbol.
                </div>
                <div class="form-check m-0">
                    <input class="form-check-input" type="checkbox" value="" id="checkPassword">
                    <label class="form-check-label" for="flexCheckDefault">
                      Show Password
                    </label>
                </div>

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="mb-3 {{  $user->is_superadmin ? 'visually-hidden' : '' }}">
                <input type="checkbox" class="form-check-input @error('is_admin') is-invalid @enderror" id="is_admin" name="is_admin" {{  $user->is_admin ? 'checked' : '' }} {{  $user->is_superadmin ? 'disabled' : '' }} value="">
                <label for="flexCheckDefault" class="form-check-label">Admin</label>
                @error('is_admin')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
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


