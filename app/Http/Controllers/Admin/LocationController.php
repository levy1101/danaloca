<?php

namespace App\Http\Controllers\Admin;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

// session_start();

class LocationController extends Controller
{
    public function all_location()
    {
        $locations = DB::table('locations')->get();
        $manager_location = view('admin.all_location')->with('locations', $locations);
        return view('layouts.admin')->with('admin.all_location', $manager_location);
    }
    public function add_location()
    {
        return view('admin.add_location');
    }
    public function save_location(Request $request)
    {
        $data = array();
        $data['location_name'] = $request->location_name;
        $data['location_status'] = $request->location_status;
        $data['location_ip'] = $request->location_ip; 

        DB::table('locations')->insert($data);
        Session::put('message', 'Thêm địa điểm thành công');
        return Redirect::to('admin/add_location');
    }
    public function edit_location($location_id)
    {
        $edit_location = DB::table('locations')->where('id', $location_id)->get();
        $manager_location = view('admin.edit_location')->with('edit_location', $edit_location);
        // dd($edit_location);
        return view('layouts.admin')->with('admin.edit_location', $manager_location);

    }
    public function update_location(Request $request, $location_id)
    {
        $data = array();
        $data['location_name'] = $request->location_name;
        $data['location_status'] = $request->location_status;
        $data['location_ip'] = $request->location_ip; // Thêm location_ip

        DB::table('locations')->where('id', $location_id)->update($data);
        Session::put('message', 'Cập nhật địa điểm thành công');
        return Redirect::to('admin/all_location');
    }
    public function delete_location($location_id)
    {
        Location::where('id', '=', $location_id)->delete();
        return redirect()->back()->with('message', 'Xoá địa điểm thành công');
    }
}
