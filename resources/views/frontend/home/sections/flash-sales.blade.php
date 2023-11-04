@php
    use App\Models\Product;
@endphp
<section id="wsus__flash_sell" class="wsus__flash_sell_2">
    <div class=" container">
        <div class="row">
            <div class="col-xl-12">
                <div class="offer_time" style="background: url({{asset('frontend/images/flash_sell_bg.jpg')}})">
                    <div class="wsus__flash_coundown">
                        <span class=" end_text">Flash Sale</span>
                        <div class="simply-countdown simply-countdown-one"></div>
                        <a class="common_btn" href="{{route('flash-sale')}}">Xem thêm <i class="fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @if(count($flashSaleItems)>0)
            <div class="row flash_sell_slider">
                @php
                    $products = Product::withAvg('reviews', 'rating')
                    ->with(['variants.variantItems','category','productImageGalleries'])
                    ->withCount('reviews')
                    ->whereIn('id',$flashSaleItems)
                    ->get();
                @endphp
                @foreach($products as $product)
                    <x-product-card :product="$product"/>
                @endforeach
            </div>
        @endif

    </div>
</section>

@push('scripts')
    <script>
        $(document).ready(function () {
            simplyCountdown('.simply-countdown-one', {
                year: {{ date('Y', strtotime($flashSaleDate->end_date)) }},
                month: {{ date('m', strtotime($flashSaleDate->end_date)) }},
                day: {{ date('d', strtotime($flashSaleDate->end_date)) }},
                enableUtc: true
            });
        })


    </script>
@endpush



