<?php
//run php artisan make:command MakeCommandAction
// and add this code.
//finally run php artisan make:action RegisterUser
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;

class MakeCommandAction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:action {name} model=--{model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create action file';
    protected $type = "Action";

    /**
 * Filesystem instance
 * @var Filesystem
 */
protected $files;

/**
 * Create a new command instance.
 * @param Filesystem $files
 */
public function __construct(Filesystem $files)
{
    parent::__construct();

    $this->files = $files;
}

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * Execute the console command.
     *
     * @return int
     */
    /**
 * Return the Singular Capitalize Name
 * @param $name
 * @return string
 */
public function getSingularClassName($name)
{
    return ucwords(Pluralizer::singular($name));
}

    public function getStub(): string
    {
        return $this->resolveStubPath('/stub/action.stub');
    }

    /**
 * Return the stub file path
 * @return string
 *
 */
public function getStubPath()
{
    return __DIR__ . '/../../../stubs/Action.stub';
}

    /**
**
* Map the stub variables present in stub to its value
*
* @return array
*
*/
public function getStubVariables()
{
    $class_name = explode('/', $this->argument('name'));
    return [
        'NAMESPACE'         => 'App\\Action',
        'CLASS_NAME'        => $this->getSingularClassName(end($class_name)),
        'MODEL_NAME'       => $this->getSingularClassName(str_replace('model=--', '', $this->argument('model')))
    ];
}

/**
 * Get the stub path and the stub variables
 *
 * @return bool|mixed|string
 *
 */
public function getSourceFile()
{
    var_dump($this->getStubVariables());
    return $this->getStubContents($this->getStubPath(), $this->getStubVariables());
}


    /**
 * Replace the stub variables(key) with the desire value
 *
 * @param $stub
 * @param array $stubVariables
 * @return bool|mixed|string
 */
public function getStubContents($stub , $stubVariables = [])
{
    $contents = file_get_contents($stub);
    foreach ($stubVariables as $search => $replace)
    {
        $contents = str_replace('$'.$search.'$' , $replace, $contents);
    }

    return $contents;

}

/**
 * Get the full path of generate class
 *
 * @return string
 */
public function getSourceFilePath()
{
    return base_path('app/Action/') .'/' .$this->getSingularClassName($this->argument('name')) . 'Action.php';
}

/**
 * Build the directory for the class if necessary.
 *
 * @param  string  $path
 * @return string
 */
protected function makeDirectory($path)
{
    if (! $this->files->isDirectory($path)) {
        $this->files->makeDirectory($path, 0777, true, true);
    }

    return $path;
}
public function handle()
{
    $path = $this->getSourceFilePath();

    $this->makeDirectory(dirname($path));

    $contents = $this->getSourceFile();

    if (!$this->files->exists($path)) {
        $this->files->put($path, $contents);
        $path = str_replace('//', '/', $path);
        $this->info("File : {$path} created");
    } else {
        $this->info("File : {$path} already exits");
    }

}
}
