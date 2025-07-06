<?php

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition()
    {
        // random tanggal lahir minimal 10 tahun lalu
        $birthdate = $this->faker->dateTimeBetween('-30 years', '-10 years')->format('Y-m-d');
        $today = Carbon::today();
        $age = Carbon::parse($birthdate)->diffInYears($today);

        return [
            'id' => Str::uuid(),
            'fullName' => $this->faker->name(),
            'birthdate' => $birthdate,
            'age' => $age,
            'identityNumber' => $this->faker->unique()->numerify('################'), // 16 digit
            'familyIdentityNumber' => $this->faker->numerify('################'), // 16 digit
            'gender' => $this->faker->randomElement(['male', 'female']),
            'streetAddress' => $this->faker->streetAddress(),
            'religion' => 1,
            'provinceId' => 11,
            'regencieId' => 1112,
            'districtId' => 111204,
            'villageId' => 1112042013,
            'kontingenId' => '789289d3-7c47-45cb-83bb-266f6834b57b', // dari dump kontingens Anda
            'phoneNumber' => '08' . $this->faker->numerify('##########'), // panjang 10-13 digit
            'email' => $this->faker->safeEmail(),
            'height' => $this->faker->numberBetween(140, 190),
            'weight' => $this->faker->numberBetween(45, 90),
            'documentId' => Str::uuid(),
            'probabilityId' => '3027264c-b764-4df5-b8d9-e7c8b3829aa8', // 'atlet'
            'userId' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
