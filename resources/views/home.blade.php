@extends('main')

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (!empty($message))
        <div class="alert alert-danger">
            <strong>Whoops!</strong>
            <p>{{$message}}</p>
        </div>
    @endif

    <div class="row">
        <form action="{{ route('process.file') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col">
                <div class="form-group">
                    <label for="file">Enviar arquivo com casos</label>
                    <input type="file" name="file" class="form-control-file" id="file">
                </div>
            </div>

            <div class="col">
                <button type="submit" class="btn btn-success">Upload</button>
            </div>
        </form>
    </div>

    @if (!empty($results))
        <div class="row justify-content-md-center">
            <div class="col-2">
                <div class="alert alert-success">
                    <strong>Resultados</strong>
                    <ul>
                        @foreach ($results as $result)
                            <li>{{ $result }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
@endsection
