<?php
$this->gui->col_width(1, 4);
		
$this->gui->add_meta( array(
	'col_id'	=>	1,
	'namespace'	=>	'simple_update',
	'type'		=>	'unwrapped'
) );

ob_start();
?>
<h4 id="simple_update"></h4>
<script>
var download_url	=	'<?php echo site_url( array( 'dashboard', 'update', 'download', '3.0' ) );?>';
var extract_url		=	'<?php echo site_url( array( 'dashboard', 'update', 'extract' ) );?>';
var install_url		=	'<?php echo site_url( array( 'dashboard', 'update', 'install' ) );?>';
var SimpleUpdate	=	new function(){
	this.do_ajax	=	function( url, before, success ){
		$.ajax( url, {
			beforeSend 	: function(){
				before();
			},
			success		: function(e){
				success(e);
			},
			dataType	: 'json'
		});
	};
};
$(document).ready(function(e) {
	SimpleUpdate.do_ajax( download_url, function(){
		$('#simple_update').text( '<?php _e( 'Downloading Latest work' );?>' );
	}, function(e){
		if( e.code == 'archive-downloaded' ) {
			SimpleUpdate.do_ajax( extract_url, function(){
				$('#simple_update').text( '<?php echo _e( 'Extracting Release...' );?>' );
			}, function(e){
				if( e.code == 'archive-uncompressed' ) {
					SimpleUpdate.do_ajax( install_url, function(){
						$('#simple_update').text( '<?php _e( 'Installing release...' );?>' );
					}, function(e){
						if( e.code == 'update-done' ) {
							bootbox.alert( '<?php _e( 'Update Done' );?>' );
						} else {
							bootbox.alert( '<?php _e( 'An error occured during installation. Please try again.' );?>' );
						}
					});
				} else {
					bootbox.alert( '<?php _e( 'An error occured during extraction...' );?>' );		
				}
			});
		} else {
			bootbox.alert( '<?php _e( 'An error occured during download' );?>' );
		}
	})
});
</script>
<?php
$content	= 	ob_get_clean();

$this->gui->add_item( array(
	'type'		=>	'dom', 
	'content'	=>	$content
), 'simple_update', 1 );

$this->gui->output();