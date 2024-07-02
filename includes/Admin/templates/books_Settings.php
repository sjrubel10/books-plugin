<?php
$limit = get_option( 'books_per_page' );
if( $limit < 1 ){
    $limit = 10;
}
?>
<div class="wrap">
    <h1><?php echo __( 'Books Settings', 'books-plugin' );?></h1>
    <form id="booksSettingsForm" >
        <h2><?php echo __( 'Books Per Page Settings', 'books-plugin' );?></h2>
        <p><?php echo __( 'Set the number of books displayed per page for the [display_books] shortcode.', 'books-plugin' );?></p>
        <table class="form-table" role="presentation">
            <tbody>
            <tr>
                <th scope="row"><?php echo __( 'Books Per Page', 'books-plugin')?></th>
                <td>
                    <input type="number" id="books_per_page" name="books_per_page" value=<?php echo esc_attr( $limit ) ?> min="1">
                </td>
            </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="booksSubmit" id="booksSubmit" class="button button-primary" value="Save Settings">
        </p>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
