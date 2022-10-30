<script>
    identific_nav();
    function identific_nav(){
        var nav = navigator.userAgent.toLowerCase();
        var browser = '';
        if(nav.indexOf("chrome") != -1){
            browser = "chrome";
        }
        
        if (browser == '') {
            alert('RECOMENDAMOS A UTILIZAÇÃO DO CHROME. A NÃO UTILIZAÇÃO PODERÁ TRAZER INEFICIÊNCIA DOS COMPONENTES DO SOFTWARE. DÚVIDAS ENTRAR EM CONTATO COM O SUPORTE.');
        }
    }

    adicionaFocus('usuario');

    $('#entrarSistema').click(function () {

        postLogin();
    });

    $('input[name=usuario]').keypress(function (e) {
        if (e.which === 13) {
            $('input[name=senha]').focus();
        }
    });

    $('input[name=senha]').keypress(function (e) {
        if (e.which === 13) {
            postLogin();
        }
    });

    function adicionaFocus(campo) {
        $('input[name=' + campo + ']').focus();
    }

    function removeClass(referencia, tipo) {
        $(referencia).removeClass(tipo);
    }

    function postLogin() {
        var usuario = $('input[name=usuario]').val();
        var senha = $('input[name=senha]').val();
        
        $.post(URL+"validaLogin", {usuario: usuario, senha: senha})
        .done(function (data) {
            if (data === '0') {
                removeClass('.erro', 'hidden');
            } else {
                verificaEmpresa(data);
            }
        });
    }

    function verificaEmpresa(dadosUsuario) {

        var request = $.ajax({
            url: "<?= base_url('login/retornaFilialPermitidas'); ?>",
            method: "POST",
            data: { dadosUsuario: dadosUsuario },
            dataType: "json"
        });

        request.done(function (res) {

            if (res.length > 1) {
                // QUANDO USUÁRIO TEM PERMISSÃO PARA VARIAS EMPRESAS E SERÁ NECESSÁRIO ESCOLHER QUAL DELAS ACESSAR.
                for(var i=0; i<res.length; i++) {
                    $('#empresaAcesso').append('<option value='+res[i]['CODIGO']+'>'+res[i]['CODIGO']+'-'+res[i]['NOME_FANTASIA']+'</option>');
                }
                setTimeout(function() {
                    $('#modal-default').modal('show');
                }, 100)
            } else if (res.length === 1) {
                // QUANDO USUARIO TEM PERMISSÃO SOMENTE PARA UMA EMPRESA;
                criaSession(res[0]['CODIGO']);
                $('#modal-success').modal('show');
                $('#modal-warning').unbind("click");
            } else {
                console.log('Provavelmente este usuário não tem permissão a acessar nenhuma empresa.');
            }
        });

        request.fail(function (jqXHR, textStatus) {
            $('#modal-success').modal('hide');
            console.log(jqXHR);
            alert('Erro: ' + jqXHR);
        });
    }
    
    $('#btn-validar-entrar-sistema').click(function() {
        
        var codigoEmpresa = $('#empresaAcesso option:selected').val();
        if (codigoEmpresa === '') {
            alert('Selecione uma filial');
            return false;
        } else {
            $('#modal-success').modal('show');
            $('#modal-warning').unbind("click");
            criaSession(codigoEmpresa);
        }
    });
    
    function criaSession(codigoEmpresa) {
        var usuario = $('input[name=usuario]').val();
        var senha = $('input[name=senha]').val();

        var request = $.ajax({
            url: "<?= base_url('login/criaSession'); ?>",
            method: "POST",
            data: { usuario: usuario, senha: senha, codigoEmpresa: codigoEmpresa },
            dataType: "json"
        });

        request.done(function (res) {
            if (res == '1') {
                setTimeout(function () {
                    location.href = URL+'dashboard';
                }, 300);
            }
        });

        request.fail(function (jqXHR, textStatus) {
            $('#modal-success').modal('hide');
            console.log(jqXHR);
            alert('Erro: ' + jqXHR);
        });
    }
</script>

</body>
</html>