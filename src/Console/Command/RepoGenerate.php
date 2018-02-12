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

    protected $hasModel = false;

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

        $this->checkPermission();
        $this->repositoryFolder();

        $model = ucfirst($this->argument('model'));
        $this->checkModel($model);

        $repository_file    = $this->getFilename($model);
        $repository_content = $this->getContent($model);

        $this->generateRepository($repository_file, $repository_content);
    }

    protected function getContent($model)
    {
        $content = $this->getRepositoryStub();
        $content = str_replace('__NAMESPACE__MODEL__', config('repository.namespace_model') . '\\' . $model, $content);
        $content = str_replace('__NAMESPACE__REPOSITORY__', config('repository.namespace'), $content);
        $content = str_replace('__MODEL__', $model, $content);
        return str_replace('__REPOSITORY_NAME__', $model.'Repository', $content);
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
     * @return bool
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
                $this->hasModel = true;
            }
        } else {

            $this->hasModel = true;
        }

    }

    /**
     * Check repository folder is writable
     *
     * @return bool
     * @throws \Exception
     */
    protected function checkPermission()
    {
        $repository_path = config('repository.folder');

        if (!is_writable($repository_path)) {

            throw new \Exception('Not write permission for repository folder!');
        }

        return true;
    }

    /**
     *  Generate repository file name
     *
     * @param $model
     * @return string
     */
    protected function getFilename($model)
    {
        $path = config('repository.folder');
        return $path . DIRECTORY_SEPARATOR . ucfirst($model) . 'Repository.php';
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

                if (!$this->hasModel) {

                    $this->warn("Please make sure model before using repository!");
                }
                $this->info('Repository has been successfully created.');

            } else {

                $this->error('Error during creation repository');
            }
        }
    }

    /**
     * Repository content
     *
     * @return string
     * @throws \Exception
     */
    protected function getRepositoryStub()
    {
        $stub = __DIR__ . '/../Stubs/Repository.stub';

        if (file_exists($stub)) {
            return file_get_contents($stub);
        }

        throw new \Exception('Repository stub file not found!');
    }

}
