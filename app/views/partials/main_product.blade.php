@if($product)
<div class="main-product">
    <div class="img">
        @if($image = $product->getImage('main')->getSmallest())
        <img class="img-responsive" src="{{ $image->url }}" alt=""/>
        @endif
    </div>

    <div class="product-info">

        <div class="row">
            <div class="key">Model:</div>
            <div class="value">{{ $product->model }}</div>
        </div>

        <div class="row">
            <div class="key">Brand:</div>
            <div class="value">{{ $product->brand }}</div>
        </div>

        <div class="row">
            <div class="key">Gender:</div>
            <div class="value">{{ $product->gender }}</div>
        </div>

        <div class="prices">
            @if($product->hasOfferPrice())
            <span class="before-price">{{ $product->getBeforePrice()->format() }}</span>
            @endif
            <span class="actual-price">{{ $product->getActualPrice()->format() }}</span>
        </div>
    </div>
</div>
@endif