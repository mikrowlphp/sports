<?php

/**
 * SportClub Module Permissions
 *
 * These permissions are automatically installed when the module is enabled
 * and removed when the module is disabled.
 *
 * Resources:
 * - MembershipType: Manage membership plans and pricing
 * - Subscription: Manage member subscriptions
 * - Team: Manage sports teams
 * - Tournament: Manage tournaments and competitions
 * - Match: Manage matches and results
 * - Instructor: Manage instructors
 * - Lesson: Manage lessons (group and individual)
 */

return [
    // Membership Types CRUD
    [
        'name' => 'Manage membership types',
        'code' => 'manage-membership-types',
        'namespace' => 'sportclub',
        'resource' => 'membership-types',
        'action' => 'manage',
        'description' => 'Full CRUD access to membership types and plans',
    ],

    // Subscriptions CRUD
    [
        'name' => 'Manage subscriptions',
        'code' => 'manage-subscriptions',
        'namespace' => 'sportclub',
        'resource' => 'subscriptions',
        'action' => 'manage',
        'description' => 'Full CRUD access to member subscriptions',
    ],

    // Teams CRUD
    [
        'name' => 'Manage teams',
        'code' => 'manage-teams',
        'namespace' => 'sportclub',
        'resource' => 'teams',
        'action' => 'manage',
        'description' => 'Full CRUD access to teams and team members',
    ],

    // Tournaments CRUD
    [
        'name' => 'Manage tournaments',
        'code' => 'manage-tournaments',
        'namespace' => 'sportclub',
        'resource' => 'tournaments',
        'action' => 'manage',
        'description' => 'Full CRUD access to tournaments, rounds and registrations',
    ],

    // Matches CRUD
    [
        'name' => 'Manage matches',
        'code' => 'manage-matches',
        'namespace' => 'sportclub',
        'resource' => 'matches',
        'action' => 'manage',
        'description' => 'Full CRUD access to matches and results',
    ],

    // Instructors CRUD
    [
        'name' => 'Manage instructors',
        'code' => 'manage-instructors',
        'namespace' => 'sportclub',
        'resource' => 'instructors',
        'action' => 'manage',
        'description' => 'Full CRUD access to instructors',
    ],

    // Lessons CRUD
    [
        'name' => 'Manage lessons',
        'code' => 'manage-lessons',
        'namespace' => 'sportclub',
        'resource' => 'lessons',
        'action' => 'manage',
        'description' => 'Full CRUD access to lessons and participants',
    ],
];
