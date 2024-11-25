<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="addLocation">
        <div class="form-group">
            <label for="location_name">Location Name</label>
            <input type="text" id="location_name" wire:model="location_name" class="form-control">
            @error('location_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="location_ip">Location IP</label>
            <input type="text" id="location_ip" wire:model="location_ip" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Add Location</button>
    </form>
</div>
