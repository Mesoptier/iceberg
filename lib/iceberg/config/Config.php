<?php

namespace iceberg\config;

use iceberg\config\exceptions\ConfigFileNotFoundException;
use iceberg\config\exceptions\InvalidConfigFileException;
use iceberg\config\exceptions\UnknownConfigValueException;

class Config {

	private static $values = array();

	public static function loadFromFile($path) {

		if (!file_exists($path))
			throw new ConfigFileNotFoundException("Config file at path \"$path\" not found.");
		
		$parsedConfig = parse_ini_string(file_get_contents($path), true);
		if (!$parsedConfig)
			throw new InvalidConfigFileException("Invalid or corrupted config file (path is \"$path\").");

		static::$values = $parsedConfig;
	}

	public static function setVal($group, $key, $val) {
		static::$values[$group][$key] = $val;
	}

	public static function getVal($group, $key, $exception = false) {

		if ( !isset(static::$values[$group][$key]) ) {
			if ($exception)
				throw new UnknownConfigValueException("Unknown config value \"$group.$key\".");
			else 
				return false;
		}

		return static::$values[$group][$key];
	}

}