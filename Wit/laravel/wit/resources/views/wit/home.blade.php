@extends('layouts.app')

@section('home-only')
    <form action="/home/search" method="post" class="m-0 d-flex align-items-center mx-2">
        @csrf
        <input name="keyword" class="form-control mx-1" type="text">
        <div class="btn-group">
            <button id="remove" class="border-0 bg-light" type="submit"> <i class="btn btn-primary bi bi-search"></i></button>

            <button class="border-0 bg-light dsropdown-toggle" type="button" data-bs-toggle="dropdown"><i
                    class="btn btn-primary bi bi-filter-square"></i></button>
            <ul class="dropdown-menu p-2 bg-light ">
                <table width=200>
                    <tr>
                        <th><input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioUser"></th>
                        <th class="form-check-label" for="flexRadioUser">
                            ユーザー検索
                        </th>
                    </tr>
                    <tr>
                        <th><input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioRoom"
                                checked></th>
                        <th class="form-check-label" for="flexRadioRoom">
                            ルーム検索
                        </th>
                    </tr>
                </table>

                <div>
                    <button type="button" class="btn btn-outline-primary">新規投稿順</button>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-primary">古い順</button>
                </div>
                <div>
                    <button type="button" class="btn btn-outline-primary">チャット数が多い順</button>
                </div>
                <table width=200>
                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadio1">
                        </td>
                        <td class="form-check-label" for="flexRadio1">
                            画像なし
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadio2">
                        </td>
                        <td class="form-check-label" for="flexRadio2">
                            タグなし
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadio3">
                        </td>
                        <td class="form-check-label" for="flexRadio3">
                            鍵あり
                        </td>

                    </tr>
                    <tr>
                        <th>
                            <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadio4">
                        </th>
                        <td class="form-check-label" for="flexRadio4">
                            回答済み
                        </td>
                    </tr>
                </table>
            </ul>
        </div>
    </form>
@endsection

@component('wit.createRoom')
@endcomponent

@component('wit.home-modals')
@endcomponent


@section('content')
    <div id="home-content" class="container-fluid h-100">
        <div class="row h-100">
            @component('wit.left')
            @endcomponent
            @component('wit.room-content')
                @slot('user')
                @endslot
            @endcomponent
            @component('wit.right')
            @endcomponent

        </div>
    </div>
    <div id="CreateRoomButton">
        <button type="button" class="d-lg-none align-items-center btn-room-create"
            style="position:fixed; right:40px; bottom:40px; z-index:5;" data-bs-toggle="modal"
            data-bs-target="#CreateRoomForm"><span>+</span></button>
        <button type="button" class="d-none d-lg-block align-items-center btn-room-create"
            style="position:fixed; right:400px; bottom:40px; z-index:5;" data-bs-toggle="modal"
            data-bs-target="#CreateRoomForm"><span>+</span></button>
    </div>
@endsection

@component('wit.footer')
@endcomponent
