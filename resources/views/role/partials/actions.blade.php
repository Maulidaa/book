@if(auth()->check() && auth()->user()->role_id == 1 && $requestUpdateRole->status == 'pending')
    <form action="{{ route('role.update', $requestUpdateRole->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('PUT')
        <button type="submit" name="status" value="approved" class="btn btn-success btn-sm">Approve</button>
        <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm">Reject</button>
    </form>
@else
    <span class="text-muted">-</span>
@endif