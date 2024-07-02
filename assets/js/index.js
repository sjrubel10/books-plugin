function set_books_limit_per_page_in_options( setUrl, type, search_data ){
    jQuery.ajax({
        type: type,
        url: setUrl,
        contentType: 'application/json',
        headers: {
            'X-WP-Nonce': search_data.nonce
        },
        data: JSON.stringify(search_data),
        success: function( response ) {
            // let searchData = display_search_data( response );
            // jQuery("#productTitleWrapper").append( searchData )
            if( response ){
                jQuery("#booksSubmit").val('Save Settings');
                alert( "Successfully Updated" );
            }else{
                alert( "Somethings Went Wrong" );
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

function isPositiveInteger(value) {
    var num = Number(value);
    return Number.isInteger(num) && num > 0;
}
jQuery('#booksSettingsForm').on('click', '#booksSubmit', function( e ) {
    e.preventDefault();

    let setUrl = myBooksVars.site_url+'/wp-json/books/v1/set_limit';
    let type = 'POST';
    let getLimit = jQuery("#books_per_page").val();
    if ( isPositiveInteger( getLimit ) ) {
        jQuery("#booksSubmit").val('Saving...');
        let search_data = {
            'limit': getLimit,
            'nonce': myBooksVars.rest_nonce,
        }
        set_books_limit_per_page_in_options( setUrl, type, search_data);
    }else{
        alert(getLimit + " is not a positive integer. for updating this need to provide positive integer value");
    }

});