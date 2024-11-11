@extends('layouts.user')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa địa điểm
                </header>
                
                <div class="panel-body">
                    
                    <div class="position-center">
                        @foreach ($edit_location as $key => $edit_value)
                        <form role="form" action="{{ URL::to('/admin/update_location/'.$edit_value->id) }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="location_name">Tên địa điểm</label>
                                <input type="text" name="location_name" class="form-control" value="{{ $edit_value->location_name }}">
                            </div>
                            <div class="form-group">
                                <label for="">Hiển thị</label>
                                <select name="location_status" id="" class="form-control input-sm m-bot15" >{{ $edit_value ->location_status }}
                                    <option value="0" {{ $edit_value->location_status == "0" ? 'selected' : '' }}>Ẩn</option>
                                    <option value="1" {{ $edit_value->location_status == "1" ? 'selected' : '' }}>Hiển thị</option>
                                </select>
                            </div>
                            <button type="submit" name="add_location" class="btn btn-info">Thêm địa điểm</button>
                        </form>
                        @endforeach
                    </div>

                </div>
            </section>

        </div>
    </div>
@endsection
