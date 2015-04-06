<!doctype html>
<html lang="zh-CN">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  </head>
<body>
Dear Internal Shop User,<br><br>

Please click <a href="{{URL::route('change_password',
['resetCode'=>Crypt::encrypt($activationcode),'uid'=>Crypt::encrypt($uid)]); }}">here</a> for the next steps of your password resetting.
<br>
请点击<a href="{{URL::route('change_password',
['resetCode'=>Crypt::encrypt($activationcode),'uid'=>Crypt::encrypt($uid)]); }}">此处</a>以重置您的账户密码。
<br><br>
Best Regards,<br>
Service Team 

<p style="font-weight:100;color:#777;font-size:12px;">PS: please do not reply this email.<br>请不要回复此邮件。</p>
</body>
</html>