@if(auth()->check() && auth()->user()->role_id == 1)
    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-info btn-sm mr-1">
        <i ></i> Edit
    </a>
    <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
            <i ></i> Delete
        </button>
    </form>
@else
    <span class="text-muted">-</span>
@endif