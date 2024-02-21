<?php

namespace App\Console\Commands;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\DateTimeAdapter\IDateTime;
use App\Chore\Modules\Adapters\MySqlAdapter\DBConnection;
use App\Chore\Modules\Adapters\MySqlAdapter\MySqlAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\Attractions\Entities\Attraction;
use App\Chore\Modules\Attractions\Entities\AttractionStatus;
use App\Chore\Modules\Attractions\Infra\MySql\AttractionDAODatabase;
use App\Chore\Modules\Attractions\UseCases\RegisterAttraction\RegisterAttraction;
use App\Chore\Modules\Comedians\Entities\Comedian;
use App\Chore\Modules\Comedians\Exceptions\ComedianAlreadyRegistered;
use App\Chore\Modules\Comedians\Infra\MySql\ComedianDAODatabase;
use App\Chore\Modules\Comedians\UseCases\RegisterComedian\RegisterComedian;
use App\Chore\Modules\Places\Entities\Place;
use App\Chore\Modules\Places\Exceptions\PlaceAlreadyRegistered;
use App\Chore\Modules\Places\Exceptions\PlaceAlreadyRegisteredException;
use App\Chore\Modules\Places\Infra\MySql\PlaceDAODatabase;
use App\Chore\Modules\Places\UseCases\RegisterPlace\RegisterPlace;
use App\Chore\Modules\User\Infra\MySql\UserDAODatabase;
use DateTimeImmutable;
use Exception;
use Illuminate\Console\Command;
use Playkids\ApiResponse\ApiResponse;
use SebastianBergmann\CodeCoverage\Report\PHP;

class ImportAttractionsByJsonFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import-attractions {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Attractions from json file';



    protected $rowCount = 0;
    protected $file = 0;
    protected $fileData = [];
    protected $campaign = 0;
    private UniqIdAdapter $uuid;
    private ComedianDAODatabase $comedianRepository;
    public IDateTime $time;
    public DBConnection $dbConnection;
    private RegisterComedian $registerComedian;
    private RegisterPlace $registerPlace;
    private PlaceDAODatabase $placeRepository;
    private RegisterAttraction $registerAttraction;
    private UserDAODatabase $userRepo;
    private AttractionDAODatabase $attractionRepo;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {

        // TODO: GET FILE FROM Firebase or Github or S3 Automatic.

        parent::__construct();
        $this->time = new DateTimeAdapter();
        $this->dbConnection = new MySqlAdapter();
        $this->uuid = new UniqIdAdapter();
        $this->comedianRepository = new ComedianDAODatabase($this->dbConnection, $this->time);
        $this->placeRepository = new PlaceDAODatabase($this->dbConnection, $this->time);
        $this->attractionRepo = new AttractionDAODatabase($this->dbConnection, $this->time);
        $this->userRepo = new UserDAODatabase($this->dbConnection, $this->time);

        $this->registerComedian = new RegisterComedian(
            $this->comedianRepository,
            $this->uuid,
        );

        $this->registerPlace = new RegisterPlace(
            $this->placeRepository,
            $this->time,
            $this->uuid
        );

        $this->registerAttraction = new RegisterAttraction(
            $this->attractionRepo,
            $this->comedianRepository,
            $this->placeRepository,
            $this->userRepo,
            $this->uuid
        );

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->validateOptions();

        $this->importData();
        $this->process();

        return true;
    }

    public function validateOptions()
    {

        if (empty($this->file)) {
            $this->file = $this->argument('file');
        }

    }

    public function importData()
    {
        $file = $this->argument('file');

        $handle = fopen($file, 'r');
        if ($handle === false) {
            $this->error('Unable to open file: ' . $file);
            return;
        }

        while (($data = fgetcsv($handle, 5000, ",")) !== false) {
            $this->fileData[] = (object) [
                'title' => $data[0],
                'season' => $data[1],
                'schedule' => $data[2],
                'placeLink' => $data[3],
                'price' => $data[4],
                'duration' =>  $data[5],
                'classificationImage' => $data[7],
                'classificationLabel' => $data[6],
                'address' => $data[8],
                'image' => $data[9],
                'placeTitle' => $data[10],
                'placeSeats' => $data[11],
                'comedianName' => $data[12],
                'seasonDateFim' => $data[13],
                'seasonDateData' => $data[14],
            ];
            $this->rowCount++;
            $this->info("Processed $this->rowCount records...");
        }
        fclose($handle);
    }

    public function eventDates(DateTimeImmutable $firstDay, string $lastDay): array
    {
        $dates = [];
        $lastDay = new DateTimeImmutable($lastDay);
        $actualDate = $firstDay;
        while ($actualDate <= $lastDay) {
            $dates[] = $actualDate;
            $actualDate = $actualDate->modify('+1 week');
        }
        return $dates;
    }

