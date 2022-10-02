@extends('layouts.app')


@section('content')
    <div class="container p-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-light">メールアドレス変更</div>

                    <div class="card-body">
                        <form method="post" action="/home/profile/settings/changeEmail">
                            @csrf
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">メールアドレス</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" name="email" class="form-control"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <div class="text-danger">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror

                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4 text-end">
                                    <button type="submit" class="btn btn-outline-primary">
                                        Send
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
