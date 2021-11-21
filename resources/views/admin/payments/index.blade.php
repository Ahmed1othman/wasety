@extends('layouts.admin.master')
@section('title')
   {{__('admin/app.website_settings')}}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('admin/app.payments') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('admin/app.home') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('admin/app.payments') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">

            <div class="card-body">
                <form class="kt-form" id="kt_form" method="post" action="{{route('payments.store')}}"
                    enctype="multipart/form-data">
                    @csrf
                @foreach ($data as $row)
                    <div class="row">
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label>{{__('admin/app.'.$row->option)}}</label>
                            </div>
                        </div>
                        @if ($row->type=='image')
                        <div class="col-xl-2">
                            <div class="form-group">
                                @if (!empty($row->value))
                                <img style="height: 100px;width: 120px;"
                                    src="{{ asset('storage/payments/'.$row->value ) }}">
                                @endif

                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">

                                <input type="file" class="form-control" name="{{$row->option}}">
                            </div>
                        </div>
                        @elseif ($row->type=='string')
                        <div class="col-xl-8">
                            <div class="form-group">
                                <input type="text" class="form-control" name="{{$row->option}}" required
                                    placeholder="{{__('admin/app.'.$row->option)}}"
                                    value="{{ old('value', $row->value  ) }}">
                            </div>
                        </div>
                        @elseif ($row->type=='text')

                        <div class="col-xl-8">
                            <div class="form-group">
                                <div class="form-group">
                                    <textarea  name="{{$row->option}}" id="{{ $row->option }}" class="form-control"  rows="3">{{ $row->value }}</textarea>
                              </div>
                            </div>
                        </div>
                                   @else
                        <div class="col-xl-8">
                            <div class="form-group">
                                <input type="{{ $row->type }}" class="form-control" name="{{$row->option}}" required
                                    placeholder="{{__('admin/app.'.$row->option)}}"
                                    value="{{ old('value', $row->value  ) }}">
                            </div>
                        </div>
                        @endif

                    </div>

                    <hr>
                    @endforeach
                    <div class="col-xl-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning">{{__('admin/app.update')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
