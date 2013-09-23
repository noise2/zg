<?php
namespace zinux\zg\operators;

/**
 * A base class for operators
 */
abstract class baseOperator extends \zinux\zg\baseZg
{    
    /**
     * Construct a new operator
     * @param boolean $suppress_header_text check if you want to have general header output or not!
     */
    public function __construct($suppress_header_text = 0)
    {
        if(!$suppress_header_text)
            $this->PrintTItleString();
    }
    /**
     * Runs exec command
     * @param array $opt the system commands to run
     */
    public function Run($opt)
    {
        # for each command 
        foreach($opt as $value)
        {
            # run it
            exec($value);
        }
    }
    /**
     * General header printer
     */
    public function PrintTItleString()
    {
        $this->cout("Zinux Generator by Dariush Hasanpoor [b.g.dariush@gmail.com] 2013", 0, self::yellow);
    }
}
