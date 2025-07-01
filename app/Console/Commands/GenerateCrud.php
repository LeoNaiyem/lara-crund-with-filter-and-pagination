<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateCrud extends Command
{
    // protected $signature = 'make:crud {table}';
    protected $signature = 'generate:crud {table} {--force : Overwrite existing files}';

    protected $description = 'Generate CRUD operations (Model, Controller, Views, Routes) from table';

    public function handle()
    {
        $table = $this->argument('table');
        $columns = DB::getSchemaBuilder()->getColumnListing($table);

        if (empty($columns)) {
            $this->error("❌ Table '$table' not found or has no columns.");
            return;
        }

        $model = Str::studly(Str::singular($table));
        $controller = $model . 'Controller';

        $this->generateModel($model, $columns);
        $this->generateController($model, $controller);
        $this->generateViews($model, $columns);
        $this->appendRoutes($model);

        $this->info("🚀 CRUD components are ready");
        $this->line('');
        $this->line('<comment>⚡ Built with Naiyem\'s magic.</comment>');
        $this->line('<comment>🔍 Next steps:</comment> Review controller and test the routes.');
        $this->line('<comment>📚 Docs:</comment> <info>https://github.com/leonaiyem/lara-crud-generator</info>');
    }

    protected function generateModel($model, $columns)
    {
        $fillable = array_diff($columns, ['id']);
        $fillableStr = implode("', '", $fillable);

        $modelTemplate = <<<EOD
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class $model extends Model
{
    protected \$fillable = ['$fillableStr'];
}
EOD;

        File::ensureDirectoryExists(app_path("Models"));
        File::put(app_path("Models/$model.php"), $modelTemplate);
        $this->info("📦 Model generated: $model");
    }

    protected function generateController($model, $controller)
    {
        $controllerPath = app_path("Http/Controllers/{$controller}.php");

        // if (file_exists($controllerPath)) {
        //     $this->warn("⚠️ Controller already exists: $controller");
        //     return;
        // }
        $shouldOverwrite = $this->option('force');

        if (file_exists($controllerPath)) {
            if (!$shouldOverwrite) {
                $this->warn("⚠️ Controller already exists: $controller");
                return;
            } else {
                File::delete($controllerPath); // overwrite
                $this->warn("♻️ Overwriting existing controller: $controller");
            }
        }


        $table = Str::snake(Str::plural($model));
        $columns = DB::getSchemaBuilder()->getColumnListing($table);

        $modelVar = Str::camel($model);
        $modelPlural = Str::plural($modelVar);
        $modelClass = "App\\Models\\$model";

        // Detect foreign keys and related models
        $foreignKeys = array_filter($columns, fn($col) => Str::endsWith($col, '_id'));
        $relatedLoads = '';
        $relatedPasses = '';
        $uses = '';
        foreach ($foreignKeys as $fk) {
            $relatedModel = Str::studly(Str::singular(str_replace('_id', '', $fk)));
            $relatedVarPlural = Str::camel(Str::plural($relatedModel));

            $relatedModelPath = app_path("Models/{$relatedModel}.php");
            if (!file_exists($relatedModelPath)) {

                $this->generateModel($relatedModel, ['name']);
            }

            $relatedLoads .= "        \$$relatedVarPlural = \\App\\Models\\$relatedModel::all();\n";
            $relatedPasses .= "            '$relatedVarPlural' => \$$relatedVarPlural,\n";
            $uses .= "use App\\Models\\$relatedModel;\n";
        }

        $controllerTemplate = <<<PHP
<?php

namespace App\Http\Controllers;

use $modelClass;
use Illuminate\Http\Request;
$uses

class $controller extends Controller
{
    public function index()
    {
        \$$modelPlural = $model::orderBy('id', 'desc')->paginate(10);
        return view('pages.$modelPlural.index', compact('$modelPlural'));
    }

    public function create()
    {
$relatedLoads
        return view('pages.$modelPlural.create', [
            'mode' => 'create',
            '$modelVar' => new $model(),
$relatedPasses
        ]);
    }

    public function store(Request \$request)
    {
        \$data = \$request->all();
        if (\$request->hasFile('photo')) {
            \$data['photo'] = \$request->file('photo')->store('uploads', 'public');
        }
        $model::create(\$data);
        return redirect()->route('$modelPlural.index')->with('success', 'Successfully created!');
    }

    public function show($model \$${modelVar})
    {
        return view('pages.$modelPlural.view', compact('$modelVar'));
    }

    public function edit($model \$${modelVar})
    {
$relatedLoads
        return view('pages.$modelPlural.edit', [
            'mode' => 'edit',
            '$modelVar' => \$${modelVar},
$relatedPasses
        ]);
    }

    public function update(Request \$request, $model \$${modelVar})
    {
        \$data = \$request->all();
        if (\$request->hasFile('photo')) {
            \$data['photo'] = \$request->file('photo')->store('uploads', 'public');
        }
        \$${modelVar}->update(\$data);
        return redirect()->route('$modelPlural.index')->with('success', 'Successfully updated!');
    }

    public function destroy($model \$${modelVar})
    {
        \$${modelVar}->delete();
        return redirect()->route('$modelPlural.index')->with('success', 'Successfully deleted!');
    }
}
PHP;

        file_put_contents($controllerPath, $controllerTemplate);
        $this->info("🎮 Controller created: $controller");
    }


    protected function appendRoutes($model)
    {
        $routeName = Str::plural(Str::snake($model));
        $controllerClass = "App\\Http\\Controllers\\" . $model . "Controller";
        $routeEntry = "\nRoute::resource('$routeName', $controllerClass::class);";
        File::append(base_path('routes/web.php'), $routeEntry);
        $this->info("🧭 Route added: /services");
    }

    protected function generateViews($model, $columns)
    {

        (new \App\ViewGenerators\FormViewGenerator())->createAllViews($model, $columns);
        $this->info("🖥️ Views generated: index | create | edit | view | _form");
    }
}