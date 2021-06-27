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
// | github 仓库地址 ：https://github.com/fast-oopdev/fast-api-extend
// +----------------------------------------------------------------------

class MakeCommand extends Command
{
    /**
     * The name of command.
     * php artisan fast:packages "ControllerName" --package="c"
     * @var string
     */
    protected $name = 'fast:packages';

    /**
     * The description of command.
     *
     * @var string
     */
    protected $description = 'Create rapid development extension packs.';

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
        try {

            (new RepositorySearchCriteriaGenerator([
                'name' => $this->argument('name'),
                'package'  => $this->option('package')
            ]))->run();
            $this->generators = new Collection();

            $migrationGenerator = new MigrationGenerator([
                'name'   => 'create_' . Str::snake($this->argument('name')) . '_table',
                'package'  => $this->option('package')
            ]);
            $this->generators->push($migrationGenerator);

            $modelGenerator = new ModelGenerator([
                'name'     => $this->argument('name'),
                'package'  => $this->option('package')
            ]);
            $this->generators->push($modelGenerator);


            $this->generators->push(new RepositoryInterfaceGenerator([
                'name'  => $this->argument('name'),
                'package'  => $this->option('package')
            ]));


            $model = $modelGenerator->getRootNamespace() . '\\' . $modelGenerator->getName();
            $model = str_replace([
                "\\",
                '/'
            ], '\\', $model);
            foreach ($this->generators as $generator) {
                $generator->run();
            }

            foreach (['Search', 'Show', 'Update', 'Store', 'Delete'] as $event){
                (new RequestGenerator([
                    'name' => $this->argument('name'),
                    'event'  => $event,
                    'package' => $this->option('package')
                ]))->run();
            }

            (new ControllerGenerator([
                'name' => $this->argument('name'),
                'package'  => $this->option('package')
            ]))->run();

            (new RepositoryEloquentGenerator([
                'name'      => $this->argument('name'),
                'package'  => $this->option('package'),
                'model'     => $model,
            ]))->run();

            (new TransformerGenerator([
                'name' => $this->argument('name'),
                'package'  => $this->option('package')
            ]))->run();


//            (new BindingsGenerator([
//                'name'    => $this->argument('name'),
//                'package' => $this->option('package')
//            ]))->run();

            foreach (['search','show','store','update','delete'] as $stub){
                (new ServicesGenerator([
                    'name' => $this->argument('name'),
                    'stub'  => $stub,
                    'package' => $this->option('package')
                ]))->run();
            }


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
            [
                'name',
                InputArgument::REQUIRED,
                'The name of class being generated.',
                null
            ],
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
