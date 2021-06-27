<?php

namespace Make\Packages\Generators;

use Make\Packages\Generators\Migrations\NameParser;
use Make\Packages\Generators\Migrations\SchemaParser;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

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

class MigrationGenerator extends Generator
{


    /**
     * Get stub name.
     *
     * @var string
     */
    protected $stub = 'migration/plain';

    /**
     * Get base path of destination file.
     *
     * @return string
     */
    public function getBasePath()
    {
        return config('fast-make.generator.basePath') .'/'.$this->options['package']. '/database/migrations/';
    }


    /**
     * Get destination path for generated file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->getBasePath() . $this->getFileName() . '.php';
    }


    /**
     * Get generator path config node.
     *
     * @return string
     */
    public function getPathConfigNode()
    {
        return '';
    }


    /**
     * Get root namespace.
     *
     * @return string
     */
    public function getRootNamespace()
    {
        return '';
    }


    /**
     * Get migration name.
     *
     * @return string
     */
    public function getMigrationName()
    {
        return strtolower($this->name);
    }


    /**
     * Get file name.
     *
     * @return string
     */
    public function getFileName()
    {
        return date('Y_m_d_His_') . $this->getMigrationName();
    }


    /**
     * Get schema parser.
     *
     * @return SchemaParser
     */
    public function getSchemaParser()
    {
        return new SchemaParser($this->fields);
    }


    /**
     * Get name parser.
     *
     * @return NameParser
     */
    public function getNameParser()
    {
        return new NameParser($this->name);
    }


    /**
     * Get stub templates.
     *
     * @return string
     */
    public function getStub()
    {
        $parser = $this->getNameParser();

        $action = $parser->getAction();
        switch ($action) {
            case 'add':
            case 'append':
            case 'update':
            case 'insert':
                $file = 'change';
                $replacements = [
                    'class'       => $this->getClass(),
                    'table'       => $parser->getTable(),
                    'fields_up'   => $this->getSchemaParser()->up(),
                    'fields_down' => $this->getSchemaParser()->down(),
                ];
                break;

            case 'delete':
            case 'remove':
            case 'alter':
                $file = 'change';
                $replacements = [
                    'class'       => $this->getClass(),
                    'table'       => $parser->getTable(),
                    'fields_down' => $this->getSchemaParser()->up(),
                    'fields_up'   => $this->getSchemaParser()->down(),
                ];
                break;
            default:
                $file = 'create';
                $replacements = [
                    'class'  => $this->getClass(),
                    'table'  => $parser->getTable(),
                    'fields' => $this->getSchemaParser()->up(),
                ];
                break;
        }
        $path = config('fast-make.generator.stubsOverridePath', __DIR__);

        if (!file_exists($path . "/Stubs/migration/{$file}.stub")) {
            $path = __DIR__;
        }

        if (!file_exists($path . "/Stubs/migration/{$file}.stub")) {
            throw new FileNotFoundException($path . "/Stubs/migration/{$file}.stub");
        }

        return Stub::create($path . "/Stubs/migration/{$file}.stub", $replacements);
    }
}
