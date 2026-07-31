<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class TicketManager extends Component
{
    use WithPagination;

    // Search, Filter, Sort
    public $search = '';
    public $statusFilter = '';
    public $priorityFilter = '';
    public $categoryFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Modals
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;

    // Form attributes
    public $ticketIdBeingEdited = null;
    public $ticketIdBeingDeleted = null;
    public $title = '';
    public $description = '';
    public $category_id = '';
    public $priority = 'medium';
    public $status = 'open';
    public $user_id = '';
    public $assigned_to = null;

    protected function rules()
    {
        return [
            'title' => 'required|string|min:4|max:255',
            'description' => 'required|string|min:5',
            'category_id' => 'required|exists:categories,id',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'user_id' => 'required|exists:users,id',
            'assigned_to' => 'nullable|exists:users,id',
        ];
    }

    public function mount()
    {
        if (auth()->check()) {
            $this->user_id = auth()->id();
        } else {
            $firstUser = User::first();
            if ($firstUser) {
                $this->user_id = $firstUser->id;
            }
        }

        $firstCategory = Category::first();
        if ($firstCategory) {
            $this->category_id = $firstCategory->id;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function updateTicketStatus($ticketId, $newStatus)
    {
        $user = auth()->user();
        $ticket = Ticket::findOrFail($ticketId);

        if ($user && $user->role === 'user') {
            $msg = __('Akses Ditolak. Pemohon tiket tidak dapat mengubah status tiket.');
            $this->dispatch('notify', message: $msg, type: 'danger');
            return;
        }

        if ($user && $user->role === 'technician' && $ticket->assigned_to !== $user->id) {
            $msg = __('Akses Ditolak. Anda hanya dapat mengerjakan tiket yang ditugaskan kepada Anda.');
            $this->dispatch('notify', message: $msg, type: 'danger');
            return;
        }

        $ticket->status = $newStatus;
        if ($newStatus === 'resolved') {
            $ticket->resolved_at = now();
        }
        $ticket->save();

        $msg = "Status tiket {$ticket->ticket_number} berhasil diperbarui!";
        session()->flash('message', $msg);
        $this->dispatch('notify', message: $msg, type: 'success');
    }

    public function assignTechnician($ticketId, $technicianId)
    {
        if (!auth()->user()?->isAdmin()) {
            $msg = __('Akses Ditolak. Hanya Admin yang dapat menugaskan teknisi pada tiket.');
            $this->dispatch('notify', message: $msg, type: 'danger');
            return;
        }

        $ticket = Ticket::findOrFail($ticketId);
        $ticket->assigned_to = $technicianId ?: null;
        if ($ticket->status === 'open' && $technicianId) {
            $ticket->status = 'in_progress';
        }
        $ticket->save();

        $msg = "Teknisi berhasil ditugaskan pada tiket {$ticket->ticket_number}!";
        session()->flash('message', $msg);
        $this->dispatch('notify', message: $msg, type: 'success');
    }

    // CRUD: Add Ticket
    public function openCreateModal()
    {
        if (auth()->user()?->isTechnician()) {
            $msg = __('Akses Ditolak. Teknisi tidak memiliki akses untuk membuat tiket baru.');
            $this->dispatch('notify', message: $msg, type: 'danger');
            return;
        }

        $this->resetValidation();
        $this->reset(['title', 'description', 'ticketIdBeingEdited']);
        $this->user_id = auth()->id() ?: User::first()?->id;
        $this->priority = 'medium';
        $this->status = 'open';
        $this->assigned_to = null;
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
    }

    public function createTicket()
    {
        $user = auth()->user();
        if ($user && $user->isTechnician()) {
            $msg = __('Akses Ditolak. Teknisi tidak memiliki akses untuk membuat tiket baru.');
            $this->dispatch('notify', message: $msg, type: 'danger');
            return;
        }

        if ($user && $user->role === 'user') {
            $this->user_id = $user->id;
            $this->assigned_to = null;
            $this->status = 'open';
        }

        $this->validate();

        Ticket::create([
            'ticket_number' => Ticket::generateTicketNumber(),
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'priority' => $this->priority,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'assigned_to' => $this->assigned_to ?: null,
        ]);

        $this->showCreateModal = false;
        $msg = __('Tiket support baru berhasil dibuat!');
        session()->flash('message', $msg);
        $this->dispatch('notify', message: $msg, type: 'success');
    }

    // CRUD: Edit Ticket
    public function openEditModal($ticketId)
    {
        $user = auth()->user();
        $ticket = Ticket::findOrFail($ticketId);

        if ($user && $user->role === 'user') {
            $msg = __('Akses Ditolak. Pemohon tiket tidak dapat mengedit detail tiket secara langsung.');
            $this->dispatch('notify', message: $msg, type: 'danger');
            return;
        }

        if ($user && $user->role === 'technician' && $ticket->assigned_to !== $user->id) {
            $msg = __('Akses Ditolak. Anda hanya dapat mengerjakan tiket yang ditugaskan kepada Anda.');
            $this->dispatch('notify', message: $msg, type: 'danger');
            return;
        }

        $this->resetValidation();
        $this->ticketIdBeingEdited = $ticket->id;
        $this->title = $ticket->title;
        $this->description = $ticket->description;
        $this->category_id = $ticket->category_id;
        $this->priority = $ticket->priority;
        $this->status = $ticket->status;
        $this->user_id = $ticket->user_id;
        $this->assigned_to = $ticket->assigned_to;

        $this->showEditModal = true;
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
    }

    public function updateTicket()
    {
        $user = auth()->user();
        $ticket = Ticket::findOrFail($this->ticketIdBeingEdited);

        if ($user && $user->role === 'user') {
            $msg = __('Akses Ditolak. Pemohon tiket tidak dapat mengubah detail tiket.');
            $this->dispatch('notify', message: $msg, type: 'danger');
            return;
        }

        if ($user && $user->role === 'technician') {
            if ($ticket->assigned_to !== $user->id) {
                $msg = __('Akses Ditolak. Anda hanya dapat mengerjakan tiket yang ditugaskan kepada Anda.');
                $this->dispatch('notify', message: $msg, type: 'danger');
                return;
            }

            // Technician ONLY updates status
            $this->validate([
                'status' => 'required|in:open,in_progress,resolved,closed',
            ]);

            $ticket->update([
                'status' => $this->status,
                'resolved_at' => $this->status === 'resolved' ? now() : $ticket->resolved_at,
            ]);

            $this->showEditModal = false;
            $msg = "Status tiket {$ticket->ticket_number} berhasil diperbarui!";
            session()->flash('message', $msg);
            $this->dispatch('notify', message: $msg, type: 'success');
            return;
        }

        $this->validate();

        $ticket->update([
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'priority' => $this->priority,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'assigned_to' => $this->assigned_to ?: null,
        ]);

        $this->showEditModal = false;
        $msg = "Tiket {$ticket->ticket_number} berhasil diperbarui!";
        session()->flash('message', $msg);
        $this->dispatch('notify', message: $msg, type: 'success');
    }

    // CRUD: Delete Ticket
    public function openDeleteModal($ticketId)
    {
        if (!auth()->user()?->isAdmin()) {
            $msg = __('Akses Ditolak. Hanya Admin yang dapat menghapus tiket.');
            $this->dispatch('notify', message: $msg, type: 'danger');
            return;
        }

        $this->ticketIdBeingDeleted = $ticketId;
        $this->showDeleteModal = true;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
    }

    public function deleteTicket()
    {
        if (!auth()->user()?->isAdmin()) {
            abort(403, 'Akses Ditolak.');
        }

        $ticket = Ticket::findOrFail($this->ticketIdBeingDeleted);
        $ticketNum = $ticket->ticket_number;
        $ticket->delete();

        $this->showDeleteModal = false;
        $msg = "Tiket {$ticketNum} berhasil dihapus!";
        session()->flash('message', $msg);
        $this->dispatch('notify', message: $msg, type: 'danger');
    }

    public function render()
    {
        $user = auth()->user();
        $query = Ticket::with(['user', 'category', 'technician']);

        // Role-based Scoping
        if ($user) {
            if ($user->role === 'technician') {
                $query->where('assigned_to', $user->id);
            } elseif ($user->role === 'user') {
                $query->where('user_id', $user->id);
            }
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('ticket_number', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->priorityFilter) {
            $query->where('priority', $this->priorityFilter);
        }

        if ($this->categoryFilter) {
            $query->where('category_id', $this->categoryFilter);
        }

        $query->orderBy($this->sortBy, $this->sortDirection);

        $tickets = $query->paginate(10);
        $categories = Category::all();
        $technicians = User::whereIn('role', ['admin', 'technician'])->get();
        $users = User::all();

        return view('livewire.ticket-manager', [
            'tickets' => $tickets,
            'categories' => $categories,
            'technicians' => $technicians,
            'users' => $users,
        ])->layout('components.layouts.app');
    }
}
