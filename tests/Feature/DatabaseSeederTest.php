<?php

namespace Tests\Feature;

use App\Models\Screen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeders_can_run_twice_without_duplicate_user_error(): void
    {
        $this->seed();
        $this->seed();

        $this->assertDatabaseCount('users', 7);
    }

    public function test_seeded_screen_components_match_existing_home_blade_components(): void
    {
        $this->seed();

        $screens = Screen::query()->where('enabled', true)->get();

        $this->assertNotEmpty($screens);

        foreach ($screens as $screen) {
            $componentPath = resource_path('views/components/home/' . $screen->component . '.blade.php');
            $this->assertTrue(
                File::exists($componentPath),
                "Screen '{$screen->name}' uses missing component '{$screen->component}'."
            );
        }
    }
}
