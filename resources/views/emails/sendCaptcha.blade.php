@component('mail::message')

您好，

感谢您在NCSLab网站注册，注册验证码如下：

@component('mail::panel')
{{ $captcha }}
@endcomponent

验证码10分钟内有效。帐号注册后，您享有120分钟的实验时间。如果您需要更多时间，请与系统管理员联系。

邮件由NCSLab系统发出，请勿回复。
<br>

谢谢,<br>
{{ config('app.name') }}开发组
@endcomponent
