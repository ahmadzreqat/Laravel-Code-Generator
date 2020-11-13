<?php

namespace generator\Console;

use Illuminate\Console\Command;


class GeneratorCommands extends Command
{


    private $RequestColumnName;
    private $ModelColumnName;
    /**
     * @var string
     * make columns as array
     */
    protected $signature = 'generate:magic {table}  {--name=}{--dataType=}{--noDefaults=} {--def=} {--cont=} {--model=}';

    protected $description = 'create migrations-DBTable-controller-model-request files  ';


    public function __construct()
    {
        parent::__construct();
    }

    protected function getStub($Type)
    {
        return file_get_contents(__DIR__ . "/stubs/$Type.stub");
    }


    protected function CreateMigrateTemplate($table, $names, $dataTypes, $noDefaults, $Defaults)
    {


        $Sanitizer = [];
        $colName = [];

        foreach (explode(',', $names) as $index => $name) {
            $colName [] = [$name => 'required'];
            foreach (explode(',', $dataTypes) as $key => $dataType) {
                foreach (explode(',', $noDefaults) as $NoDefaultsKey => $noDefault) {
                    foreach (explode(',', $Defaults) as $DefaultsKey => $Default) {
                        if ($index == $key && $index == $NoDefaultsKey && $index == $DefaultsKey) {
                            if ($noDefault == 'null') {
                                $SanitizeNoDefault = null;
                            } elseif ($Default != 'null') {
                                $SanitizeNoDefault = '->' . $noDefault . "($Default)";
                            } else {
                                $SanitizeNoDefault = '->' . $noDefault . "()";
                            }
                            $Sanitizer[] = "$" . "table->$dataType" . "('" . strtolower($name) . "')" . "$SanitizeNoDefault;";
                        }
                    }
                }
            }
        }

        $ColumnName = (collect($colName)->collapse()->toArray());
        $this->ModelColumnName = array_keys($ColumnName);
        $FixedRequestColumnName = [];
        foreach ($ColumnName as $ColName => $Validate) {
            $FixedRequestColumnName[] = (string)"'$ColName'" . " => " . (string)"'$Validate'";
        }

        $this->RequestColumnName = (collect($FixedRequestColumnName)->implode(','));
        $fixedArray = collect($Sanitizer)->implode('');
        $MigrateTemplate = str_replace(
            ['{{className}}', '{{sanitizer}}'],
            [strtolower($table), $fixedArray],
            $this->getStub('migration')
        );
        file_put_contents(database_path("/migrations/" . date('Y_m_d') . '_' . mt_rand() . '_create_' . strtolower($table) . '_table.php'), $MigrateTemplate);

    }


    protected function CreateModelTemplate($table, $path = null)
    {
        $ModelTemplate = str_replace(['{{ Table }}', '{{ColumnName}}'], [ucfirst($table), collect($this->ModelColumnName)], $this->getStub('model'));
        if (!file_Exists($ModelFile = app_path("/Models"))) mkdir($ModelFile, 0777, true);

        if ($path != null) {
            if (!file_Exists($ModelFile = app_path("/Models/$path")))
                mkdir($ModelFile, 0777, true);
            return file_put_contents(app_path("/Models/$path/" . ucfirst($table) . ".php"), $ModelTemplate);
        }

        return file_put_contents(app_path("/Models/" . ucfirst($table) . '.php'), $ModelTemplate);
    }

    protected function CreateRequestTemplate($table)
    {

        $RequestTemplate = str_replace(['{{ Table }}', '{{ColumnName}}'], [ucfirst($table), ($this->RequestColumnName)], $this->getStub('request'));
        if (!file_Exists($requestFile = app_path("/Http/Requests"))) mkdir($requestFile, 0777, true);
        file_put_contents(app_path("/Http/Requests/" . ucfirst($table)) . "Requests.php", $RequestTemplate);

    }

    protected function CreateControllerTemplate($table, $path = null)
    {
        $ControllerTemplate = str_replace(['{{Table}}'], [ucfirst($table)], $this->getStub('controller'));
        if ($path != null) {
            if (!file_Exists($ControllerFile = app_path("/Http/Controllers/$path")))
                mkdir($ControllerFile, 0777, true);
            return file_put_contents(app_path("/Http/Controllers/$path/" . ucfirst($table) . "Controller.php"), $ControllerTemplate);
        }
        return file_put_contents(app_path("/Http/Controllers/" . ucfirst($table) . "Controller.php"), $ControllerTemplate);

    }


    public function handle()
    {
        $table = $this->argument('table');
        $name = $this->option('name');
        $dataType = $this->option('dataType');
        $noDefaults = $this->option('noDefaults');
        $Defaults = $this->option('def');
        $ControllerPath = $this->option('cont');
        $ModelPath = $this->option('model');


        $this->CreateMigrateTemplate($table, $name, $dataType, $noDefaults, $Defaults);
        $this->comment('successfully created Migration ');
        $this->CreateModelTemplate($table, $ModelPath);
        $this->comment('successfully created Model ');
        $this->CreateRequestTemplate($table);
        $this->comment('successfully created Requests ');
        $this->CreateControllerTemplate($table, $ControllerPath);
        $this->comment('successfully created Controller ');
        $this->comment('successfully created enjoy ! ');
    }
}
