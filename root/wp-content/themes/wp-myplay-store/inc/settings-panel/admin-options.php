<?php
/*/////////////////////////////////////////////////////
	* Creates Admin Panel in dashboard settings page
	* Includes admin-panel.php
/////////////////////////////////////////////////////*/
add_action( 'init', '_psAdminOptions' );

function _psAdminOptions(){
    global $rg_ps_fields;
    
	if ( ! ( current_user_can( 'administrator' ) || current_user_can( 'developer' )) )
		return;
				
    require_once( RG_PS_DIR . '/admin-panel.php' );
    	
    $prefix = 'ps_';

    $rg_ps_fields = array(
    	array(
		 'id'	 => $prefix.'ps_options',
		 'type'	 => 'section',
		 'label' => __( 'Social Options', RG_PS_LOCALE )
		),
		array(
		 'label' => 'Twitter',
		 'desc'	 => sprintf( __( 'Check to display Twitter share icon.', RG_PS_LOCALE )),
		 'id'	 => $prefix.'social_tw',
		 'type'	 => 'checkbox'
		),
		array(
		 'label' => 'Facebook',
		 'desc'	 => sprintf( __( 'Check to display Facebook share icon.', RG_PS_LOCALE )),
		 'id'	 => $prefix.'social_fb',
		 'type'	 => 'checkbox'
		),
		array(
		 'label' => 'Google+',
		 'desc'	 => sprintf( __( 'Check to display Google+ share icon.', RG_PS_LOCALE )),
		 'id'	 => $prefix.'social_gp',
		 'type'	 => 'checkbox'
		),
		array(
		 'label' => 'Pinsterest',
		 'desc'	 => sprintf( __( 'Check to display Pinterest share icon.', RG_PS_LOCALE )),
		 'id'	 => $prefix.'social_pin',
		 'type'	 => 'checkbox'
		),
		array(
		 'label' => 'Feedback URL',
		 'desc'	 => sprintf( __( 'Paste the Feedback url here.', RG_PS_LOCALE )),
		 'id'	 => $prefix.'social_feb',
		 'type'	 => 'text',
		 'placeholder' => 'http://www.myplay.com/direct/contact/'
		),
		array(
		 'id'	=> $prefix.'ps_options',
		 'type'	=> 'section',
		 'label' => __( 'Footer Options', RG_PS_LOCALE )
		),
		array(
		    'label'	=> 'Footer Legal',
		    'desc'	=> 'Paste the footer text here.',
		    'id'	=> $prefix.'section_legal',
		    'type'	=> 'input_group',
		    'sanitizer' => array( 
		        'title' => 'sanitize_text_field',
		        'subtitle' => 'sanitize_text_field'
		    ),
		    'group_fields' => array(
		        'terms' => array(
		        	'label'	=> 'Terms URL',
		        	'id' => 'terms',
		        	'type' => 'text',
		        	'placeholder' => 'http://www.myplay.com/direct/terms-conditions'
		        ),
		        'privacy' => array(
		        	'label'	=> 'Privacy URL',
		        	'id' => 'privacy',
		        	'type' => 'text',
		        	'placeholder' => 'http://www.myplay.com/direct/privacy-policy'
		        ),
		        'help' => array(
		        	'label'	=> 'Help URL',
		        	'id' => 'help',
		        	'type' => 'text',
		        	'placeholder' => 'http://www.myplay.com/direct/contact/'
		        ),
                'affiliatetext' => array(
		        	'label'	=> 'Affiliate Text',
		        	'id' => 'affiliatetext',
		        	'type' => 'text',
		        	'placeholder' => 'Become an Affiliate'
		        ),
		        'affiliate' => array(
		        	'label'	=> 'Affiliate URL',
		        	'id' => 'affiliate',
		        	'type' => 'text',
		        	'placeholder' => 'http://www.myplay.com/direct/affiliates'
		        ),
		    )
		),
		array(
		 'label'	=> 'Visit Sony URL',
		 'desc'	=> 'Paste the sony url here.',
		 'id'	=> $prefix.'visit',
		 'type'	=> 'text',
		 'placeholder' => 'http://www.sony.com/'
		),
	
	);
}

?>