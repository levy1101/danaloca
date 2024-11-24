<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddLocation extends Component
{
    public $location_name;
    public $location_status = 1; // Giá trị mặc định là "Hiển thị"
    public $location_ip;

    protected $rules = [
        'location_name' => 'required|max:255',
        'location_status' => 'required|boolean',
        'location_ip' => 'nullable|ip',
    ];

    public function saveLocation()
    {
        // Validate dữ liệu
        $this->validate();

        // Lưu vào database
        Location::create([
            'name' => $this->location_name,
            'status' => $this->location_status,
            'ip_address' => $this->location_ip,
        ]);

        // Reset các field sau khi lưu
        $this->reset(['location_name', 'location_status', 'location_ip']);

        // Gửi thông báo thành công
        session()->flash('message', 'Thêm địa điểm thành công!');
    }

    public function render()
    {
        return view('livewire.add-location');
    };
}
