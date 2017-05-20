$(document).ready(function(){
    $('#test-form').submit(function(e){
        e.preventDefault();

        var data = $(this).serializeArray();
        $.ajax({
            url: site_url_check,
            type: 'POST',
            dataType: 'json',
            data: data,
            success: (function (response) {
                mostrarResultat(response);
            }),
            error: (function (error) {
                var message = "<div class='alert alert-danger'> <strong>Error!</strong> en procesar las respuesta</div>"
                $('.messages-container').append();
            })
        });
    });

    function mostrarResultat(data)
    {
        var cont = 0;
        $('input[type=radio]').each(function(){
            $(this).prop("disabled", true);
            var opcio = $('label[for=o'+cont).text().trim();
        });

        $(data).each(function(i){
            var codiPregunta = data[i].pregunta_codi;
            //$('input[type=radio]').each(function(){
            $('input[name='+codiPregunta+']').each(function(){
                var opcio = $('label[for=o'+cont);
                var opcioContent = opcio.text().trim();
                if(data[i].resposta_alumne == opcioContent)
                {
                    if(data[i].isCorrecta == 'S') 
                    {
                        var encert = "<span class='label label-inline label-success'> <i class='fa fa-check' aria-hidden=true></i> </span>";
                        opcio.append(encert);
                    }
                    else 
                    {
                        var error = "<span class='label label-inline label-danger'> <i class='fa fa-times' aria-hidden=true></i> </span>";
                        opcio.append(error);
                    }
                }
                else if(data[i].correcta == opcioContent)
                {
                    var encert = "<span class='label label-inline label-success'> <i class='fa fa-check' aria-hidden=true></i> </span>";
                    opcio.append(encert);
                }
                cont++;
            });
        });
        
        $('button[type=submit]').prop('disabled', true);

        var enrere = '<a href='+site_url_enrere+' class="btn btn-danger btn-lg btn-block">Sortir</a>';
        $('#btn-check-test').first().after(enrere);
    }

        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").slideUp(500);
    });

});
