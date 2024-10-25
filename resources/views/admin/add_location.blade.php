@extends('layouts.admin')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm danh mục địa điểm
                </header>
                <div class="panel-body">

                    @if (Session::get('message'))
                        <div class="text-center">
                            <span class="text-alert ">{{Session::get('message')}}</span>
                        </div>
                    @endif

                    <div class="position-center">
                        <form role="form" action="{{ URL::to('/admin/save_location') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="location_name">Tên địa điểm</label>
                                <input type="text" name="location_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Hiển thị</label>
                                <select name="location_status" id="" class="form-control input-sm m-bot15">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiển thị</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="location_ip">Địa chỉ IP</label>
                                <input type="text" name="location_ip" class="form-control">
                            </div>
                            <button type="submit" name="add_location" class="btn btn-info">Thêm địa điểm</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
    </div>
@endsection
