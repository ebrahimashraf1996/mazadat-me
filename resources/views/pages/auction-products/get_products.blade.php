<select class="form-control" name="search_product">
    <option value="">أختر المنتج</option>
    @foreach($products as $product)
      <option value="{{ $product->id }}">{{ $product->name }}</option>
    @endforeach
</select>