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
                'name'    => 'Project Gutenberg',
                'email'   => 'info@gutenberg.org',
                'website' => 'https://www.gutenberg.org',
                'address' => 'Project Gutenberg Literary Archive Foundation, 809 North 1500 West, Salt Lake City, UT 84116, USA',
            ],
            [
                'name'    => 'arXiv',
                'email'   => 'info@arxiv.org',
                'website' => 'https://arxiv.org',
                'address' => 'Cornell University, Ithaca, New York 14853, USA',
            ],
            [
                'name'    => 'LibriVox',
                'email'   => 'info@librivox.org',
                'website' => 'https://librivox.org',
                'address' => 'LibriVox, Internet Archive, 300 Funston Avenue, San Francisco, CA 94118, USA',
            ],
            [
                'name'    => 'Internet Archive',
                'email'   => 'info@archive.org',
                'website' => 'https://archive.org',
                'address' => '300 Funston Avenue, San Francisco, CA 94118, USA',
            ],
            [
                'name'    => 'OpenStax',
                'email'   => 'support@openstax.org',
                'website' => 'https://openstax.org',
                'address' => 'Rice University, 6100 Main Street, Houston, TX 77005, USA',
            ],
            [
                'name'    => 'DOAJ – Directory of Open Access Journals',
                'email'   => 'helpdesk@doaj.org',
                'website' => 'https://doaj.org',
                'address' => 'IS4OA CIC, Lund University Libraries, Box 134, SE-221 00 Lund, Sweden',
            ],
            [
                'name'    => 'MIT OpenCourseWare',
                'email'   => 'ocw@mit.edu',
                'website' => 'https://ocw.mit.edu',
                'address' => 'Massachusetts Institute of Technology, 77 Massachusetts Ave, Cambridge, MA 02139, USA',
            ],
            [
                'name'    => 'Public Library of Science (PLOS)',
                'email'   => 'info@plos.org',
                'website' => 'https://plos.org',
                'address' => '1160 Battery Street, Suite 225, San Francisco, CA 94111, USA',
            ],
        ];

        foreach ($publishers as $publisher) {
            Publisher::firstOrCreate(
                ['name' => $publisher['name']],
                $publisher
            );
        }
    }
}