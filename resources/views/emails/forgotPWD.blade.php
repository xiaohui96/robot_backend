@component('mail::message')

亲爱的 {{ $account }}：

您可以通过以下链接跳转到密码重置页面重置您的密码：

@component('mail::panel')
{{ $url }}
@endcomponent

@component('mail::button', ['url' => $url, 'color' => 'green'])
立即跳转
@endcomponent

此链接30分钟内有效。

谢谢,<br>
{{ config('app.name') }}开发组
@endcomponent
