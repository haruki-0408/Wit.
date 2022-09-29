@extends('layouts.app')

@section('content')
    @component('wit.home-modals')
    @endcomponent
    <div class="card border-0 overflow-auto h-100 w-100 pt-5">
        <div class="card-body p-1">
            <div class="card-title col-12 p-2 text-center">
                <p class="fw-bold">
                    Wit.のご利用誠にありがとうございました。<br>
                    ご不明点、ご意見ございましたら下記リンクからお問い合わせください。
                </p>

                <a class="d-flex align-items-center justify-content-center link-dark text-decoration-none" href="/home/profile/inquiry">
                    <svg width="16" height="16" fill="currentColor" class="bi bi-envelope-fill mx-2"
                        viewBox="0 0 16 16">
                        <path
                            d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z" />
                    </svg>
                    <span class="fs-4">Inquiry</span>
                </a>
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
