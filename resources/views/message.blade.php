@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session()->has('Add'))

<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
     {{ session()->get('Add') }}
</div>



@endif


@if (session()->has('Edit'))

<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
     {{ session()->get('Edit') }}
</div>

@endif

@if (session()->has('danger'))

<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
    <div class="d-flex align-items-center">
        <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
        </div>
        <div class="ms-3">
            <div class="text-white">{{ session()->get('danger') }}</div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if ($errors->any())
<div class="alert alert-icon-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <div class="alert-icon icon-part-danger">
        <i class="fa fa-times"></i>
    </div>
    <div class="alert-message">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
    </div>
</div>
@endif
