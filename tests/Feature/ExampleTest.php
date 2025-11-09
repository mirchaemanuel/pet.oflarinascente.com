<?php

declare(strict_types=1);

test('the application returns a successful response', function (): void {
    // Arrange
    // (No setup needed for this simple test)

    // Act
    $response = $this->get('/');

    // Assert
    $response->assertStatus(200);
});
