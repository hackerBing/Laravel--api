<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CrudGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
    protected $signature = 'curd:create {name : Class (singular) for example User}';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';

    protected $description = 'Create CRUD operations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    protected function model($name)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );
        $dir = app_path("/Http/Controllers/Home/{$name}");
        if (!file_exists($dir)){
            mkdir ($dir);
        }
        file_put_contents(app_path("/Http/Controllers/Home/{$name}/{$name}.php"), $modelTemplate);
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
            $this->getStub('Controller')
        );
        $dir = app_path("/Http/Controllers/Home/{$name}");
        if (!file_exists($dir)){
            mkdir ($dir);
        }

        file_put_contents(app_path("/Http/Controllers/Home/{$name}/{$name}Controller.php"), $controllerTemplate);
    }

    protected function request($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );

        $dir = app_path("/Http/Controllers/Home/{$name}");
        if (!file_exists($dir)){
            mkdir ($dir);
        }

        file_put_contents(app_path("/Http/Controllers/Home/{$name}/{$name}Request.php"), $requestTemplate);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        $this->controller($name);
        $this->model($name);
        $this->request($name);
        \File::append(base_path('routes/home.php'), 'Route::resource(\'/' . strtolower($name) . "', '{$name}\\{$name}Controller');");
        //
    }
}
