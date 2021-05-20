<?php

use App\Discografica_generos;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscografiaGeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discografica_generos');

        $generos =
        ['Axé', 'Blues', 'Country', 'Eletrônica', 'Forró', 'Funk', 'Gospel', 'Hip Hop', 'Jazz', 'MPB', 'Música Clássica', 'Pagode', 'Pop', 'Rap', 'Reggae', 'Rock', 'Samba', 'Sertanejo'];
        foreach ($generos as $key => $value) {
            Discografica_generos::create([
                'disco_genero' => $value
            ]);
        }
    }
}
