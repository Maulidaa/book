@if(auth()->check() && auth()->user()->role_id == 1)
    <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
    </form>
@else
    <span class="text-muted">-</span>
@endif