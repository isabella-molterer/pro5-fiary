$(document).ready(function() {
    $('#overview').DataTable( {
        "order": [[ 0, "desc" ]],
        "stateSave": true,
        dom: 'Blfrtip',
        buttons: [{
            extend: 'pdfHtml5',
            orientation: 'portrait',
            pageSize: 'A4',
            filename: 'Mitgliederliste'
        }],
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        "language": {
            "lengthMenu": "Zeige _MENU_ Einträge pro Seite",
            "zeroRecords": "Nichts gefunden - sorry",
            "info": "Seite _PAGE_ von _PAGES_",
            "infoEmpty": "Keine Einträge verfügbar",
            "infoFiltered": "(gefiltert von _MAX_ Gesamteinträgen)",
            "search": "Suchen",
            "paginatePrevious": "Vorherige"
        }
    } );

    $('#example').DataTable( {
        "order": [[ 3, "asc" ]],
        "stateSave": true,
        dom: 'Blfrtip',
        buttons: [{
                extend: 'pdfHtml5',
                orientation: 'portrait',
                pageSize: 'A4',
                filename: 'Mitgliederliste'
        }],
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        "language": {
            "lengthMenu": "Zeige _MENU_ Einträge pro Seite",
            "zeroRecords": "Nichts gefunden - sorry",
            "info": "Seite _PAGE_ von _PAGES_",
            "infoEmpty": "Keine Einträge verfügbar",
            "infoFiltered": "(gefiltert von _MAX_ Gesamteinträgen)",
            "search": "Suchen",
            "paginatePrevious": "Vorherige"
        }
    } );

    $('#häuser').DataTable( {
        "order": [[ 0, "asc" ]],
        "stateSave": true,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        "language": {
            "lengthMenu": "Zeige _MENU_ Einträge pro Seite",
            "zeroRecords": "Nichts gefunden - sorry",
            "info": "Seite _PAGE_ von _PAGES_",
            "infoEmpty": "Keien Einträge verfügbar",
            "infoFiltered": "(gefiltert von _MAX_ Gesamteinträgen)",
            "search": "Suchen",
            "paginatePrevious": "Vorherige"
        }
    } );
} );





