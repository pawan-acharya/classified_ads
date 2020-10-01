<footer class="footer text-white">
    <div class="main-footer">
        <div class="container">
            <div class="row footer-content py-4">
                <div class="col-sm-3">
                    <div class="footer-menu">
                        <h4>Wanderdorfer</h4>
                        <ul class="footer-menu-list">
                            <li class="footer-menu-item"><a href="#">About</a></li>
                            <li class="footer-menu-item"><a href="#">Careers</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="footer-menu">
                        <h4>Explore</h4>
                        <ul class="footer-menu-list">
                            <li class="footer-menu-item"><a href="#">CHALET</a></li>
                            <li class="footer-menu-item"><a href="#">CAMPING</a></li>
                            <li class="footer-menu-item"><a href="#">LODGING</a></li>
                            <li class="footer-menu-item"><a href="#">RV & TRAILER</a></li>
                            <li class="footer-menu-item"><a href="#">PACKAGES & ACTIVITIES</a></li>
                            <li class="footer-menu-item"><a href="#">ITEMS FOR SALE</a></li>
                            <li class="footer-menu-item"><a href="#">SERVICES</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="footer-menu">
                        <h4>Info</h4>
                        <ul class="footer-menu-list">
                            <li class="footer-menu-item"><a href="#">Terms of Use</a></li>
                            <li class="footer-menu-item"><a href="#">Privacy Policy</a></li>
                            <li class="footer-menu-item"><a href="#">Posting Policy</a></li>
                            <li class="footer-menu-item"><a href="#">AdChoice</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 d-flex">
                    <a href="/" class="mt-auto ml-auto">
                        <img src="{{ asset('images/logo.png') }}" width="100" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
    function openModal() {
        document.getElementById("myModal").style.display = "block";
    }
    
      function closeModal() {
        document.getElementById("myModal").style.display = "none";
      }
      
      var slideIndex = 1;
      showSlides(slideIndex);
      
      function plusSlides(n) {
        showSlides(slideIndex += n);
      }
      
      function currentSlide(n) {
        showSlides(slideIndex = n);
      }
      
      function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("demo");
        var captionText = document.getElementById("caption");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
        captionText.innerHTML = dots[slideIndex-1].alt;
      }
</script>