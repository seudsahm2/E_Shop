<div class="shop_sidebar_area">
    <form action="{{ route('shop') }}" method="GET">
        <!-- Single Widget - Categories -->
        <div class="widget catagory mb-50">
            <h6 class="widget-title mb-30">Categories</h6>
            <div class="catagories-menu">
                <ul>
                    @foreach($categories as $category)
                    <li><a href="{{ route('shop', array_merge(request()->query(), ['category' => $category->id])) }}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Single Widget - Brands -->
        <div class="widget brands mb-50">
            <h6 class="widget-title mb-30">Brands</h6>
            <div class="widget-desc">
                @foreach($brands as $brand)
                <div class="brand-checkbox">
                    <input type="checkbox" id="brand_{{ $brand->id }}" name="brands[]" value="{{ $brand->id }}" {{ is_array(request('brands')) && in_array($brand->id, request('brands')) ? 'checked' : '' }}>
                    <label for="brand_{{ $brand->id }}">{{ $brand->name }}</label>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Single Widget - Color -->
        <div class="widget color mb-50">
            <h6 class="widget-title mb-30">Color</h6>
            <div class="widget-desc">
                @foreach($colors as $color)
                <div class="color-checkbox">
                    <input type="checkbox" id="color_{{ $color->id }}" name="colors[]" value="{{ $color->id }}" {{ is_array(request('colors')) && in_array($color->id, request('colors')) ? 'checked' : '' }}>
                    <label for="color_{{ $color->id }}" style="background-color: #{{ $color->hex_code }};"></label>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Single Widget - Price -->
        <div class="widget price mb-50">
            <h6 class="widget-title mb-30">Price</h6>
            <div class="widget-desc">
                <div class="price-range">
                    <input type="range" id="price_min" name="price_min" min="{{ $minPrice }}" max="{{ $maxPrice }}" step="10" value="{{ request('price_min', $minPrice) }}" oninput="updatePriceRange()">
                    <input type="range" id="price_max" name="price_max" min="{{ $minPrice }}" max="{{ $maxPrice }}" step="10" value="{{ request('price_max', $maxPrice) }}" oninput="updatePriceRange()">
                    <div class="price-values">
                        <span id="price_min_value">${{ request('price_min', $minPrice) }}</span> - <span id="price_max_value">${{ request('price_max', $maxPrice) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden Inputs for Preserving Other Filters -->
        @foreach(request()->except(['brands', 'colors', 'price_min', 'price_max']) as $key => $value)
        @if(is_array($value))
        @foreach($value as $v)
        <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
        @endforeach
        @else
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
        @endforeach

        <!-- Filter Button -->
        <button type="submit" class="btn btn-primary mt-2">Filter</button>
    </form>
</div>

<script>
    function updatePriceRange() {
        var priceMin = document.getElementById('price_min');
        var priceMax = document.getElementById('price_max');
        var minValue = parseInt(priceMin.value);
        var maxValue = parseInt(priceMax.value);

        // Ensure the min slider does not go beyond the max slider
        if (minValue >= maxValue) {
            priceMin.value = maxValue - 10;
            minValue = maxValue - 10;
        }

        // Ensure the max slider does not go below the min slider
        if (maxValue <= minValue) {
            priceMax.value = minValue + 10;
            maxValue = minValue + 10;
        }

        document.getElementById('price_min_value').innerText = '$' + minValue;
        document.getElementById('price_max_value').innerText = '$' + maxValue;
    }

    // Initialize the price range values on page load
    document.addEventListener('DOMContentLoaded', function() {
        updatePriceRange();
    });
</script>