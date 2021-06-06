<?php
namespace Make\Packages\Generators\Commands;

use File;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Make\Packages\Generators\AbstractCriteriaGenerator;
use Make\Packages\Generators\AbstractSearchServiceGenerator;
use Make\Packages\Generators\BaseControllerGenerator;
use Make\Packages\Generators\BindingsGenerator;
use Make\Packages\Generators\ControllerGenerator;
use Make\Packages\Generators\FileAlreadyExistsException;
use Make\Packages\Generators\MigrationGenerator;
use Make\Packages\Generators\ModelGenerator;
use Make\Packages\Generators\RepositoryEloquentGenerator;
use Make\Packages\Generators\RepositoryInterfaceGenerator;
use Make\Packages\Generators\RepositorySearchCriteriaGenerator;
use Make\Packages\Generators\RequestGenerator;
use Make\Packages\Generators\ServicesGenerator;
use Make\Packages\Generators\TransformerGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

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

class InitCommand extends Command
{
    /**
     * The name of command.
     * php artisan fast:bindings --package="tms-erp-client"
     * @var string
     */
    protected $name = 'fast:bindings';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Add repository bindings to service provider.';


    /**
     * @var Collection
     */
    protected $generators = null;


    /**
     * Execute the command.
     *
     * @see fire()
     * @return void
     */
    public function handle(){
        $this->laravel->call([$this, 'fire'], func_get_args());
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function fire()
    {
        try{
            (new BaseControllerGenerator([
                'package'  => $this->option('package')
            ]))->run();

            (new AbstractCriteriaGenerator([
                'package'  => $this->option('package')
            ]))->run();

            (new AbstractSearchServiceGenerator([
                'package'  => $this->option('package')
            ]))->run();

            $this->info($this->description);
        } catch (FileAlreadyExistsException $e) {
            $this->error($e->getMessage() . ' already exists!');
            return false;
        }
    }


    /**
     * The array of command arguments.
     *
     * @return array
     */
    public function getArguments()
    {
        return [

        ];
    }


    /**
     * The array of command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [
            [
                'package',
                null,
                InputOption::VALUE_OPTIONAL,
                'The package name.',
                null
            ]
        ];
    }
}
