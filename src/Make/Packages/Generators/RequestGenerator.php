<?php
namespace Make\Packages\Generators;

// +----------------------------------------------------------------------
// | Library for FastApi
// +----------------------------------------------------------------------
// | 版权所有 2020~2021 oopdev [ http://www.oopdev.com ]
// +----------------------------------------------------------------------
// | 官方网站: https://www.fast-api.org
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github 仓库地址 ：https://github.com/fast-oopdev/fast-api-extend
// +----------------------------------------------------------------------

class RequestGenerator extends Generator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'request/request';

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
        return 'request';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . $this->getControllerName() . '/' . $this->getControllerName() .$this->options['event']. 'Request.php';
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        return config('fast-make.generator.basePath'). '/' . $this->options['package']. '/src/Requests/';
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
            'namespace'      => str_replace('Requests','Requests\\'.$this->getControllerName(),$this->getNamespace()),
            'controller'     => $this->getControllerName(),
            'event'          => ucfirst($this->options['event'])
        ];
    }
}
