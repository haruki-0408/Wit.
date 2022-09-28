@extends('layouts.app')

@section('content')
    @component('wit.home-modals')
    @endcomponent
    <div class="card border-0 overflow-auto h-100 w-100 pt-5">
        <div class="card-body p-1">
            <div class="card-title col-12 p-2 text-center">
                <p class="fw-bold">
                    Wit.のご利用誠にありがとうございました。<br>
                    ご不明点、ご意見ございましたら下記フォームにてお問い合わせ内容をご送信ください。
                </p>
            </div>

            <div class="p-3 row justify-content-center">
                <div class="form-box-table text-start col-md-12; col-lg-6">
                    <p class="hg fw-bold m-0">お問い合わせ内容</p>

                    @if (session('inquiry'))
                        <p>お問い合わせ内容が適切に送信されました</p>
                    @else
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
                    @endif
                </div>
            </div>

            <div class="card-text row justify-content-center">
                <div class="col-2 text-end">
                    <svg width="50" height="50" fill="red" class="bi bi-exclamation-triangle p-0 m-0"
                        viewBox="0 0 16 16">
                        <path
                            d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z" />
                        <path
                            d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z" />
                    </svg>
                </div>
                <div class="col-9 d-flex align-items-center">
                    <p class="p-0 m-0 text-danger">
                        アカウントを削除するとユーザ情報、過去に投稿したルーム、発言がすべて削除され、元には戻せません。
                        ご注意ください
                    </p>
                </div>

                <div class="text-center pt-3">
                    <button type="button" data-bs-toggle="modal"
                        data-bs-target="#Delete-Account-Modal"class="btn btn-outline-danger">Account Delete</button>
                </div>
            </div>



        </div>

    </div>



    </div>
@endsection



@component('wit.footer')
@endcomponent
