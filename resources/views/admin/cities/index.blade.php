
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
                                <th>{{ __('#') }}</th>
                                <th>{{ __('admin/app.name') }}</th>
                                <th>{{ __('admin/app.country') }}</th>
                                <th>{{ __('admin/app.active') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr id="row_{{ $row->id }}">
                                <td> {{$loop->iteration}} </td>
                                <td> {{ $row->name }}  </td>
                                <td> {{ $row->country->name }}  </td>
                                <td>
                                    <div class="custom-switch custom-switch-primary mb-2">
                                        <input class="custom-switch-input" id="active_{{ $row->id }}" {{ $row->active==1?'checked':'' }} value="{{ $row->active==1?0:1 }}" name="active" type="checkbox">
                                        <label class="custom-switch-btn " onclick="modelActive({{ $row->id }},'cities')" ></label>
                                    </div>
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
