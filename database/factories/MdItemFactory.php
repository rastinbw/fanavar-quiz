<?php

namespace Database\Factories;

use App\Includes\Constant;
use Illuminate\Database\Eloquent\Factories\Factory;

class MdItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question' => "آیا مفاهیم زیر / رو / بالا یا پایین را می داند؟",
            'level' => Constant::$MD_LEVEL_THREE_TO_SIX,
        ];
    }
}
