<?php
/*
Plugin Name: qTranslate support for GravityForms
Plugin URI: https://github.com/mweimerskirch/wordpress-qtranslate-support-for-gravityforms
Description: Makes qTranslate work with GravityForms
Version: 1.0.2
Author: Michel Weimerskirch
Author URI: http://michel.weimerskirch.net
License: MIT
*/
add_filter('gform_pre_render', 'qtranslate_gform_pre_render');
add_filter('gform_pre_submission_filter', 'qtranslate_gform_pre_render');
add_filter('gform_polls_form_pre_results', 'qtranslate_gform_pre_render');
function qtranslate_gform_pre_render($form)
{
	if (!function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')) return $form;

	if (isset($form['button']['text'])) {
		$form['button']['text'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['button']['text']);
	}
	if (isset($form['title'])) {
		$form['title'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['title']);
	}
	if (isset($form['description'])) {
		$form['description'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['description']);
	}
	if (isset($form['confirmation']['message'])) {
		$form['confirmation']['message'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['confirmation']['message']);
	}
	if (isset($form['fields'])) {
		foreach ($form['fields'] as $id => $field) {
			$form['fields'][$id]['label'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['fields'][$id]['label']);
			$form['fields'][$id]['content'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['fields'][$id]['content']);
			$form['fields'][$id]['description'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['fields'][$id]['description']);
			$form['fields'][$id]['defaultValue'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['fields'][$id]['defaultValue']);
			$form['fields'][$id]['errorMessage'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['fields'][$id]['errorMessage']);
			$form['fields'][$id]['validation_message'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['fields'][$id]['validation_message']);
			$form['fields'][$id]['choices'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['fields'][$id]['choices']);

			if (isset($form['fields'][$id]['conditionalLogic']['rules'])) {
				foreach ($form['fields'][$id]['conditionalLogic']['rules'] as $value => $key) {
					foreach ($key as $value2 => $key2) {
						$form['fields'][$id]['conditionalLogic']['rules'][$value][$value2] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($key2);
					}
				}
			}

			// Support for the poll add-on
			if (isset($form['fields'][$id]['choices'])) {
				foreach ($form['fields'][$id]['choices'] as $value => $key) {
					$form['fields'][$id]['choices'][$value]['text'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($key['text']);
				}
			}
                        
                        $form['fields'][$id]['nextButton']['text'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['fields'][$id]['nextButton']['text']);
                        $form['fields'][$id]['previousButton']['text'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['fields'][$id]['previousButton']['text']);

		}
	}
        if (isset($form['lastPageButton'])) {
		$form['lastPageButton'] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['lastPageButton']);
	}
        if(isset($form['pagination'])){
            foreach ($form['pagination']['pages'] as $id => $title){
                $form['pagination']['pages'][$id] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($form['pagination']['pages'][$id]);
            }
        }
	return $form;
}

add_filter('gform_form_tag', 'qtranslate_gform_form_tag');
function qtranslate_gform_form_tag($tag)
{
	if (!function_exists('qtrans_convertURL')) return $tag;

	global $q_config;
	$tag = preg_replace_callback(
		"|action='([^']+)'|",
		create_function(
			'$matches',
			'return "action=\'" . qtrans_convertURL($matches[1], ' . $q_config['language'] . ') . "\'";'
		),
		$tag
	);
	return $tag;
}

add_filter("gform_confirmation", "qtranslate_gform_confirmation", 10, 4);
function qtranslate_gform_confirmation($confirmation, $form, $lead, $ajax)
{
	if (!function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')) return $confirmation;

	$confirmation = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($confirmation);
	return $confirmation;
}

add_filter("gform_pre_send_email", "qtranslate_gform_pre_send_email");
function qtranslate_gform_pre_send_email($email)
{
	if (!function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')) return $email;

	$email["message"] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($email["message"]);
	$email["subject"] = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($email["subject"]);
	return $email;
}
