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

class BaseControllerGenerator extends Generator
{
    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'base/controller';


    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/' . 'Controller.php';
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        return config('fast-make.generator.basePath', '').'/'.$this->options['package'].'/src/';
    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'base';
    }

    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return parent::getRootNamespace();
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        $base = str_replace([
            "\\",
            '/'
        ], '\\', parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true));

        return [
            'class'          => $this->getClass(),
            'namespace' => 'namespace '.rtrim($this->getRootNamespace(),'\\').'\\'.$base.';',
            'root_namespace' => parent::getRootNamespace(),
        ];
    }
}
