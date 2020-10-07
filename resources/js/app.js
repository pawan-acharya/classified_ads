require('./bootstrap');

function getFileNames(files) {
    var names = []
    if(files.length>1) {
        return files.length + " files selected";
    }
    for(var i = 0; i < files.length; i++) {
        names.push(files[i].name)
    }
    return names.join(',')
}

try {
    window.getFileNames = getFileNames
} catch (e) {}


function fireBrandModelJs(brandName, modelName) {
    var brand =  document.getElementById(brandName)
    if(brand.value!='') {
        var model =  document.getElementById(modelName)
        var selected = options[brand.value];

        //Remove existing options
        Object.values(model.options).forEach( option => {
            model.removeChild(model.options[0]);
        })

        //Add new options
        addOptions(selected, model);
    }

    if(old_model!='') {
        var model =  document.getElementById(modelName)
        var selected = options[brand.value];

        Object.values(model.options).forEach( option => {
            if(option.value == old_model) {
                option.selected = 'selected';
            }
        })
    }

    document.getElementById(brandName).onchange = function() {
        var model =  document.getElementById(modelName)
        var selected = options[this.value];

        //Remove existing options
        Object.values(model.options).forEach( option => {
            model.removeChild(model.options[0]);
        })

        //Add new options
        addOptions(selected, model);
    }

    function addOptions(selected, model){
        var opt = document.createElement('option');
        opt.appendChild( document.createTextNode('') );
        opt.value = '';
        model.appendChild(opt);

        for (let [key, value] of Object.entries(selected)) {
            var opt = document.createElement('option');
            opt.appendChild( document.createTextNode(value) );
            opt.value = key;
            model.appendChild(opt);
        }
    }
}

function addValidation() {
    var inputFields = document.getElementsByClassName("form-control");
    for (var i = 0; i < inputFields.length; i++) {
        inputFields.item(i).addEventListener("change", validate);
        inputFields.item(i).addEventListener("invalid", validate);
    }

    function validate(event) {
        var inpObj = event.target;
        if(inpObj.value=='') {
            inpObj.setCustomValidity(validationRequired);
        } else if(inpObj.validity.patternMismatch){
            inpObj.setCustomValidity(validationPattern);
        } else {
            inpObj.setCustomValidity('');
        }
    
    }
}

function addNumberValidation() {
    var inputFields = document.querySelectorAll('input[type="number"]');
    for (var i = 0; i < inputFields.length; i++) {
        inputFields.item(i).addEventListener("input", validateNumber);
    }

    function validateNumber(event) {
        var inpObj = event.target;
        if(!inpObj.checkValidity()) {
            inpObj.value = ''
        }
    }
}



try {
    addValidation();
    addNumberValidation();
    fireBrandModelJs('brand', 'model');
    //Fire again for search
    if (window.location.pathname.indexOf('ads') !== -1) {
        fireBrandModelJs('search-brand', 'search-model');
    }
} catch (e) {}


(function($) {
    $(document).ready(function() {
        // Initialize Select2
        $('select.form-control').select2({
          minimumResultsForSearch: -1
        });

        // Select2 dropdown arrow
        $('b[role="presentation"]').hide();
        $('.select2-selection__arrow').append('<i class="fa fa-angle-down"></i>');
        // End Select2 dropdown
        // End Select2 Code

        var phonenumbers = [];
        $(".phonenumber").each(function(i) {
            phonenumbers.push($(this).text());
            var newcontent = $(this).text().substr(0, $(this).text().length - 4)
            $(this).text(newcontent);
            $(".revealphone").bind("click", function() {
                if ($(".phonenumber").text() == phonenumbers[i]) {
                    $(".phonenumber").text(phonenumbers[i].substr(0, phonenumbers[i].length - 4));
                } else {
                $(".phonenumber").each(function(x) {
                    if ($(".phonenumber").text() == phonenumbers[x]) {
                        $(".phonenumber").text(phonenumbers[x].substr(0, phonenumbers[x].length - 4));
                    }
                });            
                $(".phonenumber").text(phonenumbers[i]);
                }
            });
        });
    });

    /*
    Carousel
    */
    $('#carousel-home').on('slide.bs.carousel', function (e) {
        var $e = $(e.relatedTarget);
        var idx = $e.index();
        var itemsPerSlide = 3;
        var totalItems = $('.carousel-item').length;

        if (idx >= totalItems-(itemsPerSlide-1)) {
            var it = itemsPerSlide - (totalItems - idx);
            for (var i=0; i<it; i++) {
                // append slides to end
                if (e.direction=="left") {
                    $('.carousel-item').eq(i).appendTo('.carousel-inner');
                }
                else {
                    $('.carousel-item').eq(0).appendTo('.carousel-inner');
                }
            }
        }
    });

    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        navText : ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
        dots: false,
        responsive:{
            0:{
                items:1.5
            },
            600:{
                items:2.5
            },
            1000:{
                items:3.5
            }
        }
    });
})(jQuery); // End of use strict