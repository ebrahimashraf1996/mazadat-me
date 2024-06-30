@isset($product)
<input type="hidden" value="@isset($product) {{$product->id}} @endisset" name="product_id">
<div class="form-group col-lg-6">
    <label>أسم المنتج</label> 
    <input type="text" class="form-control form-control-solid" name="name" value="{{ $product->name }}" required>
    @error('name')
    <span class="text-danger">{{$message}} </span>
    @enderror
</div>

<div class="form-group col-lg-6">
    <label>الكمية</label>
    <input type="number" min="0" class="form-control form-control-solid" name="qty" value="{{ $product->qty }}" required>
    @error('qty')
    <span class="text-danger">{{$message}} </span>
    @enderror
</div>

<div class="form-group col-lg-6">
    <label>سعر القطعة</label>
    <input type="number" min="0" class="form-control form-control-solid" name="price" value="{{ $product->price }}" required>
    @error('price')
    <span class="text-danger">{{$message}} </span>
    @enderror
</div>

<div class="form-group col-lg-6">
    <label>صورة المنتج</label>
    <input type="file" class="form-control form-control-solid" name="image">
    @error('image')
        <span class="text-danger">{{$message}} </span>
    @enderror
</div>

<div class="form-group col-lg-12">
    <label>ملاحظات علي المنتج</label>
    <textarea class="form-control form-control-solid ckeditor" name="notes" rows="6"> 
        {!! $product->notes !!}
    </textarea>
    @error('image')
        <span class="text-danger">{{$message}} </span>
    @enderror
 </div>

{{-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ --}}
 @else

 <input type="hidden" value="" name="product_id">

 <div class="form-group col-lg-6">
    <label>أسم المنتج</label>
    <input type="text" class="form-control form-control-solid" name="name" required>
    @error('name')
    <span class="text-danger">{{$message}} </span>
    @enderror
</div>

<div class="form-group col-lg-6">
    <label>الكمية</label>
    <input type="number" min="0" class="form-control form-control-solid" name="qty" required>
    @error('qty')
    <span class="text-danger">{{$message}} </span>
    @enderror
</div>

<div class="form-group col-lg-6">
    <label>سعر القطعة</label>
    <input type="number" min="0" class="form-control form-control-solid" name="price" required>
    @error('price')
    <span class="text-danger">{{$message}} </span>
    @enderror
</div>

<div class="form-group col-lg-6">
    <label>صورة المنتج</label>
    <input type="file" class="form-control form-control-solid" name="image">
    @error('image')
        <span class="text-danger">{{$message}} </span>
    @enderror
</div>

<div class="form-group col-lg-12">
    <label>ملاحظات علي المنتج</label>
    <textarea class="form-control form-control-solid ckeditor" name="notes" rows="6"> </textarea>
    @error('image')
        <span class="text-danger">{{$message}} </span>
    @enderror
 </div>
 @endisset
