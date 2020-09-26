<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $clients = ['mohamed', 'ahmed'];

        foreach($clients as $client)
        {

            \App\Client::create([

                'name' => $client,
                'phone' => '0597665146',
                'address' => 'Palestine/gaza',
            ]);

        }

    }//end of run


}//end of seeder
