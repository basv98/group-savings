google.charts.load('current', { 'packages': ['bar'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Year', 'Jess', 'Bryan'],
        ['Enero', 1000, 400],
        ['Febrero', 1170, 460],
        ['Marzo', 660, 1120],
        ['Abril', 1030, 540],
        ['Mayo', 1030, 540],
        ['Junio', 1030, 540],
        ['Julio', 1030, 540],
        ['Agosto', 1030, 540],
        ['Septiembre', 1030, 540],
        ['Octubre', 1030, 540],
        ['Noviembre', 1030, 540],
        ['Diciembre', 1030, 540],
    ]);

    var options = {
        chart: {
            title: 'Ahorro grupal',
            subtitle: 'Ahorro 2021',
        }
    };
    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
}

function goal(anio = 2021) {
    let monto;
    $.ajax({
        type: "POST",
        url: "goal",
        data: { anio },
        async: false,
        dataType: "JSON",
        success: function (response) {
            monto = response.mount;
        }
    });
    return monto;
}

function modalAhorro() {
    $("#montoMeta").val(goal($("#anioMetaAhorro").val()));
    $("#modalAhorro").modal("show");
}