<?php

return [
    'navigation' => [
        'label' => 'Configuration',
    ],
    'title' => 'Sport Club Configuration',
    'heading' => 'Welcome! Let\'s configure your sport club',
    'subheading' => 'Follow these steps to set up your sports, fields, and instructors',

    'wizard' => [
        'sports' => [
            'label' => 'Sports',
            'description' => 'Select the sports your club offers',
            'sports_practiced' => 'Sports practiced',
            'helper_text' => 'Select the sports your club offers. If your sport is not listed, you can skip this step and add it later from the Sports menu.',
        ],
        'fields' => [
            'label' => 'Fields',
            'description' => 'Add your fields and facilities',
            'fields_and_facilities' => 'Fields and facilities',
            'field_name' => 'Field name',
            'field_name_placeholder' => 'e.g., Main Field, Court 1',
            'sport' => 'Sport',
            'description_label' => 'Description',
            'capacity' => 'Capacity',
            'hourly_rate' => 'Hourly rate',
            'color' => 'Color',
            'indoor' => 'Indoor',
            'active' => 'Active',
            'people' => 'people',
            'add_field' => 'Add field',
            'helper_text' => 'You can add fields later from the Fields section',
        ],
        'instructors' => [
            'label' => 'Instructors',
            'description' => 'Add your instructors and coaches',
            'instructors_and_coaches' => 'Instructors and coaches',
            'contact' => 'Contact',
            'hourly_rate' => 'Hourly rate',
            'specializations' => 'Specializations',
            'specializations_placeholder' => 'Enter specialization and press Enter',
            'biography' => 'Biography',
            'active' => 'Active',
            'add_instructor' => 'Add instructor',
            'helper_text' => 'You can add instructors later from the Instructors section',
        ],
    ],

    'submit' => 'Complete Configuration',

    'notifications' => [
        'success' => 'Configuration completed successfully',
        'error' => 'Error during configuration',
    ],
];
