<?php

namespace q4ev\utils;


trait JsonOpsTrait
{
	public static function jDecode ($json)
	{
		return $json ? json_decode($json, true) : null;
	}

	public static function jEncode ($value)
	{
		return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT);
	}

	public static function jExtract (&$json, $key)
	{
		return static::jGet($json, $key, true);
	}

	public static function jGet (&$json, $key, $extract = false)
	{
		$decoded = static::jDecode($json);
		$result = $decoded[$key];
		if ($extract)
			unset($decoded[$key]);
		$json = static::jEncode($decoded);

		return $result;
	}

	public static function jMerge (...$jsons)
	{
		$args = func_get_args();

		foreach ($args as &$json)
			if (is_string($json))
				$json = static::jDecode($json);

		$result = array_merge(...$args);

		return static::jEncode($result);
	}
}