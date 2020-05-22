<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AdminGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
    protected $signature = 'adminCurd:generator {name : Class (singular) for example User}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create ADMINCRUD operations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function getadminStubs($type)
    {
        return file_get_contents(resource_path("adminStubs/$type.stub"));
    }

    protected function model($name)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getadminStubs('Model')
        );
        $dir = app_path("/Http/Controllers/Api/{$name}");
        if (!file_exists($dir)){
            mkdir ($dir);
        }
        file_put_contents(app_path("/Http/Controllers/Api/{$name}/{$name}.php"), $modelTemplate);
    }

    protected function controller($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                strtolower(str_plural($name)),
                strtolower($name)
            ],
            $this->getadminStubs('Controller')
        );
        $dir = app_path("/Http/Controllers/Api/{$name}");
        if (!file_exists($dir)){
            mkdir ($dir);
        }

        file_put_contents(app_path("/Http/Controllers/Api/{$name}/{$name}Controller.php"), $controllerTemplate);
    }

    protected function request($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getadminStubs('Request')
        );

        $dir = app_path("/Http/Controllers/Api/{$name}");
        if (!file_exists($dir)){
            mkdir ($dir);
        }

        file_put_contents(app_path("/Http/Controllers/Api/{$name}/{$name}Request.php"), $requestTemplate);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $name = $this->argument('name');

        $this->controller($name);
        $this->model($name);
        $this->request($name);

    }
}
