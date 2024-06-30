<!-- Start Data Client -->
@isset($client)
<input type="hidden" value="@isset($client) {{$client->id}} @endisset" name="client_id">
<div class="form-group col-lg-4 data_client">
    <label>الأسم</label>
    <input type="text" class="form-control form-control-solid" name="name" value="{{$client->name}}" required>
    @error('name')
      <span class="text-danger">{{$message}} </span>
    @enderror
</div>

<div class="form-group col-lg-4 data_client">
  <label>اسم المستخدم</label>
  <input type="text" class="form-control form-control-solid" name="username" value="{{$client->username}}" required>
  @error('username')
    <span class="text-danger">{{$message}} </span>
  @enderror
</div>


<div class="form-group col-lg-4 data_client">
    <label>موبايل </label>
    <input type="number" class="form-control form-control-solid" name="phone1" required value="{{$client->phone1}}" required>
    @error('phone1')
      <span class="text-danger">{{$message}} </span>
    @enderror
</div>


<!-- End Data Client -->
@else
<input type="hidden" value="" name="client_id">
<div class="form-group col-lg-4 data_client">
    <label>الأسم</label>
    <input type="text" class="form-control form-control-solid" name="name" required>
    @error('name')
      <span class="text-danger">{{$message}} </span>
    @enderror
</div>

<div class="form-group col-lg-4 data_client">
  <label>اسم المستخدم</label>
  <input type="text" class="form-control form-control-solid" name="username" required>
  @error('username')
    <span class="text-danger">{{$message}} </span>
  @enderror
</div>

<div class="form-group col-lg-4 data_client">
    <label>موبايل  </label>
    <input type="number" class="form-control form-control-solid show-phone" name="phone1" required>
    @error('phone1')
      <span class="text-danger">{{$message}} </span>
    @enderror
</div>

<!-- End Data Client -->
@endisset


<script>
$(function(){
  $('.btn-search-client').click(function(e){
    e.preventDefault();
      $url = $('#search_client').attr('data-url');
      $mobile = $('#search_client').val();
      $.ajax({
        url:$url,
        type:"GET",
        dataType:"JSON",
        data:{mobile:$mobile},
        success:function(data){
            $('.show-client').html(data.client);
        }
      });
  });
});
</script>
