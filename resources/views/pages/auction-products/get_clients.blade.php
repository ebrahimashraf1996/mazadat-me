<select class="form-control" name="search_client">
    <option value="">أختر العميل</option>
    @foreach($clients as $client)
    <option value="{{ $client->username }}">{{ $client->username }}</option>
    @endforeach
  </select>
