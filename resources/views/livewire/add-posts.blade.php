<div class="create-modal">
    <form wire:submit.prevent="submitPost" class="create-post" enctype="multipart/form-data">
        @csrf
        <div class="infor">
            <div class="profile-photo">
                <img src="{{ Auth::user()->avatar }}">
            </div>
            <h3>{{ Auth::user()->name }}</h3>
        </div>
        
        <textarea wire:model="post_content" placeholder="What's on your mind, {{ Auth::user()->name }}?" rows="10" style="resize:none"></textarea>
        <div class="row">
            <div class="add-to-post col-6">
                <label class="m-0 d-flex">
                    <span class="fas fa-images align-self-center" id="upload_img">
                        <div id="element" tabindex="-1"></div>
                        <input type="file" wire:model="post_image" class="form-control">
                    </span>
                </label>
                <div class="m-0 d-flex">
                    <select wire:model="location" class="form-control align-self-center">
                        @foreach ($locations as $loc)
                            @if ($loc->location_status == '1')
                                <option value="{{ $loc->id }}">{{ $loc->location_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="submit-post col-6 justify-content-end">
                <input type="submit" value="Post" class="btn btn-primary btn-post">
            </div>
        </div>
    </form>
</div>