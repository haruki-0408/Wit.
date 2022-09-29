@extends('layouts.app')

@section('content')
    @component('wit.home-modals')
    @endcomponent
    <div class="container p-3 overflow-auto" style="height:80%;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-light">お問い合わせ</div>

                    <div class="card-body p-2">
                        @if (isset($inquiry_sentence))
                            <form method="post" action="/home/profile/inquiry/send">
                                @csrf
                                <p id="Head-sentence" style="font-size:14px;">お問い合わせ内容はこちらでよろしいでしょうか</p>
                                <hr>
                                <p class="fw-bold pb-2">ご登録メールアドレス:{{$email}}</p>
                                <textarea class="pt-2 w-100 d-flex justify-content-center bg-light" rows="7" name="inquiry_sentence" autocorrect="off" autocapitalize="off" readonly>{{ $inquiry_sentence }}</textarea>
                                <p class="text-danger fw-bold pt-2">※ご質問の場合回答はご登録されているメールアドレス宛に返信されます。ご了承下さい</p>
                                <div class="text-end">
                                    <button type="button" onclick="history.back(-1);return false;" class="mt-3 btn btn-outline-primary">Back</button>
                                    <button type="submit" class="mt-3 btn btn-outline-primary">Send</button>
                                </div>
                            </form>
                        @else
                            <form method="post" action="/home/profile/inquiry/confirm">
                                @csrf
                                <p id="Head-sentence" style="font-size:14px;">
                                    Wit.のご利用ありがとうございます。ご不明な点やご要望等ございましたらお気軽に下記フォームにて投稿ください。</p>
                                <textarea id="Inquiry" class="w-100 d-flex p-1 justify-content-center bg-light" rows="7" name="inquiry_sentence"
                                    autocorrect="off" autocapitalize="off" placeholder=""></textarea>
                                @error('inquiry_sentence')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <p class="text-danger fw-bold pt-2">※ご質問の場合回答はご登録されているメールアドレス宛に返信されます。ご了承下さい</p>
                                <div class="text-end">
                                    <button type="submit" class="mt-3 btn btn-outline-primary">Confirm</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@component('wit.footer')
@endcomponent
