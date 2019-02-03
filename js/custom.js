jQuery(document).ready(function() {
    jQuery('#userTable').dataTable( {
        "cache": false,
        //"bFilter": false, //using custom filtering below no search box
        "pagingType": "simple_numbers",
        "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, "All"]],
        "language": {
            "infoEmpty": "Sorry, no users are available.",
        },
        "initComplete": function () {
            this.api().columns([2]).every( function () { //only apply to the User Role column
                var column = this;
                var select = jQuery('<select><option value="" selected>Roles - Show All</option></select>')
                    .appendTo( jQuery(column.header()).empty() )
                    .on( 'change', function () {
                        var val = jQuery.fn.dataTable.util.escapeRegex(
                            jQuery(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );

