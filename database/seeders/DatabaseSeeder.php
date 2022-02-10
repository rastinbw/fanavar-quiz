<?php

namespace Database\Seeders;

use App\Includes\Constant;
use App\Includes\RavenHelper;
use App\Models\RavenItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // foreach($answer_sheet as $k => $a){
        //     $i = new RavenItem();
        //     $i->qo_image = "/images/raven-questions/" . $k . ".jpg";
        //     $i->correct_option_number = $a;
        //     $i->option_count = ($k >= 25) ? 8 : 6;
        //     $i->save();
        // }
        

        //\App\Models\RavenItem::factory(10)->create();
        //\App\Models\MdItem::factory(29)->create();
        //\App\Models\MdExercise::factory(1)->create();
        //\App\Models\User::factory(2)->create();
    }
}
