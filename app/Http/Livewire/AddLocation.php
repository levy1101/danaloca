<?php
namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AddLocation extends Component
{
    public $location_name;
    public $location_status = 0;
    public $location_ip;

    public function addLocation()
    {
        // Validation logic
        $this->validate([
            'location_name' => 'required|string|max:255',
        ]);

        // Save logic
        $data = [
            'location_name' => $this->location_name,
            'location_status' => $this->location_status,
            'location_ip' => $this->location_ip,
        ];

        DB::table('locations')->insert($data);
        Session::put('message', 'Thêm địa điểm thành công');

        // Reset fields
        $this->reset(['location_name', 'location_ip']);
    }

    public function render()
    {
        return view('livewire.add-location');
    }
}
