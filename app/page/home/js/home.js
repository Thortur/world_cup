$(document).ready(function() {
    $(document)
        .on('click', '#btnVaildPari', function() {
            let montant = $(document).find('#montantPari').val();
            return $.isNumeric(montant)
        })
        .on('click', '.btnChoixPari', function() {
            let cote  = $(this).data('cote'),
                data  = $(this).closest('.listBtnGoPari').data(),
                modal = $(document).find('#modalPari');
            modal.find('.modal-title').html(data.nomTeamA+' - '+data.nomTeamB);
            modal.find('#montantPari').val('');
            modal.find('#idMatchPari').val(data.match);
            modal.find('#idTypePari').val(data.typePari);
            modal.find('#idCotePari').val(cote);
            modal.modal('show');
        })
        .on('click', '.btnSaisieResultat', function() {
            let data  = $(this).closest('.divBtnSaisieResultat').data(),
                modal = $(document).find('#modalResultatMatch');
            console.log(data);
            modal.find('.modal-title').html(data.nomTeamA+' - '+data.nomTeamB);
            modal.find('#idMatchResultat').val(data.match);
            modal.find('#idTeamAResultat').val(data.idTeamA);
            modal.find('#idTeamBResultat').val(data.idTeamB);
            modal.find('#labelTeamA').html(data.nomTeamA);
            modal.find('#labelTeamB').html(data.nomTeamB);
            modal.find('#idScoreAResultat').val(0);
            modal.find('#idScoreBResultat').val(0);
            modal.modal('show');
        });
// });
// $(window).on("load", function(){
    var ctx = $("#area-chart");
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
            position: 'bottom',
        },
        hover: {
            mode: 'label'
        },
        scales: {
            xAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                    labelString: 'Matches'
                }
            }],
            yAxes: [{
                display: true,
                gridLines: {
                    color: "#f3f3f3",
                    drawTicks: false,
                },
                scaleLabel: {
                    display: true,
                    labelString: 'Cagnotte'
                }
            }]
        },
        title: {
            display: true,
            text: 'Votre cagnotte après chaque match'
        }
    };
    
    var config = {
        type: 'line',
        options : chartOptions,
        data : chartData
    };
    var areaChart = new Chart(ctx, config);
});