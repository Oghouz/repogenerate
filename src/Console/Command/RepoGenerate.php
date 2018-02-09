<?php

namespace Oghouz\RepoGenerate\Console\Command;

use Illuminate\Console\Command;

class RepoGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {model} {-m?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->repositoryFolder();

        $model              = $this->argument('model');
        $repository_file    = $this->repositoryFile($model);
        $repository_content = $this->repositoryContent($model);


        $this->checkModel($model);

        $this->generateRepository($repository_file, $repository_content);


    }

    /**
     * Check repository folder is exist,
     *  else create repository folder
     */
    protected function repositoryFolder()
    {
        $config_repository_folder = config('repository.folder');

        if (!is_dir($config_repository_folder)) {

            \File::makeDirectory($config_repository_folder);
            $this->info('Repository folder created successful');
        }

        return $config_repository_folder;
    }

    /**
     *  Check Model is exist
     *  if not exist create model with user confirmation
     *
     * @param $model
     */
    protected function checkModel($model)
    {
        $model = ucfirst($model);
        $namespace_model = ucfirst(config('repository.namespace_model'));

        if (!class_exists($namespace_model . '\\' . $model)) {

            $createModule = $this->confirm('Model is not exist, your want create?');
            if ($createModule) {

                $this->call("make:model", ['name' => $model]);
                $this->info($model .' model has been created!');
            }
        }
    }

    /**
     *  Check repository folder is writable
     *
     * @return bool
     */
    protected function checkRepositoryPermission()
    {
        $repository_path = config('repository.folder');

        if (! is_dir($repository_path) && !is_writable($repository_path)) {

            return false;
        }

        return true;
    }

    /**
     *  Generate repository file name
     *
     * @param $model
     * @return string
     */
    protected function repositoryFile($model)
    {
        $path = config('repository.folder');
        return $path . DIRECTORY_SEPARATOR . ucfirst($model) . 'Repository.php';
    }

    /**
     *  Generate default repository content
     *
     * @param $model
     * @return string
     */
    protected function repositoryContent($model)
    {
        $namespace = config('repository.namespace');
        $namespace_model = config('repository.namespace_model');

        return "<?php
        
namespace $namespace;
        
use ".$namespace_model . "\\" . $model. ";
        
class ".$model."Repository 
{
        
    public function __construct()
    {
    
    }
            
}
";
    }

    /**
     * Generate the repository file
     *
     * @param $file
     * @param $content
     */
    protected function generateRepository($file, $content)
    {

        if (file_exists($file)) {

            $this->error('Repository is all ready exist!');
            $this->warn($file);

        } else {

            if (file_put_contents($file, $content)) {

                $this->info('Repository has been successfully created.');
            } else {

                $this->error('Error during creation repository');
            }
        }
    }

}
