<?php

namespace Database\Seeders;

use App\Models\Upload;
use Illuminate\Database\Seeder;

class UploadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        $images = [ "https://s3.eu-central-1.amazonaws.com/gears-tn-bucket/uploads/636ac9d7-0472-47a4-b2be-2016adf75ceb1.jpg",
                    "https://s3.eu-central-1.amazonaws.com/gears-tn-bucket/uploads/8adc7595-5c0f-4690-b19b-50dea89398112.jpg",
                    "https://s3.eu-central-1.amazonaws.com/gears-tn-bucket/uploads/c890a047-e71c-4758-a3a2-b0744ad290ca3.jpg",
                    "https://s3.eu-central-1.amazonaws.com/gears-tn-bucket/uploads/0d4c5eaf-e3dd-4a28-bb9a-8c54afdd33194.jpg"];

        $uploads = [
            [
                'user_id' => 1,
                'file_original_name' => 'test',
                'file_name' => 'test',
                'extension' => 'jpg',
                'type' => 'image',
                'url' => 'https://s3.eu-central-1.amazonaws.com/gears-tn-bucket/uploads/636ac9d7-0472-47a4-b2be-2016adf75ceb1.jpg',
                'file_path' => 'uploads/636ac9d7-0472-47a4-b2be-2016adf75ceb1.jpg',
            ],
            [
                'user_id' => 1,
                'file_original_name' => 'test',
                'file_name' => 'test',
                'extension' => 'jpg',
                'type' => 'image',
                'url' => 'https://s3.eu-central-1.amazonaws.com/gears-tn-bucket/uploads/8adc7595-5c0f-4690-b19b-50dea89398112.jpg',
                'file_path' => 'uploads/8adc7595-5c0f-4690-b19b-50dea89398112.jpg',
            ],
            [
                'user_id' => 1,
                'file_original_name' => 'test',
                'file_name' => 'test',
                'extension' => 'jpg',
                'type' => 'image',
                'url' => 'https://s3.eu-central-1.amazonaws.com/gears-tn-bucket/uploads/c890a047-e71c-4758-a3a2-b0744ad290ca3.jpg',
                'file_path' => 'uploads/c890a047-e71c-4758-a3a2-b0744ad290ca3.jpg',
            ],
            [
                'user_id' => 1,
                'file_original_name' => 'test',
                'file_name' => 'test',
                'extension' => 'jpg',
                'type' => 'image',
                'url' => 'https://s3.eu-central-1.amazonaws.com/gears-tn-bucket/uploads/0d4c5eaf-e3dd-4a28-bb9a-8c54afdd33194.jpg',
                'file_path' => 'uploads/0d4c5eaf-e3dd-4a28-bb9a-8c54afdd33194.jpg',
            ],

       ];

       foreach ($uploads as $upload) {
           Upload::create($upload);
       }
    }
}
