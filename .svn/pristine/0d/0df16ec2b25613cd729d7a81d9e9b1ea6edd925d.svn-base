<!--jquery countTo-->
<script src="<?= base_url('bower_components/countTo/jquery.countTo.js'); ?>"></script>
<!--<script src="https://www.gstatic.com/charts/loader.js"></script>-->
<script src="<?= base_url('bower_components/graficos_google/loader.js'); ?>"></script>
<script type="text/javascript">    
    function marketing() {
        var request = $.ajax({
            url: "<?= base_url('getByIdClientMarketing'); ?>",
            method: "POST",
            data: { 
                codeClient: '', 
                codigo: '',
                data_inicial: '',
                data_final: ''
            },
            dataType: "json",
        });

        request.done(function (response) {
            if (response.dados !== false) {
                setTimeout(function() {
                    document.querySelector('.modal-titulo').textContent = 'Telemarketing';
                    dialogDefault('Encontramos '+response.dados.length+' visitas para a data de hoje. <br /><b>Deseja visualizar ?</b>');
                    $('#modal-default-confirme').modal('show'); 
                }, 100);
            }
        });

        request.fail(function (jqXHR, textStatus) {
            console.log(jqXHR);
            alert("Erro: " + textStatus + ' - ' + jqXHR);
        });
    }
    
    $('#sim_confirma').click(function() {
        location.href = "<?= base_url('telemarketing'); ?>";
    });

    alimentarWidGetsAjax();
    function alimentarWidGetsAjax() {
        var request = $.ajax({
            url: "alimentarWidGetsAjax",
            method: "POST",
            dataType: "json",
            cache: true
        });

        request.done(function (response) {
            $('#orcamentos').countTo({from: 0, to: response.orcamentos});
            $('#novasVendas').countTo({from: 0, to: response.novas_vendas});
            $('#todasVendas').countTo({from: 0, to: response.todas_vendas});
            $('#totalClientes').countTo({from: 0, to: response.todos_clientes});
            google.charts.load("current", {packages: ['corechart'], 'language': 'pt'});
            google.charts.setOnLoadCallback(geraGrafico);
            marketing();
        });

        request.fail(function (jqXHR, textStatus) {
            alert("Erro: " + textStatus + ' - ' + jqXHR);
        });
    }

    // ============== grafics ============

    function geraGrafico() {
        var request = $.ajax({
            url: "graficoResumo",
            method: "POST",
            dataType: "json",
            cache: true
        });

        request.done(function (response) {
            console.log(response);
            drawChart(response);
        });

        request.fail(function (jqXHR, textStatus) {
            alert("Erro: " + textStatus + ' - ' + jqXHR);
        });
    }

    function drawChart(response) {
        var data = google.visualization.arrayToDataTable([
            ["Element", "Total vendas", {role: "style"}], 
            [response[0][0]['ANO_MES'], parseFloat(response['0']['0'].QUANTIDADE_VENDA), "#3F51B5"],
            [response[1][0]['ANO_MES'], parseFloat(response['1']['0'].QUANTIDADE_VENDA), "#3F51B5"],
            [response[2][0]['ANO_MES'], parseFloat(response['2']['0'].QUANTIDADE_VENDA), "#3F51B5"],
            [response[3][0]['ANO_MES'], parseFloat(response['3']['0'].QUANTIDADE_VENDA), "#3F51B5"],
            [response[4][0]['ANO_MES'], parseFloat(response['4']['0'].QUANTIDADE_VENDA), "#3F51B5"],
            [response[5][0]['ANO_MES'], parseFloat(response['5']['0'].QUANTIDADE_VENDA), "#3F51B5"],
            [response[6][0]['ANO_MES'], parseFloat(response['6']['0'].QUANTIDADE_VENDA), "#3F51B5"],
            [response[7][0]['ANO_MES'], parseFloat(response['7']['0'].QUANTIDADE_VENDA), "#3F51B5"],
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"},
            2]);

        var options = {
            title: 'Relatório de vendas totalizadas por mês',
            bar: {groupWidth: "30%"},
            legend: {position: "none"},
            vAxis: {
                title: 'Ranking',
                titleTextStyle: {
                    fontSize: 18,
                    color: '#3F51B5',
                    bold: true,
                    italic: false
                }
            }
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
    }
    // ============== grafics ============


        // ======================
        function buscarDados() {
            
            var request = $.ajax({
                url: "<?= base_url('metaVendas'); ?>",
                method: "GET",
                dataType: "json",
                cache: true
            });

            request.done(function (response) {
//                console.log(response);
                drawMultSeries(response);
            });

            request.fail(function (jqXHR, textStatus) {
                alert("Erro: " + textStatus + ' - ' + jqXHR);
            });
            return false;
        }

        function drawMultSeries(dados) {
//            console.log(dados);
            var total_venda = 0;
            var total_meta = 0;
            var mes = 0;
            
            if (dados.total_meta !== null) {
                total_meta = parseFloat(dados.total_meta);
            }

            if (dados.total_venda !== null) {
                total_venda = parseFloat(dados.total_venda);
            }

            if (typeof dados.mes !== 'undefined') {
                mes = dados.mes;
            }
            
            
            var data = google.visualization.arrayToDataTable([
                ['Mês', 'Meta Vendas', 'Total Vendas'],
                [mes, total_meta, total_venda],
            ]);

            var options = {
                title: 'Gráfico de vendas',
                chartArea: {width: '50%'},
                hAxis: {
                  title: 'Total pedidos',
                  minValue: 0,
                  format: 'R$ #########',
                },
                vAxis: {
                  title: 'Mês',
                },
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
            
        google.charts.load('current', {packages: ['corechart', 'bar'], 'language': 'pt'});
        google.charts.setOnLoadCallback(buscarDados);
        // ======================

</script>

</body>
</html>