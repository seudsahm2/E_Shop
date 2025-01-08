<div class="shop_sidebar_area">
    <!-- Single Widget - Categories -->
    <div class="widget catagory mb-50">
        <h6 class="widget-title mb-30">Categories</h6>
        <div class="catagories-menu">
            <ul>
                @foreach($categories as $category)
                <li><a href="{{ route('shop', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Single Widget - Brands -->
    <div class="widget brands mb-50">
        <h6 class="widget-title mb-30">Brands</h6>
        <div class="widget-desc">
            <form action="{{ route('shop') }}" method="GET">
                @foreach($brands as $brand)
                <div class="brand-checkbox">
                    <input type="checkbox" id="brand_{{ $brand->id }}" name="brands[]" value="{{ $brand->id }}">
                    <label for="brand_{{ $brand->id }}">{{ $brand->name }}</label>
                </div>
                @endforeach
                <button type="submit" class="btn btn-primary mt-2">Filter</button>
            </form>
        </div>
    </div>

    <!-- Single Widget - Color -->
    <div class="widget color mb-50">
        <h6 class="widget-title mb-30">Color</h6>
        <div class="widget-desc">
            <form action="{{ route('shop') }}" method="GET">
                @foreach($colors as $color)
                <div class="color-checkbox">
                    <input type="checkbox" id="color_{{ $color->id }}" name="colors[]" value="{{ $color->id }}">
                    <label for="color_{{ $color->id }}">{{ $color->name }}</label>
                </div>
                @endforeach
                <button type="submit" class="btn btn-primary mt-2">Filter</button>
            </form>
        </div>
    </div>

    <!-- Single Widget - Price -->
    <div class="widget price mb-50">
        <h6 class="widget-title mb-30">Price</h6>
        <div class="widget-desc">
            <form action="{{ route('shop') }}" method="GET">
                <input type="range" name="price" min="0" max="1000" step="10" value="{{ request('price', 1000) }}">
                <button type="submit" class="btn btn-primary mt-2">Filter</button>
            </form>
        </div>
    </div>
</div>