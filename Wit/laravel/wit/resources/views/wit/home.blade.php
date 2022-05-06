@extends('layouts.app')

@section('home-only')
    <input id="search-keyword" class="form-control mx-1" type="text">
    <div class="btn-group">
        <button id="search-button" class="border-0 bg-light" type="submit"> <i
                class="btn btn-primary bi bi-search"></i></button>

        <button class="border-0 bg-light dsropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"><i
                class="btn btn-primary bi bi-filter-square"></i></button>
        <ul class="dropdown-menu p-2 bg-light" aria-labelledby="dropdown">
            <table width=200>
                <tr class="dropdown-item">
                    <th><input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioUser"></th>
                    <th>
                        <label class="form-check-label" for="flexRadioUser">
                            <i class="bi bi-people-fill mx-2 "></i>
                            ユーザー検索
                        </label>
                    </th>
                </tr>
                <tr class="dropdown-item">
                    <th><input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioRoom" checked>
                    </th>
                    <th>
                        <label class="form-check-label" for="flexRadioRoom">
                            <i class="bi bi-house-fill mx-2 "></i>
                            ルーム検索
                        </label>
                    </th>
                </tr>

                <td> <hr class="dropdown-divider"></td>

                <tr class="dropdown-item">
                    <td>
                        <input class="form-check-input" type="checkbox" name="flexCheckImage" id="flexCheckImage">
                    </td>
                    <td>
                        <label class="form-check-label" for="flexCheckImage">
                            画像なし
                        </label>
                    </td>
                </tr>
                <tr class="dropdown-item">
                    <td>
                        <input class="form-check-input" type="checkbox" name="flexCheckTag" id="flexCheckTag">
                    </td>
                    <td>
                        <label class="form-check-label" for="flexCheckTag">
                            タグなし
                        </label>
                    </td>
                </tr>
                <tr class="dropdown-item">
                    <td>
                        <input class="form-check-input" type="checkbox" name="flexCheckPassword" id="flexCheckPassword">
                    </td>
                    <td>
                        <label class="form-check-label" for="flexCheckPassword">
                            鍵あり
                        </label>
                    </td>

                </tr>
                <tr class="dropdown-item">
                    <th>
                        <input class="form-check-input" type="checkbox" name="flexCheckAnswer" id="flexCheckAnswer">
                    </th>
                    <td>
                        <label class="form-check-label" for="flexCheckAnswer">
                            回答済み
                        </label>
                    </td>
                </tr>

            </table>
            <li><hr class="dropdown-divider"></li>
            <div class="btn-group-vertical w-100">
                <button id="new-row" type="button" class="btn btn-outline-primary">新規投稿順</button>
                <button id="old-row" type="button" class="btn btn-outline-primary">古い順</button>
                <button id="chat-row" type="button" class="btn btn-outline-primary">チャット数が多い順</button>
            </div>
        </ul>
    </div>
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
