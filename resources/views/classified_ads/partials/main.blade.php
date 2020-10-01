<div class="row gallery">
    <div class="col-md-6 featured-image">
        <div class="aspect-ratio-box image">
        @if (!empty($classified_ad->file))
            <img src="{{ $classified_ad->file->getPathAttribute() }}" width="100%" onclick="openModal();currentSlide(1)"/>
        @else
            <img src="{{ asset('images/placeholder_car.png') }}" width="100%" onclick="openModal();currentSlide(1)"/>
        @endif
        </div>
    </div>

    <div class="col-md-6 thumbnails no-print">
        @foreach ($classified_ad->files as $file)
        <div class="thumbnail" onclick="openModal();currentSlide(1)">
            <div class="aspect-ratio-box">
                <img src="{{ $file->getPathAttribute() }}" width="100%"/>
            </div>
        </div>
        @endforeach
        @if ($classified_ad->files->count() > 3)
            <p class="show-all-gallery" onclick="openModal();currentSlide(1)">Show All Photos + {{ $classified_ad->files->count() - 3}}</p>
        @endif
    </div>
</div>

<div id="myModal" class="modal">
    <span class="close cursor" onclick="closeModal()">&times;</span>
    <div class="modal-content">
        @foreach ($classified_ad->files as $file)
        <div class="mySlides">
            <div class="aspect-ratio-box">
                <img src="{{ $file->getPathAttribute() }}" width="100%"/>
            </div>
        </div>
        @endforeach
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
        <div class="owl-carousel">
            @foreach ($classified_ad->files as $file)
            <div class="thumbnail" onclick="openModal();currentSlide(1)">
                <div class="aspect-ratio-box">
                    <img src="{{ $file->getPathAttribute() }}" width="100%"/>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>