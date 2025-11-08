# Architecture Documentation

## Overview

This Laravel application for **Pet Memorial Services** follows **Clean Architecture** principles with a strong emphasis on separation of concerns, type safety, and testability.

## Architecture Layers

### 1. Domain Layer (Core Business Logic)

**Models** (`app/Models/`)
- Eloquent models with full type safety
- All models use `LogsActivityAllDirty` trait for auditing
- Type-hinted relationships
- Scopes for common queries
- Counter caches for performance

**Enums** (`app/Enums/`)
- `PetSpecies`: Type-safe pet species with labels and icons
- `BookingStatus`: Booking statuses with Filament color coding
- All enums implement Filament interfaces (`HasLabel`, `HasColor`)

### 2. Application Layer

**Data Transfer Objects** (`app/Data/`)
- Immutable readonly classes
- Type-safe data containers
- Factory methods for creating from arrays
- No business logic

**Actions** (`app/Actions/`)
Single-responsibility classes for atomic operations:
- `Pets/CreatePetMemorialAction`
- `Pets/PublishPetMemorialAction`
- `Reactions/AddHeartReactionAction`
- `Reactions/LightVirtualCandleAction`
- `Bookings/CreateBookingAction`
- `Contacts/SubmitContactFormAction`

**Services** (`app/Services/`)
Orchestrate complex business workflows:
- `PetMemorialService`: Manages pet memorials with photos
- `ReactionService`: Handles hearts and candles with rate limiting
- `BookingService`: Booking lifecycle management

**Exceptions** (`app/Exceptions/`)
- `RateLimitExceededException`: Custom exception for rate limiting

### 3. Infrastructure Layer

**Migrations** (`database/migrations/`)
- 8 tables with proper indexes and foreign keys
- Soft deletes where appropriate
- Counter cache columns for performance

**Factories** (`database/factories/`)
- Realistic test data generation
- Custom states for different scenarios

## Database Schema

### Core Tables

**pets**
- UUID for public routing
- Species enum
- Birth/death dates with age calculation
- Dedication and story fields
- Owner information (optional)
- Publishing workflow (moderation)
- Counter caches: hearts_count, candles_count

**pet_photos**
- Multiple photos per pet
- Primary photo flag
- Ordering system
- Storage disk configuration

**heart_reactions**
- One heart per IP per pet (unique constraint)
- User agent tracking

**virtual_candles**
- Optional expiration
- Optional lit_by_name and message
- Scopes for active/expired candles

**services**
- Configurable pet funeral services
- Slug-based routing
- Features as JSON
- Pricing information
- SEO fields

**posts**
- Blog articles
- Author relationship
- Publishing workflow
- SEO fields

**contacts**
- Contact form submissions
- Read/replied tracking
- IP and user agent logging

**bookings**
- Service requests
- Pet and customer information
- Status workflow (Pending → Confirmed → InProgress → Completed)
- Date/time preferences

## Key Design Patterns

### 1. Action Pattern
Single-responsibility classes that perform one specific operation.

```php
$action = new CreatePetMemorialAction();
$pet = $action->execute($data);
```

### 2. Service Pattern
Orchestrate multiple actions and handle complex workflows.

```php
$service = new PetMemorialService($createAction, $publishAction);
$pet = $service->createMemorial($data, $photos);
```

### 3. DTO Pattern
Type-safe data transfer between layers.

```php
$data = PetMemorialData::from($request->validated());
$pet = $action->execute($data);
```

### 4. Repository Pattern (via Eloquent)
Models act as repositories with scopes:

```php
Pet::published()->bySpecies(PetSpecies::Dog)->get();
```

## Code Quality

### PHPStan Level 7
All code passes PHPStan at the highest level with:
- Full type annotations
- Generic type hints for collections
- PHPDoc for complex types

### Laravel Pint
Strict coding standards with:
- `declare(strict_types=1)` everywhere
- Ordered class elements
- Strict comparisons
- Global namespace imports

### Pest 4
Testing framework with:
- Arrange/Act/Assert pattern
- Browser testing with Playwright
- Feature tests preferred over unit tests

## Rate Limiting Strategy

**Hearts**: 1 per IP per pet (permanent via unique constraint)

**Candles**: 3 per hour per IP (via Laravel RateLimiter)

## Performance Optimizations

1. **Counter Caches**: hearts_count, candles_count
2. **Database Indexes**: Composite indexes on frequently queried columns
3. **Eager Loading**: Prevent N+1 queries with relationships
4. **Route Keys**: UUID for pets, slug for services/posts

## Security Considerations

1. **Mass Assignment Protection**: Explicit $fillable arrays
2. **SQL Injection**: Eloquent ORM with prepared statements
3. **XSS Protection**: Laravel's automatic escaping in Blade
4. **CSRF Protection**: Built-in Laravel middleware
5. **Rate Limiting**: Prevent spam on reactions and forms
6. **IP Tracking**: Audit trail for reactions and contacts

## Future Enhancements

### Authentication & Authorization
- User registration for pet owners
- Self-service memorial management
- Policies for authorization

### Notifications
- Email notifications for bookings
- SMS reminders
- Admin alerts for new submissions

### Payments
- Online payment integration
- Service pricing calculator
- Invoice generation

### Multi-language
- Italian (current)
- English translation support
- `spatie/laravel-translatable` for content

## Development Workflow

1. **Migration**: Define database structure
2. **Model**: Create Eloquent model with relationships
3. **Factory**: Generate test data
4. **DTO**: Define data structure
5. **Action**: Implement single operation
6. **Service**: Orchestrate actions
7. **Test**: Write feature tests
8. **Filament Resource**: Admin interface
9. **Livewire Component**: Public interface

## Testing Strategy

**Feature Tests** (Primary)
- Test complete user flows
- Use factories for data setup
- Assert database state and responses

**Browser Tests** (E2E)
- Test real user interactions
- Verify JavaScript functionality
- Test on multiple browsers

**Unit Tests** (Minimal)
- Only for complex algorithms
- Test pure functions
- No database interactions

## Conventions

- **Strict Types**: Always `declare(strict_types=1)`
- **Type Hints**: All parameters and return types
- **Readonly DTOs**: Immutable data objects
- **Constructor Promotion**: Modern PHP 8 syntax
- **Named Arguments**: For clarity in factory methods
- **Early Returns**: Avoid deep nesting
- **Single Responsibility**: One class, one purpose

## File Organization

```
app/
├── Actions/          # Single-purpose operations
│   ├── Pets/
│   ├── Reactions/
│   ├── Bookings/
│   └── Contacts/
├── Data/             # DTOs
├── Enums/            # Type-safe enumerations
├── Exceptions/       # Custom exceptions
├── Models/           # Eloquent models
└── Services/         # Business logic orchestration
```

This architecture ensures:
- ✅ Maintainability: Clear separation of concerns
- ✅ Testability: Isolated, mockable components
- ✅ Type Safety: PHPStan Level 7 compliance
- ✅ Scalability: Easy to extend with new features
- ✅ Readability: Self-documenting code structure
