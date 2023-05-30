<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Str;
use function Pest\Laravel\artisan;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;


it('raise an error if first name is not present', function (): void {
    artisan('user:create', [
        '--first_name' => '',
        '--last_name' => '',
        '--email' => 'john.doe@obcc.de',
        '--password' => 'fAzEZ869QWt',
    ])
        ->expectsOutput(trans('validation.required', ['attribute' => 'first name']))
        ->assertExitCode(1);

    assertDatabaseMissing(User::class, [
        'email' => 'john.doe@obcc.de',
    ]);
});

it('raise an error if first name is too long', function (): void {
    artisan('user:create', [
        '--first_name' => Str::random(256),
        '--last_name' => Str::random(256),
        '--email' => 'john.doe@obcc.de',
        '--password' => 'fAzEZ869QWt',
    ])
        ->expectsOutput(trans('validation.max.string', ['attribute' => 'first name', 'max' => '255']))
        ->assertExitCode(1);

    assertDatabaseMissing(User::class, [
        'email' => 'john.doe@obcc.de',
    ]);
});

it('raise an error if email is not present', function (): void {
    artisan('user:create', [
        '--first_name' => 'John',
        '--last_name' => 'Doe',
        '--email' => '',
        '--password' => 'fAzEZ869QWt',
    ])
        ->expectsOutput(trans('validation.required', ['attribute' => 'email']))
        ->assertExitCode(1);

    assertDatabaseMissing(User::class, [
        'first_name' => 'John',
    ]);
});

it('raise an error if email is not a valid email address', function (): void {
    artisan('user:create', [
        '--first_name' => 'John',
        '--last_name' => 'Doe',
        '--email' => 'not a valid email address',
        '--password' => 'fAzEZ869QWt',
    ])
        ->expectsOutput(trans('validation.email', ['attribute' => 'email']))
        ->assertExitCode(1);

    assertDatabaseMissing(User::class, [
        'first_name' => 'John',
    ]);
});

it('raise an error if email is too long', function (): void {
    artisan('user:create', [
        '--first_name' => 'John',
        '--last_name' => 'Doe',
        '--email' => Str::random(244) . '@example.com',
        '--password' => 'fAzEZ869QWt',
    ])
        ->expectsOutput(trans('validation.max.string', ['attribute' => 'email', 'max' => '255']))
        ->assertExitCode(1);

    assertDatabaseMissing(User::class, [
        'first_name' => 'John Doe',
    ]);
});

it('raise an error if password is not present', function (): void {
    artisan('user:create', [
        '--first_name' => 'John',
        '--last_name' => 'Doe',
        '--email' => Str::random(245) . '@example.com',
        '--password' => '',
    ])
        ->expectsOutput(trans('validation.required', ['attribute' => 'password']))
        ->assertExitCode(1);

    assertDatabaseMissing(User::class, [
        'first_name' => 'John',
    ]);
});

it('raise an error if password is less than 6 characters', function (): void {
    artisan('user:create', [
        '--first_name' => 'John',
        '--last_name' => 'Doe',
        '--email' => Str::random(245) . '@example.com',
        '--password' => 'fAzEZ',
    ])
        ->expectsOutput(trans('validation.min.string', ['attribute' => 'password', 'min' => '6']))
        ->assertExitCode(1);

    assertDatabaseMissing(User::class, [
        'first_name' => 'John',
    ]);
});

it('creates a new user with data passed inline', function (): void {
    artisan('user:create', [
        '--first_name' => 'John',
        '--last_name' => 'Doe',
        '--email' => 'john.doe@obcc.de',
        '--password' => 'fAzEZ869QWt',
    ])
        ->expectsOutput(trans('artisan.create_user.alerts.confirmation'))
        ->expectsTable(['First Name', 'Last Name', 'Email', 'Password'], [
            ['John', 'Doe', 'john.doe@obcc.de', 'fAzEZ869QWt'],
        ])
        ->assertExitCode(0);

    assertDatabaseHas(User::class, [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@obcc.de',
    ]);
});

it('creates a new user', function (): void {
    artisan('user:create')
        ->expectsOutput(trans('artisan.create_user.description'))
        ->expectsConfirmation(trans('artisan.create_user.dialogs.confirm_before_executing'), 'yes')
        ->expectsQuestion(trans('artisan.create_user.questions.first_name'), 'John')
        ->expectsQuestion(trans('artisan.create_user.questions.last_name'), 'Doe')
        ->expectsQuestion(trans('artisan.create_user.questions.email'), 'john.doe@obcc.de')
        ->expectsQuestion(trans('artisan.create_user.questions.password'), 'fAzEZ869QWt')
        ->expectsOutput(trans('artisan.create_user.alerts.confirmation'))
        ->expectsTable(['First Name', 'Last Name', 'Email', 'Password'], [
            ['John', 'Doe', 'john.doe@obcc.de', 'fAzEZ869QWt'],
        ])
        ->assertExitCode(0);

    assertDatabaseHas(User::class, [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john.doe@obcc.de',
    ]);
});
