<?php
namespace zg\vendors\creators;
/**
 * Controller creator
 */
class createController extends \zg\operators\baseOperator
{
    /**
     * ctor a new controller
     * @param \zg\vendors\item $module target module item
     * @param \zg\vendors\item $controller target controller item
     * @param string $project_path project directory
     */
    public function __construct(\zg\vendors\item $module, \zg\vendors\item $controller, $project_path = ".")
    {
        $ns = $this->convert_to_relative_path($controller->path, $project_path);
        $this ->cout("Creating new controller '",0.5,  self::getColor(self::defColor), 0)
                ->cout($controller->name, 0, self::getColor(self::yellow), 0)
                ->cout("' at '",0,self::getColor(self::defColor), 0)
                ->cout($ns, 0, self::getColor(self::yellow), 0)
                ->cout("'.");
        
        $mbc = "<?php
namespace $ns;
    
/**
 * The $ns\\{$controller->name}
 * @by Zinux Generator <b.g.dariush@gmail.com>
 */
class ".preg_replace("#controller$#i","", $controller->name)."Controller extends \\zinux\\kernel\\controller\\baseController
{
    /**
    * The $ns\\{$controller->name}::IndexAction()
    * @by Zinux Generator <b.g.dariush@gmail.com>
    */
    public function IndexAction()
    {
    }
}
";
        
        if(!\zinux\kernel\utilities\fileSystem::resolve_path("{$module->path}/views/view/"))
            mkdir("{$module->path}/views/view/", 0775,1);
        
        if(!\zinux\kernel\utilities\fileSystem::resolve_path("{$module->path}/views/view/".preg_replace("#controller$#i","", $controller->name)))
            mkdir("{$module->path}/views/view/".preg_replace("#controller$#i","", $controller->name), 0775,1);
        
        file_put_contents($controller->path, $mbc);
        
        $s = $this->GetStatus($project_path);
        $controller->parent = $module;
        $s->modules->collection[strtolower($module->name)]->controller[strtolower($controller->name)] = $controller;
        $this->SaveStatus($s);
    }
}

?>
