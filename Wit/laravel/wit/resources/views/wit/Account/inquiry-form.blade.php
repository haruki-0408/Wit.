@extends('layouts.app')

@section('content')
    @component('wit.home-modals')
    @endcomponent
    <div class="card col-8 border-0 h-100 pt-5">
        <div class="card-body p-1">
            <div class="card-title p-2 text-center">
                <p class="hg fw-bold m-0">お問い合わせ内容</p>
                <form method="post" action="/home/profile/inquiry">
                    @csrf
                    <textarea id="Inquiry" class="w-100 bg-light" rows="5" name="inquiry_sentence" autocorrect="off"
                        autocapitalize="off" placeholder=""></textarea>
                    @error('inquiry_sentence')
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="text-end">
                        <button type="submit" class="mt-2 btn btn-outline-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    </div>
@endsection



@component('wit.footer')
@endcomponent
