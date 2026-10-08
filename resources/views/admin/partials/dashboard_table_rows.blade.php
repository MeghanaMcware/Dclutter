@forelse($recentRequests as $req)
<tr>
    <td class="fw-bold">{{ $req->request_number }}</td>
    <td>{{ $req->applicant_name ?: 'Citizen User' }}</td>
    <td>
        @if(is_array($req->category_ids))
            {{ implode(', ', $req->category_ids) }}
        @else
            {{ $req->category_ids ?: 'N/A' }}
        @endif
    </td>
    <td>
        @if(is_array($req->subcategory_ids))
            {{ implode(', ', $req->subcategory_ids) }}
        @else
            {{ $req->subcategory_ids ?: 'N/A' }}
        @endif
    </td>
    <td>
        @php
            $st = strtolower($req->status ?? 'pending');
            $badgeClass = match($st) {
                'assigned', 'scheduled' => 'status-assigned',
                'rescheduled', 'not_available' => 'status-in-progress',
                'picked_up' => 'status-in-progress',
                'dumped', 'completed' => 'status-completed',
                'rejected', 'closed' => 'status-rejected',
                default => 'status-pending',
            };
            $statusLabel = match($st) {
                'pending' => 'Pending',
                'assigned', 'scheduled' => 'Assigned',
                'rescheduled', 'not_available' => 'Rescheduled',
                'picked_up' => 'Picked Up',
                'dumped', 'completed' => 'Dumped',
                'rejected' => 'Rejected',
                'closed' => 'Closed',
                default => ucfirst(str_replace('_', ' ', $st)),
            };
        @endphp
        <span class="status-badge {{ $badgeClass }}">{{ $statusLabel }}</span>
    </td>
    <td>{{ $req->created_at ? $req->created_at->format('d M, h:i A') : 'N/A' }}</td>
    <td class="text-center">
        <a href="{{ route('admin.requests.show', $req->id) }}" class="btn btn-sm btn-primary">View</a>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-muted py-4 text-center">No waste requests found.</td>
</tr>
@endforelse
