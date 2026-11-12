<?php

declare(strict_types=1);

use CraftCms\Cms\Edition;
use CraftCms\Cms\User\Elements\User;
use CraftCms\Cms\User\Models\User as UserModel;
use CraftCms\Cms\Utility\Utilities;
use CraftCms\Query\Utilities\Query;
use Illuminate\Testing\TestResponse;
use Inertia\Support\SessionKey;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\from;
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

function executeQuery(?string $sql): TestResponse
{
    return from('/admin/utilities/query')->post('/admin/utilities/query', ['sql' => $sql]);
}

/**
 * The query result flashed back to the utility, with rows as arrays.
 *
 * @return array<string, mixed>
 */
function flashedQuery(): array
{
    $query = session(SessionKey::FLASH_DATA)['query'];

    if (isset($query['result'])) {
        $query['result'] = array_map(fn (object $row) => (array) $row, $query['result']);
    }

    return $query;
}

it('registers the utility', function () {
    expect(app(Utilities::class)->getUtilityTypeById('query'))->toBe(Query::class);
});

it('flashes query results back to the utility', function () {
    actingAs(user(['accessCp', 'utility:query']));

    executeQuery("select 'a' as letter, null as note union all select 'b', 'not null' order by letter")
        ->assertRedirect('/admin/utilities/query');

    expect(flashedQuery())->toBe([
        'success' => true,
        'result' => [
            ['letter' => 'a', 'note' => null],
            ['letter' => 'b', 'note' => 'not null'],
        ],
        'formattedTotal' => '2',
    ]);
});

it('returns no rows for an empty query', function () {
    actingAs(user(['accessCp', 'utility:query']));

    executeQuery('')->assertRedirect('/admin/utilities/query');

    expect(flashedQuery())->toBe(['success' => true, 'result' => [], 'formattedTotal' => '0']);
});

it('flashes database errors', function () {
    actingAs(user(['accessCp', 'utility:query']));

    executeQuery('select * from nonexistent_table')->assertRedirect('/admin/utilities/query');

    expect(flashedQuery())
        ->success->toBeFalse()
        ->error->toContain('nonexistent_table');
});

it('requires the utility permission', function () {
    postJson('/admin/utilities/query', ['sql' => 'select 1'])->assertUnauthorized();

    actingAs(user(['accessCp']));
    postJson('/admin/utilities/query', ['sql' => 'select 1'])->assertForbidden();
});
