<?php

return [
    'navigation' => [
        'label' => 'Configurazione',
    ],
    'title' => 'Configurazione Centro Sportivo',
    'heading' => 'Benvenuto! Configuriamo il tuo centro sportivo',
    'subheading' => 'Segui questi passaggi per configurare sport, campi e istruttori',

    'wizard' => [
        'sports' => [
            'label' => 'Sport',
            'description' => 'Seleziona gli sport offerti dal tuo club',
            'sports_practiced' => 'Sport praticati',
            'helper_text' => 'Seleziona gli sport offerti dal tuo club. Se il tuo sport non è presente nella lista, puoi saltare questo passaggio e aggiungerlo successivamente dal menu Sport.',
        ],
        'fields' => [
            'label' => 'Campi',
            'description' => 'Aggiungi i tuoi campi e impianti',
            'fields_and_facilities' => 'Campi e impianti',
            'field_name' => 'Nome campo',
            'field_name_placeholder' => 'es. Campo Principale, Campo 1',
            'sport' => 'Sport',
            'description_label' => 'Descrizione',
            'capacity' => 'Capienza',
            'hourly_rate' => 'Tariffa oraria',
            'color' => 'Colore',
            'indoor' => 'Coperto',
            'active' => 'Attivo',
            'people' => 'persone',
            'add_field' => 'Aggiungi campo',
            'helper_text' => 'Puoi aggiungere campi in seguito dalla sezione Campi',
        ],
        'instructors' => [
            'label' => 'Istruttori',
            'description' => 'Aggiungi i tuoi istruttori e allenatori',
            'instructors_and_coaches' => 'Istruttori e allenatori',
            'contact' => 'Contatto',
            'hourly_rate' => 'Tariffa oraria',
            'specializations' => 'Specializzazioni',
            'specializations_placeholder' => 'Inserisci specializzazione e premi Invio',
            'biography' => 'Biografia',
            'active' => 'Attivo',
            'add_instructor' => 'Aggiungi istruttore',
            'helper_text' => 'Puoi aggiungere istruttori in seguito dalla sezione Istruttori',
        ],
    ],

    'submit' => 'Completa Configurazione',

    'notifications' => [
        'success' => 'Configurazione completata con successo',
        'error' => 'Errore durante la configurazione',
    ],
];
