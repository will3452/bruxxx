<div wire:poll.120s>
    <div  class="nav-item dropdown no-arrow mx-1" >
        <a  class="nav-link dropdown-toggle" href="{{ route('inbox.index') }}" id="messagesDropdown"  >
            {{-- <a  class="nav-link dropdown-toggle" href="#" id="messagesDropdown"  > --}}
            Messages
            <!-- Counter - Messages -->
            @if (count(auth()->user()->unread_messages))
                <span class="badge badge-danger badge-counter">{{ count(auth()->user()->unread_messages) }}</span>
            @endif
        </a>
    </div>
</div>