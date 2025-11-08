<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Enums\PetSpecies;
use App\Models\Pet;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class MemorialGallery extends Component
{
    use WithPagination;

    public string $search = '';

    public ?PetSpecies $species = null;

    /**
     * Get available species with published memorials
     *
     * @return array<int, PetSpecies>
     */
    #[Computed]
    public function availableSpecies(): array
    {
        return Pet::query()
            ->published()
            ->select('species')
            ->distinct()
            ->pluck('species')
            ->filter()
            ->sort()
            ->values()
            ->all();
    }

    /**
     * Get filtered and paginated memorials
     *
     * @return LengthAwarePaginator<int, Pet>
     */
    #[Computed]
    public function memorials(): LengthAwarePaginator
    {
        return Pet::query()
            ->published()
            ->with(['photos'])
            ->when($this->search, function ($query): void {
                $query->where(function ($q): void {
                    $q->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('dedication', 'like', '%'.$this->search.'%')
                        ->orWhere('story', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->species, function ($query): void {
                $query->bySpecies($this->species);
            })
            ->orderBy('published_at', 'desc')
            ->paginate(12);
    }

    /**
     * Reset pagination when search changes
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Filter by species
     */
    public function filterBySpecies(?PetSpecies $species): void
    {
        $this->species = $species;
        $this->resetPage();
    }

    public function render(): View
    {
        return view('livewire.memorial-gallery')
            ->layout('layouts.app');
    }
}
