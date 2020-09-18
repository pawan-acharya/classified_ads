@extends('layouts.app')

@section('content')
<table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">check</th>
      <th scope="col">id</th>
      <th scope="col">First</th>
      <th scope="col">location</th>
      <th scope="col">category name</th>
      <th scope="col">Category type</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
    <form action="{{ route('bulk_pay') }}" method="POST">
        @csrf
        <tbody>
        @foreach ($classified_ads as $classified_ad)
            <tr>
                <th>
                    <input type="checkbox" name="ids[]" value="{{$classified_ad->id}}">
                </th>
              <th>
                  {{$classified_ad->id}}
              </th>
              <td>{{$classified_ad->title}}</td>
              <td>{{$classified_ad->location}}</td>
              <td>
                  {{$classified_ad->category->category_name}}
              </td>
              <td>
                  {{$classified_ad->category->type== 'none'?'':$classified_ad->category->type }}
              </td>
              <td>{{$classified_ad->getCost()}}</td>
            </tr>
        @endforeach
            <button class="btn btn-primary" type="submit">Pay</button>
        </tbody>
    </form>
</table>

    
@push('scripts-vars')
    
@endpush

@push('js')

@endpush
@endsection
