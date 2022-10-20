@extends('layouts.app')


@section('content')
    <div class="container p-3" style="height: 100vh;">
        <div class="row justify-content-center h-100">
            <div class="col-md-8 h-100">
                <div class="card border-success">
                    <div class="card-header bg-success text-light">アカウント仮登録</div>

                    <div class="card-body">
                        <form method="post" action="/register/before">
                            @csrf
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">メールアドレス</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    @if (session('register_error_message'))
                                        <span class="text-danger">
                                            <strong>{{ session('register_error_message') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4 text-end">
                                    <button type="submit" class="btn btn-outline-success">
                                        Send
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card text-center" style="height:59%">
                    <div class="card-header text-muted" style="font-size:0.5em">
                        登録した時点で下記規約に同意したものと見なします。
                    </div>
                    <div class="card-body overflow-scroll text-start" style="font-size:0.6em;">
                        @component('wit.terms')
                        @endcomponent
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
