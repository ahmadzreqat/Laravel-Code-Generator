<?php

namespace generator\Http\controller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GeneratorController extends controller
{

    public function index()
    {
        return view('gen::store');
    }


    public function store(Request $request)
    {

        try {

            if (!$this->ClassNotExist($request->table) === true) {
                return redirect()
                    ->route('gen.form')
                    ->with(['error' => 'this table is already exist with the same migration class Name, ' .
                        'Cannot declare class {Create' . strtolower($request->table) . 'Table} ,
                         because the name is already in use'
                    ]);
            }

            Artisan::call("generate:magic " . strtolower($request->table) .
                " --name=" . collect($request->columnName)->implode(',') .
                " --dataType=" . collect($request->DataType)->implode(',') .
                " --noDefaults=" . collect($request->key)->implode(',') .
                " --def=" . collect($request->default)->implode(',') .
                " --cont=" . $request->ControllerPath .
                " --model=" . $request->ModelPath);

            if ($request->has('migrate')) {
                Artisan::call('migrate');
            }

            if ($request->has('route')) {
                $middlewareType = '';
                if ($request->has('middleware')) $middlewareType = $request->middleware;

                File::append(base_path('routes/web.php'),
                    " Route::group(['prefix' =>  '" . strtolower($request->table) . "' ,  'middleware' => '" . $middlewareType . "'], function ()  {
                        Route::get('/' , [ App\Http\Controllers\\" . $request->table . "Controller::class  , 'index']) ;
                        Route::post('/store' , [ App\Http\Controllers\\" . $request->table . "Controller::class  , 'store']) ;
                        Route::post('/edit/{id}' , [ App\Http\Controllers\\" . $request->table . "Controller::class  , 'edit']) ;
                        Route::put('/update/{id}' , [ App\Http\Controllers\\" . $request->table . "Controller::class  , 'update']) ;
                        Route::delete('/destroy/{id}' , [ App\Http\Controllers\\" . $request->table . "Controller::class  , 'destroy']) ;
                        Route::get('/show/{id}' , [ App\Http\Controllers\\" . $request->table . "Controller::class  , 'show']) ;
                    });"
                );
            }
            return redirect()->route('gen.form')->with(['success' => 'Successfully Generated']);
        } catch (Exception $e) {
            return redirect()->route('gen.form')->with(['error' => 'Something Went Wrong']);
        }

    }


    private function ClassNotExist($table)
    {

        if (!file_exists($migration = database_path('migrations'))) mkdir($migration, 0777, true);
        $migrationPath = database_path("migrations");
        $files = scandir($migrationPath);

        foreach ($files as $file) {
            $class = Str::studly(implode('_', array_slice(explode('_', $file), 4)));
            if ($class == 'Create' . ucfirst($table) . 'Table.php') {
                return false;
            }
        }
        return true;
    }


}
