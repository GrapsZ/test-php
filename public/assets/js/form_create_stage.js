//Compare que la ville de départ soit bien différente de la ville d'arrivée
$.validator.addMethod("departure_arrival_not_same", function(value, element) {
    return $('#departureCity').val() !== $('#arrivalCity').val()
}, "Les villes de départ et d'arrivée ne peuvent pas être identiques !");

//La valeur du type d'étape ne doit pas être à 0
$.validator.addMethod("type_selected", function(value, element) {
    console.log($('#selectType').val());
    return parseInt($('#selectType').val()) !== 0;
}, "Veuillez sélectionner un type d'étape !");

//Compare 2 dates entre elles
$.validator.addMethod("greaterThan",function(value, element, params) {
    if (!/Invalid|NaN/.test(new Date(value))) {
        return new Date(value) > new Date($(params).val());
    }

    return isNaN(value) && isNaN($(params).val())
        || (Number(value) > Number($(params).val()));
},'La date d\'arrivée doit-être supérieure à la date de départ !');

$("#stage-form-creator").validate({
    rules: {
        selectType: {
            required: true,
            type_selected: true
        },
        departureCity: {
            required: true,
            departure_arrival_not_same: true
        },
        departureCityDate: {
            required: true
        },
        arrivalCity: {
            required: true,
            departure_arrival_not_same: true
        },
        arrivalCityDate: {
            required: true,
            greaterThan: "#datepicker-range-start"
        },
        number: {
            required: true
        }
    },
    messages: {
        departureCity: {
            required: "La ville de départ est obligatoire."
        },
        arrivalCity: {
            required: "La ville d'arrivée est obligatoire."
        },
        number: {
            required: "Le numéro d'étape est obligatoire."
        }
    },
    errorPlacement: function(error, element) {
        error.insertAfter(element);
    },
    highlight: function(element, errorClass) {
        $(element).addClass("error is-invalid");
        $(element).removeClass("success is-valid");
    },
    unhighlight: function(element, errorClass) {
        $(element).removeClass("error is-invalid");
        $(element).addClass("success is-valid");
    }
});

//Datepicker de la date de départ
$('#datepicker-range-start').Zebra_DatePicker({
    direction: true,
    pair: $('#datepicker-range-end'),
    format: 'Y-m-d H:i'
});

//Datepicker de la date d'arrivée
$('#datepicker-range-end').Zebra_DatePicker({
    direction: 0,
    format: 'Y-m-d H:i'
});

//Supprime la modification CSS sur la taille de l'input de la librairie Datepicker
$('.Zebra_DatePicker_Icon_Wrapper').each(function() {
    $(this).css('width', '');
});