<?php
namespace zinux\zg\parser;
/**
 * Description of parser
 *
 * @author dariush
 */
class parser extends baseParser
{    
    public function Run()
    {
        if(!count($this->args))
            $this->args[] = "help";
        if($this->args[0]=="help")
        {
            array_shift($this->args);
            $help  = new helpParser($this->args, $this->command_generator);
            $help->Run();
            return;
        }
        $parsed_string = "zg";
        $current_parsing = $this->command_generator->Generate();
        while($current_parsing && count($this->args))
        {
            if(!isset($current_parsing->{$this->args[0]}))
            {
                if(isset($current_parsing->instance))
                    goto __EXECUTE;
                goto __ERROR;
            }
            $current_parsing = $current_parsing->{$this->args[0]};
            $parsed_string.=(" ".array_shift($this->args));
        }
__ERROR:
        throw new \zinux\kernel\exceptions\invalideArgumentException("Invalid command '".self::yellow."$parsed_string ".implode(" ", $this->args).self::defColor."'");
__EXECUTE:
        if(!isset($current_parsing->instance->class) || !isset($current_parsing->instance->method))
            throw new \zinux\kernel\exceptions\invalideOperationException
                ("The $parsed_string metadata structure is mis-configured, target action's {class} or {method} has not been specified ...");
        $c = $current_parsing->instance->class;
        $c = new $c;
        if(!method_exists($c, $current_parsing->instance->method))
            throw new \zinux\kernel\exceptions\invalideOperationException
                ("Method '{$current_parsing->instance->method}' does not exists in '{$current_parsing->instance->class}'");
        # execute the target operation's action
        $c->{$current_parsing->instance->method}($this->args);
    }
}