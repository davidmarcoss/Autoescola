$(document).ready(function(){

    $('.alert').fadeOut(5000);

    /**
     *  AJAX - Validació del test realitzat per l'usuari
     */
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

    /**
     *   Funció AJAX per als filtres de la taula de tests realitzats
     *   de l'alumne
     */
    $('#filtre-alumne-tests').on('change', function(){
        $.ajax({
            url: site_url_filtre,
            type: 'POST',
            dataType: 'json',
            data: { 'filtre-alumne-tests' : $(this).val() },
            success: (function (response) {
                if(response)
                {
                    renderTaulaTests(response);
                }
                else
                {
                    $('.table-responsive').empty();
                    $('.table-responsive').append('<p class="text-muted">No se han encontrado tests</p>');
                }
                $('#btn-limpiar-filtros').remove();
                $('#div-limpiar-filtros').append(' <a role="button" id="btn-limpiar-filtros" class="btn btn-info pull-right" href='+site_url+'>Limpiar filtros<a>');
            }),
            error: (function (error) {
                var message = "<div class='alert alert-danger'> <strong>Error!</strong> en procesar las respuesta</div>"
                $('.messages-container').append();
            })
        });
    });

    /**
     * mostrarTaula() torna a dibuixar la taula de tests realitzats
     * però aquesta vegada venen les dades amb els filtres demanats.
     */
    function renderTaulaTests(data)
    {
        $('.table-responsive').empty();

        var tbody = '<table class="table table-sm table-hover">';
        tbody += '<thead><tr><th> </th><th class="text-left">Test</th><th class="text-center">Tipo de test</th><th class="text-center">Fecha de realización</th><th class="text-center">Resultado</th></tr></thead>';
        tbody += '<tbody>';

        $.each(data, function(i, test) {
            tbody += '<tr style=cursor:pointer data-id='+test['id']+' class=accordeon data-toggle=collapse href=#desplegar_'+test['id']+'>';
            tbody += '<td> <i class="fa fa-eye" aria-hidden="true"></i> </td>';
            tbody += '<td class=text-left>' +test['nom']+ '</td>';
            tbody += '<td class=text-center>' +test['tipus']+ '</td>';
            tbody += '<td class=text-center>' +test['data_fi']+ '</td>';
            if(test['nota'] == 'excelente') var respostaFormat = 'label-success';
            else if($test['nota'] == 'aprobado') var respostaFormat = 'label-warning';
            else if($test['nota'] == 'suspendido') var respostaFormat = 'label-danger';
            tbody += '<td class=text-center> <span class="label '+respostaFormat+'"> '+test['nota'] +' </td>';
            tbody += '</tr>';

            if(test['preguntes'])
            {
                tbody += '<tr class=tr-no-hover>';
                tbody += '<td colspan=5 class=quitar-borde-superior>';
                tbody += '<div id=desplegar_'+test['id']+' class=collapse>';
                tbody += '<table class="table table-condensed table-striped taula-respostes-test">';
                tbody += '<thead> <tr> <th>Pregunta</th> <th>La meva resposta</th> <th class="text-center">Correcta?</th> </tr> <t/head>';
                tbody += '<tbody>';
                $.each(test['preguntes'], function(y, pregunta) {
                    tbody += '<tr>';
                    tbody += '<td>' + pregunta['pregunta'] + '</td>';
                    tbody += '<td>' + pregunta['resposta_alumne'] + '</td>';
                    if(pregunta['isCorrecta'] == 'N')
                    {
                        var isCorrectaFormat = 'label-danger label-resultat';
                        var text = 'No';
                    }
                    else
                    {
                        var isCorrectaFormat = 'label-success label-resultat';
                        var text = 'Si';  
                    }
                    tbody += '<td class="text-center"><span class="label '+isCorrectaFormat+'">'+text+'</span></td>';
                    tbody += '</tr>';
                });
                tbody += '</tbody>';
                tbody += '</table>';
                tbody += '</div>';
                tbody += '</td>';
                tbody += '</tr>';
            }
        });

        tbody += '</tbody>';
        tbody += '</table>';
        
        $('.table-responsive').append(tbody);
    }

    $('#btn-limpiar-filtros').on('click', function() {
        window.location = $('#thickboxId').attr('href');
    });

    /**
     *   Funció AJAX per als filtres de la taula de tests realitzats
     *   de l'alumne
     */
    $('#btn-aplicar-filtres').on('click', function(){
        var nif = $('#nif').val();
        var nom = $('#nom').val();

        $.ajax({
            url: site_url_filtre,
            type: 'POST',
            dataType: 'json',
            data: { 
                'nif' : nif,
                'nom' : nom,
            },
            success: (function (response) {
                console.info(response);
                if(response)
                {
                    renderTaulaAlumnes(response);
                }
                else
                {
                    $('.table-responsive').empty();
                    $('.table-responsive').append('<p class="text-muted">No se han encontrado alumnos</p>');
                }
                $('#btn-limpiar-filtros').remove();
                $('#div-limpiar-filtros').append(' <a role="button" id="btn-limpiar-filtros" class="btn btn-info pull-right" href='+site_url+'>Limpiar filtros<a>');
            }),
            error: (function (error) {
                var message = "<div class='alert alert-danger'> <strong>Error!</strong> en procesar las respuesta</div>"
                $('.messages-container').append();
            })
        });
    });

    function renderTaulaAlumnes(data)
    {

    }
});
