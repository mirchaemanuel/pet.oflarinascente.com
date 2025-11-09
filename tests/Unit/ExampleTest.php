<?php

declare(strict_types=1);

test('that true is true', function (): void {
    // Arrange
    $value = true;

    // Act
    // (No action needed for this assertion)

    // Assert
    expect($value)->toBeTrue();
});
