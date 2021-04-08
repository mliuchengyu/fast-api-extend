<?php
namespace Make\Packages\Generators\Migrations;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

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

class RulesParser implements Arrayable
{

    /**
     * The set of rules.
     *
     * @var string
     */
    protected $rules;


    /**
     * Create new instance.
     *
     * @param string|null $rules
     */
    public function __construct($rules = null)
    {
        $this->rules = $rules;
    }

    /**
     * Convert string migration to array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->parse($this->rules);
    }

    /**
     * Parse a string to array of formatted rules.
     *
     * @param  string $rules
     *
     * @return array
     */
    public function parse($rules)
    {
        $this->rules = $rules;
        $parsed = [];
        foreach ($this->getRules() as $rulesArray) {
            $column = $this->getColumn($rulesArray);
            $attributes = $this->getAttributes($column, $rulesArray);
            $parsed[$column] = $attributes;
        }

        return $parsed;
    }

    /**
     * Get array of rules.
     *
     * @return array
     */
    public function getRules()
    {
        if (is_null($this->rules)) {
            return [];
        }

        return explode(',', str_replace(' ', '', $this->rules));
    }

    /**
     * Get column name from rules.
     *
     * @param  string $rules
     *
     * @return string
     */
    public function getColumn($rules)
    {
        return Arr::first(explode('=>', $rules), function ($key, $value) {
            return $value;
        });
    }


    /**
     * Get column attributes.
     *
     * @param  string $column
     * @param  string $rules
     *
     * @return array
     */
    public function getAttributes($column, $rules)
    {

        return str_replace($column . '=>', '', $rules);
    }

}
