@extends('client.homepage.layout')
@section('content')
    <div class="product-container">
        <div class="uk-container uk-container-center">
            @include('client.component.breadcrumb', [
                'model' => $productCatalogue,
                'breadcrumb' => $breadcrumb,
            ])
            <div class="panel-body">
                @include('client.component.product-detail', [
                    'product' => $product,
                    'productVariant' => $productVariant,
                    'productCatalogue' => $productCatalogue,
                ])
                </div>
            </div>
        </div>
@endsection
