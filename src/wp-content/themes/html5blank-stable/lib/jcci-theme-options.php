<?php
/**
 * Define our settings sections
 *
 * array key=$id, array value=$title in: add_settings_section( $id, $title, $callback, $page );
 * @return array
 */
function jcci_options_page_sections() {

	$sections = array();
	// $sections[$id] 				= __($title, 'jcci_textdomain');
	$sections['header_section'] = __('Header Section', 'jcci_textdomain');
	$sections['footer_section'] = __('Footer Section', 'jcci_textdomain');

	if (JCCI_DEBUG_FIELDS) {
		$sections['txt_section'] 		= __('Text Form Fields', 'jcci_textdomain');
		$sections['txtarea_section'] 	= __('Textarea Form Fields', 'jcci_textdomain');
		$sections['select_section'] 	= __('Select Form Fields', 'jcci_textdomain');
		$sections['checkbox_section'] 	= __('Checkbox Form Fields', 'jcci_textdomain');
	}
	
	return $sections;
}

/**
 * Define our form fields (settings) 
 *
 * @return array
 */
function jcci_options_page_fields() {
	// Header Section section
	$options[] = array(
		"section" => "header_section",
		"id"      => JCCI_SHORTNAME . "_total_member_input",
		"title"   => __( 'Total Member', 'jcci_textdomain' ),
		"desc"    => __( 'Total member is until this month. Ex: 786.', 'jcci_textdomain' ),
		"type"    => "text",
		"std"     => "783",
		"class"   => "numeric"
	);

	$options[] = array(
		"section" => "header_section",
		"id"      => JCCI_SHORTNAME . "_bg_header_post_url_input",
		"title"   => __( 'Background Post Header URL', 'jcci_textdomain' ),
		"desc"    => __( 'Header background for post such as pickup', 'jcci_textdomain' ),
		"type"    => "text",
		"std"     => get_template_directory_uri() . '/assets/img/bg-sub-post.jpg',
		"class"   => "url"
	);

	$options[] = array(
		"section" => "header_section",
		"id"      => JCCI_SHORTNAME . "_bg_header_news_url_input",
		"title"   => __( 'Background News Header URL', 'jcci_textdomain' ),
		"desc"    => __( 'Header background for post type is news', 'jcci_textdomain' ),
		"type"    => "text",
		"std"     => get_template_directory_uri() . '/assets/img/bg-sub-news.jpg',
		"class"   => "url"
	);

	$options[] = array(
		"section" => "header_section",
		"id"      => JCCI_SHORTNAME . "_bg_header_faq_url_input",
		"title"   => __( 'Background FAQ Header URL', 'jcci_textdomain' ),
		"desc"    => __( 'Header background for post type is FAQ', 'jcci_textdomain' ),
		"type"    => "text",
		"std"     => get_template_directory_uri() . '/assets/img/bg-sub-faq.jpg',
		"class"   => "url"
	);

	$options[] = array(
		"section" => "header_section",
		"id"      => JCCI_SHORTNAME . "_bg_header_services_url_input",
		"title"   => __( 'Background Services Header URL', 'jcci_textdomain' ),
		"desc"    => __( 'Header background for post type is services', 'jcci_textdomain' ),
		"type"    => "text",
		"std"     => get_template_directory_uri() . '/assets/img/bg-sub-services.jpg',
		"class"   => "url"
	);

	$options[] = array(
		"section" => "header_section",
		"id"      => JCCI_SHORTNAME . "_bg_header_action_url_input",
		"title"   => __( 'Background Action Header URL', 'jcci_textdomain' ),
		"desc"    => __( 'Header background for post type is action', 'jcci_textdomain' ),
		"type"    => "text",
		"std"     => get_template_directory_uri() . '/assets/img/bg-sub-actions.jpg',
		"class"   => "url"
	);

	// Footer Section section
	$options[] = array(
		"section" => "footer_section",
		"id"      => JCCI_SHORTNAME . "_map_url_input",
		"title"   => __( 'Google Map URL', 'jcci_textdomain' ),
		"desc"    => __( 'Google map url to open when click map on footer.', 'jcci_textdomain' ),
		"type"    => "text",
		"std"     => "",
		"class"   => "url"
	);

	$options[] = array(
		"section" => "footer_section",
		"id"      => JCCI_SHORTNAME . "_bg_contact_input",
		"title"   => __( 'Contact Background Image', 'jcci_textdomain' ),
		"desc"    => __( 'Image url to display below contact. Best size is 765 x 510px. Using .jpg, .jpeg extension format.', 'jcci_textdomain' ),
		"type"    => "text",
		"std"     => get_template_directory_uri() . '/assets/img/bg-contact.jpg',
		"class"   => "url"
	);

	$options[] = array(
		"section" => "footer_section",
		"id"      => JCCI_SHORTNAME . "_google_analytic_input",
		"title"   => __( 'Google Analytics ID', 'jcci_textdomain' ),
		"desc"    => __( 'Put your google analytic ID here, e.g: G-JZBDE94VWR', 'jcci_textdomain' ),
		"type"    => "text",
		"std"     => __('','jcci_textdomain')
	);

	if (JCCI_DEBUG_FIELDS) {

		// Text Form Fields section
		$options[] = array(
			"section" => "txt_section",
			"id"      => JCCI_SHORTNAME . "_txt_input",
			"title"   => __( 'Text Input - Some HTML OK!', 'jcci_textdomain' ),
			"desc"    => __( 'A regular text input field. Some inline HTML (&lt;a&gt;, &lt;b&gt;, &lt;em&gt;, &lt;i&gt;, &lt;strong&gt;) is allowed.', 'jcci_textdomain' ),
			"type"    => "text",
			"std"     => __('Some default value','jcci_textdomain')
		);
		
		$options[] = array(
			"section" => "txt_section",
			"id"      => JCCI_SHORTNAME . "_nohtml_txt_input",
			"title"   => __( 'No HTML!', 'jcci_textdomain' ),
			"desc"    => __( 'A text input field where no html input is allowed.', 'jcci_textdomain' ),
			"type"    => "text",
			"std"     => __('Some default value','jcci_textdomain'),
			"class"   => "nohtml"
		);
		
		$options[] = array(
			"section" => "txt_section",
			"id"      => JCCI_SHORTNAME . "_numeric_txt_input",
			"title"   => __( 'Numeric Input', 'jcci_textdomain' ),
			"desc"    => __( 'A text input field where only numeric input is allowed.', 'jcci_textdomain' ),
			"type"    => "text",
			"std"     => "123",
			"class"   => "numeric"
		);
		
		$options[] = array(
			"section" => "txt_section",
			"id"      => JCCI_SHORTNAME . "_multinumeric_txt_input",
			"title"   => __( 'Multinumeric Input', 'jcci_textdomain' ),
			"desc"    => __( 'A text input field where only multible numeric input (i.e. comma separated numeric values) is allowed.', 'jcci_textdomain' ),
			"type"    => "text",
			"std"     => "123,234,345",
			"class"   => "multinumeric"
		);
		
		$options[] = array(
			"section" => "txt_section",
			"id"      => JCCI_SHORTNAME . "_url_txt_input",
			"title"   => __( 'URL Input', 'jcci_textdomain' ),
			"desc"    => __( 'A text input field which can be used for urls.', 'jcci_textdomain' ),
			"type"    => "text",
			"std"     => "http://wp.tutsplus.com",
			"class"   => "url"
		);
		
		$options[] = array(
			"section" => "txt_section",
			"id"      => JCCI_SHORTNAME . "_email_txt_input",
			"title"   => __( 'Email Input', 'jcci_textdomain' ),
			"desc"    => __( 'A text input field which can be used for email input.', 'jcci_textdomain' ),
			"type"    => "text",
			"std"     => "email@email.com",
			"class"   => "email"
		);
		
		$options[] = array(
			"section" => "txt_section",
			"id"      => JCCI_SHORTNAME . "_multi_txt_input",
			"title"   => __( 'Multi-Text Inputs', 'jcci_textdomain' ),
			"desc"    => __( 'A group of text input fields', 'jcci_textdomain' ),
			"type"    => "multi-text",
			"choices" => array( __('Text input 1','jcci_textdomain') . "|txt_input1", __('Text input 2','jcci_textdomain') . "|txt_input2", __('Text input 3','jcci_textdomain') . "|txt_input3", __('Text input 4','jcci_textdomain') . "|txt_input4"),
			"std"     => ""
		);
		
		// Textarea Form Fields section
		$options[] = array(
			"section" => "txtarea_section",
			"id"      => JCCI_SHORTNAME . "_txtarea_input",
			"title"   => __( 'Textarea - HTML OK!', 'jcci_textdomain' ),
			"desc"    => __( 'A textarea for a block of text. HTML tags allowed!', 'jcci_textdomain' ),
			"type"    => "textarea",
			"std"     => __('Some default value','jcci_textdomain')
		);

		$options[] = array(
			"section" => "txtarea_section",
			"id"      => JCCI_SHORTNAME . "_nohtml_txtarea_input",
			"title"   => __( 'No HTML!', 'jcci_textdomain' ),
			"desc"    => __( 'A textarea for a block of text. No HTML!', 'jcci_textdomain' ),
			"type"    => "textarea",
			"std"     => __('Some default value','jcci_textdomain'),
			"class"   => "nohtml"
		);
		
		$options[] = array(
			"section" => "txtarea_section",
			"id"      => JCCI_SHORTNAME . "_allowlinebreaks_txtarea_input",
			"title"   => __( 'No HTML! Line breaks OK!', 'jcci_textdomain' ),
			"desc"    => __( 'No HTML! Line breaks allowed!', 'jcci_textdomain' ),
			"type"    => "textarea",
			"std"     => __('Some default value','jcci_textdomain'),
			"class"   => "allowlinebreaks"
		);

		$options[] = array(
			"section" => "txtarea_section",
			"id"      => JCCI_SHORTNAME . "_inlinehtml_txtarea_input",
			"title"   => __( 'Some Inline HTML ONLY!', 'jcci_textdomain' ),
			"desc"    => __( 'A textarea for a block of text. 
			Only some inline HTML 
			(&lt;a&gt;, &lt;b&gt;, &lt;em&gt;, &lt;strong&gt;, &lt;abbr&gt;, &lt;acronym&gt;, &lt;blockquote&gt;, &lt;cite&gt;, &lt;code&gt;, &lt;del&gt;, &lt;q&gt;, &lt;strike&gt;) 
			is allowed!', 'jcci_textdomain' ),
			"type"    => "textarea",
			"std"     => __('Some default value','jcci_textdomain'),
			"class"   => "inlinehtml"
		);	
		
		// Select Form Fields section
		$options[] = array(
			"section" => "select_section",
			"id"      => JCCI_SHORTNAME . "_select_input",
			"title"   => __( 'Select (type one)', 'jcci_textdomain' ),
			"desc"    => __( 'A regular select form field', 'jcci_textdomain' ),
			"type"    => "select",
			"std"    => "3",
			"choices" => array( "1", "2", "3")
		);
		
		$options[] = array(
			"section" => "select_section",
			"id"      => JCCI_SHORTNAME . "_select2_input",
			"title"   => __( 'Select (type two)', 'jcci_textdomain' ),
			"desc"    => __( 'A select field with a label for the option and a corresponding value.', 'jcci_textdomain' ),
			"type"    => "select2",
			"std"    => "",
			"choices" => array( __('Option 1','jcci_textdomain') . "|opt1", __('Option 2','jcci_textdomain') . "|opt2", __('Option 3','jcci_textdomain') . "|opt3", __('Option 4','jcci_textdomain') . "|opt4")
		);
		
		// Checkbox Form Fields section
		$options[] = array(
			"section" => "checkbox_section",
			"id"      => JCCI_SHORTNAME . "_checkbox_input",
			"title"   => __( 'Checkbox', 'jcci_textdomain' ),
			"desc"    => __( 'Some Description', 'jcci_textdomain' ),
			"type"    => "checkbox",
			"std"     => 1 // 0 for off
		);
		
		$options[] = array(
			"section" => "checkbox_section",
			"id"      => JCCI_SHORTNAME . "_multicheckbox_inputs",
			"title"   => __( 'Multi-Checkbox', 'jcci_textdomain' ),
			"desc"    => __( 'Some Description', 'jcci_textdomain' ),
			"type"    => "multi-checkbox",
			"std"     => '',
			"choices" => array( __('Checkbox 1','jcci_textdomain') . "|chckbx1", __('Checkbox 2','jcci_textdomain') . "|chckbx2", __('Checkbox 3','jcci_textdomain') . "|chckbx3", __('Checkbox 4','jcci_textdomain') . "|chckbx4")	
		);
	}

	return $options;	
}

/**
 * Contextual Help
 */
function jcci_options_page_contextual_help() {
	
	$text 	= "<h3>" . __('JCCI Settings - Contextual Help','jcci_textdomain') . "</h3>";
	$text 	.= "<p>" . __('Contextual help goes here. You may want to use different html elements to format your text as you want.','jcci_textdomain') . "</p>";
	
	// must return text! NOT echo
	return $text;
} ?>