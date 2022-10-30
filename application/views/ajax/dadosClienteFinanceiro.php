<script type="text/javascript">
    $(function () {
        
        $('#financeiro').click(function() {
            var codeClient = $('#codigoInterno').val();
            setTimeout(() => {
                getByIdClientFinancial(codeClient);
            }, 200);
        });

        function getByIdClientFinancial(codeClient) {
            $("#tabela_financeiro").html("");
            var request = $.ajax({
                url: "<?= base_url('getByIdClientFinancial'); ?>",
                method: "POST",
                data: { codeClient: codeClient },
                dataType: "json"
            });

            request.done(function (response) {
                $.each(response.dados, function (key, value) {
                    var color = 'label-warning';
                    if (value.ABERTO_BAIXADO === 'Pago')  {
                        var color = 'label-success';
                    }
                    $("#tabela_financeiro").append("<tr><td>" + value.NDODOCUMENTO + "</td><td>" + value.REF_VENDA + "</td><td>" + value.TIPO + "</td><td>" + value.DATADEVENCIMENTO + "</td><td>R$ " + parseFloat(value.VALOR) + "</td><td><span class='label " + color + "'>" + value.ABERTO_BAIXADO + "</span></td></tr>");
                });
            });

            request.fail(function (jqXHR, textStatus) {
                $('#modal-success').modal('hide');
                dialogDanger("getByIdClientFinancial - erro: " + jqXHR);
                $('#modal-danger').modal('show');
            });
        }
    });
</script>

</body>
</html>