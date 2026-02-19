@extends('partials.layouts.master')

@section('title', 'Edit Hidden Gem | MyTripTaylor Admin')
@section('title-sub', 'Hidden Gems')
@section('pagetitle', 'Edit Hidden Gem')

@section('content')

<div class="row">
    <div class="col-lg-8 col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Gem: {{ $cityGem->name }}</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('admin.city-gems.update', $cityGem) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="island_id" class="form-label">Island <span class="text-danger">*</span></label>
                        <select class="form-select" id="island_id" onchange="filterCities(this.value)">
                            <option value="">Select Island...</option>
                            @foreach($islands as $island)
                            <option value="{{ $island->id }}" {{ old('island_id', $cityGem->city->island_id) == $island->id ? 'selected' : '' }}>{{ $island->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="city_id" class="form-label">City <span class="text-danger">*</span></label>
                        <select class="form-select @error('city_id') is-invalid @enderror" id="city_id" name="city_id" required>
                            <option value="">Select City...</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $cityGem->name) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $cityGem->description) }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label for="tip" class="form-label">Tip</label>
                        <input type="text" class="form-control @error('tip') is-invalid @enderror" id="tip" name="tip" value="{{ old('tip', $cityGem->tip) }}">
                    </div>
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary">Update Gem</button>
                        <a href="{{ route('admin.city-gems.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const citiesByIsland = @json($islands->mapWithKeys(fn ($i) => [$i->id => $i->cities->map(fn ($c) => ['id' => $c->id, 'name' => $c->name])]));
    const oldCityId = {{ old('city_id', $cityGem->city_id) }};

    function filterCities(islandId) {
        const select = document.getElementById('city_id');
        select.innerHTML = '<option value="">Select City...</option>';
        if (islandId && citiesByIsland[islandId]) {
            citiesByIsland[islandId].forEach(city => {
                const opt = document.createElement('option');
                opt.value = city.id;
                opt.textContent = city.name;
                if (city.id == oldCityId) opt.selected = true;
                select.appendChild(opt);
            });
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const islandSelect = document.getElementById('island_id');
        if (islandSelect.value) filterCities(islandSelect.value);
    });
</script>

@endsection
