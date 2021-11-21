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
                                <th>{{ __('admin/app.offer_winner') }}</th>
                                <th>{{ __('admin/app.description') }}</th>
                                <th>{{ __('admin/app.status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr id="row_{{ $row->id }}">
                                <td> {{ $row->title }}  </td>
                                <td> {{ $row->user->name }}  </td>
                                <td> {{ $row->amount }}  </td>
                                <td> {{ $row->offer? $row->offer->user->name:'' }}  </td>
                                <td> {{ $row->description }}  </td>
                                <td> {{ $row->status }} </td>
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
