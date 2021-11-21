@extends('layouts.admin.master')
@section('content')
<div class="row">
    <div class="col-12">
        <h1>{{ __('admin/app.'.$title) }}</h1>
        @include('message')
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ __('admin/app.title') }}</th>
                                <th>{{ __('admin/app.user') }}</th>
                                <th>{{ __('admin/app.amount') }}</th>
                                <th>{{ __('admin/app.photo') }}</th>
                                <th>{{ __('admin/app.description') }}</th>
                                <th>{{ __('admin/app.accept_reject') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr id="row_{{ $row->id }}">
                                <td> {{ $row->title }}  </td>
                                <td> {{ $row->user->name }}  </td>
                                <td> {{ $row->amount }}  </td>
                                <td>
                                    <div class="row social-image-row gallery">
                                        <a href="{{ $row->image }}">
                                            <img src="{{ $row->image }}" alt="{{ $row->name }}" class="list-thumbnail border-0">
                                        </a>
                                    </div>
                                </td>
                                <td> {{ $row->description }}  </td>


                                <td>
                                    <div class="form-group">
                                        <button class="btn btn-success" onclick="changeProjectStatus({{ $row->id }},'recieve_offer')"><i class="simple-icon-check"></i></button>
                                        <button class="btn btn-danger" onclick="changeProjectStatus({{ $row->id }},'rejected')"><i class="simple-icon-close"></i></button>
                                    </div>
                                    {{-- <div class="custom-switch custom-switch-primary mb-2">
                                        <input class="custom-switch-input" id="active_{{ $row->id }}" {{ $row->active==1?'checked':'' }} value="{{ $row->active==1?0:1 }}" name="active" type="checkbox">
                                        <label class="custom-switch-btn " onclick="modelActive({{ $row->id }},'projects')" ></label>
                                    </div> --}}


                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
