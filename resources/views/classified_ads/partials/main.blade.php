<div class="row gallery">
    <div class="col-md-6 featured-image">
        <div class="image">
        @if (!empty($classified_ad->file))
            <img src="{{ $classified_ad->file->getPathAttribute() }}" width="100%"/>
        @else
            <img src="{{ asset('images/placeholder_car.png') }}" width="100%"/>
        @endif
        </div>
    </div>

    <div class="col-md-6 row thumbnails no-print">
        @foreach ($classified_ad->files as $file)
        <div class="col-md-6 col-6 thumbnail">
            <div class="aspect-ratio-box">
                <img src="{{ $file->getPathAttribute() }}" width="100%"/>
            </div>
        </div>
        @endforeach
    </div>
</div>