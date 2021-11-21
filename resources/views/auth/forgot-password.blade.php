
@extends('auth.app')
@section('content')
<div class="row h-100">
    <div class="col-12 col-md-10 mx-auto my-auto">
        <div class="card auth-card">
            <div class="position-relative image-side ">

            </div>
            <div class="form-side">
                <a href="Dashboard.Default.html">
                    <span class="logo-single"></span>
                </a>
                <p>
                    @include('message')

                </p>
                <h6 class="mb-4">{{ __('admin/app.forget_password') }}</h6>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <span class="mb-4 text-danger" >{{ session('status') }}</span>
                    <label class="form-group has-float-label mb-4">
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}"  />
                        <span>E-mail</span>
                    </label>

                    <div class="d-flex justify-content-end align-items-center">
                        <button class="btn btn-primary btn-lg btn-shadow" type="submit">RESET</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
