import $ from "jquery";

$(document).ready(function() {
    $('.alert-success').delay(2000).hide(0);
    $('.alert-danger').delay(2000).hide(0);

    var userTable = $('#user_data').bootgrid({
        ajax: true,
        rowSelect: true,
        url: "fetch-users",
        formatters: {
            "commands": function(column, row) {
                var urlEditBtn = "{{ path('edit_user', {'id': 'rowId'}) }}";
                var urlDelBtn = "{{ path('delete_user', {'id': 'rowId'}) }}";
                urlEditBtn = urlEditBtn.replace("rowId", row.id);
                urlDelBtn = urlDelBtn.replace("rowId", row.id);

                return "<a href='"+urlEditBtn+"' class='btn btn-warning btn-xs update'>Modifier</a>" +
                    "&nbsp; <a href='"+urlDelBtn+"' class='btn btn-danger btn-xs delete'>Supprimer</a>";
            }
        },
        labels: {
            loading: "Chargement",
            noResults: "Aucun résultat trouvé !",
            refresh: "Actualiser",
            search: "Rechercher",
        }
    });
});
