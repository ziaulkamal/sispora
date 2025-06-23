<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakePageCommand extends GeneratorCommand
{
    protected $name = 'make:page';
    protected $description = 'Create a new Blade Page class for view rendering';
    protected $type = 'Page';

    protected function getStub()
    {
        return base_path('stubs/page.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Pages';
    }
}
