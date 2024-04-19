<?php

namespace App\Console\Commands;

use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class ImportLocations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locations:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import JP Locations';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $converted_csv_path = storage_path('app/csv/postal_code_utf8.csv');

        file_put_contents(
            $converted_csv_path,
            mb_convert_encoding(
                file_get_contents(storage_path('app/csv/locations.csv')),
                'UTF-8',
                'SJIS-win'
            )
        );

        $file = new \SplFileObject($converted_csv_path);
        $file->setFlags(\SplFileObject::READ_CSV);

        foreach ($file as $index => $row) {

            $line_number = $index + 1;

            if($line_number > 1 && $line_number % 1000 === 0) {
                $this->info(number_format($line_number) .' lines imported.');
            }

            if(!is_null($row[0])) {
                $location = Location::newModelInstance();
                $location->location_uuid = Str::uuid();
                $location->location_postal_code = $row[2];
                $location->location_prefecture = $row[6];
                $location->location_city = $row[7];
                $location->location_address = (Str::contains($row[8], '（')) ? current(explode('（', $row[8])) : $row[8];

                $location->save();

            }
        }

        $this->info("Done");
    }
}
