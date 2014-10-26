$(document).ready(function(){
    
    $(document).tooltip({
        content: function () {
            return $(this).prop('title');
        },
        hide: false,
        show: false,
        track: false
    });
    
    $('#add_player, #s_player').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: '/site/_players',
                type: 'POST',
                dataType: 'json',
                data: {
                    q: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            $(this).val(ui.item.value);
        },
        open: function() {
            $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        }
    });

    $('#add_tribe, #s_tribe').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: '/site/_tribes',
                type: 'POST',
                dataType: 'json',
                data: {
                    q: request.term
                },
                success: function( data ) {
                    response( data );
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            $(this).val(ui.item.value);
        },
        open: function() {
            $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
        },
        close: function() {
            $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
        }
    });
    
    $('._s_search').keydown(function(e){
        if ( e.keyCode==13 ) {
            $(this).parent().find('button').click();
        }
    });
    
});