<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeProduit;

class TypeProduitSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'nom' => 'Écrans',
                'slug' => 'ecrans',
                'description' => 'Écrans professionnels et affichage dynamique'
            ],
            [
                'nom' => 'Audiovisuel',
                'slug' => 'audiovisuel',
                'description' => 'Solutions audiovisuelles pour entreprises'
            ],
            [
                'nom' => 'Tablettes',
                'slug' => 'tablettes',
                'description' => 'Tablettes professionnelles'
            ],
            [
                'nom' => 'Logiciels',
                'slug' => 'logiciels',
                'description' => 'Solutions logicielles pour affichage dynamique'
            ],
        ];

        foreach ($types as $type) {
            TypeProduit::updateOrCreate(
                ['slug' => $type['slug']], // unique key
                $type
            );
        }
    }
}
