<?php

use Illuminate\Database\Seeder;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        DB::table('users')->truncate();

        $admin = [
            'last_name' => "admin",
            'first_name' => "shop",
            'email' =>  "admin@gmail.com",
            'password' => password_hash('123@123a', PASSWORD_BCRYPT),
            'phone_number' => '01669209256',
            'gender' => 'M',
            'is_admin' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        factory(App\User::class)->create($admin);

        $data = [];
        for($i=0; $i<10; $i++) {
            $user = [
                'last_name' => $faker->lastName,
                'first_name' => $faker->firstName,
                'email' =>  $faker->email,
                'password' => password_hash('123@123a', PASSWORD_BCRYPT),
                'is_admin' => 0,
                'gender' => $faker->randomElement(['M', 'F']),
                'phone_number' => $faker->e164PhoneNumber,
                'county' => $faker->state,
                'country' => $faker->country,
                'address1' => $faker->streetAddress,
                'address2' => $faker->streetAddress,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
            array_push($data, $user);
        }
        DB::table('users')->insert($data);
    }
}
