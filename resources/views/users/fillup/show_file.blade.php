

    <h2>Uploaded Files for {{ ucfirst(str_replace('_', ' ', $type)) }}</h2>

    @if($files->isEmpty())
        <p>No files uploaded for this requirement.</p>
    @else
        <ul>
            @foreach($files as $file)
                <li>
                    <a href="{{ $file->file_path }}" target="_blank">{{ $file->file_name }}</a>
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
