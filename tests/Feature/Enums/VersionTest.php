<?php

declare(strict_types=1);

use App\Enums\VersionEnum;

it('checks if the version satisfies the given constraint', function (): void {
    expect(VersionEnum::v1_0->satisfies('^1.0'))->toBeTrue();
    expect(VersionEnum::v1_1->satisfies('^1.0'))->toBeTrue();
    expect(VersionEnum::v1_0->satisfies('^1.1'))->toBeFalse();
    expect(VersionEnum::v1_1->satisfies('1.0'))->toBeFalse();
    expect(VersionEnum::v1_1->satisfies('^1.1'))->toBeTrue();
    expect(VersionEnum::v2_0->satisfies('^1.1'))->toBeFalse();
    expect(VersionEnum::v2_0->satisfies('^2.0'))->toBeTrue();
});

it('checks if the version is greater than a given one', function (): void {
    expect(VersionEnum::v1_1->greaterThan(VersionEnum::v1_0))->toBeTrue();
    expect(VersionEnum::v1_0->greaterThan(VersionEnum::v1_0))->toBeFalse();
    expect(VersionEnum::v1_0->greaterThan(VersionEnum::v1_1))->toBeFalse();
});

it('checks if the version is greater than or equals to a given one', function (): void {
    expect(VersionEnum::v1_0->greaterThanOrEqualsTo(VersionEnum::v1_0))->toBeTrue();
    expect(VersionEnum::v1_0->greaterThanOrEqualsTo(VersionEnum::v1_1))->toBeFalse();
});

it('checks if the version is less than a given one', function (): void {
    expect(VersionEnum::v1_0->lessThan(VersionEnum::v1_1))->toBeTrue();
    expect(VersionEnum::v1_0->lessThan(VersionEnum::v1_0))->toBeFalse();
    expect(VersionEnum::v1_1->lessThan(VersionEnum::v1_0))->toBeFalse();
});

it('checks if the version is less than or equals to a given one', function (): void {
    expect(VersionEnum::v1_0->lessThanOrEqualsTo(VersionEnum::v1_0))->toBeTrue();
    expect(VersionEnum::v1_1->lessThanOrEqualsTo(VersionEnum::v1_0))->toBeFalse();
});

it('checks if the version is equals to a given one', function (): void {
    expect(VersionEnum::v1_0->equalsTo(VersionEnum::v1_0))->toBeTrue();
    expect(VersionEnum::v1_0->equalsTo(VersionEnum::v1_1))->toBeFalse();
});

it('checks if the version is not equals to a given one', function (): void {
    expect(VersionEnum::v1_0->notEqualsTo(VersionEnum::v1_0))->toBeFalse();
    expect(VersionEnum::v1_0->notEqualsTo(VersionEnum::v1_1))->toBeTrue();
});
