/**
 * Gestion du multi sélect d'ajout d'étapes sur les voyages
 */
$('select').each(function () {
    $(this).select2({
        theme: 'bootstrap4',
        language: "fr",
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        //placeholder: $(this).data('placeholder'),
        //allowClear: Boolean($(this).data('allow-clear')),
        closeOnSelect: !$(this).attr('multiple'),
    });
});
