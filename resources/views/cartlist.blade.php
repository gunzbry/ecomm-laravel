@extends('master')
@section('content')
<div class="custom-product">
    {{-- Filter --}}
    <div class="row">
        <div class="col-sm-10">
            {{-- Search Result --}}
            <div class="trending-wrapper">
                <h3>My Cart</h3>
                <div class="">
                    @foreach ($products as $item)
                        <div class="row searched-item cart-list-divider">
                            <div class="col-sm-3">
                                <a href="detail/{{ $item->id }}">
                                    <img class="trending-image" src="{{ $item->gallery }}">
                                </a>
                            </div>
                            <div class="col-sm-4">
                                <div class="">
                                    <h3>{{ $item->name }}</h3>
                                    <h5>{{ $item->description }}</h5>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-warning" href="/removecart/{{ $item->cart_id }}">Remove From Cart</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection