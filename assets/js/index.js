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

jQuery('#booksSettingsForm').on('click', '#booksSubmit', function( e ) {
    e.preventDefault();

   jQuery("#booksSubmit").val('Saving...');
    let setUrl = myBooksVars.site_url+'/wp-json/books/v1/set_limit';
    let type = 'POST';
    let search_data = {
        'limit': jQuery("#books_per_page").val(),
        'nonce': myBooksVars.rest_nonce,
    }
    set_books_limit_per_page_in_options( setUrl, type, search_data);
});