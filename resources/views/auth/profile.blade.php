@extends('layouts.admin.master')
@section('content')

<div class="row">
    <div class="col-12 col-lg-12 mb-5">
        <h5 class="mb-5">{{ __('admin/app.profile') }}</h5>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-4"><i class="simple-icon-pencil"></i></h5>

                    <form  class="needs-validation tooltip-label-right" novalidate action="{{route('users.update',auth()->user()->id)}}" method="post" autocomplete="off" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                    <input type="hidden" name="id" value="{{auth()->user()->id}}">
                    <div class="form-group has-float-label">
                        @if(auth()->user()->photo)
                        <img class="img-fluid border-radius" src="{{ auth()->user()->photo }}" width="200px">
                        @endif
                    </div>
                    <div class="form-group position-relative error-l-50">
                        <label>{{ __('admin/app.first_name') }}</label>
                        <input class="form-control @error('first_name') is-invalid @enderror" placeholder="{{ __('admin/app.first_name') }}" name="first_name" value="{{ old('first_name')?old('first_name'):auth()->user()->first_name }}" required >
                        @error('first_name')
                        <div class="invalid-tooltip" >
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group position-relative error-l-50">
                        <label>{{ __('admin/app.last_name') }}</label>
                        <input class="form-control @error('last_name') is-invalid @enderror" placeholder="{{ __('admin/app.last_name') }}" name="last_name" value="{{ old('last_name')?old('last_name'):auth()->user()->last_name }}" required >
                        @error('last_name')
                        <div class="invalid-tooltip" >
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group position-relative error-l-50">
                        <label>{{ __('admin/app.phone') }}</label>
                        <input type="number" class="form-control @error('phone') is-invalid @enderror" placeholder="{{ __('admin/app.phone') }}" name="phone" value="{{ old('phone')?old('phone'):auth()->user()->phone }}" required >
                        @error('phone')
                        <div class="invalid-tooltip" >
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group position-relative error-l-50">
                        <label>{{ __('admin/app.email') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('admin/app.email') }}" name="email" value="{{ old('email')?old('email'):auth()->user()->email }}" required >
                        @error('email')
                        <div class="invalid-tooltip" >
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="form-group position-relative error-l-50">
                        <label>{{ __('admin/app.country') }}</label>
                        <select class="form-control select2-single @error('country_id') is-invalid @enderror"  name="country_id" id="country_id"  onchange="getCities(this.value)">
                            <option value=""></option>
                            @foreach ($countries as $country)
                            <option value="{{ $country->id }}" {{ auth()->user()->country_id==$country->id }}>{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('country_id')
                        <div class="invalid-tooltip" >
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group position-relative error-l-50">
                        <label>{{ __('admin/app.city') }}</label>
                        <select class="form-control select2-single @error('city_id') is-invalid @enderror"  name="city_id" id="city_id" >
                            <option value=""></option>

                        </select>
                        @error('city_id')
                        <div class="invalid-tooltip" >
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <div class="form-group position-relative error-l-50">
                        <label>{{ __('admin/app.fb_link') }}</label>
                        <input type="text" class="form-control @error('fb_link') is-invalid @enderror" placeholder="{{ __('admin/app.fb_link') }}" name="fb_link" value="{{ old('fb_link')?old('fb_link'):auth()->user()->fb_link }}"  >
                        @error('fb_link')
                        <div class="invalid-tooltip" >
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group position-relative error-l-50">
                        <label>{{ __('admin/app.tw_link') }}</label>
                        <input type="text" class="form-control @error('tw_link') is-invalid @enderror" placeholder="{{ __('admin/app.tw_link') }}" name="tw_link" value="{{ old('tw_link')?old('tw_link'):auth()->user()->tw_link }}"  >
                        @error('tw_link')
                        <div class="invalid-tooltip" >
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group position-relative error-l-50">
                        <label>{{ __('admin/app.in_link') }}</label>
                        <input type="text" class="form-control @error('in_link') is-invalid @enderror" placeholder="{{ __('admin/app.in_link') }}" name="in_link" value="{{ old('in_link')?old('in_link'):auth()->user()->in_link }}"  >
                        @error('in_link')
                        <div class="invalid-tooltip" >
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="form-group has-float-label">
                        <input type="file" class="form-control @error('photo') is-invalid @enderror" placeholder="{{ __('admin/app.photo') }}" name="image"  />
                        @error('photo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>
                    <div class="form-group position-relative error-l-50">
                        <label>{{ __('admin/app.password') }}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('admin/app.password') }}" name="password" value=""  >
                        @error('password')
                        <div class="invalid-tooltip" >
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group position-relative error-l-50">
                        <label>{{ __('admin/app.password_confirmation') }}</label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="{{ __('admin/app.password_confirmation') }}" name="password_confirmation" value=""  >
                        @error('password_confirmation')
                        <div class="invalid-tooltip" >
                            {{ $message }}
                        </div>
                        @enderror
                    </div>


                    <button type="submit" class="btn btn-primary mb-0">{{ __('admin/app.save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

    if(document.getElementById("country_id").value!=0){
        getCities(document.getElementById("country_id").value)
    }

    function getCities(country_id) {
        var all_cities = @json($cities);
        var cities = Object.values(all_cities.filter(city => city.country_id == country_id))
        html = '<option  value=""></option>'
        for (var i = 0; i < cities.length; i++) {
            html += '<option value="' + cities[i].id + '">' + cities[i].name + '</option>'
        }
        document.getElementById('city_id').innerHTML = html;

    }

</script>

@endsection
