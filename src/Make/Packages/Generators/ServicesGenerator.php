<?php
namespace Make\Packages\Generators;

use Illuminate\Support\Str;

// +----------------------------------------------------------------------
// | Library for FastApi
// +----------------------------------------------------------------------
// | 版权所有 2020~2021 oopdev [ http://www.oopdev.com ]
// +----------------------------------------------------------------------
// | 官方网站: https://www.fast-api.org
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github 仓库地址 ：https://github.com/fast-oopdev/fast-api-permission
// +----------------------------------------------------------------------

class ServicesGenerator extends Generator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = '';



    function __construct (array $options = []) {
        $this->stub = 'services/'.$options['stub'];
        parent::__construct ($options);
        //构造函数
    }

    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return str_replace('/', '\\', parent::getRootNamespace() . parent::getConfigGeneratorClassPath($this->getPathConfigNode()));
    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'services';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . $this->getControllerName() . '/' . $this->getControllerName() . ucfirst(str_replace('services/', '', $this->stub)). 'Service.php';
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        return config('fast-make.generator.basePath'). '/' . $this->options['package']. '/src/Http/Api/Services/';
    }

    /**
     * Gets controller name based on model
     *
     * @return string
     */
    public function getControllerName()
    {

        return ucfirst($this->getPluralName());
    }

    /**
     * Gets plural name based on model
     *
     * @return string
     */
    public function getPluralName()
    {

        return lcfirst(ucwords($this->getClass()));
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        return [
            'class'          => $this->getClass(),
            'namespace'      => str_replace('Services','Services\\'.$this->getControllerName(),$this->getNamespace()),
            'root_namespace' => parent::getRootNamespace(),
        ];
    }
}
