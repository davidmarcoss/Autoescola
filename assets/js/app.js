$(document).ready(function(){

    if($('.alert').length > 0)
    {
        $('.alert').fadeOut(5000);
    }

    /**
     *  Validació del test realitzat per l'alumne (AJAX)
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
            var codiPregunta = data[i].alu_resp_pregunta_codi;

            $('input[name='+codiPregunta+']').each(function(){
                var opcio = $('label[for=o'+cont);
                var opcioContent = opcio.text().trim();
                if(data[i].alu_resp_resposta_alumne == opcioContent)
                {
                    if(data[i].alu_resp_isCorrecta == 'S') 
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

        $('#btn-exit-test').attr('href', ""); 
        $('#btn-exit-test').attr('href', site_url_enrere); 

        window.scrollTo(0, 0);
    }


    /**
     *   Filtres de la taula de tests realitzats (AJAX)
     */
    $('#filtre-alumne-tests').on('change', function(){
        $.ajax({
            url: site_url_filtre,
            type: 'POST',
            dataType: 'json',
            data: { 'filtre-alumne-tests' : $(this).val() },
            success: (function (response) {
                $('#btn-limpiar-filtros').remove();
                $('#div-limpiar-filtros').append(' <a role="button" id="btn-limpiar-filtros" class="btn btn-info pull-right" href='+site_url+'>Limpiar filtros<a>');
                
                if(response)
                {
                    renderTaulaTests(response);
                }
                else
                {
                    console.info(response);
                    $('.table-responsive').empty();
                    $('.table-responsive').append('<p class="text-muted">No se han encontrado tests</p>');
                }
            }),
            error: (function (error) {
                var message = "<div class='alert alert-danger'> <strong>Error!</strong> en procesar las respuesta</div>"
                $('.messages-container').append();
            })
        });
    });

    /**
     *  mostrarTaula() torna a dibuixar la taula de tests realitzats
     *  però aquesta vegada venen les dades amb els filtres demanats.
     */
    function renderTaulaTests(data)
    {
        $('.table-responsive').empty();

        var tbody = '<table class="table table-sm table-hover">';
        tbody += getHeaderTable([' ', 'Test', 'Tipo de test', 'Fecha de realización', 'Resultado']);

        $.each(data, function(i, test) {
            tbody += '<tr style=cursor:pointer data-id='+test['test_id']+' class=accordeon data-toggle=collapse href=#desplegar_'+test['test_id']+'>';
            tbody += getRowTable(['<i class="fa fa-eye" aria-hidden="true"></i>', test['test_nom'], test['test_tipus'], test['alu_test_data_fi']]);
            if(test['alu_test_nota'] == 'excelente') var respostaFormat = 'label-success';
            else if(test['alu_test_nota'] == 'aprobado') var respostaFormat = 'label-warning';
            else if(test['alu_test_nota'] == 'suspendido') var respostaFormat = 'label-danger';
            tbody += '<td class=text-center> <span class="label '+respostaFormat+'"> '+test['alu_test_nota'] +' </td>';
            tbody += '</tr>';

            if(test['preguntes'])
            {
                tbody += '<tr class=tr-no-hover>';
                tbody += '<td colspan=5 class=quitar-borde-superior>';
                tbody += '<div id=desplegar_'+test['test_id']+' class=collapse>';
                tbody += '<table class="table table-condensed table-striped taula-respostes-test">';
                tbody += '<thead> <tr> <th>Pregunta</th> <th>La meva resposta</th> <th class="text-center">Correcta?</th> </tr> <t/head>';
                tbody += '<tbody>';
                $.each(test['preguntes'], function(y, pregunta) {
                    tbody += '<tr>';
                    tbody += '<td>' + pregunta['preg_pregunta'] + '</td>';
                    tbody += '<td>' + pregunta['alu_resp_resposta_alumne'] + '</td>';
                    if(pregunta['alu_resp_isCorrecta'] == 'N')
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
     *  Filtres de la taula de gestió d'alumnes (AJAX)
     */
    $('#btn-aplicar-filtres-alumnes').on('click', function(){
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
                $('.table-responsive').empty();

                if(response)
                {
                    renderTaulaAlumnes(response);
                    setPopulateAlumne();
                }
                else
                {
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
        $('.table-responsive').empty();

        var tbody = '<table class="table table-sm table-hover table-condensed">';

        tbody += getHeaderTable(['NIF', 'Nombre', 'Correo electrónico', 'Teléfono de contacto', 'Carnet actual', 'Profesor asignado', 'Acción']);

        tbody += "<tbody>";
        $.each(data, function(i, alumne) {
            tbody += '<tr>';
            var nomComplet = alumne['alu_cognoms'] + ', ' + alumne['alu_nom'];
            var nomCompletProfessor = alumne['admin_cognoms'] + ', ' + alumne['admin_nom']
            tbody += getRowTable([alumne['alu_nif'], nomComplet, alumne['alu_correu'], alumne['alu_telefon'], alumne['alu_carn_carnet_codi'], nomCompletProfessor]);
            tbody += '<td class="text-center">'
            tbody += '<a class="btn btn-warning btn-sm obrir-modal-mod-alumne" role="button" data-toggle="modal" href="#modal-editar-alumne" value="'+alumne['alu_nif']+':'+alumne['alu_nom']+':'+alumne['cognoms']+':'+alumne['alu_correu']+':'+alumne['alu_telefon']+':'+alumne['alu_poblacio']+':'+alumne['alu_adreca']+':'+alumne['alu_professor_nif']+'"><i class="fa fa-pencil" aria-hidden="true" ></i> Editar</a> ';
            tbody += '<a class="btn btn-danger btn-sm obrir-modal-del-alumne" role="button" data-toggle="modal" href="#modal-eliminar-alumne" value='+alumne['alu_nif']+':'+alumne['alu_nom']+'><i class="fa fa-times " aria-hidden="true" ></i> Dar de baja</a>';
            tbody += '</td>';
            tbody += '</tr>';
        });

        tbody += '</tbody>';
        tbody += '</table>';
        
        $('.table-responsive').append(tbody);
    }

    /**
     * Filtres de la taula de gestió de professors (AJAX)
     */
    $('#btn-aplicar-filtres-professors').on('click', function(){
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
                $('.table-responsive').empty();

                if(response)
                {
                    renderTaulaProfessors(response);
                    setPopulateProfessor();
                }
                else
                {
                    $('.table-responsive').append('<p class="text-muted">No se han encontrado alumnos</p>');
                }

                $('#btn-limpiar-filtros').remove();
                $('#div-limpiar-filtros').append('<a role="button" id="btn-limpiar-filtros" class="btn btn-info pull-right" href='+site_url+'>Limpiar filtros<a>');
            }),
            error: (function (error) {
                var message = "<div class='alert alert-danger'> <strong>Error!</strong> en procesar las respuesta</div>"
                $('.messages-container').append();
            })
        });
    });

    function renderTaulaProfessors(data)
    {
        $('.table-responsive').empty();

        var tbody = '<table class="table table-sm table-hover table-condensed">';

        tbody += getHeaderTable(['NIF', 'Nombre', 'Correo electrónico', 'Acción']);

        tbody += "<tbody>";
        $.each(data, function(i, professor) {
            tbody += '<tr>';
            var nomComplet = professor['admin_cognoms'] + ', ' + professor['admin_nom'];
            tbody += getRowTable([professor['admin_nif'], nomComplet, professor['admin_correu']]);
            tbody += '<td class="text-center">'
            tbody += '<a class="btn btn-warning btn-sm obrir-modal-mod-professor" role="button" data-toggle="modal" href="#modal-editar-professor" value='+professor['admin_nif']+':'+professor['admin_nom']+':'+professor['admin_cognoms']+':'+professor['admin_correu']+'><i class="fa fa-pencil" aria-hidden="true" ></i> Editar</a> ';
            tbody += '<a class="btn btn-danger btn-sm obrir-modal-del-professor" role="button" data-toggle="modal" href="#modal-eliminar-professor" value='+professor['admin_nif']+':'+professor['admin_nom']+'><i class="fa fa-times " aria-hidden="true" ></i> Eliminar</a>';
            tbody += '</td>';
            tbody += '</tr>';
        });

        tbody += '</tbody>';
        tbody += '</table>';
        
        $('.table-responsive').append(tbody);
    }

    /**
     * Funció per a generar un header d'una taula apartir
     * de l'array de paràmetres que conté els valors
     * de la capçalera.
     * @param {*} data
     */
    function getHeaderTable(data)
    {
        header = '<thead>';
        header += '<tr>';
        $.each(data, function(i, item) {
            header += '<th class="text-center">'+item+'</th>';
        });
        header += '</tr>';
        header += '</thead>';   
        
        return header;
    }

    /**
     * Funció per a generar una fila d'una taula
     * a partir de l'array de paràmetres que conté
     * els valors de cada columna.
     * 
     * @param {*} data 
     */
    function getRowTable(data)
    {
        var column = '';

        $.each(data, function(i, item) {
            column += '<td class="text-center">'+item+'</td>';
        });

        return column;
    }


    if($('.obrir-modal-mod-alumne').length > 0 || $('.obrir-modal-del-alumne').length > 0)
    {
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
            var professor = dades[7];
            $('select option[value='+professor+']').attr("selected",true);
            var password = dades[8];
            $('#password-populate').val(password);
        });
        $('.obrir-modal-del-alumne').on('click', function() {
            dades = $(this).attr('value').split(':');
            $('#nom-alumne-title-2').html(dades[1]);
            $('#nif-populate-2').val(dades[0]);
        }); 
    }



    if($('.obrir-modal-mod-professor').length > 0 || $('.obrir-modal-del-professor').length > 0)
    {
        $('.obrir-modal-mod-professor').on('click', function() {
            var dades = jQuery.parseJSON($(this).attr('value'));
            $('#nom-professor-title').html(dades.admin_nom);
            $('#nif-populate').val(dades.admin_nif);
            $('#nom-populate').val(dades.admin_nom);
            $('#cognoms-populate').val(dades.admin_cognoms);
            $('#correu-populate').val(dades.admin_correu);
        });

        $('.obrir-modal-del-professor').on('click', function() {
            var dades = jQuery.parseJSON($(this).attr('value'));
            $('#nif-populate-2-professor').val(dades.admin_nif);
            $('#nom-professor-title-2').html(dades.admin_nom);
        });
    }



    if($('.obrir-modal-del-carnet').length > 0)
    {
        $('.obrir-modal-del-carnet').on('click', function() {
            var codi = $(this).attr('value');
            $('#nom-carnet-title').html(codi);
            $('#codi-carnet-populate').val(codi);
        });
    }

});
