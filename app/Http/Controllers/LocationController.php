<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function saveLocation(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'location_name' => 'required|max:255',
            'location_status' => 'required|boolean',
            'location_ip' => 'nullable|ip', // Validate địa chỉ IP nếu có
        ]);

        // Lưu dữ liệu vào database
        $location = new Location();
        $location->name = $request->location_name;
        $location->status = $request->location_status;
        $location->ip_address = $request->location_ip;
        $location->save();

        // Gửi thông báo thành công
        return redirect()->back()->with('message', 'Thêm địa điểm thành công!');
    }
}
