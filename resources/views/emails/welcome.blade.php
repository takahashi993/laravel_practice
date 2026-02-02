<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Application!</title>
</head>
<body>
    <h1>こんにちは、{{ $name }}様！</h1>
    <p>翌日対応期限のタスクが以下の通りです。</p>
    <p>{!! nl2br(e($taskList)) !!}</p>
</body>
</html>