google.charts.load('current', { 'packages': ['bar'] });
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    let anio = $("#selectAnioAhorro").val();
    let mes_id = $("#selectMesMontoAhorro").val();
    saving(anio, mes_id).then(function (saving) {
        var data = google.visualization.arrayToDataTable(saving);

        var options = {
            chart: {
                title: 'Ahorro en pareja',
                subtitle: 'Ahorro ' + anio,
            },
            vAxis: {format: 'decimal'},
        };
        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }).catch(function (error) {
        mensajeError(error);
    })
}

function modalAhorro() {
    goal($("#anioMetaAhorro").val())
        .then(function (goal) {
            $("#montoMeta").val(goal.mount);
            $("#modalAhorro").modal("show");
        }).catch(function () {
            $("#modalAhorro").modal("hide");
            mensajeError("no se encontro el año buscado");
        });
}

function goal(anio) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "goal",
            data: { anio },
            dataType: "JSON",
            success: function (data) {
                resolve(data)
            },
            error: function (error) {
                reject(error)
            },
        })
    })
}

function guardarAhorro() {
    $.ajax({
        type: "POST",
        url: "saving/save",
        data: {
            anio: $("#anioMontoAhorro").val(),
            mes_id: $("#mesMontoAhorro").val(),
            mount: $("#montoAhorrro").val()
        },
        dataType: "JSON",
        success: function (response) {
            $("#modalIngresarAhorro").modal("hide");
            if (response.sucess) {
                mensajeExitoso(response.response);
                drawChart();
            } else if (!response.sucess) {
                error(response.response)
            }
        },
        error: function (error) {
            error(error)
        },
    })
}

function modalIngresarAhorro() {
    $("#modalIngresarAhorro").modal("show");
}

function saving(anio, mes_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            type: "POST",
            url: "saving",
            data: { anio, mes_id },
            dataType: "JSON",
            async: false,
            success: function (response) {
                if (response.sucess) {
                    resolve(response.saving);
                } else {
                    reject(response.response);
                }
            },
            error: function (error) {
                reject(error);
            }
        });
    })
}