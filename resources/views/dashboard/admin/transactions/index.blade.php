@extends('dashboard.admin.layouts.app')

@section('title', 'Room')

@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Transacions Tables</h4>
            <div class="flex-shrink-0">
            </div>
        </div><!-- end card header -->  
        <div class="card-body">
            <!-- <p class="text-muted">Use <code>table-responsive</code> class to make any table responsive across all viewports. Responsive tables allow tables to be scrolled horizontally with ease.</p> -->
            <div class="live-preview">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">User</th>
                                <th scope="col">Kamar</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Period</th>
                                <th scope="col">Status</th>
                                <th scope="col">Payment Type</th>
                                <th scope="col">Paid At</th>
                                <th scope="col">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $key => $transaction)
                                <tr>
                                    <td><a href="#" class="fw-medium">{{ ($transactions->currentPage() - 1) * $transactions->perPage() + $key + 1 }}</a></td>
                                    
                                    <td>
                                        <span class="fw-medium text-primary">{{ $transaction->order_id }}</span>
                                    </td>
                                    
                                    <td>
                                        @if($transaction->user)
                                            <div class="d-flex flex-column">
                                                <span class="text-primary fw-medium">{{ $transaction->user->name }}</span>
                                                <small class="text-muted">{{ $transaction->user->email }}</small>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        @if($transaction->user && $transaction->user->room)
                                            <span class="badge badge-soft-info">{{ $transaction->user->room->name }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <span class="fw-medium">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</span>
                                    </td>
                                    
                                    <td>
                                        <span class="fw-medium">{{ \Carbon\Carbon::parse($transaction->meter->period)->format('F Y') }}</span>
                                    </td>
                                    
                                    <td>
                                        @switch($transaction->status)
                                            @case('pending')
                                                <span class="badge badge-soft-warning">
                                                    <i class="ri-time-line fs-12 align-middle"></i> Pending
                                                </span>
                                                @break
                                            @case('success')
                                                <span class="badge badge-soft-success">
                                                    <i class="ri-checkbox-circle-line fs-12 align-middle"></i> Success
                                                </span>
                                                @break
                                            @case('failed')
                                                <span class="badge badge-soft-danger">
                                                    <i class="ri-close-circle-line fs-12 align-middle"></i> Failed
                                                </span>
                                                @break
                                            @case('expired')
                                                <span class="badge badge-soft-secondary">
                                                    <i class="ri-time-line fs-12 align-middle"></i> Expired
                                                </span>
                                                @break
                                            @case('cancelled')
                                                <span class="badge badge-soft-dark">
                                                    <i class="ri-close-line fs-12 align-middle"></i> Cancelled
                                                </span>
                                                @break
                                            @case('challenge')
                                                <span class="badge badge-soft-info">
                                                    <i class="ri-question-line fs-12 align-middle"></i> Challenge
                                                </span>
                                                @break
                                            @default
                                                <span class="badge badge-soft-secondary">{{ ucfirst($transaction->status) }}</span>
                                        @endswitch
                                    </td>
                                    
                                    <td>
                                        @if($transaction->payment_type)
                                            <span class="text-muted">{{ ucfirst(str_replace('_', ' ', $transaction->payment_type)) }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        @if($transaction->paid_at)
                                            <div class="d-flex flex-column">
                                                <span class="fw-medium">{{ \Carbon\Carbon::parse($transaction->paid_at)->format('d M Y') }}</span>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($transaction->paid_at)->format('H:i') }}</small>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-medium">{{ $transaction->created_at->format('d M Y') }}</span>
                                            <small class="text-muted">{{ $transaction->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- end table responsive -->

                <div class="d-flex justify-content-end mt-3">
                    {{ $transactions->links('dashboard.admin.layouts.pagination') }}
                </div>

                
                
            </div>
        </div><!-- end card-body -->
    </div>
</div>

@endsection
