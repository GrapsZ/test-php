jQuery('.travelDatatables').DataTable({
    "language": {
        "decimal":        "",
        "emptyTable":     "Aucune donnée trouvée.",
        "info": "Page _PAGE_ sur _PAGES_",
        "infoEmpty": "Aucun voyage trouvé.",
        "infoFiltered": "(filtré depuis un total de _MAX_ voyages)",
        "infoPostFix":    "",
        "thousands":      " ",
        "lengthMenu": "Affichage de _MENU_ voyages par page.",
        "loadingRecords": "Chargement en cours...",
        "processing":     "Veuillez patientez...",
        "search":         "Recherche : ",
        "zeroRecords": "Désolé, aucun voyage n'a été trouvé.",
        "paginate": {
            "first":      "Première page",
            "last":       "Dernière page",
            "next":       "Page suivante",
            "previous":   "Page précédente"
        },
        "aria": {
            "sortAscending":  ": cliquez pour trier cette colonne dans l'ordre croissant",
            "sortDescending": ": cliquez pour trier cette colonne dans l'ordre décroissant"
        }
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tous"]]
});

jQuery('.stageDatatables').DataTable({
    "language": {
        "decimal":        "",
        "emptyTable":     "Aucune donnée trouvée.",
        "info": "Page _PAGE_ sur _PAGES_",
        "infoEmpty": "Aucune étape trouvée.",
        "infoFiltered": "(filtré depuis un total de _MAX_ étapes)",
        "infoPostFix":    "",
        "thousands":      " ",
        "lengthMenu": "Affichage de _MENU_ étapes par page.",
        "loadingRecords": "Chargement en cours...",
        "processing":     "Veuillez patientez...",
        "search":         "Recherche : ",
        "zeroRecords": "Désolé, aucune étape n'a été trouvée.",
        "paginate": {
            "first":      "Première page",
            "last":       "Dernière page",
            "next":       "Page suivante",
            "previous":   "Page précédente"
        },
        "aria": {
            "sortAscending":  ": cliquez pour trier cette colonne dans l'ordre croissant",
            "sortDescending": ": cliquez pour trier cette colonne dans l'ordre décroissant"
        }
    },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tous"]]
});