<div class="card h-100 shadow-sm">

    <img src="{{ asset('storage/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->productname }}"
        style="height:180px;object-fit:cover;">

    <div class="card-body d-flex flex-column">

        <h6 class="card-title">
            {{ $product->productname }}
        </h6>

        @if ($product->pricediscount > 0)
            <small class="text-decoration-line-through">
                {{ number_format($product->price) }}
            </small>

            <h5 class="text-danger fw-bold">
                {{ number_format($product->pricediscount) }}
            </h5>
        @else
            <h5 class="text-danger fw-bold">
                {{ number_format($product->price) }}
            </h5>
        @endif

        <div class="mt-auto">

            <div class="row g-2">

                <div class="col-6">

                    <a href="{{ route('product.show', ['slug' => $product->slug]) }}" class="btn btn-primary w-100">

                        <i class="bi bi-eye"></i>

                    </a>

                </div>

                <div class="col-6">

                    <button class="btn btn-success w-100">

                        <i class="bi bi-cart-plus"></i>

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>
