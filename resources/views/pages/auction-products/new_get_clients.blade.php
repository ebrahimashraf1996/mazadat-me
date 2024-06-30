<select class="form-control" name="search_client" onchange="update_original(this)">
    <option value="">أختر العميل</option>
    @foreach($clients as $client)
    <option value="{{ $client->username }}">{{ $client->username }}</option>
    @endforeach
  </select>
