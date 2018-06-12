$(document).ready(function() {
    $(document)
        .on('click', '.btnChoixPari', function() {
            let cote = $(this).data('cote'),
                data = $(this).closest('.row').data(),
                modal = $(document).find('#modalPari');
            modal.find('.modal-title').html(data.nomTeamA+' - '+data.nomTeamB);
            modal.find('#idMatchPari').val(data.match);
            modal.find('#idTypePari').val(data.typePari);
            modal.find('#idCotePari').val(cote);
            modal.modal('show');
        });
});