    /**
     * @throws Exception
     */
    public function convertStringToDate(string $dateString): DateTimeImmutable {
        $daysOfWeek = [
            'domingo' => 0,
            'segunda' => 1,
            'terça' => 2,
            'quarta' => 3,
            'quinta' => 4,
            'sexta' => 5,
            'sábado' => 6
        ];

        $weekDay = null;
        foreach ($daysOfWeek as $day => $number) {
            if (stripos($dateString, $day) !== false) {
                $weekDay = $number;
                break;
            }
        }

        preg_match('/\d{1,2}h\d{0,2}/', $dateString, $matches);
        $hourMinute = $matches[0];
        $hourMinute = str_replace('h', ':', $hourMinute);

        if (strlen($hourMinute) == 3) {
            $hourMinute .= '00';
        }
        // Adicionando exceções de datas, se houver
        if (preg_match('/\(exceto (.+?)\)/', $dateString, $matches)) {
            $exceptions = explode('/', $matches[1]);
        } else {
            $exceptions = [];
        }

        // Verificando se a data atual está entre as exceções
        $actualDate = new DateTimeImmutable();
        $actualDateFormatted = $actualDate->format('Y-m-d');
        if (in_array($actualDateFormatted, $exceptions)) {
            // Se a data atual estiver entre as exceções, avançamos para a próxima semana
            $actualDate = $actualDate->modify('+1 week');
        }

        while ($actualDate->format('w') != $weekDay) {
            $actualDate = $actualDate->modify('+1 day');
        }

        $formattedDate = $actualDate->format('Y-m-d');
        $dateHourString = $formattedDate . ' ' . $hourMinute;
        return new DateTimeImmutable($dateHourString);
    }

    public function process()
    {

        foreach ($this->fileData as &$fileData) {

            if ($this->fileData[0]->title == $fileData->title) {
                continue;
            }

            $comedian = $this->registerComedian($fileData);
            $this->info("[registerComedian] Registered ". $fileData->comedianName);

            $place = $this->registerPlace($fileData);
            $this->info("[registerPlace] Registered ". $fileData->placeTitle);

            if ($comedian instanceof Comedian && $place instanceof Place) {
                $this->registerAttraction($fileData, $comedian, $place);
                $this->info("[registerAttraction] Registered ". $fileData->title);
            }

            $this->info("_________________________________");

        }
    }

    private function registerComedian($fileData): ?Comedian
    {
        try {

            $this->info($fileData->comedianName);

            $comedianData = [
                'name' => $fileData->comedianName,
                'miniBio' => $fileData->miniBio ?? '',
                'thumbnail' => $fileData->thumbnail ?? '',
                'attractions' => []
            ];

            return $this->registerComedian->handle($comedianData);
        } catch (Exception $exception) {
            if ($exception instanceof ComedianAlreadyRegistered) {
                return $this->comedianRepository->getComedianByName($fileData->comedianName);
            }
            $this->error("[registerComedian] " . $fileData->comedianName . " ". $exception->getMessage());
        }
        return null;
    }
    private function registerPlace($fileData): ?Place
    {
        try {
            $this->info($fileData->placeTitle);

            $placeData = [
                "name" => $fileData->placeTitle ?? '',
                "seats" => (int) $fileData->placeSeats ?? '',
                "address" => $fileData->address ?? '',
                "zipcode" => $fileData->zipcode ?? '',
                "image" => $fileData->image ?? '',
                "lat" => $fileData->lat ?? '',
                "lng" => $fileData->lng ?? '',
            ];
            return $this->registerPlace->handle($placeData);
        } catch (Exception $exception) {
            if ($exception instanceof PlaceAlreadyRegisteredException) {
                return $this->placeRepository->getPlaceByName($fileData->placeTitle);
            }
            $this->error("[registerPlace] " . $fileData->placeTitle . " " . $exception->getMessage());
        }
        return null;
    }

    private function registerAttraction($fileData, $comedian, $place): ?Attraction
    {

        try {
            $this->info($fileData->title);
            $this->info($fileData->image);

            $date = $this->convertStringToDate($fileData->schedule);

            $attraction = [
                "title" => $fileData->title ?? '',
                "date" => $date->format('Y-m-d H:i:s') ?? '',
                "status" => AttractionStatus::PUBLISHED ?? '',
                "comedianId" => $comedian->id ?? '',
                "placeId" => $place->id ?? '',
                "ownerId" => '63d1c98e22ccb' ?? '', // User Test user.test63cb4a1551081@gmail.com
                "duration" => $fileData->duration ?? '',
                "image" => $fileData->image ?? '',
            ];
            return $this->registerAttraction->handle($attraction, $this->time);
        } catch (Exception $exception) {
            $this->error("[registerAttraction] " . $fileData->title . " ". $exception->getMessage());
        }
        return null;
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
