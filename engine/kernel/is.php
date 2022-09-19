<?php final class Is extends Genome{public static function IP($value){return filter_var($value,FILTER_VALIDATE_IP);}public static function URL($value){return filter_var($value,FILTER_VALIDATE_URL);}public static function __callStatic(string $kin,array $lot=[]){return parent::_($kin)?parent::__callStatic($kin,$lot):null;}public static function email($value){return filter_var($value,FILTER_VALIDATE_EMAIL);}public static function file($value){return is_string($value)&&strlen($value)<=260&&is_file($value);}public static function files($value){return is_string($value)&&strlen($value)<=260&&is_dir($value);}public static function folder($value){return self::files($value);}public static function path($value,$exist=false){if(!is_string($value)){return false;}return 0===strpos($value,ROOT)&&false===strpos($value,"\n")&&(!$exist||stream_resolve_include_path($value));}public static function toggle($value){return filter_var($value,FILTER_VALIDATE_BOOLEAN);}public static function void($value){if($value instanceof \Traversable){return 0===\iterator_count($value);}return(""===$value||false===$value||null===$value||is_string($value)&&""===trim($value)||is_array($value)&&empty($value)||is_object($value)&&empty((array)$value));}}