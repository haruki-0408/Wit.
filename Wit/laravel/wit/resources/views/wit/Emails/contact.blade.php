@if ( Session::has('sent'))
<div>
    <p>{{old('name')}}さん、{{ session('sent') }}</p>
</div>
@endif

<form action="/contact" method="post">
    @csrf

    <p>名前：<input type="text" name="name"></p>

    <input type="submit" value="送信">
</form>