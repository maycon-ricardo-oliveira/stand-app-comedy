<?php

namespace App\Console\Commands;

use App\Models\AppAdmin\Author;
use App\Models\AppAdmin\BlogIndication;
use App\Models\AppAdmin\Campaign;
use App\Models\AppAdmin\Category;
use App\Models\AppAdmin\IndicationCategory;
use App\Models\AppAdmin\IndicationPlan;
use App\Models\AppAdmin\Plan;
use App\Services\S3;
use Illuminate\Console\Command;

class ImportAttractionsByJsonFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-attractions {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Attractions from json file';



    protected $file = 0;
    protected $fileData = [];
    protected $campaign = 0;

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

        $this->validateOptions();

        $this->importBlogCampaign();
        $this->process();

    }

    public function validateOptions()
    {

        if (empty($this->file)) {
            $this->file = $this->option('file');
        }

    }

    public function importBlogCampaign()
    {

        if (($handle = fopen($this->file, "r")) !== FALSE) {

            while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {

                if (trim(strtolower($data[0])) == "status") {
                    continue;
                }

                $image = (!empty($data[8]) ? (strpos($data[8], ".") === false ? $data[8] . ".jpg" : $data[8]) : null);
                $image = !empty($image) ? (base_path() . "/Imagens App/Imagens Blog /" . $image) : null;

                $categories = array_map('trim', explode(',', $data[11]));
                $plans = array_map('trim', explode(',', $data[12]));

                $this->fileData[] = (object) [
                    'title' => $data[6], // Título da Matéria
                    'url' => $data[7], // URL Matéria
                    'image' => $image, // Imagem
                    'author' => $data[9], // Autor
                    'author_id' => $data[10], // author_id
                    'categories' => $categories, // Categorias
                    'plans' => $plans, // Planos
                ];

            }

        }

    }

    public function process()
    {

        foreach ($this->fileData as &$fileData) {

            $this->info(json_encode($fileData));

            // store Comedian
            // store Place
            // store Attraction
            // store sessions





        }

    }

}


//
//                    $s3 = new S3();
//                    $s3->uploadByFilePath(
//                        $fileData->image,
//                        "App/blog_indications/{$blogIndication->id}/{$blogIndication->id}" . substr($fileData->image, -4),
//                        "cdn.leiturinha.com.br",
//                        "public-read"
//                    );
