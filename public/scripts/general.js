$(document).bind("mobileinit",  function(){
    //Page
    $.mobile.page.prototype.options.headerTheme         = "d"; 
    $.mobile.page.prototype.options.contentTheme        = "a";
    $.mobile.page.prototype.options.footerTheme         = "d";

    $.mobile.page.prototype.options.domCache = false;

    //Listview
    $.mobile.listview.prototype.options.theme           = "a";
    $.mobile.listview.prototype.options.headerTheme     = "d"; 
    $.mobile.listview.prototype.options.dividerTheme    = "d"; 
    $.mobile.listview.prototype.options.splitTheme      = "d";
    $.mobile.listview.prototype.options.countTheme      = "d";
    $.mobile.listview.prototype.options.filterTheme     = "d";

    //Dialog
    $.mobile.dialog.prototype.options.create = function()
    {
        var id = $(this).attr("id");

        $("#" + id).find("form").on(
            "submit", 
            function( event )
            {
                event.preventDefault();

                Cenbrap.ajax.post({
                    url:        $(this).attr("action"), 
                    data:       $(this).serialize(), 
                    selector:   "#" + id + " form" 
                });
            }
        );
    };
});

/**
 *
 */
var Cenbrap = (function(){

    function validator( error )
    {
        for ( id in error )
            //$("#" + id).addClass("invalid");
            $(".ui-page-active").find("#" + id).addClass("invalid");
    }

    function checkValidation( form )
    {
        //$(form).find(".invalid").live("click", function(){
        $(".ui-page-active").find(form).find(".invalid").live("click", function(){
            $(this).removeClass("invalid");
        });
    }

    return {

        //Ajax
        ajax: {
            post: function( options )
            {
                $.mobile.showPageLoadingMsg();

                $.post(
                    options.url, 
                    options.data, 
                    function( response ) 
                    {
                        if ( response.valid ) {
                            if ( options.callback ) {
                                options.callback( response );
                                return false;
                            }
                        } else {
                            validator( response.error );
                        }

                        Cenbrap.message.show( response.message );
                    }, 
                    "json"
                ).complete(
                    function()
                    {
                        $.mobile.hidePageLoadingMsg();
                    }
                ).error(
                    function( e ) 
                    {
                        $.mobile.hidePageLoadingMsg();
                    }
                );
            },
            get: function( options )
            {
                $.mobile.showPageLoadingMsg();

                $.get(
                    options.url,
                    function( response )
                    {
                        if ( response.valid ) {
                            if ( options.callback ) {
                                options.callback();
                                return false;
                            }
                        } else {
                            validator( response.error )
                        }

                        Cenbrap.message.show( response.message, selector );
                    },
                    "json"
                ).complete(
                    function()
                    {
                        $.mobile.hidePageLoadingMsg();
                    }
                ).error(
                    function( e )
                    {
                        $.mobile.hidePageLoadingMsg();
                    }
                )
            }
        },

        //Mensagens
        message: {
            show: function( data )
            {
                var 
                    ul  = $("<ul>"),
                    li,
                    span,
                    i,
                    length;

                $(".notification").remove();

                $(ul).addClass( "ui-body ui-body-c notification" );

                for ( i = 0, length = data.length; i < length; i++ ) {

                    li      = $("<li>");
                    span    = $("<span>").addClass( data[i].level );

                    $(li).append( span );
                    $(li).append( data[i].message );

                    $(ul).addClass( data[i].level );
                    $(ul).append( li );

                }

                //$("#content").prepend( ul );
                $(".ui-page-active").prepend(ul);

                //setTimeout( this.hide, 2000 );
                $(ul).bind( "click", this.hide );
            },
            hide: function()
            {
                $(".notification").remove();
            }
        },

        submit: function( form, options )
        {
            Cenbrap.ajax.post({
                url: $(form).attr("action"),
                data: $(form).serialize(),
                callback: function( response )
                {
                    if ( options && options.callback )  {
                        options.callback( response );
                        return false;
                    } else {
                        //$(form).get(0).reset();
                        Cenbrap.message.show( response.message, "#content form" );
                    }
                }
            });

            checkValidation( form );

            return false;
        },

        logout: function()
        {
            Cenbrap.ajax.get({
                url: baseUrl + "auth/logout",
                callback: function()
                {
                    location.assign( baseUrl + "auth" );
                }
            });
        }
    };

})();

function remarcarDisciplina( response )
{
    $('.ui-dialog')
        .on(
            "pagehide",
            function()
            {
                Cenbrap.message.show( response.message );
            }
        )
        .dialog('close');
}