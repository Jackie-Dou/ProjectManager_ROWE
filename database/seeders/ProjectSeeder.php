<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $projects = ['Новое'];

        foreach ($projects as $project) {
            $newProject = new Project();
            $newProject->fill(['name' => $project, 'isFavourite' => false]);
            $newProject->save();
        }
    }
}
