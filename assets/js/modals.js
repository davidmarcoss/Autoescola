$(document).ready(function(){
    $('#obrir-modal-mod-alumne').on('click', function() {
        dades = $(this).attr('value').split(':');
        $('#nom-alumne-title').html(dades[1]);
        $('#nif-populate').val(dades[0]);
        $('#nom-populate').val(dades[1]);
        $('#cognoms-populate').val(dades[2]);
        $('#correu-populate').val(dades[3]);
        $('#telefon-populate').val(dades[4]);
        $('#poblacio-populate').val(dades[5]);
        $('#adreca-populate').val(dades[6]);
    });

    $('#obrir-modal-del-alumne').on('click', function() {
        dades = $(this).attr('value').split(':');
        $('#nom-alumne-title-2').html(dades[1]);
        $('#nif-populate-2').val(dades[0]);
    }); 
});