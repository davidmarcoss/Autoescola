$(document).ready(function(){
    /**
     * Modals per a la gestió d'alumnes
     */
    $('.obrir-modal-mod-alumne').on('click', function() {
        dades = $(this).attr('value').split(':');
        $('#nom-alumne-title').html(dades[1]);
        $('#nif-populate').val(dades[0]);
        $('#nom-populate').val(dades[1]);
        $('#cognoms-populate').val(dades[2]);
        $('#correu-populate').val(dades[3]);
        $('#telefon-populate').val(dades[4]);
        $('#poblacio-populate').val(dades[5]);
        $('#adreca-populate').val(dades[6]);
        var carnet = dades[7];
        $('#carnet-populate option[value='+carnet+']').attr("selected",true);
        var professor = dades[8];
        $('#professor-populate option[value='+professor+']').attr("selected",true);
        $('#password-populate').val(dades[9]);
    });

    $('.obrir-modal-del-alumne').on('click', function() {
        dades = $(this).attr('value').split(':');
        $('#nom-alumne-title-2').html(dades[1]);
        $('#nif-populate-2').val(dades[0]);
    }); 

    /**
     * Modals per a la gestió de professors
     */
    $('.obrir-modal-mod-professor').on('click', function() {
        dades = $(this).attr('value').split(':');
        $('#nom-professor-title').html(dades[1]);
        $('#nif-populate').val(dades[0]);
        $('#nom-populate').val(dades[1]);
        $('#cognoms-populate').val(dades[2]);
        $('#correu-populate').val(dades[3]);
    });

    $('.obrir-modal-del-professor').on('click', function() {
        dades = $(this).attr('value').split(':');
        $('#nif-populate-2-professor').val(dades[0]);
        $('#nom-professor-title-2').html(dades[1]);
    });
});