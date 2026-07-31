<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoryManager extends Component
{
    public $name = '';
    public $description = '';
    public $icon = 'cpu-chip';

    public $showDeleteModal = false;
    public $categoryIdBeingDeleted = null;

    protected $rules = [
        'name' => 'required|string|min:3|max:100',
        'description' => 'nullable|string|max:255',
    ];

    public function mount()
    {
        if (!auth()->user()?->isAdmin()) {
            abort(403, 'Akses Ditolak. Hanya Admin yang memiliki akses ke Kategori Layanan.');
        }
    }

    public function createCategory()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'icon' => $this->icon,
            'description' => $this->description,
        ]);

        $this->name = '';
        $this->description = '';

        $msg = __('Kategori layanan baru berhasil dibuat!');
        session()->flash('message', $msg);
        $this->dispatch('notify', message: $msg, type: 'success');
    }

    public function openDeleteModal($id)
    {
        $this->categoryIdBeingDeleted = $id;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->categoryIdBeingDeleted = null;
    }

    public function deleteCategory()
    {
        if (!$this->categoryIdBeingDeleted) {
            return;
        }

        $cat = Category::findOrFail($this->categoryIdBeingDeleted);
        $catName = $cat->name;
        $cat->delete();

        $this->showDeleteModal = false;
        $this->categoryIdBeingDeleted = null;

        $msg = __('Kategori ') . "'{$catName}' " . __('berhasil dihapus!');
        session()->flash('message', $msg);
        $this->dispatch('notify', message: $msg, type: 'danger');
    }

    public function render()
    {
        $categories = Category::withCount('tickets')->get();
        return view('livewire.category-manager', [
            'categories' => $categories,
        ])->layout('components.layouts.app');
    }
}
