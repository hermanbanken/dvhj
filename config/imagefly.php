<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package   Modules
 * @category  Imagefly
 * @author    Fady Khalife
 * @uses      Image Module
 */

return array
(
    'cache_expire'     => 7 * 24 * 60 * 60,
    'cache_dir'        => 'cache/',
    'mimic_source_dir' => FALSE,
    'enforce_presets'  => FALSE,
		'scale_up'		   	 => TRUE,
);
