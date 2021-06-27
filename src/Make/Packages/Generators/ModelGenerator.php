<?php

namespace Make\Packages\Generators;

use Make\Packages\Generators\Migrations\SchemaParser;

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

class ModelGenerator extends Generator
{

    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'model';

    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return parent::getRootNamespace() . parent::getConfigGeneratorClassPath($this->getPathConfigNode());
    }

    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode()
    {
        return 'models';
    }

    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . '/' . parent::getConfigGeneratorClassPath($this->getPathConfigNode(), true) . '/' . $this->getName() . '.php';
    }

    /**
     * Get base path of destination file.
     *
     * @return string
     */

    public function getBasePath()
    {
        return config('fast-make.generator.basePath').'/'.$this->options['package'].'/src/';
    }

    /**
     * Get array replacements.
     *
     * @return array
     */
    public function getReplacements()
    {
        return array_merge(parent::getReplacements(), [
            'fillable' => $this->getFillable()
        ]);
    }

    /**
     * Get the fillable attributes.
     *
     * @return string
     */
    public function getFillable()
    {
        if (!$this->fillable) {
            return '[]';
        }
        $results = '[' . PHP_EOL;

        foreach ($this->getSchemaParser()->toArray() as $column => $value) {
            $results .= "\t\t'{$column}'," . PHP_EOL;
        }

        return $results . "\t" . ']';
    }

    /**
     * Get schema parser.
     *
     * @return SchemaParser
     */
    public function getSchemaParser()
    {
        return new SchemaParser($this->fillable);
    }
}
