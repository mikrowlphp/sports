<?php

namespace Packages\Sports\SportClub\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Packages\Sports\SportClub\Models\Sport;

class SportsSeeder extends Seeder
{
    public function run(): void
    {
        $sports = [
            [
                'name' => 'Calcio',
                'icon' => '⚽',
                'description' => 'Lo sport più popolare al mondo, giocato in squadre da 11 giocatori.',
            ],
            [
                'name' => 'Basket',
                'icon' => '🏀',
                'description' => 'Sport di squadra con canestri, giocato in 5 contro 5.',
            ],
            [
                'name' => 'Tennis',
                'icon' => '🎾',
                'description' => 'Sport di racchetta giocato in singolo o doppio su vari tipi di superficie.',
            ],
            [
                'name' => 'Pallavolo',
                'icon' => '🏐',
                'description' => 'Sport di squadra con rete, giocato in 6 contro 6.',
            ],
            [
                'name' => 'Nuoto',
                'icon' => '🏊',
                'description' => 'Sport acquatico con vari stili: libero, dorso, rana, farfalla.',
            ],
            [
                'name' => 'Padel',
                'icon' => '🎾',
                'description' => 'Sport di racchetta simile al tennis, giocato in doppio con pareti.',
            ],
            [
                'name' => 'Calcetto',
                'icon' => '⚽',
                'description' => 'Calcio a 5, versione indoor del calcio tradizionale.',
            ],
            [
                'name' => 'Atletica',
                'icon' => '🏃',
                'description' => 'Insieme di discipline: corsa, salti, lanci e prove multiple.',
            ],
            [
                'name' => 'Ciclismo',
                'icon' => '🚴',
                'description' => 'Sport su bicicletta con specialità su strada, pista e mountain bike.',
            ],
            [
                'name' => 'Golf',
                'icon' => '⛳',
                'description' => 'Sport di precisione che si gioca colpendo una pallina in buche successive.',
            ],
            [
                'name' => 'Rugby',
                'icon' => '🏉',
                'description' => 'Sport di contatto giocato con palla ovale in squadre da 15 o 7.',
            ],
            [
                'name' => 'Hockey',
                'icon' => '🏒',
                'description' => 'Sport di squadra su ghiaccio o prato con bastone e disco/pallina.',
            ],
            [
                'name' => 'Baseball',
                'icon' => '⚾',
                'description' => 'Sport di squadra con mazza e palla, popolare in USA e Asia.',
            ],
            [
                'name' => 'Pallamano',
                'icon' => '🤾',
                'description' => 'Sport di squadra indoor simile al calcio ma giocato con le mani.',
            ],
            [
                'name' => 'Tennis Tavolo',
                'icon' => '🏓',
                'description' => 'Ping pong, sport di racchetta su tavolo.',
            ],
            [
                'name' => 'Badminton',
                'icon' => '🏸',
                'description' => 'Sport di racchetta con volano, giocato in singolo o doppio.',
            ],
            [
                'name' => 'Scherma',
                'icon' => '🤺',
                'description' => 'Sport di combattimento con spada, fioretto o sciabola.',
            ],
            [
                'name' => 'Judo',
                'icon' => '🥋',
                'description' => 'Arte marziale giapponese basata su proiezioni e leve.',
            ],
            [
                'name' => 'Karate',
                'icon' => '🥋',
                'description' => 'Arte marziale giapponese con colpi di mani e piedi.',
            ],
            [
                'name' => 'Boxe',
                'icon' => '🥊',
                'description' => 'Sport di combattimento con pugni, praticato con guantoni.',
            ],
            [
                'name' => 'Ginnastica',
                'icon' => '🤸',
                'description' => 'Discipline artistiche e ritmiche con attrezzi o corpo libero.',
            ],
            [
                'name' => 'Pattinaggio',
                'icon' => '⛸️',
                'description' => 'Sport su ghiaccio o rotelle, artistico o di velocità.',
            ],
            [
                'name' => 'Squash',
                'icon' => '🎾',
                'description' => 'Sport di racchetta indoor giocato contro le pareti.',
            ],
            [
                'name' => 'Bocce',
                'icon' => '🎱',
                'description' => 'Sport di precisione tradizionale italiano con sfere.',
            ],
        ];

        foreach ($sports as $index => $sport) {
            Sport::updateOrCreate(
                ['slug' => Str::slug($sport['name'])],
                [
                    'name' => $sport['name'],
                    'icon' => $sport['icon'],
                    'description' => $sport['description'],
                    'is_active' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
