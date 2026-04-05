<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;

class PublisherSeeder extends Seeder
{
    public function run(): void
    {
        $publishers = [
            [
                'name'    => 'Ateneo de Manila University Press',
                'email'   => 'press@admu.edu.ph',
                'website' => 'https://www.admupress.com',
                'address' => 'Loyola Heights, Quezon City, Philippines',
            ],
            [
                'name'    => 'University of the Philippines Press',
                'email'   => 'uppress@up.edu.ph',
                'website' => 'https://www.uppress.com.ph',
                'address' => 'UP Diliman, Quezon City, Philippines',
            ],
            [
                'name'    => 'Rex Book Store',
                'email'   => 'info@rexbookstore.com',
                'website' => 'https://www.rexbookstore.com',
                'address' => 'Sampaloc, Manila, Philippines',
            ],
            [
                'name'    => 'De La Salle University Publishing House',
                'email'   => 'publishing@dlsu.edu.ph',
                'website' => 'https://www.dlsu.edu.ph',
                'address' => '2401 Taft Avenue, Manila, Philippines',
            ],
            [
                'name'    => 'Kandalayang Academic Press',
                'email'   => 'press@kandalayang.edu.ph',
                'website' => 'https://www.kandalayang.edu.ph',
                'address' => 'Davao City, Philippines',
            ],
        ];

        foreach ($publishers as $publisher) {
            Publisher::create($publisher);
        }
    }
}
