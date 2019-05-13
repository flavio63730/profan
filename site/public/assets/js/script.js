function drawChart(info) {
    //pour aller chercher la data dans une BD:
    //https://developers.google.com/chart/interactive/docs/queries
    var data = google.visualization.arrayToDataTable(info);

    var options = {
        title: 'Quantité de produit en stock',
        legend: { position: 'none' },
    };

    var chart = new google.visualization.Histogram(document.getElementById('chart_div'));
    chart.draw(data, options);
}

setTimeout(function() {
    $( '#flash-message' ).fadeOut();
}, 5000);