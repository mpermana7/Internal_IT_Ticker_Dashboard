<?php

namespace App\Livewire;

use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\User;
use Livewire\Component;

class TicketDetail extends Component
{
    public Ticket $ticket;
    public $commentText = '';
    public $isInternalNote = false;
    public $selectedUserId = '';
    public $showStatusModal = false;
    public $pendingStatus = '';

    protected $rules = [
        'commentText' => 'required|string|min:2',
    ];

    public function mount($id)
    {
        $this->ticket = Ticket::with(['user', 'category', 'technician', 'comments.user'])->findOrFail($id);

        $user = auth()->user();
        if ($user) {
            if ($user->role === 'user' && $this->ticket->user_id !== $user->id) {
                abort(403, 'Akses Ditolak. Anda hanya dapat melihat dan memantau tiket yang Anda buat.');
            }
            if ($user->role === 'technician' && $this->ticket->assigned_to !== $user->id && $this->ticket->user_id !== $user->id) {
                abort(403, 'Akses Ditolak. Anda hanya dapat mengerjakan tiket yang ditugaskan kepada Anda.');
            }
        }

        $this->selectedUserId = auth()->id() ?: User::first()?->id;
    }

    public function addComment()
    {
        $user = auth()->user();
        $authorId = $user ? $user->id : ($this->selectedUserId ?: User::first()?->id);

        $this->validate([
            'commentText' => 'required|string|min:2',
        ]);

        TicketComment::create([
            'ticket_id' => $this->ticket->id,
            'user_id' => $authorId,
            'comment' => $this->commentText,
            'is_internal_note' => ($user && $user->role === 'user') ? false : $this->isInternalNote,
        ]);

        $this->commentText = '';
        $this->isInternalNote = false;
        $this->ticket->refresh();

        $msg = __('Catatan / aktivitas tiket berhasil ditambahkan!');
        session()->flash('message', $msg);
        $this->dispatch('notify', message: $msg, type: 'success');
    }

    public function confirmStatusChange($newStatus)
    {
        if ($this->ticket->status === $newStatus) {
            return;
        }

        $user = auth()->user();
        if ($user && $user->role === 'user') {
            $msg = __('Akses Ditolak. Pemohon tiket tidak dapat mengubah status tiket.');
            $this->dispatch('notify', message: $msg, type: 'danger');
            return;
        }

        if ($user && $user->role === 'technician' && $this->ticket->assigned_to !== $user->id) {
            $msg = __('Akses Ditolak. Anda hanya dapat mengubah status tiket yang ditugaskan kepada Anda.');
            $this->dispatch('notify', message: $msg, type: 'danger');
            return;
        }

        $this->pendingStatus = $newStatus;
        $this->showStatusModal = true;
    }

    public function cancelStatusChange()
    {
        $this->pendingStatus = '';
        $this->showStatusModal = false;
    }

    public function applyStatusChange()
    {
        if (!$this->pendingStatus) {
            return;
        }

        $user = auth()->user();
        if ($user && $user->role === 'user') {
            $msg = __('Akses Ditolak. Pemohon tiket tidak dapat mengubah status tiket.');
            $this->dispatch('notify', message: $msg, type: 'danger');
            return;
        }

        if ($user && $user->role === 'technician' && $this->ticket->assigned_to !== $user->id) {
            $msg = __('Akses Ditolak. Anda hanya dapat mengubah status tiket yang ditugaskan kepada Anda.');
            $this->dispatch('notify', message: $msg, type: 'danger');
            return;
        }

        $oldStatusLabel = $this->getStatusLabel($this->ticket->status);
        $newStatusLabel = $this->getStatusLabel($this->pendingStatus);

        $this->ticket->status = $this->pendingStatus;
        if ($this->pendingStatus === 'resolved') {
            $this->ticket->resolved_at = now();
        }
        $this->ticket->save();

        TicketComment::create([
            'ticket_id' => $this->ticket->id,
            'user_id' => auth()->id() ?: User::first()?->id,
            'comment' => 'Status tiket diperbarui dari ' . $oldStatusLabel . ' menjadi ' . $newStatusLabel . '.',
            'is_internal_note' => true,
        ]);

        $this->pendingStatus = '';
        $this->showStatusModal = false;
        $this->ticket->refresh();

        $msg = __('Status tiket berhasil diperbarui menjadi ') . $newStatusLabel . '!';
        session()->flash('message', $msg);
        $this->dispatch('notify', message: $msg, type: 'success');
    }

    public function getStatusLabel($statusKey)
    {
        return match ($statusKey) {
            'open' => __('Terbuka'),
            'in_progress' => __('Sedang Diproses'),
            'resolved' => __('Selesai'),
            'closed' => __('Ditutup'),
            default => ucfirst($statusKey),
        };
    }

    public function render()
    {
        $users = User::all();
        return view('livewire.ticket-detail', [
            'users' => $users,
        ])->layout('components.layouts.app');
    }
}
