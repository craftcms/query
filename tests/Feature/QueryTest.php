<?php

declare(strict_types=1);

use CraftCms\Cms\Edition;
use CraftCms\Cms\User\Elements\User;
use CraftCms\Cms\User\Models\User as UserModel;
use CraftCms\Cms\Utility\Utilities;
use CraftCms\Query\Utilities\Query;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

beforeEach(function () {
    Edition::set(Edition::Pro);
});

/**
 * @param  string[]  $permissions
 */
function user(array $permissions): User
{
    return UserModel::factory()->withPermissions($permissions)->createElement();
}

it('registers the utility', function () {
    expect(app(Utilities::class)->getUtilityTypeById('query'))->toBe(Query::class);
});

it('executes queries at the Craft 5 action paths', function (string $url) {
    actingAs(user(['accessCp', 'utility:query']));

    postJson($url, ['sql' => "select 'a' as letter, null as note union all select 'b', 'not null' order by letter"])
        ->assertOk()
        ->assertExactJson([
            'success' => true,
            'result' => [
                ['letter' => 'a', 'note' => null],
                ['letter' => 'b', 'note' => 'not null'],
            ],
            'formattedTotal' => '2',
        ]);
})->with([
    'site action URL' => '/actions/query/default/execute',
    'control panel action URL' => '/admin/actions/query/default/execute',
]);

it('returns no rows for an empty query', function () {
    actingAs(user(['accessCp', 'utility:query']));

    postJson('/actions/query/default/execute', ['sql' => ''])
        ->assertOk()
        ->assertExactJson(['success' => true, 'result' => [], 'formattedTotal' => '0']);
});

it('returns database errors', function () {
    actingAs(user(['accessCp', 'utility:query']));

    postJson('/actions/query/default/execute', ['sql' => 'select * from nonexistent_table'])
        ->assertOk()
        ->assertJsonPath('success', false)
        ->assertJsonPath('error', fn (string $error) => str_contains($error, 'nonexistent_table'));
});

it('requires the utility permission', function () {
    postJson('/actions/query/default/execute', ['sql' => 'select 1'])->assertUnauthorized();

    actingAs(user(['accessCp']));
    postJson('/actions/query/default/execute', ['sql' => 'select 1'])->assertForbidden();
});
