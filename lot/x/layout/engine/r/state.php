<?php class_alias('State','Site');$GLOBALS['site']=$site=$state;$GLOBALS['t']=$t=new Anemon([$state->title],' &#x00B7; ');if(is_file($f=Layout::$state['path'].DS.'state.php')){State::set(require $f);}