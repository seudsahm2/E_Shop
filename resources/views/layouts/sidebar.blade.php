<div class="shop_sidebar_area">
    <!-- Single Widget - Categories -->
    <div class="widget catagory mb-50">
        <h6 class="widget-title mb-30">Categories</h6>
        <div class="catagories-menu">
            <ul>
                <li class="active"><a href="#">Chairs</a></li>
                <li><a href="#">Beds</a></li>
                <li><a href="#">Accessories</a></li>
                <li><a href="#">Furniture</a></li>
                <li><a href="#">Home Deco</a></li>
                <li><a href="#">Dressings</a></li>
                <li><a href="#">Tables</a></li>
            </ul>
        </div>
    </div>

    <!-- Single Widget - Brands -->
    <div class="widget brands mb-50">
        <h6 class="widget-title mb-30">Brands</h6>
        <div class="widget-desc">
            @foreach(['Amado', 'Ikea', 'Furniture Inc', 'The Factory', 'Artdeco'] as $brand)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="{{ strtolower(str_replace(' ', '-', $brand)) }}">
                    <label class="form-check-label" for="{{ strtolower(str_replace(' ', '-', $brand)) }}">{{ $brand }}</label>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Single Widget - Color -->
    <div class="widget color mb-50">
        <h6 class="widget-title mb-30">Color</h6>
        <div class="widget-desc">
            <ul class="d-flex">
                @foreach(range(1, 8) as $color)
                    <li><a href="#" class="color{{ $color }}"></a></li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Single Widget - Price -->
    <div class="widget price mb-50">
        <h6 class="widget-title mb-30">Price</h6>
        <div class="widget-desc">
            <div class="slider-range">
                <div data-min="10" data-max="1000" data-unit="$" class="slider-range-price ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" data-value-min="10" data-value-max="1000" data-label-result="">
                    <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                    <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                    <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                </div>
                <div class="range-price">$10 - $1000</div>
            </div>
        </div>
    </div>
</div>