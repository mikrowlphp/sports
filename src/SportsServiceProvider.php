<?php

namespace Packages\Sports;

use App\PackageServiceProvider;
use Packages\Sports\SportClub\Models\MembershipType;
use Packages\Sports\SportClub\Models\Subscription;
use Packages\Sports\SportClub\Models\Team;
use Packages\Sports\SportClub\Models\TeamMember;
use Packages\Sports\SportClub\Models\Tournament;
use Packages\Sports\SportClub\Models\TournamentRound;
use Packages\Sports\SportClub\Models\TournamentTeam;
use Packages\Sports\SportClub\Models\SportMatch;
use Packages\Sports\SportClub\Models\MatchResult;
use Packages\Sports\SportClub\Models\Instructor;
use Packages\Sports\SportClub\Models\Lesson;
use Packages\Sports\SportClub\Models\LessonParticipant;
use Packages\Sports\SportClub\Policies\MembershipTypePolicy;
use Packages\Sports\SportClub\Policies\SubscriptionPolicy;
use Packages\Sports\SportClub\Policies\TeamPolicy;
use Packages\Sports\SportClub\Policies\TeamMemberPolicy;
use Packages\Sports\SportClub\Policies\TournamentPolicy;
use Packages\Sports\SportClub\Policies\TournamentRoundPolicy;
use Packages\Sports\SportClub\Policies\TournamentTeamPolicy;
use Packages\Sports\SportClub\Policies\MatchPolicy;
use Packages\Sports\SportClub\Policies\MatchResultPolicy;
use Packages\Sports\SportClub\Policies\InstructorPolicy;
use Packages\Sports\SportClub\Policies\LessonPolicy;
use Packages\Sports\SportClub\Policies\LessonParticipantPolicy;

class SportsServiceProvider extends PackageServiceProvider
{


    public function getPackageName(): string
    {
        return 'sports';
    }

    public function getModules(): array
    {
        return $this->modules;
    }

    public function registerModules(): void
    {
        $this->modules = [
            [
                'name_key' => 'sports::modules.sportclub.name',
                'slug' => 'sportclub',
                'description_key' => 'sports::modules.sportclub.description',
                'panels' => [
                    'SportClub\\SportClubPanelProvider'
                ],
                'seeder' => 'SportClub\\Database\\Seeders\\DatabaseSeeder',
                'protected' => false
            ],
        ];
    }

    /**
     * Register model policies.
     */
    protected function policies(): array
    {
        return [
            // Membership policies
            MembershipType::class => MembershipTypePolicy::class,
            Subscription::class => SubscriptionPolicy::class,

            // Team policies
            Team::class => TeamPolicy::class,
            TeamMember::class => TeamMemberPolicy::class,

            // Tournament policies
            Tournament::class => TournamentPolicy::class,
            TournamentRound::class => TournamentRoundPolicy::class,
            TournamentTeam::class => TournamentTeamPolicy::class,

            // Match policies
            SportMatch::class => MatchPolicy::class,
            MatchResult::class => MatchResultPolicy::class,

            // Lesson policies
            Instructor::class => InstructorPolicy::class,
            Lesson::class => LessonPolicy::class,
            LessonParticipant::class => LessonParticipantPolicy::class,
        ];
    }


}
