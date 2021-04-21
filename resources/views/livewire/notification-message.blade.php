<li wire:poll.5s class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="{{ route('inbox.index') }}" id="messagesDropdown"  >
        <i class="fas fa-envelope fa-fw"></i>
        <!-- Counter - Messages -->
        @if (count(auth()->user()->unread_messages))
            <span class="badge badge-danger badge-counter">{{ count(auth()->user()->unread_messages) }}</span>
        @endif
    </a>
</li>