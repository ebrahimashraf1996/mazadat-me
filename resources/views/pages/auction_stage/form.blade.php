@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <a href="{{route('auctionStages.index')}}" class="btn btn-success" style="border-radius:0;font-size:20px"> الدورات</a>
        <!--begin::Card-->
        <div class="card card-custom gutter-b example example-compact">

            <div class="card-header">
                <h3 class="card-title">أضافة دورة جديدة للمزاد</h3>
            </div>

            <form class="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($method == 'PUT')
                    @method('PUT')
                @endif

                <div class="card-body">
                    <div class="row">

                        <div class="form-group col-lg-6">
                            <label>أسم الدورة</label>
                            <input type="text" class="form-control form-control-solid" name="name" value="{{  $auctionStage->name }}" required>
                            @error('name')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                        <div class="form-group col-lg-6">
                            <label>تاريخ البدء</label>
                            <input type="datetime-local" name="start_time" min="{{ date('Y-m-d H:i:s') }}" class="form-control form-control-solid" value="{{  $auctionStage->getStartTime()}}" required>
                            @error('start_time')
                            <span class="text-danger">{{$message}} </span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary mr-2">حفظ</button>
                </div>

            </form>

        </div>
    </div>
</div>
<!--end::Card-->
@endsection
