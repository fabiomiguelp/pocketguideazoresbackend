@extends('partials.layouts.master')

@section('title', 'Trip Details | MyTripTaylor Admin')
@section('title-sub', 'Trips')
@section('pagetitle', 'Trip Details')

@section('content')

<div class="row">
    <div class="col-lg-8 col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Trip #{{ $trip->id }}</h4>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label fw-semibold">User</label>
                    <div class="d-flex align-items-center gap-3">
                        @if($trip->user->avatar)
                        <img src="{{ $trip->user->avatar }}" alt="{{ $trip->user->name }}" class="avatar-md rounded-pill">
                        @else
                        <div class="avatar-md rounded-pill bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-semibold">
                            {{ strtoupper(substr($trip->user->name, 0, 2)) }}
                        </div>
                        @endif
                        <div>
                            <h6 class="mb-1">{{ $trip->user->name }}</h6>
                            <p class="fs-12 mb-0 text-muted">{{ $trip->user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Island</label>
                    <p><span class="badge bg-primary-subtle text-primary fs-13 px-3 py-2">{{ $trip->island->name }}</span></p>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Hotel Location (City)</label>
                    <p>{{ $trip->city->name }}</p>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Trip Categories</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($trip->categories as $category)
                        <span class="badge bg-info-subtle text-info fs-13 px-3 py-2">{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Budget Level</label>
                    <p>
                        <span class="badge bg-warning-subtle text-warning fs-13 px-3 py-2">
                            {{ $trip->budgetLevel->name }} ({{ $trip->budgetLevel->min_budget }}{{ $trip->budgetLevel->max_budget ? ' - ' . $trip->budgetLevel->max_budget : '+' }} EUR/day)
                        </span>
                    </p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Adults</label>
                        <p class="fs-16">{{ $trip->num_adults }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Children</label>
                        <p class="fs-16">{{ $trip->num_children }}</p>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Duration</label>
                        <p class="fs-16">{{ $trip->duration_days }} days</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Has Car</label>
                    <p>
                        @if($trip->has_car)
                        <span class="badge bg-success-subtle text-success fs-13 px-3 py-2">Yes</span>
                        @else
                        <span class="badge bg-secondary-subtle text-secondary fs-13 px-3 py-2">No</span>
                        @endif
                    </p>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Created At</label>
                    <p>{{ $trip->created_at->format('M d, Y \a\t H:i') }}</p>
                </div>

                <div class="d-flex gap-3">
                    <a href="{{ route('admin.trips.index') }}" class="btn btn-light">Back to List</a>
                    <form action="{{ route('admin.trips.destroy', $trip) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this trip?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Trip</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- AI Itinerary --}}
@if($trip->itinerary)
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="ri-robot-line me-2"></i>AI Itinerary: {{ $trip->itinerary['title'] ?? 'Generated Plan' }}
                </h4>
            </div>
            <div class="card-body">
                @if(!empty($trip->itinerary['summary']))
                <p class="text-muted mb-4">{{ $trip->itinerary['summary'] }}</p>
                @endif

                @if(!empty($trip->itinerary['estimated_total_cost']))
                <div class="mb-4">
                    <span class="badge bg-success fs-14 px-3 py-2">
                        <i class="ri-money-euro-circle-line me-1"></i>Custo Total Estimado: {{ $trip->itinerary['estimated_total_cost'] }}
                    </span>
                </div>
                @endif

                {{-- Day-by-day itinerary --}}
                @foreach($trip->itinerary['days'] ?? [] as $day)
                <div class="card border mb-3">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            Dia {{ $day['day'] }}: {{ $day['title'] ?? '' }}
                        </h5>
                    </div>
                    <div class="card-body">
                        @foreach(['morning' => 'Manhã', 'afternoon' => 'Tarde', 'evening' => 'Noite'] as $period => $label)
                        @if(!empty($day[$period]))
                        @php $activity = $day[$period]; @endphp
                        <div class="d-flex gap-3 mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                            <div class="flex-shrink-0">
                                <span class="badge {{ $period === 'morning' ? 'bg-warning' : ($period === 'afternoon' ? 'bg-primary' : 'bg-dark') }} px-2 py-1" style="min-width: 60px;">
                                    {{ $label }}
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    {{ $activity['activity'] ?? '' }}
                                    @if(!empty($activity['is_hidden_gem']))
                                    <span class="badge bg-danger-subtle text-danger ms-1">Hidden Gem</span>
                                    @endif
                                    @if(!empty($activity['partner']))
                                    <span class="badge bg-success-subtle text-success ms-1">Partner</span>
                                    @endif
                                </h6>
                                <p class="text-muted mb-1 fs-13">{{ $activity['description'] ?? '' }}</p>
                                <div class="d-flex flex-wrap gap-3 fs-12 text-muted">
                                    @if(!empty($activity['location']))
                                    <span><i class="ri-map-pin-line me-1"></i>{{ $activity['location'] }}</span>
                                    @endif
                                    @if(!empty($activity['duration']))
                                    <span><i class="ri-time-line me-1"></i>{{ $activity['duration'] }}</span>
                                    @endif
                                    @if(!empty($activity['estimated_cost']))
                                    <span><i class="ri-money-euro-circle-line me-1"></i>{{ $activity['estimated_cost'] }}</span>
                                    @endif
                                </div>
                                @if(!empty($activity['tip']))
                                <p class="fs-12 text-info mt-1 mb-0"><i class="ri-lightbulb-line me-1"></i>{{ $activity['tip'] }}</p>
                                @endif
                                @if(!empty($activity['partner']))
                                <p class="fs-12 text-success mt-1 mb-0">
                                    <i class="ri-phone-line me-1"></i>{{ $activity['partner']['contact'] ?? '' }}
                                    @if(!empty($activity['partner']['price']))
                                    | {{ $activity['partner']['price'] }}
                                    @endif
                                </p>
                                @endif
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @endforeach

                {{-- Partners included --}}
                @if(!empty($trip->itinerary['partners_included']))
                <div class="card border mt-3">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0"><i class="ri-hand-heart-line me-2"></i>Partners Included</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Contact</th>
                                        <th>Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trip->itinerary['partners_included'] as $partner)
                                    <tr>
                                        <td>{{ $partner['name'] ?? '' }}</td>
                                        <td>{{ $partner['price'] ?? '' }}</td>
                                        <td>{{ $partner['contact'] ?? '' }}</td>
                                        <td>
                                            @if(!empty($partner['link']))
                                            <a href="{{ $partner['link'] }}" target="_blank" class="text-primary">Visit</a>
                                            @else
                                            —
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                {{-- General tips --}}
                @if(!empty($trip->itinerary['tips']))
                <div class="card border mt-3">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0"><i class="ri-lightbulb-line me-2"></i>General Tips</h5>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            @foreach($trip->itinerary['tips'] as $tip)
                            <li class="mb-1">{{ $tip }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@else
<div class="row mt-4">
    <div class="col-lg-12">
        <div class="alert alert-warning">
            <i class="ri-robot-line me-2"></i>No AI itinerary generated for this trip.
        </div>
    </div>
</div>
@endif

@endsection
