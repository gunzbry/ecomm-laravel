@extends('master')
@section('content')
<div class="custom-product">
    {{-- Filter --}}
    <div class="row">
        <div class="col-md-6">
            <a href="#">Filter</a>
        </div>
        <div class="col-md-6">
            {{-- Search Result --}}
            <div class="trending-wrapper">
                <h3>Search Results</h3>
                <div class="">
                    @foreach ($products as $item)
                        <div class="trending-item">
                            <a href="detail/{{ $item['id'] }}">
                                <img class="trending-image" src="{{ $item['gallery'] }}">
                                <div class="">
                                    <h5>{{ $item['name'] }}</h5>
                                    <h5>{{ $item['description'] }}</h5>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>    
    </div>

    {{-- Trending Wrapper --}}
    <div class="trending-wrapper">
        <h3>Trending Products</h3>
        <div class="">
            @foreach ($data_trending as $item)
                <div class="trending-item">
                    <a href="detail/{{ $item['id'] }}">
                        <img class="trending-image" src="{{ $item['gallery'] }}">
                        <div class="">
                            <h3>{{ $item['name'] }}</h3>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection