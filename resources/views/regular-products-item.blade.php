<div class="regular-products-item">
  <div class="products-item__image">
    <a href="/catalog/{{ $product->slug }}" class="products-item__link">
      @if($product->image)
        <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="">
      @else
        <img src="/img/no-photo.jpg" alt="">
      @endif
    </a>
  </div>
  <a href="/catalog/{{ $product->slug }}" class="products-item__title">{{ $product->title }}</a>
  <div class="products-item__text">{{ Str::words(strip_tags(preg_replace('/&(.+?);/','', $product->text_html)), 8) }}</div>
  <div class="products-item-price-wrapper">
    @if($product->promo_price)
      <div class="products-item__price products-item__promo-price">
        <span class="products-item__value">{{ str_replace('.0', '', $product->promo_price) }}</span>
        <span class="products-item__currency">&#8381;</span>
        <div class="products-item__percent hidden-mobile">
          <img src="/img/product-percent-icon.png" alt="">
        </div>
      </div>
      <div class="products-item__old-price item__old-price">
        <span class="products-item__value">{{ str_replace('.0', '', $product->retail_price) }}</span>
        <span class="products-item__currency">&#8381;</span>
        <span class="line-through"></span>
      </div>
    @else
      <div class="products-item__price">
        <span class="products-item__value">{{ str_replace('.0', '', $product->retail_price) }}</span>
        <span class="products-item__currency">&#8381;</span>
        @if($product->property)
          <div class="products-item__percent">
            <img src="/img/product-hit-icon.png" alt="">
          </div>
        @endif
      </div>
    @endif
  </div>
  <div class="add-to-cart-btn add-to-cart" data-id="{{ $product->id }}">В корзину</div>
  <div class="add-to-favourites" data-id="{{ $product->id }}">
    <svg width="100%" height="100%" viewBox="0 0 23 21" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M10.9177 19.7475L2.65498 11.0978C0.327621 8.66145 0.474179 4.66658 2.97318 2.42425C5.45236 0.199689 9.21145 0.631665 11.1706 3.36625L11.5 3.82598L11.8294 3.36625C13.7886 0.631665 17.5476 0.199689 20.0268 2.42425C22.5258 4.66658 22.6724 8.66145 20.345 11.0978L12.0823 19.7475C11.7607 20.0842 11.2393 20.0842 10.9177 19.7475Z" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </div>
</div>