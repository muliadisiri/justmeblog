<?php From::_('YAML',$fn=function(string $value,string $dent='  ',$docs=false,$eval=true){$yaml=static function(string $value,string $dent='  ',$eval=true)use(&$yaml){$yaml_select=static function(string $value){$out=[];$s=$n=null;foreach(explode("\n",$value)as $v){if('#'===substr($vv=trim($v),0,1)){continue;}if($v&&' '!==$v[0]&&0!==strpos($v,'- ')&&'-'!==$vv){if(null!==$s){$out[]=rtrim($s);}$s=$v;}else{$s.=$n?' '.ltrim($v):"\n".$v;}$n='-'===$vv;}$out[]=rtrim($s);return $out;};$yaml_set=static function(&$out,string $value,string $dent,$eval)use(&$yaml){$yaml_block=static function(string $value){$out="";$e=false;$x=false;foreach(explode("\n",$value)as $k=>$v){$t=trim($v);if(""===$t){$out.="\n";}else if(!$e&&!$x){$out.=' ';}if(""!==$t&&"\\"===substr($t,-1)){$out.=ltrim(substr($v,0,-1));}else if(""!==$t){$out.=$t;}if(""===$t){$e=true;$x=false;}else if("\\"===substr($t,-1)){$e=false;$x=true;}else{$e=$x=false;}}return trim($out);};$yaml_break=static function(string $value){$value=trim($value,"\n");if(0===strpos($value,'"')||0===strpos($value,"'")){$q=$value[0];if(preg_match('/^('.$q.'(?:[^'.$q.'\\\]|\\\.)*'.$q.')\s*(:[ \n])([\s\S]*)$/',$value,$m)){array_shift($m);$m[0]=e($m[0]);return $m;}}else if(false!==strpos($value,':')&&0!==strpos($value,'- ')&&false===strpos('[{',$value[0])){$m=explode(':',$value,2);$m[0]=trim($m[0]);if(false!==strpos($m[1],'#')){$m[1]=preg_replace('#^\s*\#.*$#m',"",$m[1]);}$m[2]=ltrim(rtrim($m[1]??""),"\n");$m[1]=':'.($m[1][0]??"");return $m;}$out=strstr($value,'#',true);return[false,false,trim(false!==$out?$out:$value)];};$yaml_list=static function(string $value,string $dent,$eval)use(&$yaml,&$yaml_break,&$yaml_pull,&$yaml_value){$out=[];$value=$yaml_pull($value,'  ');foreach(explode("\n- ",substr($value,2))as $v){$v=str_replace("\n  ","\n",$v);list($k,$m)=$yaml_break($v);if(false===$m){$v=$yaml_value($v);$out[]=$eval?e($v,['~'=>null]):$v;}else{$out[]=$yaml($v,$dent,$eval);}}return $out;};$yaml_pull=static function(string $value,string $dent){if(0===strpos($value,$dent)){return str_replace("\n".$dent,"\n",substr($value,strlen($dent)));}return $value;};$yaml_span=static function(string $value,$eval){$out="";foreach(preg_split('#\s*("(?:[^"\\\]|\\\.)*"|\'(?:[^\'\\\]|\\\.)*\'|[\[\]\{\}:,])\s*#',$value,null,PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY)as $v){$out.=false!==strpos('[]{}:,',$v)?$v:json_encode($v);}$out=json_decode($out,true)??$value;return $eval?e($out,['~'=>null]):$out;};$yaml_value=static function(string $value){$value=trim($value);if(0===strpos($value,'"')||0===strpos($value,"'")){$q=$value[0];if(preg_match('/^('.$q.'(?:[^'.$q.'\\\]|\\\.)*'.$q.')(\s*#.*)?$/',$value,$m)){return $m[1];}}$out=strstr($value,'#',true);return trim(false!==$out?$out:$value);};list($k,$m,$v)=$yaml_break($value);if(false===$k&&false===$m&&""!==$v){if('['===$v[0]&&']'===substr($v,-1)||'{'===$v[0]&&'}'===substr($v,-1)){$out=$yaml_span($v,$eval);return;}}$vv=$yaml_pull($v,$dent);$t=substr(trim($vv),0,1);if('|'===$t||'>'===$t){$vv=$yaml_pull(ltrim(substr(ltrim($vv),1),"\n"),$dent);$out[$k]='>'===$t?$yaml_block($vv):$vv;}else if(":\n"===$m){if(0===strpos($vv,'- ')){if(0===strpos($v,$dent.'-')){$v=$vv;}$out[$k]=$yaml_list($v,$dent,$eval);}else{$out[$k]=""!==$vv?$yaml($vv,$dent,$eval):[];}}else{$vv=$yaml_value($vv);if(0===strpos($vv,'- ')){$out=$yaml_list($vv,$dent,$eval);return;}if(""===$vv){$vv=null;}else if('[]'===$vv||'{}'===$vv){$vv=[];}else if($vv&&('['===$vv[0]&&']'===substr($vv,-1)||'{'===$vv[0]&&'}'===substr($vv,-1))){$vv=json_decode($vv,true)??$yaml_span($vv,$eval);}else if($eval){$vv=e($vv,['~'=>null]);}$out[$k]=$vv;}};$out=[];$value=trim(n($value));if(""===$value){return $out;}foreach($yaml_select($value)as $v){""!==$v&&$yaml_set($out,$v,$dent,$eval);}return $out;};$yaml_docs=static function(string $value,string $dent='  ',$eval=true,$content="\t")use(&$yaml){$docs=[];$value=trim(n($value));$value=0===strpos($value,YAML\SOH)&&'-'!==substr($value,3,1)?preg_replace('#^'.x(YAML\SOH).'\s*#',"",$value):$value;$parts=explode("\n".YAML\EOT."\n",trim($value)."\n",2);foreach(explode("\n".YAML\ETB,$parts[0])as $v){$docs[]=$yaml(trim($v),$dent,$eval);}if(isset($parts[1])){$docs[$content]=trim($parts[1],"\n");}return $docs;};return $docs?$yaml_docs($value,$dent,$eval,true===$docs?"\t":$docs):$yaml($value,$dent,$eval);});From::_('yaml',$fn);