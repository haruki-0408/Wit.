@extends('layouts.app')

@section('home-only')
    <div class="btn-group">
        <select id="searchType" class="form-select-sm btn-outline-primary text-center" aria-label="searchType">
            <option value="keyword" selected>キーワード</option>
            <option value="id">ルームID</option>
            <option value="tag">タグ</option>
        </select>
        <input id="search-keyword" class="form-control mx-1" type="text">
    </div>
    <div class="btn-group">

        <button id="search-button" class="border-0 bg-light" type="submit"> <i
                class="btn btn-primary bi bi-search"></i></button>

        <button class="border-0 bg-light dsropdown-toggle" type="button" data-bs-toggle="dropdown"
            data-bs-auto-close="outside" aria-expanded="false"><i class="btn btn-primary bi bi-filter-square"></i></button>
        <ul class="dropdown-menu p-2 bg-light" aria-labelledby="dropdown">
            <table width=200>
                <tr class="dropdown-item">
                    <th><input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioUser"></th>
                    <th>
                        <label class="form-check-label" for="flexRadioUser">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-people-fill mx-2" viewBox="0 0 16 16">
                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                <path fill-rule="evenodd"
                                    d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
                                <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                            </svg>
                            ユーザー検索
                        </label>
                    </th>
                </tr>
                <tr class="dropdown-item">
                    <th><input class="form-check-input" type="radio" name="flexRadioDisabled" id="flexRadioRoom" checked>
                    </th>
                    <th>
                        <label class="form-check-label" for="flexRadioRoom">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-house-fill mx-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                                <path fill-rule="evenodd"
                                    d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                            </svg>
                            ルーム検索
                        </label>
                    </th>
                </tr>

                <td>
                    <hr class="dropdown-divider">
                </td>

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
            <li>
                <hr class="dropdown-divider">
            </li>
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
            <div id="Room-content" class="col-lg-6 col-md-8 col-sm-12 m-0 p-2">
                <ul id="Rooms" class="p-0 m-0 ">
                    @component('wit.room-content')
                        @slot('rooms', $rooms);
                    @endcomponent
                </ul>
                @if ($rooms->count() == 15)
                    <div id="getMoreButton" class="btn d-flex justify-content-center m-3"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-caret-down" viewBox="0 0 16 16">
                            <path
                                d="M3.204 5h9.592L8 10.481 3.204 5zm-.753.659 4.796 5.48a1 1 0 0 0 1.506 0l4.796-5.48c.566-.647.106-1.659-.753-1.659H3.204a1 1 0 0 0-.753 1.659z">
                            </path>
                        </svg></div>
                @endif

            </div>
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
