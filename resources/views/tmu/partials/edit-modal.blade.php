<!-- resources/views/partials/edit-modal.blade.php -->
@foreach($violators as $violator)
<div class="modal fade" id="editModal{{ $violator->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $violator->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{ $violator->id }}">Edit Violator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('violators.update', $violator) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="plate_number_edit">Plate Number</label>
                        <input type="text" name="plate_number" id="plate_number_edit" 
                               class="form-control @error('plate_number') is-invalid @enderror" 
                               value="{{ old('plate_number', $violator->plate_number) }}">
                        @error('plate_number')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="violator_name_edit">Violator Name</label>
                        <input type="text" name="violator_name" id="violator_name_edit" 
                               class="form-control @error('violator_name') is-invalid @enderror" 
                               value="{{ old('violator_name', $violator->violator_name) }}">
                        @error('violator_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="violation_details_edit">Violation Details</label>
                        <input type="text" name="violation_details" id="violation_details_edit" 
                               class="form-control @error('violation_details') is-invalid @enderror" 
                               value="{{ old('violation_details', $violator->violation_details) }}">
                        @error('violation_details')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="fee_edit">Fee</label>
                        <input type="number" name="fee" id="fee_edit" 
                               class="form-control @error('fee') is-invalid @enderror" 
                               value="{{ old('fee', $violator->fee) }}">
                        @error('fee')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="violation_date_edit">Violation Date</label>
                        <input type="date" name="violation_date" id="violation_date_edit" 
                               class="form-control @error('violation_date') is-invalid @enderror" 
                               value="{{ old('violation_date', $violator->violation_date->format('Y-m-d')) }}">
                        @error('violation_date')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Violator</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach