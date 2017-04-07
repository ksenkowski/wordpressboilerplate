<?php

class SGReplacements
{
	static function processReplacements($str, $replacements)
	{
		foreach ($replacements as $find => $replace) {
			$str = str_replace($find, $replace, $str);
		}

		return $str;
	}

	static function migrateSite()
	{
		$sgdb = SGDatabase::getInstance();
		if (SG_ENV_ADAPTER == SG_ENV_WORDPRESS) {
			$siteUrl = get_site_url();
			$home = get_home_url();

			$uploadDir = wp_upload_dir();
			$uploadPath = $uploadDir['basedir'];
		}
		else{
			$siteUrl = Mage::getBaseUrl();
		}

		if (SG_ENV_ADAPTER == SG_ENV_WORDPRESS) {
			$query = "UPDATE ".SG_ENV_CORE_TABLE." SET option_value=%s WHERE option_name='siteurl'";
			$sgdb->query($query, array($siteUrl));
			$query = "UPDATE ".SG_ENV_CORE_TABLE." SET option_value=%s WHERE option_name='home'";
			$sgdb->query($query, array($home));
			$query = "UPDATE ".SG_ENV_CORE_TABLE." SET option_value=%s WHERE option_name='upload_path'";
			$sgdb->query($query, array($uploadPath));
		}
		else {
			$query = "UPDATE ".SG_ENV_CORE_TABLE." SET value WHERE path='web/unsecure/base_url'";
			$sgdb->query($query, array($siteUrl));
			$query = "UPDATE ".SG_ENV_CORE_TABLE." SET value WHERE path='web/secure/base_url'";
			$sgdb->query($query, array($siteUrl));
		}
	}
}
