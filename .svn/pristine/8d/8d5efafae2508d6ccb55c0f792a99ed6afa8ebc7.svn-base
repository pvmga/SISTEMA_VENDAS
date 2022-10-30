<!--jquery countTo-->
<script type="text/javascript">
    alimentarWidGetsAjax();
    function alimentarWidGetsAjax() {
        var request = $.ajax({
            url: "alimentarWidGetsAjax",
            method: "GET",
            dataType: "json",
            cache: true
        });

        request.done(function (response) {
            document.querySelector('.orcamentos').textContent = response.orcamentos;
            document.querySelector('.novas_vendas').textContent = response.novas_vendas;
            document.querySelector('.todas_vendas').textContent = response.todas_vendas;
            document.querySelector('.todos_clientes').textContent = response.todos_clientes;
//            console.log(response);
        });

        request.fail(function (jqXHR, textStatus) {
            alert("Erro: " + textStatus + ' - ' + jqXHR);
        });
    }
    
    $('.btn-enviar-email').click(function() {
        document.querySelector('.alertaDanger').textContent = 'Em desenvolvimento...';
        $('#modal-danger').modal('show');
        return false;
    });
</script>

</body>
</html>