$("#travel-form-editor").validate({
    rules: {
        "name-editor": {
            required: true,
            maxlength: 50,
            minlength: 3
        },
        "price-editor": {
            required: true,
            max: 10000,
            min: 0
        },
    },
    messages: {
        "name-editor": {
            required: "Veuillez renseigner un intitulé pour le voyage.",
            maxlength: "L'intitulé du voyage doit contenir au maximum 50 caractères.",
            minlength: "L'intitulé du voyage doit contenir au minimum 2 caractères.",
        },
        "price-editor": {
            required: "Le prix est obligatoire.",
            max: "Le prix doit être au maximum à 10000",
            min: "Le prix doit-être au minimum à 0"
        },
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