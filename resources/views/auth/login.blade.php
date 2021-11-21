@extends('auth.app')
@section('content')

    <div class="row h-100">
        <div class="col-12 col-md-10 mx-auto my-auto">
            <div class="card auth-card">
                <div class="position-relative image-side ">


                    <p class="white mb-0">
                        Please use your credentials to login.
                        <br>If you are not a member, please
                        <a href="#" class="white">register</a>.
                    </p>
                </div>
                <div class="form-side">
                    <a href="#">
                        <span class="logo-single"></span>
                    </a>
                    <p>
                        @if (session()->has('error'))

                            <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                                <div class="d-flex align-items-center">
                                    <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                                    </div>
                                    <div class="ms-3">
                                        <div class="text-white">{{ session()->get('error') }}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                    </p>
                    <h6 class="mb-4">Login</h6>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <label class="form-group has-float-label mb-4">
                            <input class="form-control @error('email')
                                text-danger
                            @enderror"  type="email" name="email" value="{{ old('email') }}"  required/>
                            <span>E-mail</span>
                        </label>

                        <label class="form-group has-float-label mb-4">
                            <input class="form-control @error('password')
                            text-danger
                            @enderror" name="password" type="password" placeholder=""required />
                            <span>Password</span>
                        </label>
                        <div class="d-flex justify-content-between align-items-center">
                            @if (Route::has('password.request'))
                            <a  href="{{ asset(route('password.request'))}}">
                                {{ __('Forgot your password?') }}
                            </a>
                                @endif
                            <button class="btn btn-primary btn-lg btn-shadow" type="submit">LOGIN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
