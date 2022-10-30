<script type="text/javascript">
$('#data_telemarketing_contato').mask("99/99/9999");
$('#data_telemarketing_proximo_contato').mask("99/99/9999");
$('#data_telemarketing_filtro_inicial').mask("99/99/9999");
$('#data_telemarketing_filtro_final').mask("99/99/9999");

function getDadosTelemarketing() {
    if (($('#data_telemarketing_filtro_inicial').val() > $('#data_telemarketing_filtro_final').val()) || ($('#data_telemarketing_filtro_final').val() < $('#data_telemarketing_filtro_inicial').val())) {
        alert('Conferir as datas de filtro, existe divergência.');
        return false;
    }
    marketing();
}

marketing();
function marketing() {
    $("#tabela_telemarketing").html('');
    var request = $.ajax({
        url: "<?= base_url('getByIdClientMarketing'); ?>",
        method: "POST",
        data: {
            codeClient: '',
            codigo: '',
            data_inicial: ($('#data_telemarketing_filtro_inicial').val().replace('/', '')).replace('/', ''),
            data_final: ($('#data_telemarketing_filtro_final').val().replace('/', '')).replace('/', '')
        },
        dataType: "json",
    });

    request.done(function (response) {
//        console.log(response);
        if (response.dados !== false) {
            $.each(response.dados, function (key, value) {
                var color_retorno = '';
                if (value.RETORNO === 'N') {
                    color_retorno = 'red';
                }
                var data_proximo;
                if (value.PROXIMO_CONTATO === '01/01/1900') {
                    data_proximo = '';
                } else {
                    data_proximo = value.PROXIMO_CONTATO;
                }
                $("#tabela_telemarketing").append('<tr><td>' + value.CLIENTE +'-'+ value.NOME_FANTASIA + '</td><td>' + value.DATA_CONTATO + '</td><td>' + value.CONTATO + '</td><td>' + data_proximo + '</td><td style="color: '+color_retorno+'; ">' + value.RETORNO + '</td><td>' + value.MOTIVO + '</td><td><button class="btn btn-info btn-xs" onclick="visualizarTelemarketing('+value.CLIENTE+','+value.CODIGO+');">Visualizar</button></td></tr>');
            });

        }
    });

    request.fail(function (jqXHR, textStatus) {
        console.log(jqXHR);
        alert("Erro: " + textStatus + ' - ' + jqXHR);
    });
}
function visualizarTelemarketing(cliente, codigo) {
    var request = $.ajax({
        url: "<?= base_url('getByIdClientMarketing'); ?>",
        method: "POST",
        data: { codeClient: cliente, codigo: codigo },
        dataType: "json"
    });

    request.done(function (response) {
        $('#modal-telemarketing').modal('show');

        setTimeout(function() {
            var dados = response.dados[0];
            $('#codigoInterno').val(cliente);
            $('#codigo_telemarketing').val(codigo);
            $('#data_telemarketing_contato').val(dados.DATA_CONTATO);
            
            if (dados.PROXIMO_CONTATO === '01/01/1900') {
                $('#data_telemarketing_proximo_contato').val('');
            } else {
                $('#data_telemarketing_proximo_contato').val(dados.PROXIMO_CONTATO);
            }
            
            $('#contato_telemarketing').val(dados.CONTATO);
            $('#observacao_telemarketing').val(dados.OBSERVACAO);

            if (dados.RETORNO === 'S') {
                $("#check_retorno_efetuado").attr("checked", "checked")
            } else {
                $("#check_retorno_efetuado").removeAttr('checked');
            }

            var radios = document.getElementsByName("optionsRadios");
            if (dados.TIPO_MOTIVO === 'C') {
                radios[0].checked = true;
            } else if (dados.TIPO_MOTIVO === 'T') {
                radios[1].checked = true;
            } else if (dados.TIPO_MOTIVO === 'R') {
                radios[2].checked = true;
            } else if (dados.TIPO_MOTIVO === 'F') {
                radios[3].checked = true;
            } else if (dados.TIPO_MOTIVO === 'S') {
                radios[4].checked = true;
            } else {
                radios[5].checked = true;
            }
        }, 500);
    });

    request.fail(function (jqXHR, textStatus) {
        $('#modal-success').modal('hide');
        console.log(jqXHR);
        dialogDanger("getByIdClientFinancial - erro: " + jqXHR);
        $('#modal-danger').modal('show');
    });
}

$('#gravarTelemarketing').click(function() {
    var data_telemarketing_contato = ($('#data_telemarketing_contato').val().replace('/', '')).replace('/', '');
    var data_telemarketing_proximo_contato = ($('#data_telemarketing_proximo_contato').val().replace('/', '')).replace('/', '');
    var codigoInterno = $('#codigoInterno').val();
    var contato_telemarketing = $('#contato_telemarketing').val();
    var observacao_telemarketing = $('#observacao_telemarketing').val();
    var vendedor_telemarketing = $('#vendedor_telemarketing').val();
    var motivos = $("input[name='optionsRadios']:checked").val();
    var retorno = $("#check_retorno_efetuado").is(':checked');
    var codigoTelemarketing = $('#codigo_telemarketing').val();

    if ($('#contato_telemarketing').val() === '') {
        alert('Contato não pode ser vazio');
        return false;
    }

    var request = $.ajax({
        url: "<?= base_url('salvarTelemarketing'); ?>",
        method: "POST",
        data: {
            data_telemarketing_contato: data_telemarketing_contato,
            data_telemarketing_proximo_contato: data_telemarketing_proximo_contato,
            contato_telemarketing: contato_telemarketing,
            observacao_telemarketing: observacao_telemarketing,
            vendedor_telemarketing: vendedor_telemarketing,
            motivos: motivos,
            retorno: retorno,
            cliente: codigoInterno,
            codigoTelemarketing: codigoTelemarketing
        },
        dataType: "json"
    });

    request.done(function (response) {
//        console.log(response === true);
        if (response === true) {
            alert('Salvo com sucesso');
            $('#modal-telemarketing').modal('hide');
            location.reload();
//            getByIdClientMarketing(codigoInterno);
        }

    });

    request.fail(function (jqXHR, textStatus) {
        $('#modal-telemarketing').modal('hide');
        console.log(jqXHR);
        dialogDanger("salvarTelemarketing - erro: " + jqXHR);
        $('#modal-danger').modal('show');
    });
});

</script>

</body>
</html>