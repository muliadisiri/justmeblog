<?php namespace x\markdown{function span($content){$type=$this->type;if('Markdown'!==$type&&'text/markdown'!==$type){return $content;}$parser=new \ParsedownExtraPlugin;foreach(\State::get('x.markdown',true)??[]as $k=>$v){if(0===\strpos($k,'block')){continue;}$parser->{$k}=$v;}return $parser->line($content??"");}\Hook::set(['page.description','page.title'],__NAMESPACE__."\\span",2);}namespace x{function markdown($content){$type=$this->type;if('Markdown'!==$type&&'text/markdown'!==$type){return $content;}$parser=new \ParsedownExtraPlugin;foreach(\State::get('x.markdown',true)??[]as $k=>$v){$parser->{$k}=$v;}return $parser->text($content??"");}\File::$state['type']['text/markdown']=1;\File::$state['x']['markdown']=1;\File::$state['x']['md']=1;\File::$state['x']['mkd']=1;\Hook::set(['page.content'],__NAMESPACE__."\\markdown",2);}